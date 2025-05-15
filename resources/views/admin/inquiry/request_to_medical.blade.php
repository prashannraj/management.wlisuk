@extends('layouts.master')

@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Request Access to Medical Records</h6>
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
                <form id='form_ltf' enctype="multipart/form-data" action="{{ route('enquiry.requesttomedical', $data['enquiry']->id) }}" method="POST">
                    @csrf
                    <h4 class="text-primary">Enter Primary Details (PRIVATE AND CONFIDENTIAL)</h4>
                    <div class="row">
                        <input type="hidden" name="basic_info_id" value="{{ old('enquiry_id') }}">

                         <!-- Date -->
                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date:</label>
                                <input type="text" name="date" id="date" class="form-control datepicker2" value="{{ old('date', \Carbon\Carbon::parse(optional($data['requesttomedical'])->date)->format('d/m/Y')) }}" required>
                                {!! isError($errors, 'date') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paitent_name">Patient Name:</label>
                                <input type="text" name="paitent_name" id="paitent_name" class="form-control" value="{{ old('paitent_name', optional($data['requesttomedical'])->paitent_name) }}" required>
                                {!! isError($errors, 'paitent_name') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="practice_name">Medical Practice Name:</label>
                                <input type="text" name="practice_name" id="practice_name" class="form-control" value="{{ old('practice_name', optional($data['requesttomedical'])->practice_name) }}" required>
                                {!! isError($errors, 'practice_name') !!}
                            </div>
                        </div>

                        <!-- Current Address -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="current_address">Patient Current Address:</label>
                                <input type="text" name="current_address" id="current_address" class="form-control" value="{{ old('current_address', optional($data['requesttomedical'])->current_address) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="practice_address">Medical Practice Address:</label>
                                <input type="text" name="practice_address" id="practice_address" class="form-control" value="{{ old('practice_address', optional($data['requesttomedical'])->practice_address) }}" required>
                                {!! isError($errors, 'practice_address') !!}
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paitent_address">Patient Previous Address:</label>
                                <input type="text" name="paitent_address" id="paitent_address" class="form-control" value="{{ old('paitent_address', optional($data['requesttomedical'])->paitent_address) }}">
                                {!! isError($errors, 'paitent_address') !!}
                            </div>
                        </div>

                        <div class='col-md-6'>
                            <div class="form-group">
                                <label for="nationality">Nationality:</label>
                                <select name='iso_country_id' required class="form-control">
                                    <option value="">Select an option</option>
                                    @foreach ($data['countries'] as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('iso_country_id', session('data.iso_country_id', optional($data['requesttomedical'])->iso_country_id)) == $country->id ? 'selected' : '' }}>
                                            {{ ucfirst($country->title) }}</option>
                                    @endforeach
                                </select>
                                {!! isError($errors, 'iso_country_id') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sex">Patient Sex:</label>
                                <select name="sex" id="sex" class="form-control">
                                    <option value="">Prefer not to say</option>
                                    <option value="Male" {{ old('sex', optional($data['requesttomedical'])->sex) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('sex', optional($data['requesttomedical'])->sex) == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                {!! isError($errors, 'sex') !!}
                            </div>
                        </div>




                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth:</label>
                                <input type="text" name="date_of_birth" id="date_of_birth" class="form-control datepicker2"
                                    value="{{ old('date_of_birth', optional($data['requesttomedical'])->date_of_birth ? \Carbon\Carbon::parse($data['requesttomedical']->date_of_birth)->format('d/m/Y') : '') }}" placeholder="dd/mm/yyyy">

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
                                        <option value="{{ $advisor->id }}" {{ old('advisor_id', optional($data['requesttomedical'])->advisor_id) == $advisor->id ? 'selected' : '' }}>{{ $advisor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_by">Contact By:</label>
                                <select name="contact_by" id="contact_by" class="form-control">
                                    <option value="">Prefer not to say</option>
                                    <option value="Email" {{ old('contact_by', optional($data['requesttomedical'])->contact_by) == 'Email' ? 'selected' : '' }}>Email</option>
                                    <option value="Post" {{ old('contact_by', optional($data['requesttomedical'])->contact_by) == 'Post' ? 'selected' : '' }}>Post</option>
                                </select>
                                {!! isError($errors, 'contact_by') !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="language">Patient's Communication Language:</label>
                                <input type="text" name="language" id="language" class="form-control" value="{{ old('language', optional($data['requesttomedical'])->language) }}">
                                {!! isError($errors, 'language') !!}
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
                                    <div id="content_display" style="color: black; text-align: justify; padding: 15px;">
                                        <h4>Dear Sirs,</h4>

                                        <h4>Re: (patient) {{ optional($data['requesttomedical'])->paitent_name ?? '' }}</h4>

                                        <p>
                                            I am writing to request access to my medical records under section 45 of the Data Protection Act 2018.
                                            I require these to assist in the preparation of an immigration application/appeal by members of my family
                                            who are applying to come to the United Kingdom.
                                        </p>

                                        <p>
                                            The legal representative firm/person instructed is <strong>{{ $data['company_info']->name }}</strong>
                                            located at <strong>{{ $data['company_info']->address }}</strong>.
                                        </p>

                                        <p>I would be grateful if you could send a <strong>digital copy</strong> of:</p>
                                        <ul>
                                            <li>My medical notes;</li>
                                            <li>Any referral letters sent by your practice;</li>
                                            <li>The result of any investigations or referrals sent to you;</li>
                                            <li>Any discharge summary or notes you hold in relation to any hospital treatment I may have received;</li>
                                        </ul>

                                        <p>
                                            to <strong>{{ $data['company_info']->name }}</strong> or its representative (<strong>{{ optional($data['advisor'])->name }}</strong>) at the following email address:
                                            <strong>{{ optional($data['advisor'])->email }}</strong>.
                                        </p>

                                        <p>
                                            I include below relevant personal information to assist you in identifying these:
                                        </p>

                                        <p>
                                            Please note that my second name may be a common one in <strong>{!! old('nationality', $data['selected_country'] ?? '') !!}</strong>, and I may have an attributed
                                            date of birth (e.g. 1 Jan).
                                        </p>

                                        <p>
                                            My address: <strong>{!! old('current_address', $data['requesttomedical']->current_address ?? '') !!}</strong><br><br>
                                            My previous address: <strong>{{ optional($data['requesttomedical'])->paitent_address ?? '' }}</strong><br><br>
                                            My date of birth: <strong>{{ \Carbon\Carbon::parse(old('date', $data['requesttomedical']->date_of_birth ?? ''))->format('d M Y') }}</strong><br><br>
                                            Sex: <strong>{{ optional($data['requesttomedical'])->sex ?? '' }}</strong>
                                        </p>

                                        <p>
                                            Should you need to contact me, I would prefer to be contacted by <strong>{{ optional($data['requesttomedical'])->contact_by ?? '' }}</strong>.
                                            Please note that I may have limited command of English, and it may be necessary to communicate
                                            with the assistance of an interpreter (<strong>{{ optional($data['requesttomedical'])->language ?? '' }}</strong>).
                                        </p>

                                        <p>
                                            My contact details should you require further information are: <strong>{!! old('current_address', $data['requesttomedical']->current_address ?? '') !!}</strong>
                                        </p>

                                        <p>Yours sincerely,</p>

                                        <p>Name: <strong>{{ optional($data['requesttomedical'])->paitent_name }}</p>
                                        <p>Signed:</p>
                                    </div>
                                </textarea>
                                {!! isError($errors, 'content') !!}
                            </div>
                        </div>

                     <h4 class="text-primary">Actions</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="shadow px-2 py-3 my-3 border">
                                <h3 class="text-primary">Request Access to Medical</h3>
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
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js">
    </script>


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


    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>

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
            images_upload_url: '{{ route('upload.image') }}', // Set the upload URL
            automatic_uploads: true,
            file_picker_types: 'image',
            file_picker_callback: function(callback, value, meta) {
                if (meta.filetype === 'image') {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');
                    input.onchange = function() {
                        var file = this.files[0];
                        var reader = new FileReader();
                        reader.onload = function() {
                            // Call the callback to insert the image
                            callback(reader.result, {
                                alt: file.name
                            });
                        };
                        reader.readAsDataURL(file);
                    };
                    input.click();
                }
            },
        });
    </script>

    <script>
        function addField(e) {
            e.preventDefault();
            var field = '<input type="file" name="attachments[]" class="form-control">';
            $(".attachment-list").append(field);
        }



        $("#addField").on('click', addField);

        function addDocumentField(e) {
            e.preventDefault();
            var field = '<select name="documents[]" class="form-control">' +
                '<option>Select an option</option>' +
                '@foreach ($data['documents'] as $doc) <option value="{{ $doc->id }}">{{ $doc->name }}</option>  @endforeach' +
                '</select>';
            $(".documents-list").append(field);

        }

        $("#addDocumentField").on('click', addDocumentField);
    </script>

@endpush
