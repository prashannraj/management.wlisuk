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
            {{-- <div class="card-header border-0">
        <h3 class="mb-0">Enquiry Form</h3>
      </div> --}}
            <div class="card-body">
                <!-- Address Contact From Block -->
                <div id="AddressContactDetailAddForm">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Passport Contact Detail
                                <a href="{{ route('client.show', ['id'=> $data['row']->basic_info_id, 'click'=>'immigration_info' ]) }}" class="btn btn-sm btn-primary float-right"> Back</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="address_details_error"></div>
                            <form action="{{ route('client.update.passport', $data['row']->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input value="{{ $data['row']->basic_info_id }}" name="basic_info_id" type="hidden">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Issuing Country</label>
                                            <select class="form-control" id="iso_countrylist_id" name="iso_countrylist_id">
                                                <option value="">Select Options</option>
                                                @foreach ($data['country_code'] as $countryCode)
                                                <option value="{{ $countryCode->id }} " {{ ($data['row']->iso_countrylist_id && $countryCode->id == $data['row']->iso_countrylist_id)? 'selected':'' }}>{{ $countryCode->title }}</option>
                                                @endforeach
                                            </select>
                                            {!! isError($errors, 'iso_countrylist_id') !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Passport Number</label>
                                            <input type="text" autocomplete="off" class="form-control" name="passport_number" id="passport_number" placeholder="Passport Number" value="{{ $data['row']->passport_number }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Place of Birth</label>
                                            <input type="text" autocomplete="off" class="form-control" name="birth_place" id="birth_place" placeholder="" value="{{ $data['row']->birth_place }}">
                                            {!! isError($errors, 'birth_place') !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Issuing Authority</label>
                                            <input type="text" autocomplete="off" class="form-control" name="issuing_authority" id="issuing_authority" placeholder="" value="{{ $data['row']->issuing_authority }}">
                                            {!! isError($errors, 'issuing_authority') !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Issue Date</label>
                                            <input type="text" autocomplete="off" class="form-control" name="issue_date" id="issue_date" placeholder="" value="{{ $data['row']->issue_date }}">
                                            {!! isError($errors, 'issue_date') !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Expiry Date</label>
                                            <input type="text" autocomplete="off" class="form-control" name="expiry_date" id="expiry_date" placeholder="" value="{{$data['row']->expiry_date }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Citizenship Number</label>
                                            <input type="text" autocomplete="off" class="form-control" name="citizenship_number" id="citizenship_number" placeholder="" value="{{ $data['row']->citizenship_number }}">
                                            {!! isError($errors, 'citizenship_number') !!}
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-primary" type="submit">Edit</button>
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
    });
</script>
@endpush