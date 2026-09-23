@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="title mb-0">Audit Log</h4>
        <div>{{ $audits->links() }}</div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-striped table-sm table-hover table-dark mb-0">
            <thead class="thead-dark text-center">
              <tr>
                <th scope="col" style="width: 14%;">Time</th>
                <th scope="col" style="width: 18%;">Model</th>
                <th scope="col" style="width: 8%;">Action</th>
                <th scope="col" style="width: 12%;">User</th>
                <th scope="col" style="width: 24%;">Old Values</th>
                <th scope="col" style="width: 24%;">New Values</th>
              </tr>
            </thead>
            <tbody id="audits">
              @foreach($audits as $audit)
                @php
                  $modelClass = $audit->auditable_type;
                  $modelName = class_basename($modelClass);
                  $auditable = null;
                  if (!empty($modelClass) && class_exists($modelClass)) {
                      try {
                          $auditable = $audit->auditable;
                      } catch (\Throwable $e) {
                          $auditable = null;
                      }
                  }

                  $auditableUrl = null;
                  $auditableLabel = $modelName . ' #' . $audit->auditable_id;

                  if ($audit->auditable_id) {
                      switch ($modelClass) {
                          case 'App\Event':
                              $auditableUrl = Route::has('event.show') ? route('event.show', $audit->auditable_id) : null;
                              if ($auditable && !empty($auditable->name)) {
                                  $auditableLabel = $auditable->name;
                              }
                              break;
                          case 'App\User':
                              $auditableUrl = Route::has('user.show') ? route('user.show', $audit->auditable_id) : null;
                              if ($auditable) {
                                  $name = trim(($auditable->forename ?? '') . ' ' . ($auditable->surname ?? ''));
                                  $auditableLabel = $name ?: $auditableLabel;
                              }
                              break;
                          case 'App\Droid':
                              $auditableUrl = Route::has('droid.show') ? route('droid.show', $audit->auditable_id) : null;
                              if ($auditable && !empty($auditable->name)) {
                                  $auditableLabel = $auditable->name;
                              }
                              break;
                          case 'App\Location':
                              $auditableUrl = Route::has('location.show') ? route('location.show', $audit->auditable_id) : null;
                              if ($auditable && !empty($auditable->name)) {
                                  $auditableLabel = $auditable->name;
                              }
                              break;
                          case 'App\PartsRunData':
                              $auditableUrl = Route::has('parts-run.show') ? route('parts-run.show', $audit->auditable_id) : null;
                              break;
                          case 'App\Models\Asset':
                              $auditableUrl = Route::has('asset.show') ? route('asset.show', $audit->auditable_id) : null;
                              if ($auditable && !empty($auditable->title)) {
                                  $auditableLabel = $auditable->title;
                              }
                              break;
                          case 'App\Models\Auction':
                              $auditableUrl = Route::has('auctions.show') ? route('auctions.show', $audit->auditable_id) : null;
                              if ($auditable && !empty($auditable->title)) {
                                  $auditableLabel = $auditable->title;
                              }
                              break;
                          case 'App\Models\Ware':
                              $auditableUrl = Route::has('ware.show') ? route('ware.show', $audit->auditable_id) : null;
                              if ($auditable && !empty($auditable->title)) {
                                  $auditableLabel = $auditable->title;
                              }
                              break;
                          case 'App\Achievement':
                              $auditableUrl = Route::has('achievements.show') ? route('achievements.show', $audit->auditable_id) : null;
                              if ($auditable && !empty($auditable->name)) {
                                  $auditableLabel = $auditable->name;
                              }
                              break;
                          case 'App\PortalNews':
                              $auditableUrl = Route::has('portalnews.show') ? route('portalnews.show', $audit->auditable_id) : null;
                              if ($auditable && !empty($auditable->title)) {
                                  $auditableLabel = $auditable->title;
                              }
                              break;
                          case 'App\MOT':
                              $auditableUrl = Route::has('mot.show') ? route('mot.show', $audit->auditable_id) : null;
                              break;
                          case 'App\Contact':
                              $auditableUrl = Route::has('admin.contacts.show') ? route('admin.contacts.show', $audit->auditable_id) : null;
                              break;
                      }
                  }

                  $badgeClasses = [
                      'created' => 'badge-success',
                      'updated' => 'badge-info',
                      'deleted' => 'badge-danger',
                      'restored' => 'badge-warning',
                  ];
                  $badgeClass = $badgeClasses[$audit->event] ?? 'badge-secondary';
                @endphp
                <tr>
                  <td class="align-middle text-center text-nowrap"><small>{{ $audit->created_at }}</small></td>
                  <td class="align-middle">
                    <div>
                      @if($auditableUrl)
                        <a href="{{ $auditableUrl }}" class="font-weight-bold">{{ $auditableLabel }}</a>
                      @else
                        <span class="font-weight-bold">{{ $auditableLabel }}</span>
                      @endif
                    </div>
                    <small class="text-muted">{{ $modelName }} (ID: {{ $audit->auditable_id }})</small>
                  </td>
                  <td class="align-middle text-center">
                    <span class="badge {{ $badgeClass }}">{{ ucfirst($audit->event) }}</span>
                  </td>
                  <td class="align-middle text-center">
                    @if($audit->user)
                      <a href="{{ route('user.show', $audit->user->id) }}">{{ $audit->user->forename }} {{ $audit->user->surname }}</a>
                    @else
                      <span class="text-muted">System</span>
                    @endif
                  </td>
                  <td class="align-top">
                    <table class="table table-sm table-dark table-borderless mb-0 text-left" style="font-size: 0.85rem;">
                      @forelse($audit->old_values ?? [] as $attribute => $value)
                        <tr>
                          <td class="font-weight-bold text-nowrap py-0 pr-2" style="color: #adb5bd; width: 1%;">{{ $attribute }}:</td>
                          <td class="text-break py-0" style="color: #f8f9fa;">
                            @if(is_null($value))
                              <span class="text-muted"><em>null</em></span>
                            @elseif(is_bool($value))
                              <span class="badge badge-secondary">{{ $value ? 'true' : 'false' }}</span>
                            @elseif(is_array($value))
                              <code>{{ json_encode($value) }}</code>
                            @elseif($value === '')
                              <span class="text-muted"><em>empty</em></span>
                            @else
                              {{ $value }}
                            @endif
                          </td>
                        </tr>
                      @empty
                        <tr><td class="text-muted py-0 text-center">—</td></tr>
                      @endforelse
                    </table>
                  </td>
                  <td class="align-top">
                    <table class="table table-sm table-dark table-borderless mb-0 text-left" style="font-size: 0.85rem;">
                      @forelse($audit->new_values ?? [] as $attribute => $value)
                        <tr>
                          <td class="font-weight-bold text-nowrap py-0 pr-2" style="color: #adb5bd; width: 1%;">{{ $attribute }}:</td>
                          <td class="text-break py-0" style="color: #f8f9fa;">
                            @if(is_null($value))
                              <span class="text-muted"><em>null</em></span>
                            @elseif(is_bool($value))
                              <span class="badge badge-secondary">{{ $value ? 'true' : 'false' }}</span>
                            @elseif(is_array($value))
                              <code>{{ json_encode($value) }}</code>
                            @elseif($value === '')
                              <span class="text-muted"><em>empty</em></span>
                            @else
                              {{ $value }}
                            @endif
                          </td>
                        </tr>
                      @empty
                        <tr><td class="text-muted py-0 text-center">—</td></tr>
                      @endforelse
                    </table>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer d-flex justify-content-center">
        {{ $audits->links() }}
      </div>
    </div>
  </div>
</div>
@endsection

