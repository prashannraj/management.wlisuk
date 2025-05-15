@extends('layouts.master')

@push('styles')

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
          <i class="fas fa-chevron-left" ></i> Back To list</a>
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
        <h3 class="mb-0">Enquiry Form</h3>
      </div> --}}
      <div class="card-body">
      <form class="row" action="{{ route('enquiry.update',$data['row']->id) }}" method="POST">
          @csrf
          @method('PUT')
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
                                <option value="{{ $t }}" 
                                {{ ($data['row']->title && strtolower($t)==strtolower($data['row']->title))? 'selected':'' }}
                                {{ (old("title") == $t ? "selected":"") }}>{{ $t }}</option>
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
                        <input autocomplete="off" type="text" class="form-control" id="middleName" name="middleName" placeholder="Middle Name" value="{{ $data['row']->m_name }}">
                        {!! isError($errors, 'middleName') !!}
                      </div>
                    </div>
                   <div class="form-group row border-bottom-1">
                        <label class="col-3 col-form-label form-control-label" for="mobile">Mobile: </label>
                        <div class="col-9">
                          <select class="form-control" id="mobile_title" name="mobile_code">
                              <option>Select Options</option>
                              @foreach ($data['country_code'] as $countryCode)
                                <option value="{{ $countryCode->id }}" {{ ($data['row']->country_mobile && $countryCode->id==$data['row']->country_mobile)? 'selected':'' }} >{{ $countryCode->title }} ({{ $countryCode->calling_code }})</option>
                              @endforeach
                          </select>
                          {!! isError($errors, 'mobile_code') !!}
                          <input autocomplete="off" type="text" class="form-control mt-3" name="mobile" id="mobile" placeholder="Mobile" value="{{ $data['row']->mobile }}">
                          {!! isError($errors, 'mobile') !!}
                        </div>
                    </div>
                    <div class="form-group row border-bottom-1">
                        <label class="col-3 col-form-label form-control-label" for="tel">Tel: </label>
                        <div class="col-9">
                          <select class="form-control" id="tel_code" name="tel_code">
                            <option value="">Select Options</option>
                            @foreach ($data['country_code'] as $countryCode)
                                <option value="{{ $countryCode->id }}" {{ ($data['row']->country_tel && $countryCode->id == $data['row']->country_tel)? 'selected':'' }}
                                >{{ $countryCode->title }}</option>
                              @endforeach
                          </select>
                          {!! isError($errors, 'tel_code') !!}
                          <input autocomplete="off" type="text" class="form-control mt-3" id="tel" name="tel" placeholder="Telephone" value="{{ $data['row']->tel }}">
                          {!! isError($errors, 'tel') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-3 col-form-label form-control-label" for="email">Email: </label>
                      <div class="col-9">
                        <input autocomplete="off" type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $data['row']->email }}">
                        {!! isError($errors, 'email') !!}
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
                        <label class="col-3 col-form-label form-control-label" for="enquiry_type">Enquiry Type: </label>
                        <div class="col-9">
                          <select class="form-control" id="enquiry_type" name="enquiry_type">
                              <option>Select Options</option>
                              @foreach ($data['enquiry_type'] as $et)
                                <option value="{{ $et->id }} " 
                                {{ ($data['row']->enquiry_type_id && $et->id==$data['row']->enquiry_type_id)? 'selected':'' }}
                                {{ (old("enquiry_type") == $et->id ? "selected":"") }}>{{ $et->title }} </option>
                              @endforeach
                          </select>
                          {!! isError($errors, 'enquiry_type') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label form-control-label" for="referral">Referral: </label>
                        <div class="col-9">
                           <input autocomplete="off" type="text" class="form-control" id="referral" name="referral" placeholder="Referral" value="{{ $data['row']->referral }}">
                           {!! isError($errors, 'referral') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label form-control-label" for="assignedto">Assigned To: </label>
                        <div class="col-9">
                          <select class="form-control" id="assignedto" name="assignedto">
                              <option>Select Options</option>
                              @foreach ($data['users'] as $user)
                                <option value="{{ $user->id }}" 
                                {{ (old("assignedto") == $user->id ? "selected":"") }}
                                {{ ($data['row']->enquiry_assigned_to && $user->id==$data['row']->enquiry_assigned_to)? 'selected':'' }}>{{ ucfirst($user->username) }}</option>
                              @endforeach
                          </select>
                          {!! isError($errors, 'assignedto') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-12 col-form-label form-control-label" for="note">Note: </label>
                      <div class="col-12">
                        <textarea class="form-control" id="note" rows="5" name="note">{!! ($data['row']->note) ?? '' !!}</textarea>
                        {!! isError($errors, 'note') !!}
                      </div>
                    </div>
                    <button class="btn btn-icon btn-success" type="submit">
                        <span class="btn-inner--icon"><i class="ni ni-check-bold"></i></span>
                        <span class="btn-inner--text">Submit</span>
                    </button>
                    <!-- <button class="btn btn-icon btn-warning ml-1 float-right" type="reset">
                        <span class="btn-inner--icon"><i class="fas fa-sync"></i></span>
                        <span class="btn-inner--text">Reset</span>
                    </button> -->
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

<script type="text/javascript">


</script>
@endpush