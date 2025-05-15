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
          <h6 class="h2 text-white d-inline-block mb-0">Process to enquiry</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('rawenquiry.index') }}" class="btn btn-sm btn-neutral">
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
      <div class="card-header border-0">
        <h4 class="text-primary font-weight-600">Edit and process


          <a href="{{ route('rawenquiry.show',$data['row']->id) }}" class="btn btn-sm btn-primary float-right"> Back</a>
        </h4>
      </div>
      <div class="card-body">
        <form class="row" action="{{ route('rawenquiry.process',$data['row']->id) }}" method="POST">
          @csrf
          <div class="col-lg-6">
            <div class="card-wrapper">
              <!-- Form controls -->
              <div class="card">
                <!-- Card body -->
                <div class="card-body">
                  <div class="form-group row">
                    <label class="col-3 col-form-label form-control-label" for="title">Title: </label>
                    <div class="col-9">
                    {{-- <input autocomplete="off" type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{ $data['row']->title == 'other' ? $data['row']->other_text : $data['row']->title }}"> --}}
                      <select class="form-control" id="title" name="title">
                        <option>Select Options</option>
                        @foreach ($data['title'] as $t)
                        <option value="{{ $t }}" {{ ($data['row']->title && strtolower($t)==strtolower($data['row']->title))? 'selected':'' }} {{ (old("title") == $t ? "selected":"") }}>{{ $t }}</option>
                        @endforeach
                      </select>
                      {!! isError($errors, 'title') !!}
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label form-control-label" for="surname">
                      Surname: </label>
                    <div class="col-9">
                      <input autocomplete="off" type="text" class="form-control" name="surname" id="surname" placeholder="Surname" value="{{ old('surname',$data['row']->l_name) }}">
                      {!! isError($errors, 'surname') !!}
                    </div>

                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label form-control-label" for="firstName">
                      First Name: </label>
                    <div class="col-9">
                      <input autocomplete="off" type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name" value="{{ old('first_name',$data['row']->f_name) }}">
                      {!! isError($errors, 'first_name') !!}
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label form-control-label" for="middle_name">Middle Name: </label>
                    <div class="col-9">
                      <input autocomplete="off" type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name" value="{{ old('middle_name',$data['row']->m_name) }}">
                      {!! isError($errors, 'middle_name') !!}
                    </div>
                  </div>
                  <div class="form-group row border-bottom-1">
                    <label class="col-3 col-form-label form-control-label" for="mobile">Mobile: </label>
                    <div class="col-9">
                      <select class="form-control" id="mobile_title" name="country_mobile">
                        <option value="">Select Options</option>
                        @foreach ($data['country_code'] as $countryCode)
                        <option value="{{ $countryCode->id }}" {{ $countryCode->id==$data['row']->country_iso_mobile ? 'selected':'' }}>{{ $countryCode->title }} ({{ $countryCode->calling_code }})</option>
                        @endforeach
                      </select>
                      {!! isError($errors, 'country_mobile') !!}
                      <input autocomplete="off" type="text" class="form-control mt-3" name="mobile" id="mobile" placeholder="Mobile" value="{{ $data['row']->mobile }}">
                      {!! isError($errors, 'mobile') !!}
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-3 col-form-label form-control-label" for="email">Email: </label>
                    <div class="col-9">
                      <input autocomplete="off" type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $data['row']->email }}">
                      {!! isError($errors, 'email') !!}
                    </div>
                  </div>

                  <div class="form-group row border-bottom-1">
                    <label class="col-3 col-form-label form-control-label" for="mobile">Address details: </label>
                    <div class="col-9">
                    {{-- <input autocomplete="off" type="text" class="form-control" id="country_id" name="country_id" placeholder="Country" value="{{$data['row']->country_id}}">--}}
                      <select class="form-control" id="country_id" name="country_id">
                        <option value="">Select Options</option>
                            @foreach($data['countries'] as $country)
                         <option value="{{$country->id}}" {{old('iso_country_id',optional($data['row'])->iso_country_id) == $country->id?"selected":""}}>{{ucfirst($country->title)}}</option>
                             @endforeach
                      </select>
                      {!! isError($errors, 'country_id') !!}
                      <input autocomplete="off" type="text" class="form-control mt-3" name="address" id="address" placeholder="Address" value="{{ $data['row']->appellant_address}}">
                      {!! isError($errors, 'address') !!}

                      <input autocomplete="off" type="text" class="form-control mt-3" name="postal_code" id="postal_code" placeholder="Postal Code" value="{{ $data['row']->postal_code }}">
                      {!! isError($errors, 'address') !!}
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
                      <select class="form-control" id="enquiry_type" name="enquiry_type_id">
                        <option value="">Select Options</option>
                        @foreach ($data['enquiry_type'] as $et)
                        <option value="{{ $et->id }} " {{ (old("enquiry_type_id") == $et->id ? "selected":"") }}>{{ $et->title }} </option>
                        @endforeach
                      </select>
                      {!! isError($errors, 'enquiry_type_id') !!}
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label form-control-label" for="referral">Referral: </label>
                    <div class="col-9">
                      <input autocomplete="off" type="text" class="form-control" id="referral" name="referral" placeholder="Referral" value="{{old('referral')}}">
                      {!! isError($errors, 'referral') !!}
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label form-control-label" for="enquiry_assigned_to">Assigned To: </label>
                    <div class="col-9">
                      <select class="form-control" id="enquiry_assigned_to" name="enquiry_assigned_to">
                        <option value="">Select Options</option>
                        @foreach ($data['users'] as $user)
                        <option value="{{ $user->id }}" {{ (old("enquiry_assigned_to") == $user->id ? "selected":"") }}>{{ ucfirst($user->username) }}</option>
                        @endforeach
                      </select>
                      {!! isError($errors, 'enquiry_assigned_to') !!}
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-3 col-form-label form-control-label" for="status">Status: </label>
                    <div class="col-9">
                      <select class="form-control" id="status" name="status">
                        <option value="">Select Options</option>
                        @foreach (["Active","Inactive"] as $user)
                        <option value="{{ $user }}" {{ (old("status") == $user ? "selected":"") }}>{{ ucfirst($user) }}</option>
                        @endforeach
                      </select>
                      {!! isError($errors, 'status') !!}
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-12 col-form-label form-control-label" for="notes">Instruction/ discussion: </label>
                    <div class="col-12">
                      <textarea class="form-control" id="notes" rows="3" name="notes" value="{{ $data['row']->notes }}">{{ $data['row']->notes }}</textarea>
                      {!! isError($errors, 'notes') !!}

                      <label for="">Send processed email</label>
                      <input type="checkbox" checked name="send_processed_mail" class='checkbox-control' id="">
                      <button name='action' formtarget="_blank" value="preview" class="btn btn-icon btn-outline-success" value='preview' type="submit">
                        Preview processed document
                      </button>

                      </input>
                    </div>


                  </div>


                  <button class="btn btn-icon btn-success float-right" type="submit">
                    <span class="btn-inner--icon"><i class="ni ni-check-bold"></i></span>
                    <span class="btn-inner--text">Save</span>
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

<script type="text/javascript">


</script>
@endpush
