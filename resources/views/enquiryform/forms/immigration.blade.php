<div class="form-row">
    <div class="form-group col-md-4">
        <label for="refusalLetterDate">Refusal letter date (DD/MM/YYYY):</label>
         <input name ="refusalLetterDate" type="date" class="form-control" id="refusalLetterDate" value="{{old('refusalLetterDate',optional($row)->refusalLetterDate)}}">

        {!! isError($errors, 'refusalLetterDate') !!}
    </div>
    <div class="form-group col-md-4">
        <label for="refusalreceivedDate">Refusal received date (DD/MM/YYYY):</label>
        <input name ="refusalreceivedDate" type="date" class="form-control" id="refusalreceivedDate" value="{{old('refusalreceivedDate',optional($row)->refusalreceivedDate)}}">
        {!! isError($errors, 'refusalreceivedDate') !!}
    </div>

    <div class="form-group col-md-4">
         <label for="applicationLocation">Did you apply in the UK or outside the UK?</label>
            <select name="applicationLocation" class="form-control" id="applicationLocation" value="{{old('applicationLocation',optional($row)->applicationLocation)}}">
            <option value="">Please select</option>
            <option value="Outside the UK" {{ old('applicationLocation', optional($row)->applicationLocation) == 'Outside the UK' ? 'selected' : '' }}> Outside the UK</option>
            <option value="Inside the UK" {{ old('applicationLocation', optional($row)->applicationLocation) == 'Inside the UK' ? 'selected' : '' }}>Inside the UK</option>
            </select>
    {!! isError($errors, 'applicationLocation') !!}
    </div>

    <div class="form-group col-md-4">
        <label>Visa application (UAN/GWF Number) <span class="text-danger">*</span></label>
        <input type="text" name='uan'  class="form-control" id="inputName" value="{{old('uan',optional($row)->uan)}}" placeholder="UAN/GWF Number">
        {!! isError($errors, 'uan') !!}
    </div>

    <div class="form-group col-md-4">
        <label>Post Reference/Ho Ref: <span class="text-danger">*</span></label>
        <input type="text" name='ho_ref'  class="form-control" id="inputName" value="{{old('ho_ref',optional($row)->ho_ref)}}" placeholder="Post Reference/Ho Ref">
        {!! isError($errors, 'ho_ref') !!}
    </div>

    <div class="form-group col-md-4">
        <label for="decision_received">How was the decision received?:</label>
            <select name='method_decision_received'  class="form-control">
                <option value="">Please Select</option>
                @foreach(['Email',"Post","Visa intermediary","In person"] as $decisionReceived)
                <option {{old('method_decision_received',optional($row)->method_decision_received ) == $decisionReceived?"selected":""}} value="{{$decisionReceived}}">{{$decisionReceived}}</option>
                @endforeach
            </select>
            {!! isError($errors, 'method_decision_received') !!}
        </div>
</div>
    <h2>Appellant details:</h2>
<div class="form-row">
    <div class="form-group col-md-4">
    <label for="title">Title:</label>
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
        <label>First Name(s): <span class="text-danger">*</span></label>
        <input type="text" name='f_name'  class="form-control" id="inputName" value="{{old('f_name',optional($row)->f_name)}}" placeholder="First Name">
        {!! isError($errors, 'f_name') !!}

    </div>

    <div class="form-group col-md-4">
        <label>Last Name(s): <span class="text-danger">*</span></label>
        <input type="text"  name='l_name' class="form-control" id="inputName" value="{{old('l_name',optional($row)->l_name)}}" placeholder="Last Name">
        {!! isError($errors, 'l_name') !!}

    </div>

    <div class="form-group col-md-4">
        <label for="birthDate">Date of Birth (DD/MM/YYYY):</label>
         <input name="birthDate" type="date" class="form-control" id="birthDate" value="{{ old('birthDate', optional($row)->birthDate) }}">
        {!! isError($errors, 'birthDate') !!}
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
<h2>Appellant Contact details:</h2>
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
    <label>Mobile Number:</label>
    <input type="text" name="mobile" required class="form-control" value="{{ old('mobile', optional($row)->mobile) }}" placeholder="Contact number">
    {!! isError($errors, 'contact_number') !!}
    </div>

    <div class="form-group col-md-6">
        <label>Appellants Email:</label>
        <input type="email" name='email'  class="form-control" id="" value="{{old('email',optional($row)->email)}}" placeholder="Appellant Email">
        {!! isError($errors, 'email') !!}

    </div>

    <div class="form-group col-md-4">
        <label for="">Appellants Country:</label>
        <select name='appellant_nation'  class="form-control">
            <option value="">Please select</option>
            @foreach($data['countries'] as $country)
                @if($country->id == '154' || $country->id == '826') // Nepal (154) and United Kingdom (826)
                    <option value="{{$country->id}}" {{old('appellant_nation',optional($row)->appellant_nation) == $country->id?"selected":""}}>{{ucfirst($country->title)}}</option>
                @endif
            @endforeach
            @foreach($data['countries'] as $country)
                @if($country->id != '154' && $country->id != '826') // exclude Nepal and United Kingdom
                    <option value="{{$country->id}}" {{old('appellant_nation',optional($row)->appellant_nation) == $country->id?"selected":""}}>{{ucfirst($country->title)}}</option>
                @endif
            @endforeach
        </select>

        {!! isError($errors, 'iso_country_id') !!}

    </div>

    <div class="form-group col-md-6">
    <label>Appellants Address:</label>
    <textarea class="form-control" id="appellantaddress" name='appellant_address'  placeholder="Appellants Address:">{{old('appellant_address',optional($row)->appellant_address)}}</textarea>
    {!! isError($errors, 'appellantaddress') !!}
    </div>


</div>
<h2>Sponsor Details:</h2>
<p>"Sponsor is someone who you are applying to join or remain in the UK e.g. Father, Mother, Sibling or a relative”</p>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="has_uk_sponsor">Do you have a UK Sponsor?</label>
        <select  name="has_uk_sponsor" class="form-control" id="has_uk_sponsor" onchange="showSponserField(this)" value="{{ old('has_uk_sponsor', optional($row)->has_uk_sponsor) }}">
            <option value="">Please select</option>
            <option value="1" {{ old('has_uk_sponsor', optional($row)->has_uk_sponsor) == '1' ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ old('has_uk_sponsor', optional($row)->has_uk_sponsor) == '0' ? 'selected' : '' }}>No</option>
        </select>
    </div>
</div>

<div id="sponsorDetails" style="{{ optional($row)->has_uk_sponsor == 1 ? '' : 'display: none;' }}">
    <div class="row">
        <div class="col-md-6">
            <label for="sponsor_name">Sponsor Name:</label>
            <input type="text" id="sponsor_name" name="sponsor_name" class="form-control" value="{{ old('sponsor_name', optional($row)->sponsor_name) }}" placeholder="Enter sponsor name">
            <label for="sponsor_relationship">Relationship with Sponsor (Father, Mother, Spouse, Uncle, Sibling, child):</label>
            <input type="text" id="sponsor_relationship" name="sponsor_relationship" class="form-control" value="{{ old('sponsor_relationship', optional($row)->sponsor_relationship) }}" placeholder="Enter sponsor relationship">
            <label for="sponsor_email">Sponsor's Contact Email (if any):</label>
            <input type="email" id="sponsor_email" name="sponsor_email" class="form-control" value="{{ old('sponsor_email', optional($row)->sponsor_email) }}" placeholder="Enter sponsor email">
        </div>
        <div class="col-md-6">
            <label for="sponsor_phone">UK Sponsor Mobile/Contact:</label>
            <input type="text" id="sponsor_phone" name="sponsor_phone" class="form-control" value="{{ old('sponsor_phone', optional($row)->sponsor_phone) }}" placeholder="Enter sponsor phone">
            <label for="sponsor_address">Sponsor's Address</label>
            <textarea id="sponsor_address" name="sponsor_address" class="form-control" placeholder="Enter sponsor address">{{ old('sponsor_address', optional($row)->sponsor_address) }}</textarea>
            <label for="sponsor_preferred">UK preferred contact person, if different to the sponsor</label>
            <input type="text" id="sponsor_preferred" name="sponsor_preferred" class="form-control" value="{{ old('sponsor_preferred', optional($row)->sponsor_preferred) }}" placeholder="UK preferred contact person">
            <label for="sponsor_preEmail">UK preferred contact person's Mobile/Email:</label>
            <textarea id="sponsor_preEmail" name="sponsor_preEmail" class="form-control" placeholder="Enter contact person's Mobile/Email">{{ old('sponsor_preEmail', optional($row)->sponsor_preEmail) }}</textarea>
           {{-- <input type="text" id="sponsor_preEmail" name="sponsor_preEmail" class="form-control" value="{{ old('sponsor_preEmail', optional($row)->sponsor_preEmail) }}" placeholder="Enter contact person's Email">--}}
        </div>
    </div>
</div>

<h2>Tell us who prepared your application?</h2>

<div class="form-row">
    <div class="form-group col-md-4">
        <label>Application prepared by (Name/contact):</label>
        <input type="text" name='preparedby' class="form-control" id="" value="{{old('preparedby',optional($row)->preparedby)}}" placeholder="Name/contact">
        {!! isError($errors, 'preparedby') !!}

    </div>

    <div class="form-group col-md-4">
        <label>Visa Application type</label>
        <input type="text" name='visa' class="form-control" id="" value="{{old('visa',optional($row)->visa)}}" placeholder="visa application type">
        {!! isError($errors, 'visa') !!}

    </div>

    <div class="form-group col-md-6">
        <label>Their Contact details (Email/Telephone):</label>
        <textarea class="form-control" id="prepared_email" name='prepared_email'  placeholder="Their Contact details (Email/Telephone)">{{old('prepared_email',optional($row)->prepared_email)}}</textarea>
        {!! isError($errors, 'prepared_email') !!}
        </div>
</div>

<h2>Authorise additional contact:</h2>

<div class="form-row">
    <p>Would you like to authorise additional contact who you wish to authorise to discuss your appeal matter?</p>
    <div class="form-group col-md-4">
        <label for="authorise"></label>
        <select  name="authorise" class="form-control" id="authorise" onchange="showAuthoriseField(this)">
            <option value="">Please select</option>
            <option value="1" {{ old('authorise') == 1 ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ old('authorise') == 0 ? 'selected' : '' }}>No</option>
        </select>
        <div id="authoriseDetail" style="{{ (optional($row)->authorise == 1) ? '' : 'display: none;' }}">
            <label for="authorise_name">Please provide their Name’s, contact phone number and email ID:</label>
            <textarea class="form-control" id="authorise_name" name='authorise_name'  placeholder="Their Contact details (Email/Telephone)">{{ old('authorise_name') ?? optional($row)->authorise_name }}</textarea>
            {!! isError($errors, 'authorise') !!}
        </div>
    </div>
</div>

<h2>Upload essential documents:</h2>
<div class="form-row">
    <div class="form-group col-md-4">
        <label>Upload refusal document:</label>
        <input type="file" name='refusal_document' class="form-control" id="" value="" placeholder="Refusal Document" multiple  accept=".pdf,.jpg,.jpeg,.png">
        @if(optional($row)->refusal_document)
        <img src="{{ asset('uploads/files/' . optional($row)->refusal_document) }}" alt="Previously uploaded file" width="100" height="100">
        @endif
        {!! isError($errors, 'refusal_document') !!}
    </div>
    <div class="form-group col-md-4">
        <label>Upload Appellant's Passport:</label>
        <input type="file" name='appellant_passport' class="form-control" id="" value="{{old('appellant_passport',optional($row)->appellant_passport)}}" placeholder="Appellant's Passport" multiple accept=".pdf,.jpg,.jpeg,.png">
        @if(optional($row)->appellant_passport)
        <img src="{{ asset('uploads/files/' . optional($row)->appellant_passport) }}" alt="Previously uploaded file" width="100" height="100">
        @endif
        {!! isError($errors, 'appellant_passport') !!}
    </div>
    <div class="form-group col-md-12">
        <label>Upload Appellant's Proof of Address: </label>
        <input type="file" name='proff_address' class="form-control" id="" value="{{old('proff_address',optional($row)->proff_address)}}" placeholder="Additional Document" multiple accept=".pdf,.jpg,.jpeg,.png">
        @if(optional($row)->proff_address)
        <img src="{{ asset('uploads/files/' . optional($row)->proff_address) }}" alt="Previously uploaded file" width="100" height="100">
        @endif
        <span class="helper">Upload (multiple documents selection at once) PDF, JPG, JPEG and PNG files only.</span>
        {!! isError($errors, 'proff_address') !!}
    </div>
</div>


<script>
     function showOtherField(select) {
    if (select.value === "Other") {
      document.getElementById("other-field").style.display = "block";
    } else {
      document.getElementById("other-field").style.display = "none";
    }
  };

    function showSponserField(select) {
    if (select.value === "1") {
        document.getElementById("sponsorDetails").style.display = "block";
    }
    else {
        document.getElementById("sponsorDetails").style.display = "none";
    }
   };

    function showAuthoriseField(select) {
    if (select.value === "1") {
        document.getElementById("authoriseDetail").style.display = "block";
    }
    else {
        document.getElementById("authoriseDetail").style.display = "none";
    }
   }

  </script>
  <script>

  $(document).ready(function() {
    $('#has_sponsor').on('change', function() {
      var value = $(this).val();
      if (value == 'Yes') {
        $('.sponsor-details').show();
      } else {
        $('.sponsor-details').hide();
      }
    });
  });

</script>
