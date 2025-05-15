<div class="form-row">
    <div class="form-group col-md-4">
        <label>Title</label>
        <select name='title' required class="form-control">
            <option value="">Select an option</option>
            @foreach(['Mr',"Ms","Miss","Mrs"] as $country)
            <option {{old('title',optional($row)->title ) == $country?"selected":""}} value="{{$country}}">{{$country}}</option>
            @endforeach
        </select>

        {!! isError($errors, 'title') !!}

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
        <select name='iso_country_id' required class="form-control">
            <option value="">Select an option</option>
            @foreach($data['countries'] as $country)
            <option value="{{$country->id}}" {{old('iso_country_id',optional($row)->iso_country_id) == $country->id?"selected":""}}>{{ucfirst($country->title)}}</option>
            @endforeach
        </select>

        {!! isError($errors, 'iso_country_id') !!}

    </div>

</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="">Mobile country code</label>
        <select name='country_code' required class="form-control">
            <option value="">Select an option</option>
            @foreach($data['countries'] as $country)
            <option value="{{$country->id}}" {{old('country_code',optional($row)->country_iso_mobile) == $country->id?"selected":""}}>{{$country->title}} ({{$country->calling_code}})</option>
            @endforeach
        </select>

        {!! isError($errors, 'country_code') !!}

    </div>

    <div class="form-group col-md-6">
        <label>Mobile Number</label>
        <input type="text" name='contact_number' required class="form-control" id="" value="{{old('contact_number',optional($row)->mobile)}}" placeholder="Contact number">
        {!! isError($errors, 'contact_number') !!}

    </div>

    
</div>
<p>Address details</p>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="">Country</label>
        <select name='country_id' required class="form-control">
            <option value="">Select an option</option>
            @foreach($data['countries'] as $country)
            <option value="{{$country->id}}" {{old('country_code',optional($row)->country_id) == $country->id?"selected":""}}>{{$country->title}} ({{$country->calling_code}})</option>
            @endforeach
        </select>

        {!! isError($errors, 'country_id') !!}

    </div>

    <div class="form-group col-md-4">
        <label>Address</label>
        <input type="text" name='address' class="form-control" id="" value="{{old('address',optional($row)->address)}}" placeholder="Address">
        {!! isError($errors, 'address') !!}

    </div>

    <div class="form-group col-md-4">
        <label>Postal code</label>
        <input type="text" name='postal_code' class="form-control" id="" value="{{old('postal_code',optional($row)->postal_code)}}" placeholder="Postal code">
        {!! isError($errors, 'postal_code') !!}

    </div>

    
</div>
<div class="form-group">
    <label>Enquiry/Instruction</label>
    <textarea class="form-control" id="inputmessage" name='enquiry' placeholder="Enquiry/Instructions">{{old('enquiry',optional($row)->additional_details)}}</textarea>
    {!! isError($errors, 'enquiry') !!}

</div>