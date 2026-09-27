<?php

namespace Tests\Feature;

use App\Club;
use App\Droid;
use App\DroidInvite;
use App\Notifications\DroidInviteNotification;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DroidInviteTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        \Illuminate\Support\Facades\Schema::create('members', function ($table) {
            $table->increments('id');
            $table->string('forename')->nullable();
            $table->string('surname')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('active')->default('on');
            $table->boolean('accepted_gdpr')->default(1);
            $table->timestamp('last_activity')->nullable();
            $table->timestamp('created_on')->nullable();
            $table->timestamp('last_updated')->nullable();
            $table->rememberToken();
        });

        \Illuminate\Support\Facades\Schema::create('clubs', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\Schema::create('droids', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('club_id');
            $table->string('type')->nullable();
            $table->string('style')->nullable();
            $table->string('public')->default('No');
            $table->timestamp('date_added')->nullable();
            $table->timestamp('last_updated')->nullable();
        });

        \Illuminate\Support\Facades\Schema::create('droid_members', function ($table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('droid_id');
            $table->timestamp('timestamp')->useCurrent();
        });

        \Illuminate\Support\Facades\Schema::create('droid_invites', function ($table) {
            $table->id();
            $table->integer('droid_id');
            $table->integer('invited_by');
            $table->integer('invited_user_id')->nullable();
            $table->string('email');
            $table->string('token', 64)->unique();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        \Illuminate\Support\Facades\Schema::create('permissions', function ($table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('guard_name', 100);
            $table->timestamps();
        });

        \Illuminate\Support\Facades\Schema::create('roles', function ($table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('guard_name', 100);
            $table->timestamps();
        });

        \Illuminate\Support\Facades\Schema::create('model_has_permissions', function ($table) {
            $table->unsignedBigInteger('permission_id');
            $table->string('model_type', 100);
            $table->unsignedBigInteger('model_id');
            $table->primary(['permission_id', 'model_id', 'model_type']);
        });

        \Illuminate\Support\Facades\Schema::create('model_has_roles', function ($table) {
            $table->unsignedBigInteger('role_id');
            $table->string('model_type', 100);
            $table->unsignedBigInteger('model_id');
            $table->primary(['role_id', 'model_id', 'model_type']);
        });

        \Illuminate\Support\Facades\Schema::create('role_has_permissions', function ($table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
            $table->primary(['permission_id', 'role_id']);
        });

        Club::create([
            'id' => 1,
            'name' => 'R2 Builders Club',
        ]);
    }

    protected function createUser(array $attributes = []): User
    {
        return User::create(array_merge([
            'forename' => 'Test',
            'surname' => 'User',
            'email' => 'user' . uniqid() . '@example.com',
            'active' => 'on',
            'accepted_gdpr' => 1,
            'password' => bcrypt('password'),
        ], $attributes));
    }

    protected function createDroid(User $owner, array $attributes = []): Droid
    {
        $droid = Droid::create(array_merge([
            'name' => 'R2-D2',
            'club_id' => 1,
        ], $attributes));

        $droid->users()->attach($owner->id);

        return $droid;
    }

    public function test_owner_can_invite_existing_user_to_share_droid()
    {
        Notification::fake();

        $owner = $this->createUser(['forename' => 'Owner', 'surname' => 'Builder']);
        $recipient = $this->createUser(['forename' => 'Partner', 'surname' => 'Builder']);
        $droid = $this->createDroid($owner);

        $response = $this->actingAs($owner)
            ->post(route('droid.invite.send', $droid->id), [
                'user_id' => $recipient->id,
            ]);

        $response->assertRedirect(route('droid.show', $droid->id));

        $this->assertDatabaseHas('droid_invites', [
            'droid_id' => $droid->id,
            'invited_user_id' => $recipient->id,
            'invited_by' => $owner->id,
            'email' => $recipient->email,
        ]);

        Notification::assertSentTo($recipient, DroidInviteNotification::class);
    }

    public function test_cannot_invite_already_existing_droid_owner()
    {
        $owner1 = $this->createUser();
        $owner2 = $this->createUser();
        $droid = $this->createDroid($owner1);
        $droid->users()->attach($owner2->id);

        $response = $this->actingAs($owner1)
            ->post(route('droid.invite.send', $droid->id), [
                'user_id' => $owner2->id,
            ]);

        $response->assertRedirect(route('droid.show', $droid->id));
        $this->assertDatabaseMissing('droid_invites', [
            'droid_id' => $droid->id,
            'invited_user_id' => $owner2->id,
        ]);
    }

    public function test_admin_bypasses_invitation_and_adds_owner_directly()
    {
        Notification::fake();
        \Illuminate\Support\Facades\Gate::define('Edit Droids', function () {
            return true;
        });

        $admin = $this->createUser(['forename' => 'Admin', 'surname' => 'User']);
        $owner = $this->createUser(['forename' => 'Owner', 'surname' => 'Builder']);
        $newOwner = $this->createUser(['forename' => 'New', 'surname' => 'CoOwner']);
        $droid = $this->createDroid($owner);

        $response = $this->actingAs($admin)
            ->post(route('droid.invite.send', $droid->id), [
                'user_id' => $newOwner->id,
            ]);

        $response->assertRedirect(route('droid.show', $droid->id));

        $this->assertDatabaseHas('droid_members', [
            'droid_id' => $droid->id,
            'user_id' => $newOwner->id,
        ]);

        $this->assertDatabaseMissing('droid_invites', [
            'droid_id' => $droid->id,
            'invited_user_id' => $newOwner->id,
        ]);

        Notification::assertNothingSent();
    }

    public function test_user_can_view_invitation_screen()
    {
        $owner = $this->createUser();
        $recipient = $this->createUser();
        $droid = $this->createDroid($owner);

        $invite = DroidInvite::create([
            'droid_id' => $droid->id,
            'invited_by' => $owner->id,
            'invited_user_id' => $recipient->id,
            'email' => $recipient->email,
            'token' => 'test-token-12345',
            'expires_at' => now()->addDays(7),
        ]);

        $response = $this->get(route('droid.invite.accept', $invite->token));

        $response->assertStatus(200);
        $response->assertSee('Droid Sharing Invitation');
        $response->assertSee($droid->name);
    }

    public function test_user_can_accept_invitation()
    {
        $owner = $this->createUser();
        $recipient = $this->createUser();
        $droid = $this->createDroid($owner);

        $invite = DroidInvite::create([
            'droid_id' => $droid->id,
            'invited_by' => $owner->id,
            'invited_user_id' => $recipient->id,
            'email' => $recipient->email,
            'token' => 'test-token-12345',
            'expires_at' => now()->addDays(7),
        ]);

        $response = $this->actingAs($recipient)
            ->post(route('droid.invite.confirm', $invite->token));

        $response->assertRedirect(route('droid.show', $droid->id));

        $this->assertTrue($droid->fresh()->users->contains($recipient));
        $this->assertDatabaseMissing('droid_invites', [
            'id' => $invite->id,
        ]);
    }

    public function test_owner_can_cancel_invitation()
    {
        $owner = $this->createUser();
        $recipient = $this->createUser();
        $droid = $this->createDroid($owner);

        $invite = DroidInvite::create([
            'droid_id' => $droid->id,
            'invited_by' => $owner->id,
            'invited_user_id' => $recipient->id,
            'email' => $recipient->email,
            'token' => 'cancel-token',
            'expires_at' => now()->addDays(7),
        ]);

        $response = $this->actingAs($owner)
            ->delete(route('droid.invite.destroy', $invite->id));

        $response->assertRedirect(route('droid.show', $droid->id));
        $this->assertDatabaseMissing('droid_invites', [
            'id' => $invite->id,
        ]);
    }

    public function test_owner_can_remove_co_owner()
    {
        $owner1 = $this->createUser();
        $owner2 = $this->createUser();
        $droid = $this->createDroid($owner1);
        $droid->users()->attach($owner2->id);

        $this->assertEquals(2, $droid->users()->count());

        $response = $this->actingAs($owner1)
            ->delete(route('droid.user.remove', [$droid->id, $owner2->id]));

        $response->assertRedirect(route('droid.show', $droid->id));
        $this->assertFalse($droid->fresh()->users->contains($owner2));
        $this->assertEquals(1, $droid->fresh()->users()->count());
    }

    public function test_cannot_remove_the_sole_owner()
    {
        $owner = $this->createUser();
        $droid = $this->createDroid($owner);

        $this->assertEquals(1, $droid->users()->count());

        $response = $this->actingAs($owner)
            ->delete(route('droid.user.remove', [$droid->id, $owner->id]));

        $response->assertRedirect(route('droid.show', $droid->id));
        $this->assertTrue($droid->fresh()->users->contains($owner));
        $this->assertEquals(1, $droid->fresh()->users()->count());
    }

    public function test_search_users_returns_empty_when_under_three_chars()
    {
        $owner = $this->createUser();
        $droid = $this->createDroid($owner);

        $response = $this->actingAs($owner)
            ->getJson(route('droid.invite.search_users', ['droid' => $droid->id, 'q' => 'ab']));

        $response->assertStatus(200);
        $response->assertExactJson(['results' => []]);
    }

    public function test_search_users_returns_matching_users_and_excludes_existing_owners()
    {
        $owner = $this->createUser(['forename' => 'Owner', 'surname' => 'Person']);
        $droid = $this->createDroid($owner);

        $member1 = $this->createUser(['forename' => 'Alice', 'surname' => 'Smith', 'email' => 'alice@example.com']);
        $member2 = $this->createUser(['forename' => 'Bob', 'surname' => 'Smith', 'email' => 'bob@example.com']);
        $inactive = $this->createUser(['forename' => 'Carol', 'surname' => 'Smith', 'active' => 'off']);

        $response = $this->actingAs($owner)
            ->getJson(route('droid.invite.search_users', ['droid' => $droid->id, 'q' => 'Smi']));

        $response->assertStatus(200);

        $data = $response->json('results');
        $ids = collect($data)->pluck('id')->toArray();

        $this->assertContains($member1->id, $ids);
        $this->assertContains($member2->id, $ids);
        $this->assertNotContains($owner->id, $ids);
        $this->assertNotContains($inactive->id, $ids);
    }
}
