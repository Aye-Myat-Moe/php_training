@extends('layouts.app')
@section('content')
<!-- Styles -->
<link href="{{ asset('css/upload.css') }}" rel="stylesheet">

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Upload CSV File</div>
        <div class="card-body">
          @if (session('error'))
          <div class="alert alert-danger">
          {{ session('error') }}
          </div>
          @endif
          <form method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
              <label for="csv_file" class="col-md-4 col-form-label text-md-right required">{{ __('CSV File') }}</label>

              <div class="col-md-6">
                <input id="csv_file" type="file" class="csv-file form-control @error('csv_file') is-invalid @enderror" name="csv_file" value="{{ old('csv_file') }}" autocomplete="csv_file" autofocus>

                @error('csv_file')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  {{ __('Upload') }}
                </button>
                <button type="reset" class="btn btn-secondary">
                  {{ __('Clear') }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection