@extends('layouts.master')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">{{ $data['panel_name']}}</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('application.admission.index') }}" class="btn btn-sm btn-neutral">
            <i class="fas fa-chevron-left"></i> Back to list</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('main-content')
<div class="row">
  <div class="col">
    <div class="card">
      <!-- Card header -->
      <!-- -->
      <div class="card-body">
        <!-- Address Contact From Block -->
        <div id="DocumentAddForm">
          <div class="card">
            <div class="card-header">
              <h4>Edit Application
                <a href="{{ route('client.show', $data['basic_info']->id) }}" class="btn btn-sm btn-primary float-right"> Back to client</a>
              </h4>
            </div>
            <div class="card-body">
              <div class="document_error"></div>
              <form action="{{ route('client.update.admission', $data['application']->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                 @include("admin.application.admission.form")
                <button class="btn btn-primary float-right" type="submit">Save</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
  $(function() {
    $('#course_start').datepicker({
      format: "{{config('constant.date_format_javascript')}}"
    });
  });
</script>
@endpush