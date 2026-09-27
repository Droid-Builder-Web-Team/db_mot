@extends('layouts.app')

@section('content')

  <div class="row">
    <div class="col md-6">
      <div class="card">
        <div class="card-header">
          <span class="float-left">
            <h2>{{ $droid->name }}</h2>
          </span>
          <div class="float-right text-right">
            <div class="badge badge-info badge-size-match mb-2">{{ $droid->club->name }}</div>
            <div class="d-flex align-items-center justify-content-end">
              <span id="publicStatusBadge"
                class="badge badge-pill-glow {{ $droid->public == 'Yes' ? 'badge-success' : 'badge-secondary' }}">
                <label class="switch-glow">
                  <input type="checkbox" id="publicToggle" value="{{$droid->public}}" {{ $droid->public == 'Yes' ? 'checked' : '' }}>
                  <span class="slider"></span>
                </label>
                <span class="font-weight-bold ml-2">Public Profile</span>
              </span>
            </div>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-striped table-sm table-hover table-dark">
            <tr>
              <th>Owner(s)</th>
              <td>
                @foreach ($droid->users as $user)
                  <a href="{{ route('user.show', $user->id) }}">{{ $user->forename }} {{ $user->surname }}</a>
                  @if((Auth::user()->can('Edit Droids') || $droid->users->contains(Auth::user())) && $droid->users->count() > 1)
                    <form action="{{ route('droid.user.remove', [$droid->id, $user->id]) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure you want to remove {{ $user->forename }} as an owner of this droid?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-link text-danger p-0 ml-1 border-0" title="Remove owner"
                        style="vertical-align: baseline;"><i class="fas fa-user-minus"></i></button>
                    </form>
                  @endif
                  <br>
                @endforeach
                @if(Auth::user()->can('Edit Droids') || $droid->users->contains(Auth::user()))
                  @if($droid->invites->count() > 0)
                    <div class="mt-2 text-muted small border-top border-secondary pt-2">
                      <strong>Pending Invites:</strong><br>
                      @foreach ($droid->invites as $invite)
                        <span
                          class="text-info">{{ $invite->recipient ? ($invite->recipient->forename . ' ' . $invite->recipient->surname . ' (' . $invite->email . ')') : $invite->email }}</span>
                        <form action="{{ route('droid.invite.destroy', $invite->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Cancel invitation for {{ $invite->recipient ? ($invite->recipient->forename . ' ' . $invite->recipient->surname) : $invite->email }}?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-link text-warning p-0 ml-1 border-0" title="Cancel invitation"
                            style="vertical-align: baseline;"><i class="fas fa-times-circle"></i></button>
                        </form>
                        <br>
                      @endforeach
                    </div>
                  @endif
                @endif
              </td>
            </tr>
            @if ($droid->public == 'Yes')
              <tr>
                <th>Scan Count</th>
                <td>{{ $droid->scan_count ?? 0 }}</td>
              </tr>
              <tr>
                <th>Commendations</th>
                <td>★ {{ $droid->commendations ?? 0 }}</td>
              </tr>
            @endif
            <tr>
              <th>Type</th>
              <td>{{ $droid->type }}</td>
            </tr>
            <tr>
              <th>Style</th>
              <td>{{ $droid->style }}</td>
            </tr>
            <tr>
              <th>Radio Controlled?</th>
              <td>{{ $droid->radio_controlled }}</td>
            </tr>
            <tr>
              <th>Transmitter Type</th>
              <td>{{ $droid->transmitter_type }}</td>
            </tr>
            <tr>
              <th>Material</th>
              <td>{{ $droid->material }}</td>
            </tr>
            <tr>
              <th>Approx Weight</th>
              <td>{{ $droid->weight }} (kg)</td>
            </tr>
            <tr>
              <th>Battery Type</th>
              <td>{{ $droid->battery }}</td>
            </tr>
            <tr>
              <th>Drive Voltage</th>
              <td>{{ $droid->drive_voltage }}</td>
            </tr>
            <tr>
              <th>Drive Type</th>
              <td>{{ $droid->drive_type }}</td>
            </tr>
            <tr>
              <th>Top Speed</th>
              <td>{{ $droid->top_speed }} (m/s)</td>
            </tr>
            <tr>
              <th>Sound System</th>
              <td>{{ $droid->sound_system }}</td>
            </tr>
            <tr>
              <th>Approx Value</th>
              <td>{{ $droid->value }}</td>
            </tr>
            <tr>
              <th>Build Log</th>
              <td><a target="_blank" href="{{ $droid->build_log }}">{{ $droid->build_log }}</a></td>
            </tr>
            @if ($droid->club->hasOption('tier_two'))
              <tr>
                <th>Tier 2</th>
                <td>{{ $droid->tier_two }}</td>
              </tr>
            @endif
            @if ($droid->club->hasOption('topps'))
              @if ($droid->topps_id != null)
                <tr>
                  <th>Topps Number</th>
                  <td>Run: {{ $droid->topps_run }} Card:{{ $droid->topps_id }}</td>
                </tr>
              @endif
            @endif
            @if(Auth::user()->can('Edit Droids') || $droid->users->contains(Auth::user()))
              <tr id="tagUrlRow" style="{{ $droid->public == 'Yes' ? '' : 'display: none;' }}">
                <th>Tag URL</th>
                <td>
                  <a id="tagUrlLink" class="text-break" target="_blank"
                    href="{{ $droid->tagUrl() }}">{{ $droid->tagUrl() }}</a>
                  <div class="mt-2">
                    <button id="writeNfcBtn" class="btn btn-sm btn-nfc" style="display: none;">
                      <i class="fas fa-rss"></i> Write to Tag
                    </button>
                  </div>
                </td>
              </tr>
            @endif
          </table>
          <span class="float-left">
            @if(Auth::user()->isAdminOf($droid->club) && Auth::user()->can('Edit Droids'))
              <a class="btn btn-edit" style="width:auto; display:inline-block;"
                href="{{ route('admin.droids.edit', $droid->id) }}">Edit</a>
            @else
              <a class="btn btn-edit" style="width:auto; display:inline-block;"
                href="{{ route('droid.edit', $droid->id) }}">Edit</a>
            @endif
            @if(Auth::user()->can('Edit Droids') || $droid->users->contains(Auth::user()))
              <button type="button" class="btn btn-edit ml-1" style="width:auto; display:inline-block;" data-toggle="modal"
                data-target="#shareDroidModal">
                @if(Auth::user()->can('Edit Droids') || Auth::user()->hasRole(['Super Admin', 'Org Admin']))
                  <i class="fas fa-user-plus"></i> Add Owner
                @else
                  <i class="fas fa-share-alt"></i> Share
                @endif
              </button>
            @endif
          </span>
          <span class="float-right">
            <a class="btn-sm btn-details" style="color:#2586e7;"
              href="{{ action('DroidController@downloadPDF', $droid->id )}}" target="_blank">Info Sheet</a>
          </span>
        </div>
      </div>
      @if ($droid->club->hasOption('mot'))
        <div class="card">
          <div class="card-header">
            MOT Details
          </div>
          <div class="card-body">
            <table class="table table-striped table-sm table-hover table-dark">
              <tr>
                <th>Date</th>
                <th>Location</th>
                <th>Officer</th>
                <th>Approved</th>
                <th>Action</th>
              </tr>
              @foreach($droid->mot as $mot)
                <tr>
                  <td>{{ Carbon\Carbon::parse($mot->date)->isoFormat(Auth::user()->settings()->get('date_format')) }}</td>
                  <td>{{ $mot->location }}</td>
                  <td>{{ $mot->officer() }}</td>
                  <td>{{ $mot->approved }}</td>
                  <td><a class="btn btn-view btn-sm" href="{{ route('mot.show', $mot->id) }}">View</a></td>
                </tr>
              @endforeach
            </table>
            @if(Auth::user()->isAdminOf($droid->club) && Auth::user()->can('Add MOT'))
              <a class="btn btn-mot" href="{{ route('admin.mot.create', $droid->id) }}">Add MOT</a>
            @endif
          </div>
        </div>
      @endif
    </div>
    <div class="col-md-6"> <!-- image column -->
      <div class="card">
        <div class="card-header">
          <span class="float-left">
            Images
          </span>
        </div>
        <div class="card-body">
          <div class="row"> <!-- droid images -->
            @include('partials.image', ['photo_name' => 'photo_front', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
            @include('partials.image', ['photo_name' => 'photo_side', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
            @include('partials.image', ['photo_name' => 'photo_rear', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
          </div> <!-- end of droid images -->
        </div>
      </div>

      @if($droid->topps_id != null && $droid->topps_id != 0)
        <div class="card">
          <div class="card-header">
            <span class="float-left">
              Topps Cards
            </span>
          </div>
          <div class="card-body">
            <div class="row"> <!-- topps images -->
              @include('partials.image', ['photo_name' => 'topps_front', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
              @include('partials.image', ['photo_name' => 'topps_rear', 'user_id' => $droid->users->first()->id, 'droid_id' => $droid->id])
            </div> <!-- end of topps images -->
          </div>
        </div>
      @endif

    </div> <!-- end of images column -->
  </div>

  @if ($droid->club->hasOption('mot'))
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Officer Comments
          </div>
          <div class="card-body">
            @foreach($droid->comments as $comment)
              <div class="card border-primary">
                <div class="card-header">
                  <strong>{{ $comment->user->forename }} {{ $comment->user->surname }}</strong>
                  <span class="float-right">
                    {{ Carbon\Carbon::parse($comment->created_at, Auth::user()->settings()->get('timezone'))->isoFormat(Auth::user()->settings()->get('date_format') . ' - ' . Auth::user()->settings()->get('time_format')) }}
                  </span>
                </div>
                <div class="card-body">
                  {!! nl2br(e($comment->body)) !!}
                  @can('Add MOT')
                    <span class="float-right">
                      <a href="{{ route('comment.delete', $comment->id)}}" class="btn-sm btn-danger">Delete</a>
                    </span>
                  @endcan
                </div>
              </div>
            @endforeach

            @if(Auth::user()->isAdminOf($droid->club) && Auth::user()->can('Add MOT'))
              <div class="card border-primary">
                <div class="card-header">
                  <strong>Add Comment</strong>
                </div>
                <div class="card-body">
                  <form action="{{ route('comment.add', ['id' => $droid->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="model" value="App\Droid">
                    <div class="form-group">
                      <textarea type="text" class="form-control" name="body"></textarea>
                    </div>
                    <input type="submit" class="btn-sm btn-primary" name="comment" value="Add Comment"
                      onclick="this.disabled=true;this.form.submit();">
                  </form>
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  @endif
  <div class="row mb-5">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          Builders Notes
        </div>
        <div class="card-body">
          <div>
            {!! nl2br(e($droid->notes)) !!}
          </div>
          @can('Edit Droids')
            @if(Auth::user()->isAdminOf($droid->club))
              <a class="btn btn-edit" style="width:auto;" href="{{ route('admin.droids.edit', $droid->id) }}">Edit</a>
            @endif
          @else
            <a class="btn btn-edit" style="width:auto;" href="{{ route('droid.edit', $droid->id) }}">Edit</a>
          @endcan
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          Back Story
        </div>
        <div class="card-body">
          <div>
            {!! nl2br(e($droid->back_story)) !!}
          </div>
          @can('Edit Droids')
            @if(Auth::user()->isAdminOf($droid->club))
              <a class="btn btn-edit" style="width:auto;" href="{{ route('admin.droids.edit', $droid->id) }}">Edit</a>
            @endif
          @else
            <a class="btn btn-edit" style="width:auto;" href="{{ route('droid.edit', $droid->id) }}">Edit</a>
          @endcan
        </div>
      </div>
    </div>
  </div>

  @if(Auth::user()->can('Edit Droids') || $droid->users->contains(Auth::user()))
    <div class="modal fade" id="shareDroidModal" role="dialog" aria-labelledby="shareDroidModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark text-white">
          <form action="{{ route('droid.invite.send', $droid->id) }}" method="POST">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="shareDroidModalLabel">
                @if(Auth::user()->can('Edit Droids') || Auth::user()->hasRole(['Super Admin', 'Org Admin']))
                  <i class="fas fa-user-plus"></i> Add Co-Owner to {{ $droid->name }}
                @else
                  <i class="fas fa-share-alt"></i> Share {{ $droid->name }}
                @endif
              </h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              @if(Auth::user()->can('Edit Droids') || Auth::user()->hasRole(['Super Admin', 'Org Admin']))
                <p>As an administrator, selecting a member will directly add them as a co-owner immediately without requiring
                  an email invitation.</p>
              @else
                <p>Invite another member (e.g. family member, spouse, or co-builder) to share ownership of this droid.</p>
                <p class="text-muted small">They will receive an email with an invite link. Once they accept, this droid will
                  appear on their profile and they can co-manage it.</p>
              @endif

              <div class="form-group position-relative">
                <label for="member-search-input">Search Member</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-secondary text-white border-secondary"><i
                        class="fas fa-search"></i></span>
                  </div>
                  <input type="text" id="member-search-input" class="form-control bg-secondary text-white border-secondary"
                    placeholder="Type at least 3 characters to search..." autocomplete="off">
                </div>
                <input type="hidden" name="user_id" id="selected-user-id" required>

                <div id="search-status-text" class="small text-muted mt-1"></div>

                <!-- Dropdown search results -->
                <div id="member-search-results" class="list-group position-absolute w-100 shadow mt-1"
                  style="display: none; z-index: 1060; max-height: 220px; overflow-y: auto;">
                </div>

                <!-- Selected member preview -->
                <div id="selected-member-card" class="card bg-secondary text-white mt-2 p-2"
                  style="display: none !important;">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <div class="font-weight-bold text-success"><i class="fas fa-check-circle"></i> <span
                          id="selected-member-name"></span></div>
                      <div class="small text-light" id="selected-member-email"></div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger" id="clear-selected-member"
                      title="Choose a different member">
                      <i class="fas fa-times"></i> Change
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" id="share-submit-btn" class="btn btn-primary" disabled>
                @if(Auth::user()->can('Edit Droids') || Auth::user()->hasRole(['Super Admin', 'Org Admin']))
                  <i class="fas fa-user-plus"></i> Add Co-Owner
                @else
                  <i class="fas fa-paper-plane"></i> Send Invite
                @endif
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var modal = $('#shareDroidModal');
      var searchInput = document.getElementById('member-search-input');
      var resultsContainer = document.getElementById('member-search-results');
      var statusText = document.getElementById('search-status-text');
      var hiddenUserId = document.getElementById('selected-user-id');
      var submitBtn = document.getElementById('share-submit-btn');
      var selectedCard = document.getElementById('selected-member-card');
      var selectedName = document.getElementById('selected-member-name');
      var selectedEmail = document.getElementById('selected-member-email');
      var clearBtn = document.getElementById('clear-selected-member');

      var debounceTimer = null;

      function resetSearch() {
        if (searchInput) searchInput.value = '';
        if (resultsContainer) {
          resultsContainer.innerHTML = '';
          resultsContainer.style.display = 'none';
        }
        if (statusText) statusText.textContent = '';
        if (hiddenUserId) hiddenUserId.value = '';
        if (selectedCard) selectedCard.setAttribute('style', 'display: none !important;');
        if (submitBtn) submitBtn.disabled = true;
      }

      modal.on('shown.bs.modal', function () {
        if (searchInput && !hiddenUserId.value) {
          searchInput.focus();
        }
      });

      modal.on('hidden.bs.modal', function () {
        resetSearch();
      });

      if (clearBtn) {
        clearBtn.addEventListener('click', function () {
          resetSearch();
          if (searchInput) searchInput.focus();
        });
      }

      if (searchInput) {
        searchInput.addEventListener('input', function () {
          var query = this.value.trim();

          clearTimeout(debounceTimer);
          hiddenUserId.value = '';
          if (submitBtn) submitBtn.disabled = true;
          if (selectedCard) selectedCard.setAttribute('style', 'display: none !important;');

          if (query.length === 0) {
            statusText.textContent = '';
            resultsContainer.style.display = 'none';
            resultsContainer.innerHTML = '';
            return;
          }

          if (query.length < 3) {
            statusText.textContent = 'Please enter at least 3 characters...';
            resultsContainer.style.display = 'none';
            resultsContainer.innerHTML = '';
            return;
          }

          statusText.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching members...';

          debounceTimer = setTimeout(function () {
            fetch("{{ route('droid.invite.search_users', $droid->id) }}?q=" + encodeURIComponent(query), {
              headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
              }
            })
              .then(function (res) { return res.json(); })
              .then(function (data) {
                resultsContainer.innerHTML = '';
                var results = (data && data.results) ? data.results : [];

                if (results.length === 0) {
                  statusText.textContent = 'No members found matching "' + query + '".';
                  resultsContainer.style.display = 'none';
                  return;
                }

                statusText.textContent = 'Found ' + results.length + ' member' + (results.length > 1 ? 's' : '') + ':';
                resultsContainer.style.display = 'block';

                results.forEach(function (item) {
                  var btn = document.createElement('button');
                  btn.type = 'button';
                  btn.className = 'list-group-item list-group-item-action bg-dark text-white border-secondary d-flex justify-content-between align-items-center py-2';

                  var nameDiv = document.createElement('div');
                  var nameEl = document.createElement('div');
                  nameEl.className = 'font-weight-bold';
                  nameEl.textContent = item.forename + ' ' + item.surname;
                  var emailEl = document.createElement('div');
                  emailEl.className = 'small text-muted';
                  emailEl.textContent = item.email;
                  nameDiv.appendChild(nameEl);
                  nameDiv.appendChild(emailEl);

                  var badge = document.createElement('span');
                  badge.className = 'badge badge-primary px-2 py-1 font-weight-normal text-nowrap ml-2';
                  badge.style.fontSize = '0.75rem';
                  badge.innerHTML = '<i class="fas fa-plus fa-xs" style="font-size: 0.65rem; width: 0.65rem; height: 0.65rem; vertical-align: -0.05em; margin-right: 3px;"></i> Select';

                  btn.appendChild(nameDiv);
                  btn.appendChild(badge);

                  btn.addEventListener('click', function () {
                    hiddenUserId.value = item.id;
                    if (submitBtn) submitBtn.disabled = false;
                    resultsContainer.style.display = 'none';
                    statusText.textContent = '';
                    searchInput.value = '';

                    selectedName.textContent = item.forename + ' ' + item.surname;
                    selectedEmail.textContent = item.email;
                    selectedCard.removeAttribute('style');
                  });

                  resultsContainer.appendChild(btn);
                });
              })
              .catch(function (err) {
                statusText.textContent = 'Error searching members. Please try again.';
                resultsContainer.style.display = 'none';
              });
          }, 250);
        });
      }
    });

    $('#publicToggle').change(function () {
      var mode = $(this).prop('checked');
      if (mode) {
        $('#tagUrlRow').show();
        $('#publicStatusBadge').removeClass('badge-secondary').addClass('badge-success');
      } else {
        $('#tagUrlRow').hide();
        $('#publicStatusBadge').removeClass('badge-success').addClass('badge-secondary');
      }
      var id = $(this).val();
      var droid = {};
      droid.mode = $(this).prop('checked');
      droid.publicstatus = $(this).val();
      droid._token = '{{csrf_token()}}';
      droid.id = '{{ $droid->id }}';
      $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "{{ route('droid.togglePublic') }}",
        data: droid,
        success: function (data) {
        }
      });
    });

    if ('NDEFReader' in window) {
      $('#writeNfcBtn').show();
      $('#writeNfcBtn').click(async () => {
        const btn = $('#writeNfcBtn');
        const originalHtml = btn.html();
        try {
          btn.html('<i class="fas fa-spinner fa-spin"></i> Approach Tag...');
          btn.prop('disabled', true);
          const ndef = new NDEFReader();
          await ndef.write({
            records: [{ recordType: "url", data: $('#tagUrlLink').attr('href') }]
          });
          if (typeof flasher !== 'undefined') {
            flasher.success("URL written to NFC tag successfully!");
          } else {
            alert("URL written to NFC tag successfully!");
          }
        } catch (error) {
          console.error("Write failed: " + error);
          if (error.name != 'AbortError') {
            if (typeof flasher !== 'undefined') {
              flasher.error("Write failed: " + error);
            } else {
              alert("Write failed: " + error);
            }
          }
        } finally {
          btn.html(originalHtml);
          btn.prop('disabled', false);
        }
      });
    }
  </script>
@endsection