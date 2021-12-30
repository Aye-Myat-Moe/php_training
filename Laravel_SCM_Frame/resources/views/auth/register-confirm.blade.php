@extends('layouts.app')

@section('content')
<!-- Styles -->
<link href="{{ asset('css/register-confirm.css') }}" rel="stylesheet">

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Register Confirm') }}</div>

        <div class="card-body">
          <form method="POST" action="{{ route('registerConfirm') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
              <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autocomplete="name" readonly="readonly">
              </div>
            </div>

            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" readonly="readonly">
              </div>
            </div>

            <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" readonly="readonly">
              </div>
            </div>

            <div class="form-group row">
              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

              <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" readonly="readonly">
              </div>
            </div>

            <div class="form-group row">
              <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>
              <div class="col-md-6">
                <!-- @if(old('type') == '0')
                <input id="type" type="text" class="form-control" name="type" value="Admin" readonly="readonly" />
                @else
                <input id="type" type="text" class="form-control" name="type" value="{{config('usertype.user_types')[old('type')]}}" readonly="readonly" />
                @endif -->
                <select class="form-control @error('type') is-invalid @enderror hide-input" name="type" readonly="readonly">
                  <option value="{{ old('type') }}" selected>{{ config('usertype.user_types')[old('type')] }}</option>
                </select>
                <input id="text_type" type="text" class="form-control" name="text_type" value="{{config('usertype.user_types')[old('type')]}}" readonly="readonly" />
              </div>
            </div>

            <div class="form-group row">
              <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

              <div class="col-md-6">
                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" readonly="readonly">
              </div>
            </div>

            <div class="form-group row">
              <label for="dob" class="col-md-4 col-form-label text-md-right">{{ __('Date of Birth') }}</label>

              <div class="col-md-6">
                <input id="dob" type="date" class="form-control" name="dob" value="{{ old('dob') }}" readonly="readonly">

                @error('dob')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

              <div class="col-md-6">
                <textarea d="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" readonly="readonly">{{old('address')}}</textarea>
                @error('address')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label text-md-right">{{ __('Profile') }}</label>
              <div class="col-md-6">
                <input id="profile" type="text" class="form-control hide-input" name="profile" required value="{{ session('profileName') }}" autocomplete="profile" readonly="readonly" />
                <img class="preview-profile" src="{{session('profilePath')}}" />
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
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection