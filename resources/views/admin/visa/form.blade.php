@php

if(!isset($disabled)) $disabled = "";

@endphp
<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Visa Type</label>
            <input type="text" autocomplete="off" class="form-control" {{$disabled}} name="visa_type" id="visa_type" placeholder="Visa Type" value="{{ old('visa_type',optional($visa)->visa_type) }}">
            {!! isError($errors, 'visa_type') !!}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Visa/BRP Number</label>
            <input type="text" autocomplete="off" class="form-control" {{$disabled}} name="visa_number" id="visa_number" placeholder="Visa Number" value="{{ old('visa_number',optional($visa)->visa_number) }}">
            {!! isError($errors, 'visa_number') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Issue Date</label>
            <input type="text" autocomplete="off" class="form-control datepicker2" {{$disabled}} name="issue_date" id="issue_date" placeholder="" value="{{ old('issue_date',optional($visa)->issue_date) }}">
            {!! isError($errors, 'issue_date') !!}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Expiry Date</label>
            <input type="text" autocomplete="off" class="form-control datepicker2" {{$disabled}} name="expiry_date" id="expiry_date" placeholder="" value="{{ old('expiry_date',optional($visa)->expiry_date) }}">
            {!! isError($errors, 'expiry_date') !!}
        </div>
    </div>
</div>