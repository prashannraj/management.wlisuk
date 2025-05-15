@php 

if(!isset($disabled)) $disabled = "";

@endphp

<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Issuing Country</label>
            <select class="form-control" id="iso_countrylist_id" {{$disabled}} name="iso_countrylist_id">
                <option value="">Select Options</option>
                @foreach ($data['country_code'] as $countryCode)
                <option value="{{ $countryCode->id }} " {{ old('iso_countrylist_id',optional($passport)->iso_countrylist_id) == $countryCode->id? 'selected':'' }}>{{ $countryCode->title }}</option>
                @endforeach
            </select>
            {!! isError($errors, 'iso_countrylist_id') !!}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Passport Number</label>
            <input type="text" autocomplete="off" class="form-control" {{$disabled}} name="passport_number" id="passport_number" placeholder="Passport Number" 
            value="{{ old('passport_number',optional($passport)->passport_number) }}">
            {!! isError($errors, 'passport_number') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label for="">Place of Birth</label>
            <input type="text" autocomplete="off" class="form-control" {{$disabled}} name="birth_place" id="birth_place" 
            placeholder="" value="{{ old('birth_place',optional($passport)->birth_place) }}">
            {!! isError($errors, 'birth_place') !!}
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="">Issuing Authority</label>
            <input type="text" autocomplete="off" class="form-control" {{$disabled}} name="issuing_authority" id="issuing_authority" 
            placeholder="" value="{{ old('issuing_authority',optional($passport)->issuing_authority) }}">
            {!! isError($errors, 'issuing_authority') !!}
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="">Issue Date</label>
            <input type="text" autocomplete="off" class="form-control datepicker2" {{$disabled}} name="issue_date" 
            id="issue_date" placeholder="" value="{{ old('issue_date',optional($passport)->issue_date) }}">
            {!! isError($errors, 'issue_date') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Expiry Date</label>
            <input type="text" autocomplete="off" class="form-control datepicker2" {{$disabled}} name="expiry_date" 
            id="expiry_date" placeholder="" value="{{ old('expiry_date',optional($passport)->expiry_date) }}">
            {!! isError($errors, 'expiry_date') !!}
        </div>
    </div>

</div>