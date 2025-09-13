<div class="form-row">
    <div class="form-group col-md-4">
        <label>Title</label>
         <select name='title' class="form-control" id="title" onchange="showOtherField(this)" value="{{old('title',optional($row)->title)}}">
                        <option value="">Please select</option>
                        <option value="Mr" {{ old('title', optional($row)->title) == 'Mr' ? 'selected' : '' }}>Mr.</option>
                        <option value="Miss" {{ old('title', optional($row)->title) == 'Miss' ? 'selected' : '' }}>Miss.</option>
                        <option value="Mrs" {{ old('title', optional($row)->title) == 'Mrs' ? 'selected' : '' }}>Mrs.</option>
                        <option value="Ms" {{ old('title', optional($row)->title) == 'Ms' ? 'selected' : '' }}>Ms.</option>
                        <option value="Master" {{ old('title', optional($row)->title) == 'Master' ? 'selected' : '' }}>Master.</option>
                        <option value="Dr" {{ old('title', optional($row)->title) == 'Dr' ? 'selected' : '' }}>Dr.</option>
                        <option value="Other" {{ old('title', optional($row)->title) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @if(old('title', optional($row)->title) == 'Other')
                    <div id="other-field" style="display: block;">
                    <label for="other_field">Other (please type)</label>
                    <input type="text" class="form-control" id="other_text" name="other_text" placeholder="Enter other" value="{{ old('other_text', optional($row)->other_text) }}">
                    </div>
                    @else
                    <div id="other-field" style="display: none;">
                    <label for="other-field">Other (please type)</label>
                    <input type="text" class="form-control" id="other_text" name="other_text" placeholder="Enter other" value="{{ old('other_text', optional($row)->other_text) }}">
                    </div>
                    @endif


    </div>

    <div class="form-group col-md-4">
        <label>First Name</label>
        <input type="text" name='f_name' required class="form-control" id="inputName" value="{{old('f_name',optional($row)->f_name)}}" placeholder="First Name">
        {!! isError($errors, 'f_name') !!}

    </div>

    <div class="form-group col-md-4">
        <label>Middle Name</label>
        <input type="text" name='m_name' class="form-control" id="inputName" value="{{old('m_name',optional($row)->m_name)}}" placeholder="Middle Name">
        {!! isError($errors, 'm_name') !!}

    </div>

    <div class="form-group col-md-4">
        <label>Last Name</label>
        <input type="text" required name='l_name' class="form-control" id="inputName" value="{{old('l_name',optional($row)->l_name)}}" placeholder="Last Name">
        {!! isError($errors, 'l_name') !!}

    </div>


    <div class="form-group col-md-4">
        <label>Email</label>
        <input type="email" name='email' class="form-control" id="inputName" value="{{old('email',optional($row)->email)}}" placeholder="Email address">
        {!! isError($errors, 'email') !!}

    </div>

    <div class="form-group col-md-4">
        <label for="">National of</label>
        <select name='appellant_nation' required class="form-control">
            <option value="">Select an option</option>
            @foreach($data['countries'] as $country)
            <option value="{{$country->id}}" {{old('appellant_nation',optional($row)->appellant_nation) == $country->id?"selected":""}}>{{ucfirst($country->title)}}</option>
            @endforeach
        </select>

        {!! isError($errors, 'appellant_nation') !!}

    </div>

</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="">Mobile country code</label>
        <select name="country_iso_mobile" required class="form-control">
            <option value="">Select an option</option>
            @foreach($data['countries'] as $country)
            <option value="{{$country->id}}" {{ old('country_iso_mobile', optional($row)->country_iso_mobile) == $country->id ? "selected" : "" }}>{{$country->title}} ({{$country->calling_code}})</option>
            @endforeach
        </select>

        {!! isError($errors, 'country_code') !!}

    </div>

    <div class="form-group col-md-6">
        <label>Mobile Number</label>
        <input type="text" name="mobile" required class="form-control" value="{{ old('mobile', optional($row)->mobile) }}" placeholder="Contact number">
        {!! isError($errors, 'contact_number') !!}

    </div>


</div>
<p>Address details</p>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="">Country</label>
        <select name='iso_country_id' required class="form-control">
            <option value="">Select an option</option>
            @foreach($data['countries'] as $country)
            <option value="{{$country->id}}" {{old('iso_country_id',optional($row)->iso_country_id) == $country->id?"selected":""}}>{{ucfirst($country->title)}}</option>
            @endforeach
        </select>

        {!! isError($errors, 'iso_country_id') !!}

    </div>

    <div class="form-group col-md-4">
        <label>Address</label>
        <input type="text" name='appellant_address' class="form-control" id="" value="{{old('appellant_address',optional($row)->appellant_address)}}" placeholder="address">
        {!! isError($errors, 'appellant_address') !!}

    </div>

    <div class="form-group col-md-4">
        <label>Postal code</label>
        <input type="text" name='postal_code' class="form-control" id="" value="{{old('postal_code',optional($row)->postal_code)}}" placeholder="Postal code">
        {!! isError($errors, 'postal_code') !!}

    </div>


</div>
<div class="form-group">
    <label>Enquiry/Instruction</label>
    <textarea name="additional_details" class="form-control" placeholder="Enquiry/Instructions">{{ old('additional_details', optional($row)->additional_details) }}</textarea>
    {!! isError($errors, 'enquiry') !!}

</div>

<script>
 function showOtherField(select) {
    if (select.value === "Other") {
      document.getElementById("other-field").style.display = "block";
    } else {
      document.getElementById("other-field").style.display = "none";
    }
 }
</script>
