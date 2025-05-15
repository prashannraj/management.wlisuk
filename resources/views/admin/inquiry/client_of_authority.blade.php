@extends('layouts.master')

@section('header')
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Letter of Authority</h6>
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
                <form id="form_loa" action="{{ route('enquiry.clientofauthority', $data['enquiry']->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h4 class="text-primary">Enter Primary Details</h4>
                    <div class="row">
                         <!-- Date -->
                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date:</label>
                                <input type="text" name="date" id="date" class="form-control datepicker2" value="{{ old('date', \Carbon\Carbon::parse(optional($data['clientofauthority'])->date)->format('d/m/Y')) }}" required>
                                {!! isError($errors, 'date') !!}
                            </div>
                        </div>

                        <div class='col-md-6'>
                            <div class="form-group">
                                <label for="client_name">Client Name:</label>
                                <input type="text" name="client_name" class="form-control"
                                    value="{{ old('client_name', optional($data['enquiry'])->full_name_with_title) }}">
                                {!! isError($errors, 'client_name') !!}
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label for="parent_address">Parent Address (if child):</label>
                                <input type="text" id="parent_address" name="parent_address" class="form-control" value="{{ old('parent_address', optional($data['clientofauthority'])->parent_address) }}">
                                {!! isError($errors, 'parent_address') !!}
                            </div>
                        </div>

                        <div class='col-md-6'>
                            <div class="form-group">
                                <label for="full_address">Full Address:</label>
                                <input type="text" id="full_address" name="full_address" class="form-control"
                                    value="{{ old('full_address', optional($data['clientofauthority'])->full_address) }}">
                                {!! isError($errors, 'full_address') !!}
                            </div>
                        </div>

                        <div class='col-md-6'>
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth:</label>
                                <input type="text" name="date_of_birth" id="date_of_birth" class="form-control datepicker2"
                                    value="{{ old('date_of_birth', optional($data['clientofauthority'])->date_of_birth ? \Carbon\Carbon::parse($data['clientofauthority']->date_of_birth)->format('d/m/Y') : '') }}" placeholder="dd/mm/yyyy">

                                {!! isError($errors, 'date_of_birth') !!}
                            </div>
                        </div>

                        <div class='col-md-6'>
                            <div class="form-group">
                                <label for="nationality">Nationality:</label>
                                <select name='iso_country_id' required class="form-control">
                                    <option value="">Select an option</option>
                                    @foreach ($data['countries'] as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('iso_country_id', session('data.iso_country_id', optional($data['clientofauthority'])->iso_country_id)) == $country->id ? 'selected' : '' }}>
                                            {{ ucfirst($country->title) }}</option>
                                    @endforeach
                                </select>
                                {!! isError($errors, 'iso_country_id') !!}
                            </div>
                        </div>


                        <div class='col-md-6'>
                            <div class="form-group">
                                <label for="email">Client Email:</label>
                                <input type="text" id="email" name="email" class="form-control"
                                    value="{{ old('email', optional($data['clientofauthority'])->email) }}">
                                {!! isError($errors, 'email') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Select Advisor</label>
                                <select name="advisor_id" class="form-control">
                                    <option value="">Select an advisor</option>
                                    @foreach ($data['advisors'] as $advisor)
                                        <option
                                            {{ old('advisor_id', optional($data['clientofauthority'])->advisor_id) == $advisor->id ? 'selected' : '' }}
                                            value="{{ $advisor->id }}">{{ $advisor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Other Input Fields (Truncated for Brevity) -->
                        <!-- Add the rest of the fields like Address, DOB, Nationality, Email, etc. -->

                        <!-- Load Content Button -->
                        <button type="button" id="loadBtn" class="btn btn-primary">Click on Save Button for Load Content</button>

                        <!-- Content Area -->
                        <div class="col-md-12 mt-4">
                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea name="content" id="content_loa" cols="30" rows="10" class="wysiwyg">
                                    <p class="mt-4" style="margin-bottom: 0.14in; margin-top: 10px;" align="justify">I, <strong>{!! old('client_name', $data['clientofauthority']->client_name ?? '') !!}</strong> do hereby instruct <strong>{{ $data['company_info']->name }}</strong> of <strong>{{ $data['company_info']->address }}</strong> to act and represent me in respect of my Immigration matter.</p>
                                    <p style="margin-bottom: 0.14in;" align="justify">My personal details are given below:</p>
                                    <table style="width: 1000px; margin-right: auto; margin-left: auto;" cellspacing="0" cellpadding="7">
                                    <tbody>
                                    <tr valign="top">
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                    <p>Full Name:</p>
                                    </td>
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                    <p><strong>{!! old('client_name', $data['clientofauthority']->client_name ?? '') !!}</strong></p>
                                    </td>
                                    </tr>
                                    <tr valign="top">
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                    <p>Date of Birth (D.O.B):</p>
                                    </td>
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                        <p><strong>
                                            {{ \Carbon\Carbon::parse(old('date_of_birth', $data['clientofauthority']->date_of_birth ?? ''))->format('d M Y') }}
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
                                    <p>Current address:</p>
                                    </td>
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                    <p><strong>{!! old('full_address', $data['clientofauthority']->full_address ?? '') !!}</strong></p>
                                    </td>
                                    </tr>
                                    <tr valign="top">
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                    <p>Parental address (if child applicant):</p>
                                    </td>
                                    <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                    <p><strong>{!! old('parent_address', $data['clientofauthority']->parent_address ?? '') !!}</strong></p>
                                    </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                    <p style="margin-bottom: 0.14in;" align="justify">I request and require the recipient of this letter to provide all documents and data held concerning me to <strong>{{ $data['company_info']->name }}, {{ $data['company_info']->address }}</strong>.</p>
                                    <p style="margin-bottom: 0.14in;" align="justify">I further authorise all documents and data held concerning me to be sent to <strong>{{ $data['company_info']->name }}</strong> and its advisor/staff, <strong>{{ $data['advisor']->name ?? 'Default name here' }}</strong>, via their email address: <strong>{{ $data['advisor']->email ?? 'Default name here' }}.</strong></p>
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
