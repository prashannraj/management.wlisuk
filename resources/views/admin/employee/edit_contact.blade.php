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
          <h6 class="h2 text-white d-inline-block mb-0">Edit contact detail</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('employee.show',$data['row']->id) }}" class="btn btn-sm btn-neutral">
          <i class="fas fa-chevron-left" ></i> Back to dashboard</a>
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
      <div class="card-body">
        <!-- Address Contact From Block -->
        <div id="AddressContactDetailAddForm">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Current Contact
                    
                    <a href="{{ route('client.show', $data['row']->employee_id) }}" class="btn btn-sm btn-primary float-right"> Back</a>



                    </h4>
                </div>
                <div class="card-body">
                    <div class="address_details_error"></div>
                    <form action="{{ route('employeecontact.update', $data['row']->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input value="{{ $data['row']->employee_id }}" name="employee_id" type="hidden">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Primary Mobile Code</label>
                                    <select class="form-control" id="country_mobile" name="country_mobile">
                                        <option value="">Select Options</option>
                                        @foreach ($data['country_code'] as $countryCode)
                                        <option value="{{ $countryCode->id }} "  {{ (($data['row']->country_mobile == $countryCode->id) ? "selected":"") }}>{{ $countryCode->title }} ({{ $countryCode->calling_code }})</option>
                                        @endforeach
                                    </select>
                                    {!! isError($errors, 'country_mobile') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Primary Mobile Number</label>
                                    <input type="text"autocomplete="off" class="form-control" name="mobile_number" id="mobile_number" value="{{ $data['row']->mobile_number }}" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Telephone Number Code</label>
                                    <select class="form-control" id="country_contact" name="country_contact">
                                        <option value="">Select Options</option>
                                        @foreach ($data['country_code'] as $countryCode)
                                        <option value="{{ $countryCode->id }} " {{ ($data['row']->country_contact == $countryCode->id ? "selected":"") }}>{{ $countryCode->title }} ({{ $countryCode->calling_code }})</option>
                                        @endforeach
                                    </select>
                                    {!! isError($errors, 'country_contact') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Telephone Number</label>
                                    <input type="text"autocomplete="off" class="form-control" name="contact_number" id="contact_number" value="{{ $data['row']->contact_number }}" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text"autocomplete="off" class="form-control" name="primary_email" id="primary_email" value="{{ $data['row']->primary_email }}" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                            </div>
                        </div>
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

<script type="text/javascript">


</script>
@endpush