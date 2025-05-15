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
      <div class="card-body">
        <!-- Address Contact From Block -->
        <div id="AddressContactDetailAddForm">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Current Contact
                    
                    <a href="{{ route('client.show', ['id'=> $data['row']->id, 'click'=>'contact_details' ]) }}" class="btn btn-sm btn-primary float-right"> Back</a>



                    </h4>
                </div>
                <div class="card-body">
                    <div class="address_details_error"></div>
                    <form action="{{ route('update.client.contact', $data['row']->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input value="{{ $data['row']->basic_info_id }}" name="basic_info_id" type="hidden">
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
                                    <input type="text"autocomplete="off" class="form-control" name="primary_mobile" id="primary_mobile" value="{{ $data['row']->primary_mobile }}" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Telephone Number Code</label>
                                    <select class="form-control" id="country_contacttwo" name="country_contacttwo">
                                        <option value="">Select Options</option>
                                        @foreach ($data['country_code'] as $countryCode)
                                        <option value="{{ $countryCode->id }} " {{ ($data['row']->country_contacttwo == $countryCode->id ? "selected":"") }}>{{ $countryCode->title }} ({{ $countryCode->calling_code }})</option>
                                        @endforeach
                                    </select>
                                    {!! isError($errors, 'country_contacttwo') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Telephone Number</label>
                                    <input type="text"autocomplete="off" class="form-control" name="contact_number_two" id="contact_number_two" value="{{ $data['row']->contact_number_two }}" placeholder="">
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