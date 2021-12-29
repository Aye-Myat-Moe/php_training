@extends('layouts.app')

@section('content')
<!-- Styles -->
<link href="{{ asset('css/lib/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/post-list.css') }}" rel="stylesheet">

<!-- Script -->
<script src="{{ asset('js/lib/moment.min.js') }}"></script>
<script src="{{ asset('js/lib/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/post-list.js') }}"></script>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">{{ __('Post List') }}</div>
        <div class="card-body">
          <div class="row mb-2 search-bar">
            <label class="p-2 search-lbl">Keyword :</label>
            <input class="search-input mb-2 form-control" type="text" id="search-keyword" />
            <button class="btn btn-primary mb-2 search-btn" id="search-click">Search</button>
            @if(auth()->user() && (auth()->user()->type == 0 || auth()->user()->type == 1))
            <a class="btn btn-primary header-btn" href="/post/create">{{ __('Create') }}</a>
            <a class="btn btn-primary header-btn" href="/post/upload">{{ __('Upload') }}</a>
            @endif
            <a class="btn btn-primary header-btn" href="/post/download">{{ __('Download') }}</a>
          </div>
          <table class="table table-hover" id="post-list">
            <thead>
              <tr>
                <th class="header-cell" scope="col">Post Title</th>
                <th class="header-cell" scope="col">Post Description</th>
                <th class="header-cell" scope="col">Posted User</th>
                <th class="header-cell" scope="col">Posted Date</th>
                @if(auth()->user() && (auth()->user()->type == 0 || auth()->user()->type == 1))
                <th class="header-cell" scope="col">Operation</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach ($postList as $post)
              <tr>
                <td>
                  <a class="post-name" onclick="showPostDetail({{json_encode($post)}})" data-toggle="modal" data-target="#post-detail-popup">{{$post->title}}</a>
                <td>{{$post->description}}</td>
                <td>{{$post->created_user}}</td>
                <td>{{date('Y/m/d', strtotime($post->created_at))}}</td>
                @if(auth()->user() && (auth()->user()->type == 0 || auth()->user()->type == 1))
                <td>
                  <a type="button" class="btn btn-primary" href="/post/edit/{{$post->id}}">Edit</a>
                  <button onclick="showDeleteConfirm({{json_encode($post)}})" type="button" class="btn btn-danger" data-toggle="modal" data-target="#post-delete-popup">Delete</button>
                </td>
                @endif
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="modal fade" id="post-detail-popup" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{ __('Post Detail') }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" id="post-detail">
                  <div class="col-md-12">
                    <div class="row">
                      <label class="col-md-4 text-md-left">{{ __('Title') }}</label>
                      <label class="col-md-8 text-md-left">
                        <i class="post-text" id="post-title"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-4 text-md-left">{{ __('Description') }}</label>
                      <label class="col-md-8 text-md-left">
                        <i class="post-text" id="post-description"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-4 text-md-left">{{ __('Status') }}</label>
                      <label class="col-md-8 text-md-left">
                        <i class="post-text" id="post-status"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-4 text-md-left">{{ __('Created Date') }}</label>
                      <label class="col-md-8 text-md-left">
                        <i class="post-text" id="post-created-at"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-4 text-md-left">{{ __('Created User') }}</label>
                      <label class="col-md-8 text-md-left">
                        <i class="post-text" id="post-created-user"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-4 text-md-left">{{ __('Updated Date') }}</label>
                      <label class="col-md-8 text-md-left">
                        <i class="post-text" id="post-updated-at"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-4 text-md-left">{{ __('Updated User') }}</label>
                      <label class="col-md-8 text-md-left">
                        <i class="post-text" id="post-updated-user"></i>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="post-delete-popup" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{ __('Delete Confirm') }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" id="post-delete">
                  <h4 class="delete-confirm-header">Are you sure to delete post?</h4>
                  <div class="col-md-12">
                    <div class="row">
                      <label class="col-md-4 text-md-left">{{ __('ID') }}</label>
                      <label class="col-md-8 text-md-left">
                        <i class="post-text" id="post-id"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-4 text-md-left">{{ __('Title') }}</label>
                      <label class="col-md-8 text-md-left">
                        <i class="post-text" id="post-title"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-4 text-md-left">{{ __('Description') }}</label>
                      <label class="col-md-8 text-md-left">
                        <i class="post-text" id="post-description"></i>
                      </label>
                    </div>
                    <div class="row">
                      <label class="col-md-4 text-md-left">{{ __('Status') }}</label>
                      <label class="col-md-8 text-md-left">
                        <i class="post-text" id="post-status"></i>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button onclick="deletePostById({{json_encode(csrf_token())}})" type="button" class="btn btn-danger">Delete</button>
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