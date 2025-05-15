@extends('layouts.master')

@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Subject Access Request – Home Office</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('enquiry.log', $data['enquiry']->id) }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back to Enquiry
                    </a>
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
                <form id='form_ltf' enctype="multipart/form-data" action="{{ route('enquiry.subjectaccess', $data['enquiry']->id) }}" method="POST">
                    @csrf
                    <h4 class="text-primary">Enter Primary Details (PRIVATE AND CONFIDENTIAL)</h4>
                    <div class="row">
                        <input type="hidden" name="basic_info_id" value="{{ old('enquiry_id') }}">

                        <!-- Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date:</label>
                                <input type="text" name="date" id="date" class="form-control datepicker2" value="{{ old('date', \Carbon\Carbon::parse(optional($data['subjectaccess'])->date)->format('d/m/Y')) }}">
                                {!! isError($errors, 'date') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reference_number">The HO reference number (if known):</label>
                                <input type="text" name="reference_number" id="reference_number" class="form-control" value="{{ old('reference_number', optional($data['subjectaccess'])->reference_number) }}" required>
                                {!! isError($errors, 'reference_number') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="appellant_name">Appellant Name:</label>
                                <input type="text" name="appellant_name" id="appellant_name" class="form-control" value="{{ old('appellant_name', optional($data['subjectaccess'])->appellant_name) }}" required>
                                {!! isError($errors, 'appellant_name') !!}
                            </div>
                        </div>

                        <!-- Current Address Input -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="current_address">Current Address:</label>
                                <input type="text" name="current_address" id="current_address" class="form-control" value="{{ old('current_address', optional($data['subjectaccess'])->current_address) }}" required>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sex">Gender:</label>
                                <select name="sex" id="sex" class="form-control">
                                    <option value="">Prefer not to say</option>
                                    <option value="Male" {{ old('sex', optional($data['subjectaccess'])->sex) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('sex', optional($data['subjectaccess'])->sex) == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                {!! isError($errors, 'sex') !!}
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth:</label>
                                <input type="text" name="date_of_birth" id="date_of_birth" class="form-control datepicker2"
                                    value="{{ old('date_of_birth', optional($data['subjectaccess'])->date_of_birth ? \Carbon\Carbon::parse($data['subjectaccess']->date_of_birth)->format('d/m/Y') : '') }}" placeholder="dd/mm/yyyy">

                                {!! isError($errors, 'date_of_birth') !!}
                            </div>
                        </div>
                         <!-- Advisor Selection -->
                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="advisor_id">Select Advisor:</label>
                                <select name="advisor_id" class="form-control">
                                    <option value="">Select an Advisor</option>
                                    @foreach ($data['advisors'] as $advisor)
                                        <option value="{{ $advisor->id }}" {{ old('advisor_id', optional($data['subjectaccess'])->advisor_id) == $advisor->id ? 'selected' : '' }}>{{ $advisor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Contact Email Input -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_details">Contact Email:</label>
                                <input type="text" name="contact_details" id="contact_details" class="form-control" value="{{ old('contact_details', optional($data['subjectaccess'])->contact_details) }}">
                                {!! isError($errors, 'contact_details') !!}
                            </div>
                        </div>

                        <!-- Contacted By Dropdown -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contacted_by">Contact By:</label>
                                <select name="contacted_by" id="contacted_by" class="form-control">
                                    <option value="">Prefer not to say</option>
                                    <option value="Email" {{ old('contacted_by', optional($data['subjectaccess'])->contacted_by) == 'Email' ? 'selected' : '' }}>Email</option>
                                    <option value="Post" {{ old('contacted_by', optional($data['subjectaccess'])->contacted_by) == 'Post' ? 'selected' : '' }}>Post</option>
                                </select>
                                {!! isError($errors, 'contacted_by') !!}
                            </div>
                        </div>

                        <!-- Load Content Button -->
                        <div class="col-md-12">
                            <button type="button" id="loadBtn" class="btn btn-primary">Click on Save Button to Load Content</button>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="content">Content:</label>
                                <textarea name="content" id="content_loa" cols="30" rows="10" class="form-control wysiwyg" required>
                                        <h4>Dear Sirs,</h4>

                                        <h4>Re: (Appellant) {{ optional($data['subjectaccess'])->appellant_name ?? '' }}</h4>

                                        <p>
                                            I am writing to request access to detailed records of documents and refusals of my visa application(s) (pursuant to section 45 of the Data Protection Act 2018).
                                        </p>
                                        <p>
                                            I would be grateful if you could please release a detailed record of my applications, refusals, and any documents held by the home office regarding my previous applications for Entry Clearance to: <strong>{{ optional($data['advisor'])->email }}</strong>
                                        </p>
                                        <p>
                                            I include below relevant personal information to assist you in identifying my file.I am afraid that this is all the information that I have concerning the visa application (s), but I hope it will allow you to locate it.
                                        </p>
                                        <p>
                                            My current address: <strong>{!! old('current_address', $data['subjectaccess']->current_address ?? '') !!}</strong><br><br>
                                            The HO reference number: <strong>{!! old('reference_number', $data['subjectaccess']->reference_number ?? '') !!}</strong><br><br>
                                            My date of birth: <strong>{{ \Carbon\Carbon::parse(old('date', $data['subjectaccess']->date_of_birth ?? ''))->format('d M Y') }}<br><br>
                                            Gender: <strong>{{ optional($data['subjectaccess'])->sex ?? '' }}</strong>
                                        </p>
                                        <p>
                                            Should you need to contact me, I would prefer to be contacted by <strong>{{ optional($data['subjectaccess'])->contacted_by ?? '' }}</strong>.
                                        </p>
                                        <p>
                                            My contact details should require further information are:<br>
                                            <strong>{!! old('current_address', $data['subjectaccess']->current_address ?? '') !!}</strong>.
                                            Email:<strong>{!! old('contact_details', $data['subjectaccess']->contact_details ?? '') !!}</strong>
                                        </p>
                                        <p>
                                            I enclose a scanned copy of my passport as evidence of my identity.
                                        </p>

                                        <p>Yours sincerely,</p>

                                        <p>Name: <strong>{{ optional($data['subjectaccess'])->appellant_name }}</p>
                                        <p>Signed:</p>
                                </textarea>
                                {!! isError($errors, 'content') !!}
                            </div>
                        </div>

                     <h4 class="text-primary">Actions</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="shadow px-2 py-3 my-3 border">
                                <h3 class="text-primary">Request Access to Tribunal</h3>
                                <button name="action" value="Save" class="btn btn-success">Save</button>
                                <button name="action" formtarget="_blank" value="Preview" class="btn btn-warning">Preview</button>
                                <button name="action" value="Download" class="btn btn-primary">Download</button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h3>Send Email</h3>
                                    <div class="attachment-list">
                                        <label for="">Attachments (if any)</label>
                                        <input type="file" name="attachments[]" class="form-control">
                                    </div>
                                    <button class="btn-sm btn-primary" id="addField">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <br>
                                    <br>
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
<script>
          $('.datepicker2').datepicker({
    format: "dd/mm/yyyy", // Specify the desired format
    autoclose: true, // Automatically close the calendar when a date is selected
    todayHighlight: true, // Highlight the current date
    startView: 0, // This allows the user to start from the day view
    todayBtn: true, // Adds a "Today" button
    forceParse: false // This allows users to manually type the date

    });

  $('.status').on('change', function(evt) {
    var $this = $(evt.currentTarget);
    if ($this.val() == 2) {
        $this.parent().parent().find('.followup').show();
    } else {
        $this.parent().parent().find('.followup').hide();
    }
})

$('#delete_log').on('show.bs.modal', function(evt) {
    var button = $(evt.relatedTarget);
    var modal = $(evt.currentTarget);
    var id = button.data('docid');

    modal.find('#doc_id').val(id);
});

$('#edit_log').on('show.bs.modal', function(evt) {
    var button = $(evt.relatedTarget);
    if (button.html() === undefined || button.hasClass('datepicker2')) {
        return;
    }


    var modal = $(evt.currentTarget);
    var id = button.data('docid');
    var note = button.data('note');
    var status = button.data('status');
    var followup_date = button.data('followup_date');

    modal.find('#activity_id').val(id);
    modal.find('#note').val(note);
    modal.find('#status').val(status);
    modal.find('#status').change();

    modal.find('#followup_date').val(followup_date);




});
</script>

<script>

    tinymce.init({
        selector: 'textarea.wysiwyg',
        height: 300,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code'
        ],
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    });

    $(document).on('click', '#addField', function(e) {
        e.preventDefault();
        var field = '<input type="file" name="attachments[]" class="form-control">';
        $(".attachment-list").append(field);
    });
</script>
@endpush
