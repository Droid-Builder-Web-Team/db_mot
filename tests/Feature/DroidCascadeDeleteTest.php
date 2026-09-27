<?php

namespace Tests\Feature;

use App\Club;
use App\Droid;
use App\DroidInvite;
use App\MOT;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DroidCascadeDeleteTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('members', function ($table) {
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

        Schema::create('clubs', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('droids', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('club_id');
            $table->string('type')->nullable();
            $table->string('style')->nullable();
            $table->string('public')->default('No');
            $table->timestamp('date_added')->nullable();
            $table->timestamp('last_updated')->nullable();
        });

        Schema::create('droid_members', function ($table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('droid_id');
            $table->timestamp('timestamp')->useCurrent();
        });

        Schema::create('mot', function ($table) {
            $table->increments('id');
            $table->integer('droid_id');
            $table->date('date');
            $table->text('location')->nullable();
            $table->string('mot_type', 10)->default('Initial');
            $table->string('approved', 15)->default('Yes');
            $table->integer('user')->default(1);
            $table->timestamps();
        });

        Schema::create('mot_details', function ($table) {
            $table->increments('mot_detail_uid');
            $table->integer('mot_uid');
            $table->string('mot_test', 32);
            $table->string('mot_test_result', 5);
        });

        Schema::create('comments', function ($table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('body')->nullable();
            $table->string('commentable_type');
            $table->integer('commentable_id');
            $table->timestamps();
        });

        Schema::create('droid_invites', function ($table) {
            $table->id();
            $table->integer('droid_id');
            $table->integer('invited_by');
            $table->integer('invited_user_id')->nullable();
            $table->string('email');
            $table->string('token', 64)->unique();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::create('id_list', function ($table) {
            $table->increments('id');
            $table->integer('droid_id');
        });

        Schema::create('course_runs', function ($table) {
            $table->increments('id');
            $table->integer('droid_id');
        });

        Schema::create('permissions', function ($table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('guard_name', 100);
            $table->timestamps();
        });

        Schema::create('roles', function ($table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('guard_name', 100);
            $table->timestamps();
        });

        Schema::create('model_has_permissions', function ($table) {
            $table->unsignedBigInteger('permission_id');
            $table->string('model_type', 100);
            $table->unsignedBigInteger('model_id');
            $table->primary(['permission_id', 'model_id', 'model_type']);
        });

        Schema::create('model_has_roles', function ($table) {
            $table->unsignedBigInteger('role_id');
            $table->string('model_type', 100);
            $table->unsignedBigInteger('model_id');
            $table->primary(['role_id', 'model_id', 'model_type']);
        });

        Schema::create('role_has_permissions', function ($table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
            $table->primary(['permission_id', 'role_id']);
        });

        Club::create([
            'id' => 1,
            'name' => 'R2 Builders Club',
        ]);
    }

    public function test_deleting_droid_cascades_and_removes_all_mots_and_mot_details()
    {
        $user = User::create([
            'forename' => 'Test',
            'surname' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret'),
        ]);

        $droid = Droid::create([
            'name' => 'R2-D2',
            'club_id' => 1,
        ]);
        $droid->users()->attach($user->id);

        // Create MOT
        $mot = MOT::create([
            'droid_id' => $droid->id,
            'date' => now()->toDateString(),
            'location' => 'Workshop',
            'mot_type' => 'Initial',
            'approved' => 'Yes',
            'user' => $user->id,
        ]);

        // Insert mot_details
        DB::table('mot_details')->insert([
            ['mot_uid' => $mot->id, 'mot_test' => 'Dome rotation', 'mot_test_result' => 'Pass'],
            ['mot_uid' => $mot->id, 'mot_test' => 'Drive system', 'mot_test_result' => 'Pass'],
        ]);

        // Insert comments
        DB::table('comments')->insert([
            ['user_id' => $user->id, 'body' => 'Droid comment', 'commentable_type' => 'App\Droid', 'commentable_id' => $droid->id, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $user->id, 'body' => 'MOT comment', 'commentable_type' => 'App\MOT', 'commentable_id' => $mot->id, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insert invite
        DroidInvite::create([
            'droid_id' => $droid->id,
            'invited_by' => $user->id,
            'email' => 'partner@example.com',
            'token' => 'random_token_123',
        ]);

        // Insert id_list & course_runs
        DB::table('id_list')->insert(['droid_id' => $droid->id]);
        DB::table('course_runs')->insert(['droid_id' => $droid->id]);

        // Verify records exist before delete
        $this->assertDatabaseHas('droids', ['id' => $droid->id]);
        $this->assertDatabaseHas('mot', ['id' => $mot->id]);
        $this->assertDatabaseHas('mot_details', ['mot_uid' => $mot->id]);
        $this->assertDatabaseHas('droid_members', ['droid_id' => $droid->id]);
        $this->assertDatabaseHas('droid_invites', ['droid_id' => $droid->id]);
        $this->assertDatabaseHas('id_list', ['droid_id' => $droid->id]);
        $this->assertDatabaseHas('course_runs', ['droid_id' => $droid->id]);
        $this->assertDatabaseHas('comments', ['commentable_type' => 'App\Droid', 'commentable_id' => $droid->id]);
        $this->assertDatabaseHas('comments', ['commentable_type' => 'App\MOT', 'commentable_id' => $mot->id]);

        // Delete droid
        $droid->delete();

        // Verify everything is deleted
        $this->assertDatabaseMissing('droids', ['id' => $droid->id]);
        $this->assertDatabaseMissing('mot', ['id' => $mot->id]);
        $this->assertDatabaseMissing('mot_details', ['mot_uid' => $mot->id]);
        $this->assertDatabaseMissing('droid_members', ['droid_id' => $droid->id]);
        $this->assertDatabaseMissing('droid_invites', ['droid_id' => $droid->id]);
        $this->assertDatabaseMissing('id_list', ['droid_id' => $droid->id]);
        $this->assertDatabaseMissing('course_runs', ['droid_id' => $droid->id]);
        $this->assertDatabaseMissing('comments', ['commentable_type' => 'App\Droid', 'commentable_id' => $droid->id]);
        $this->assertDatabaseMissing('comments', ['commentable_type' => 'App\MOT', 'commentable_id' => $mot->id]);
    }

    public function test_admin_destroy_controller_endpoint_removes_droid_and_mot_details()
    {
        Gate::define('Edit Droids', fn() => true);

        $admin = User::create([
            'forename' => 'Super',
            'surname' => 'Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('secret'),
        ]);

        $droid = Droid::create([
            'name' => 'Chopper',
            'club_id' => 1,
        ]);
        $droid->users()->attach($admin->id);

        $mot = MOT::create([
            'droid_id' => $droid->id,
            'date' => now()->toDateString(),
            'location' => 'Field',
            'mot_type' => 'Initial',
            'approved' => 'Yes',
            'user' => $admin->id,
        ]);

        DB::table('mot_details')->insert([
            ['mot_uid' => $mot->id, 'mot_test' => 'Arms test', 'mot_test_result' => 'Pass'],
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('admin.droids.destroy', $droid->id));

        $response->assertRedirect(route('admin.droids.index'));

        $this->assertDatabaseMissing('droids', ['id' => $droid->id]);
        $this->assertDatabaseMissing('mot', ['id' => $mot->id]);
        $this->assertDatabaseMissing('mot_details', ['mot_uid' => $mot->id]);
    }
}
