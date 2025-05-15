@extends('layouts.master')

@push("styles")
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
      {{-- <div class="card-header border-0">
        <h3 class="mb-0">Client Form</h3>
      </div> --}}
      <div class="card-body">
        <form class="row" action="{{ route('client.addbasicinfo') }}" method="POST">
          @csrf
          @method('POST')
          <input type="hidden" class="" name="id" value="{{ $data['row']->id }}">
          <div class="col-lg-6">
            <div class="card-wrapper">
              <!-- Form controls -->
              <div class="card">
                <!-- Card body -->
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-3 col-form-label form-control-label" for="title">Title: </label>
                    <div class="col-9">
                      <select class="form-control" id="title" name="title">
                        <option>Select Options</option>
                        @foreach ($data['title'] as $t)
                        <option value="{{ $t }}" {{ ($data['row']->title && strtolower($t)==strtolower($data['row']->title))? 'selected':'' }} {{ (old("title") == $t ? "selected":"") }}>{{ $t }}</option>
                        {{-- <option value="{{ $t->title }} ">{{ $t->title }} ({{ $t->calling_code }})</option> --}}
                        @endforeach
                      </select>
                      {!! isError($errors, 'title') !!}
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label form-control-label" for="surname">
                      Surname: </label>
                    <div class="col-9">
                      <input autocomplete="off" type="text" class="form-control" name="surname" id="surname" placeholder="Surname" value="{{ $data['row']->surname }}">
                      {!! isError($errors, 'surname') !!}
                    </div>

                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label form-control-label" for="firstName">
                      First Name: </label>
                    <div class="col-9">
                      <input autocomplete="off" type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" value="{{ $data['row']->first_name }}">
                      {!! isError($errors, 'firstName') !!}
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label form-control-label" for="middleName">Middle Name: </label>
                    <div class="col-9">
                      <input autocomplete="off" type="text" class="form-control" id="middleName" name="middleName" placeholder="Middle Name" value="{{ $data['row']->middle_name }}">
                      {!! isError($errors, 'middleName') !!}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card-wrapper">
              <!-- Form controls -->
              <div class="card">
                <!-- Card body -->
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-3 col-form-label form-control-label" for="Date of birth">Date of birth: </label>
                    <div class="col-9">
                      <input autocomplete="off" type="text" class="form-control" id="dob" name="dob" placeholder="Date of birth" value="">
                      {!! isError($errors, 'dob') !!}
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label" for="note">Gender: </label>
                    <div class="col-lg-9">
                      <div class="row pl-3">
                        <!-- Gender  -->
                        <div class="col-lg-4 custom-control custom-radio float-left mt-2">
                          <input name="gender" class="custom-control-input" id="male" type="radio" value="Male">
                          <label class="custom-control-label" for="male">Male</label>
                        </div>
                        <div class="col-lg-4 custom-control custom-radio mt-2 ">
                          <input name="gender" class="custom-control-input" id="female" type="radio" value="Female">
                          <label class="custom-control-label" for="female">Female</label>
                        </div>
                        <!-- End of Gender  -->
                      </div>
                      {!! isError($errors, 'gender') !!}
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label" for="status">Status: </label>
                    <div class="col-lg-9">
                      <div class="row pl-3">
                        <!-- Gender  -->
                        <div class="col-lg-4 mt-2 custom-control custom-radio">
                          <input name="status" class="custom-control-input" id="active" type="radio" value="Active">
                          <label class="custom-control-label" for="active">Active</label>
                        </div>
                        <div class="col-lg-4 mt-2 custom-control custom-radio">
                          <input name="status" class="custom-control-input" id="inactive" type="radio" value="Inactive">
                          <label class="custom-control-label" for="inactive">Inactive</label>
                        </div>
                        <div class="col-lg-4 mt-2 custom-control custom-radio">
                          <input name="status" class="custom-control-input" id="pending" type="radio" value="Pending">
                          <label class="custom-control-label" for="pending">Pending</label>
                        </div>
                        <!-- End of Gender  -->
                      </div>
                      {!! isError($errors, 'status') !!}
                    </div>
                  </div>

                  <button class="btn btn-icon btn-warning ml-1" type="reset">
                    <span class="btn-inner--icon"><i class="fas fa-sync"></i></span>
                    <span class="btn-inner--text">Reset</span>
                  </button>
                  <button class="btn btn-icon btn-success float-right" type="submit">
                    <span class="btn-inner--icon"><i class="ni ni-check-bold"></i></span>
                    <span class="btn-inner--text">Submit</span>
                  </button>

                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">
  $('#dob').datepicker({
    format: "{{config('constant.date_format_javascript')}}",
  });
</script>
@endpush