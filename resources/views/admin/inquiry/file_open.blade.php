@extends('layouts.master')

@section('header')
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">File Opening Form for client</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('enquiry.log', $data['enquiry']->id) }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back To Enquiry</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('main-content')
<div>
    @foreach ($errors->all() as $error)
        <p class='alert alert-warning'>{{ $error }}</p>
    @endforeach
</div>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form id="form_loa" action="{{ route('enquiry.fileopeningform', $data['enquiry']->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h4 class="text-primary">Enter Primary Details</h4>
                    <div class="row">
                        <!-- Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date:</label>
                                <input type="text" name="date" id="date" class="form-control datepicker2" value="{{ old('date', \Carbon\Carbon::parse(optional($data['fileopeningform'])->date)->format('d/m/Y')) }}" required>
                                {!! isError($errors, 'date') !!}
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_name">Client Name:</label>
                                <input type="text" name="client_name" class="form-control"
                                value="{{ old('client_name', $data['fileopeningform']->client_name ?? $data['enquiry']->full_name_with_title) }}">

                            {!! isError($errors, 'client_name') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth:</label>
                                <input type="text" name="date_of_birth" id="date_of_birth" class="form-control datepicker2"
                                    value="{{ old('date_of_birth', optional($data['fileopeningform'])->date_of_birth ? \Carbon\Carbon::parse($data['fileopeningform']->date_of_birth)->format('d/m/Y') : '') }}" placeholder="dd/mm/yyyy">

                                {!! isError($errors, 'date_of_birth') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="matter">Matter:</label>
                                <input type="text" name="matter" id="matter" class="form-control" value="{{ old('matter', optional($data['fileopeningform'])->matter) }}" required>
                                {!! isError($errors, 'matter') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-3 col-form-label form-control-label" for="email">
                                    Email Address:
                                </label>
                                <div class="col-9">
                                    <select name="email" data-toggle="populate" data-target="#email" id="email_select" class="form-control mb-2">
                                        <option value="">Manually add email address</option>
                                        <option value="{{ $data['enquiry']->email }}" {{ old('email') == $data['enquiry']->email ? 'selected' : '' }}>
                                            {{ $data['enquiry']->email }}
                                        </option>
                                    </select>

                                    <input autocomplete="off" type="text" class="form-control" name="email" id="email" required placeholder="Email Address" value="{{ old('email', $data['fileopeningform']->email ?? $data['enquiry']->email) }}">
                                    {!! isError($errors, 'email') !!}
                                </div>
                            </div>
                        </div>


                        <div class='col-md-6'>
                            <div class="form-group">
                                <label for="nationality">Nationality:</label>
                                <select name='iso_country_id' required class="form-control">
                                    <option value="">Select an option</option>
                                    @foreach ($data['countries'] as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('iso_country_id', session('data.iso_country_id', optional($data['fileopeningform'])->iso_country_id)) == $country->id ? 'selected':''}}>
                                            {{ ucfirst($country->title) }}</option>
                                    @endforeach
                                </select>
                                {!! isError($errors, 'iso_country_id') !!}
                            </div>
                        </div>

                        <!-- Current Address -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-3 col-form-label form-control-label" for="current_address">
                                    Current Address:
                                </label>
                                <div class="col-9">
                                    <select name="current_address" data-toggle="populate" data-target="#current_address" id="current_address_select" class="form-control mb-2">
                                        <option value="">Manually add address</option>
                                        <option value="{{ $data['enquiry']->address->full_address }}" {{ old('current_address') == $data['enquiry']->address->full_address ? 'selected' : '' }}>
                                            {{ $data['enquiry']->address->full_address }}
                                        </option>
                                    </select>

                                    <input autocomplete="off" type="text" class="form-control" name="current_address" id="current_address" required placeholder="Address" value="{{ old('current_address', $data['fileopeningform']->current_address ?? ($data['enquiry']->address)->full_address) }}">
                                    {!! isError($errors, 'current_address') !!}
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-3 col-form-label form-control-label" for="mobile">
                                    Mobile:
                                </label>
                                <div class="col-9">
                                    <select name="mobile" data-toggle="populate" data-target="#mobile" id="mobile_select" class="form-control mb-2">
                                        <option value="">Manually add mobile number</option>
                                        <option value="{{ $data['enquiry']->mobile }}" {{ old('mobile') == $data['enquiry']->mobile ? 'selected' : '' }}>
                                            {{ $data['enquiry']->mobile }}
                                        </option>
                                    </select>

                                    <input autocomplete="off" type="text" class="form-control" name="mobile" id="mobile" required placeholder="Mobile Number" value="{{ old('mobile', $data['fileopeningform']->mobile ?? $data['enquiry']->mobile) }}">
                                    {!! isError($errors, 'mobile') !!}
                                </div>
                            </div>
                        </div>



                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="authorised_name">Authorised Person's Name:</label>
                                <input type="text" name="authorised_name" id="authorised_name" class="form-control" value="{{ old('authorised_name', optional($data['fileopeningform'])->authorised_name) }}">
                                {!! isError($errors, 'authorised_name') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="authorised_relation">Authorised Person's Relationship:</label>
                                <input type="text" name="authorised_relation" id="authorised_relation" class="form-control" value="{{ old('authorised_relation', optional($data['fileopeningform'])->authorised_relation) }}">
                                {!! isError($errors, 'authorised_relation') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="authorised_address">Authorised Person's address:</label>
                                <input type="text" name="authorised_address" id="authorised_address" class="form-control" value="{{ old('authorised_address', optional($data['fileopeningform'])->authorised_address) }}">
                                {!! isError($errors, 'authorised_address') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_no">Authorised Person's contact:</label>
                                <input type="text" name="contact_no" id="contact_no" class="form-control" value="{{ old('contact_no', optional($data['fileopeningform'])->contact_no) }}">
                                {!! isError($errors, 'contact_no') !!}
                            </div>
                        </div>

                         <!-- Advisor Selection -->
                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="advisor_id">Select Advisor:</label>
                                <select name="advisor_id" class="form-control">
                                    <option value="">Select an Advisor</option>
                                    @foreach ($data['advisors'] as $advisor)
                                        <option value="{{ $advisor->id }}" {{ old('advisor_id', optional($data['fileopeningform'])->advisor_id) == $advisor->id ? 'selected' : '' }}>{{ $advisor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="authorised_email">Authorised Email :</label>
                                <input type="text" name="authorised_email" id="authorised_email" class="form-control" value="{{ old('authorised_email', optional($data['fileopeningform'])->authorised_email) }}">
                                {!! isError($errors, 'authorised_email') !!}
                            </div>
                        </div>

                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="word">Word:</label>
                                <input type="text" name="word" id="word" class="form-control" value="{{ old('word', optional($data['fileopeningform'])->word) }}">
                                {!! isError($errors, 'word') !!}
                            </div>
                        </div> --}}
                        <!-- Other Input Fields (Truncated for Brevity) -->
                        <!-- Add the rest of the fields like Address, DOB, Nationality, Email, etc. -->

                        <!-- Load Content Button -->
                        <div class="col-md-12">
                            <button type="button" id="loadBtn" class="btn btn-primary">Click on Save Button to Load Content</button>
                        </div>
                        <!-- Content Area -->
                        <div class="col-md-12 mt-4">
                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea name="content" id="content_loa" cols="30" rows="10" class="wysiwyg">
                                    <p class="mt-4" style="margin-bottom: 0.14in; margin-top: 10px;" align="justify">Client Details</p>
                                    <table style="width: 1000px; margin-right: auto; margin-left: auto;" cellspacing="0" cellpadding="7">
                                    <tbody>
                                    <tr valign="top">
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                    <p>Full Name:</p>
                                    </td>
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                    <p><strong>{!! old('client_name', $data['fileopeningform']->client_name ?? '') !!}</strong></p>
                                    </td>
                                    </tr>
                                    <tr valign="top">
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                    <p>Date of Birth (D.O.B):</p>
                                    </td>
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                        <p><strong>
                                            {{ \Carbon\Carbon::parse(old('date_of_birth', $data['fileopeningform']->date_of_birth ?? ''))->format('d M Y') }}
                                        </strong></p>
                                    </td>
                                    </tr>
                                    <tr valign="top">
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                    <p>National of:</p>
                                    </td>
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                    <p><strong>{!! old('nationality', $data['selected_country'] ?? '') !!}</strong></p>
                                    </td>
                                    </tr>
                                    <tr valign="top">
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                    <p> Applicant Current address:</p>
                                    </td>
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                    <p><strong>{!! old('current_address', $data['fileopeningform']->current_address ?? '') !!}</strong></p>
                                    </td>
                                    </tr>
                                    <tr valign="top">
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                    <p>Mobile:</p>
                                    </td>
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                    <p><strong>{!! old('mobile', $data['fileopeningform']->mobile ?? '') !!}</strong></p>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                        <p>Email:</p>
                                        </td>
                                        <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                        <p><strong>{!! old('email', $data['fileopeningform']->email ?? '') !!}</strong></p>
                                    </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                    <p style="margin-bottom: 0.14in;" align="justify">I agree to this <strong>{!! old('matter', $data['fileopeningform']->matter ?? '') !!}</strong> matter being opened.</p>
                                    <p style="margin-bottom: 0.14in;" align="justify">I agree my case/file information can be discussed or shared with the following individual: </p>
                                    <table style="width: 1000px; margin-right: auto; margin-left: auto;" cellspacing="0" cellpadding="7">
                                        <tbody>
                                        <tr valign="top">
                                        <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                        <p>Authorised person's name: </p>
                                        </td>
                                        <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                        <p><strong>{!! old('authorised_name', $data['fileopeningform']->authorised_name ?? '') !!}</strong></p>
                                        </td>
                                        </tr>
                                        <tr valign="top">
                                        <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                        <p>Relationship to client:</p>
                                        </td>
                                        <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                            <p><strong>{!! old('authorised_relation', $data['fileopeningform']->authorised_relation ?? '') !!}</strong></p>
                                        </td>
                                        </tr>
                                        <tr valign="top">
                                        <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                        <p>Address:</p>
                                        </td>
                                        <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                            <p><strong>{!! old('authorised_address', $data['fileopeningform']->authorised_address ?? '') !!}</strong></p>
                                        </td>
                                        </tr>
                                        <tr valign="top">
                                        <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                        <p> Tel/Mobile: </p>
                                        </td>
                                        <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                        <p><strong>{!! old('contact_no', $data['fileopeningform']->contact_no ?? '') !!}</strong></p>
                                        </td>
                                        </tr>
                                        <tr valign="top">
                                        <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                        <p>Email:</p>
                                        </td>
                                        <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                        <p><strong>{!! old('authorised_email', $data['fileopeningform']->authorised_email ?? '') !!}</strong></p>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                            <p>Authorisation word:</p>
                                            </td>
                                            <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                            <p><strong>{!! old('nationality', $data['selected_country'] ?? '') !!}</strong></p>
                                        </td>
                                        </tr>
                                        </tbody>
                                        </table>
                                </textarea>
                            </div>
                        </div>
                    </div>

                    <h4 class="text-primary">Actions</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="shadow px-2 py-3 my-3 border">
                                <h3 class="text-primary">Letter of authority</h3>
                                <button name="action" value="Save" class="btn btn-success">Save</button>
                                <button name="action" formtarget="_blank" value="Preview" class="btn btn-warning">Preview</button>
                                <button name="action" value="Download" class="btn btn-primary">Download</button>
                            </div>
                            <!-- File Attachments -->
                            <div class="card">
                                <div class="card-body">
                                    <h3>Send Email</h3>
                                    <div class="attachment-list">
                                        <label for="attachments">Attachments (if any)</label>
                                        <input type="file" name="attachments[]" class="form-control">
                                    </div>
                                    <button class="btn-sm btn-primary" id="addField"><i class="fa fa-plus"></i></button>
                                    <br><br>
                                    <button name="action" value="Email" class="btn btn-info">Send Email</button>
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
<script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>

<script>
// Initialize Datepicker
$('.datepicker2').datepicker({
    format: "{{ config('constant.date_format_javascript') }}",
});

// Initialize WYSIWYG Editor
tinymce.init({
    selector: 'textarea.wysiwyg',
    height: 300,
    plugins: ['advlist autolink lists link image charmap print preview anchor', 'searchreplace visualblocks code fullscreen', 'insertdatetime media table contextmenu paste code'],
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    images_upload_url: '{{ route('upload.image') }}',
    automatic_uploads: true,
});

// Load Content via AJAX
$('#loadContent').on('click', function () {
    $.ajax({
        type: "POST",
        url: "{{ route('ajax.load.loa', $data['enquiry']->id) }}",
        data: { _token: '{{ csrf_token() }}' },
        success: function (response) {
            tinyMCE.get('content_loa').setContent(response.content);
        },
        error: function (error) {
            alert('Unable to load content.');
        }
    });
});


// Add Attachment Fields
$('#addField').on('click', function (e) {
    e.preventDefault();
    $('.attachment-list').append('<input type="file" name="attachments[]" class="form-control mt-2">');
});

</script>
@endpush
