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
          <a href="{{ route('enquiry.list') }}" class="btn btn-sm btn-neutral">
            <i class="fas fa-chevron-left"></i> Back To list</a>
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
        <div id="CurrentVisaDetailAddForm">
          <div class="card">
            <div class="card-header">
              <h4>Add UK Visa
                <a href="{{ route('client.show', ['id'=> $data['row']->id, 'click'=>'immigration_info' ]) }}" class="btn btn-sm btn-primary float-right"> Back</a>
              </h4>
            </div>
            <div class="card-body">
              <div class="address_details_error"></div>
              <form action="{{ route('client.store.ukvisa') }}" method="POST">
                @csrf
                <input value="{{ $data['row']->id }}" name="basic_info_id" type="hidden">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Visa Type</label>
                      <input type="text" autocomplete="off" class="form-control" name="visa_type" id="visa_type" placeholder="Visa Type" value="{{ old('visa_type') }}">
                      {!! isError($errors, 'visa_type') !!}
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Visa Number</label>
                      <input type="text" autocomplete="off" class="form-control" name="visa_number" id="visa_number" placeholder="Visa Number" value="{{ old('visa_number') }}">
                      {!! isError($errors, 'visa_number') !!}
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Issue Date</label>
                      <input type="text" autocomplete="off" class="form-control" name="issue_date" id="issue_date" placeholder="" value="{{ old('issue_date') }}">
                      {!! isError($errors, 'issue_date') !!}
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Expiry Date</label>
                      <input type="text" autocomplete="off" class="form-control" name="expiry_date" id="expiry_date" placeholder="" value="{{ old('expiry_date') }}">
                      {!! isError($errors, 'expiry_date') !!}
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Course Start Date</label>
                      <input type="text" autocomplete="off" class="form-control" name="course_start_date" id="course_start_date" placeholder="" value="{{ old('course_start_date') }}">
                      {!! isError($errors, 'course_start_date') !!}
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Course End Date</label>
                      <input type="text" autocomplete="off" class="form-control" name="course_end_date" id="course_end_date" placeholder="" value="{{ old('course_end_date') }}">
                      {!! isError($errors, 'course_end_date') !!}
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Course Title</label>
                      <input type="text" autocomplete="off" class="form-control" name="course_title" id="course_title" placeholder="Course Title" value="{{ old('course_title') }}">
                      {!! isError($errors, 'course_title') !!}
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Level Of Study</label>
                      <input type="text" autocomplete="off" class="form-control" name="level_of_study" id="level_of_study" placeholder="Level Of Study" value="{{ old('level_of_study') }}">
                      {!! isError($errors, 'level_of_study') !!}
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Institution</label>
                      <input type="text" autocomplete="off" class="form-control" name="institution" id="institution" placeholder="Institution" value="{{ old('institution') }}">
                      {!! isError($errors, 'institution') !!}
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Note</label>
                      <textarea name="note" id="note" cols="30" rows="10" autocomplete="off" class="form-control"></textarea>
                      {!! isError($errors, 'Note') !!}
                    </div>
                  </div>
                </div>
                <button class="btn btn-primary" type="submit">Add</button>
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
    $('#issue_date').datepicker({
      format: '{{config("constant.date_format_javascript")}}'
    });
    $('#expiry_date').datepicker({
      format: '{{config("constant.date_format_javascript")}}'
    });
    $('#course_start_date').datepicker({
      format: '{{config("constant.date_format_javascript")}}'
    });
    $('#course_end_date').datepicker({
      format: '{{config("constant.date_format_javascript")}}'
    });
  });
</script>
@endpush