@extends('layouts.app')

@section('content')
<!-- Styles -->
<link href="{{ asset('css/lib/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/user-list.css') }}" rel="stylesheet">

<!-- Script -->
<script src="{{ asset('js/lib/moment.min.js') }}"></script>
<script src="{{ asset('js/lib/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/user-list.js') }}"></script>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">{{ __('User List') }}</div>
        <div class="card-body">
          <div class="row search-bar">
            <div class="row m-0">
              <label class="p-2 search-lbl">Name :</label>
              <input class="search-input mb-2 form-control" type="text" id="search-name" />
            </div>
            <div class="row m-0">
              <label class="p-2 search-lbl">Email :</label>
              <input class="search-input mb-2 form-control" type="text" id="search-email" />
            </div>
            <div class="row m-0">
              <label class="p-2 search-lbl">From :</label>
              <input class="search-input mb-2 form-control" id="dateStart" type="date" />
            </div>
            <div class="row m-0">
              <label class="p-2 search-lbl">To :</label>
              <input class="search-input mb-2 form-control" id="dateEnd" type="date" />
            </div>
            <button class="btn btn-primary mb-2 search-btn" id="search-click">Search</button>
          </div>
          <table class="table table-hover table-responsive" id="user-list">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th class="header-cell" scope="col">Name</th>
                <th class="header-cell" scope="col">Email</th>
                <th class="header-cell" scope="col">Created User</th>
                <th class="header-cell" scope="col">Type</th>
                <th class="header-cell" scope="col">Phone</th>
                <th class="header-cell" scope="col">Date of Birth</th>
                <th class="header-cell" scope="col">Address</th>
                <th class="header-cell" scope="col">Created Date</th>
                <th class="header-cell" scope="col">Updated Date</th>
                <th class="header-cell" scope="col">Operation</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($userList as $user)
              <tr>
                <td>{{$user->id}}</td>
                <td>
                  <a class="user-name" onclick="showUserDetail({{json_encode($user)}})" data-toggle="modal" data-target="#user-detail-popup">{{$user->name}}</a></td>
                <td>{{$user->email}}</td>
                <td>{{$user->created_user}}</td>
                <td>
                  {{ config('usertype.user_types')[$user->type] }}
                </td>
                <td>{{$user->phone}}</td>
                <td>{{date('Y/m/d', strtotime($user->dob))}}</td>
                <td>{{$user->address}}</td>
                <td>{{date('Y/m/d', strtotime($user->created_at))}}</td>
                <td>{{date('Y/m/d', strtotime($user->updated_at))}}</td>
                <td>
                  @if($user->id != auth()->user()->id)
                  <button type="button" class="btn btn-danger" onclick="showDeleteConfirm({{json_encode($user)}})" data-toggle="modal" data-target="#delete-confirm">Delete</button>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="modal fade" id="user-detail-popup" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{ __('User Detail') }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" id="user-detail">
                  <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-6 text-center">
                      <img id="user-profile" class="preview-profile" src="{{'/profile/'.$userList[0]->id.'/'.$userList[0]->profile}}" />
                    </div>
                    <div class="col-lg-8 col-md-12 col-sm-6">
                      <div class="row">
                        <label class="col-md-3 text-md-left">{{ __('Name') }}</label>
                        <label class="col-md-9 text-md-left">
                          <i class="profile-text" id="user-name"></i>
                        </label>
                      </div>
                      <div class="row">
                        <label class="col-md-3 text-md-left">{{ __('Type') }}</label>
                        @if($userList[0]->type == '0')
                        <label class="col-md-9 text-md-left">
                          <i class="profile-text" id="user-type">Admin</i>
                        </label>
                        @else
                        <label class="col-md-9 text-md-left">
                          <i class="profile-text" id="user-type">User</i>
                        </label>
                        @endif
                      </div>
                      <div class="row">
                        <label class="col-md-3 text-md-left">{{ __('Email') }}</label>
                        <label class="col-md-9 text-md-left">
                          <i class="profile-text" id="user-email"></i>
                        </label>
                      </div>
                      <div class="row">
                        <label class="col-md-3 text-md-left">{{ __('Phone') }}</label>
                        <label class="col-md-9 text-md-left">
                          <i class="profile-text" id="user-phone"></i>
                        </label>
                      </div>
                      <div class="row">
                        <label class="col-md-3 text-md-left">{{ __('Date of Birth') }}</label>
                        <label class="col-md-9 text-md-left">
                          <i class="profile-text" id="user-dob"></i>
                        </label>
                      </div>
                      <div class="row">
                        <label class="col-md-3 text-md-left">{{ __('Address') }}</label>
                        <label class="col-md-9 text-md-left">
                          <i class="profile-text" id="user-address"></i>
                        </label>
                      </div>
                      <div class="row">
                        <label class="col-md-3 text-md-left">{{ __('Created Date') }}</label>
                        <label class="col-md-9 text-md-left">
                          <i class="profile-text" id="user-created-at"></i>
                        </label>
                      </div>
                      <div class="row">
                        <label class="col-md-3 text-md-left">{{ __('Created User') }}</label>
                        <label class="col-md-9 text-md-left">
                          <i class="profile-text" id="user-created-user"></i>
                        </label>
                      </div>
                      <div class="row">
                        <label class="col-md-3 text-md-left">{{ __('Updated Date') }}</label>
                        <label class="col-md-9 text-md-left">
                          <i class="profile-text" id="user-updated-at"></i>
                        </label>
                      </div>
                      <div class="row">
                        <label class="col-md-3 text-md-left">{{ __('Updated User') }}</label>
                        <label class="col-md-9 text-md-left">
                          <i class="profile-text" id="user-updated-user"></i>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="delete-confirm" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Delete Confirm</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" id="user-delete">
                  <h4 class="delete-confirm-header">Are you sure to delete user?</h4>
                  <div class="col-md-12">
                    <div class="row">
                      <label class="col-md-3 text-md-left">{{ __('ID') }}</label>
                      <label class="col-md-9 text-md-left">
                        <i class="profile-text" id="user-id"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-3 text-md-left">{{ __('Name') }}</label>
                      <label class="col-md-9 text-md-left">
                        <i class="profile-text" id="user-name"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-3 text-md-left">{{ __('Type') }}</label>
                      <label class="col-md-9 text-md-left">
                        <i class="profile-text" id="user-type"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-3 text-md-left">{{ __('Email') }}</label>
                      <label class="col-md-9 text-md-left">
                        <i class="profile-text" id="user-email"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-3 text-md-left">{{ __('Phone') }}</label>
                      <label class="col-md-9 text-md-left">
                        <i class="profile-text" id="user-phone"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-3 text-md-left"></label>
                      <label class="col-md-9 text-md-left">
                        <i class="profile-text" id="user-dob"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-3 text-md-left">{{ __('Address') }}</label>
                      <label class="col-md-9 text-md-left">
                        <i class="profile-text" id="user-address"></i>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button onclick="deleteUserById({{json_encode(csrf_token())}})" type="button" class="btn btn-danger">Delete</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection