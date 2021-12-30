@extends('layouts.app')

@section('content')
<!-- Styles -->
<link href="{{ asset('css/post-edit-confirm.css') }}" rel="stylesheet">

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Post Edit') }}</div>

        <div class="card-body">
          <form method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
              <label for="title" class="col-md-4 col-form-label text-md-right required">{{ __('Title') }}</label>

              <div class="col-md-6">
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus readonly="readonly">

                @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="description" class="col-md-4 col-form-label text-md-right required">{{ __('Description') }}</label>

              <div class="col-md-6">
                <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" readonly="readonly">{{ old('description') }}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

              <div class="col-md-6 mt-auto mb-auto">
                <div class="custom-control custom-switch">
                  @if(old('status'))
                  <input type="checkbox" class="custom-control-input" id="customSwitch1" name="status" checked onclick="return false;">
                  <label class="custom-control-label" for="customSwitch1"></label>
                  @else
                  <input type="checkbox" class="custom-control-input" id="customSwitch1" name="status" onclick="return false;">
                  <label class="custom-control-label" for="customSwitch1"></label>
                  @endif
                </div>
              </div>

            </div>

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('Confirm') }}
                </button>
                <a class="cancel-btn btn btn-secondary" onClick="window.history.back()">{{ __('Cancel') }}</a>
              </div>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
@endsection