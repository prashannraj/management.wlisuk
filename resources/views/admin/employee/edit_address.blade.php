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
          <h6 class="h2 text-white d-inline-block mb-0">Edit address</h6>
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
        <h3 class="mb-0">Edit address</h3>
      </div> --}}
      <div class="card-body">
        <!-- Address Contact From Block -->
        <div id="AddressContactDetailAddForm">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Address Contact Detail

                    <a href="{{ route('client.show', $data['row']->employee_id) }}" class="btn btn-sm btn-primary float-right"> Back</a>

                    </h4>
                </div>
                <div class="card-body">
                    <div class="address_details_error"></div>
                    <form action="{{ route('employeeaddress.update', $data['row']->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input value="{{ $data['row']->employee_id }}" name="employee_id" type="hidden">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Country</label>
                                    <select class="form-control" id="iso_countrylist_id" name="iso_countrylist_id">
                                        <option value="">Select Options</option>
                                        @foreach ($data['country_code'] as $countryCode)
                                            <option value="{{ $countryCode->id }} " {{ ($data['row']->iso_countrylist_id && $countryCode->id == $data['row']->iso_countrylist_id)? 'selected':'' }} >{{ $countryCode->title }} ({{ $countryCode->calling_code }})</option>
                                        @endforeach
                                    </select>
                                    {!! isError($errors, 'iso_countrylist_id') !!}
                                </div>
                            </div>
                      
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Post Code</label>
                                    <input type="text"autocomplete="off" class="form-control" name="postal_code" id="postal_code" placeholder="" value="{{ $data['row']->postal_code }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <textarea name="address" id="" cols="30" rows="5"  class="form-control" id="address">{{ $data['row']->address }}</textarea>
                                </div>
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