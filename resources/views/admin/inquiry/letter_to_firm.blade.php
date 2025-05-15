@extends('layouts.master')



@section('header')
    <!-- Header -->
    <div class="header bg-wlis pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Letter to Firm When Requesting Data</h6>
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
            <p class="alert alert-warning">{{ $error }}</p>
        @endforeach
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card Body -->
                <div class="card-body">
                    <form id="form_ltf" class="" action="{{ route('enquiry.lettertofirm', $data['enquiry']->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h4 class="text-primary">Enter Primary Details</h4>

                        <div class="row">
                            <input type="hidden" id="basic_info_id" name="basic_info_id" value="{{ old('enquiry_id') }}">

                            <!-- Date -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date:</label>
                                    <input type="text" name="date" id="date" class="form-control datepicker2" value="{{ old('date', \Carbon\Carbon::parse(optional($data['lettertofirms'])->date)->format('d/m/Y')) }}">
                                    {!! isError($errors, 'date') !!}
                                </div>
                            </div>

                            <!-- Client Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nameField">Client Name:</label>
                                    <input type="text" id="nameField" class="form-control" value="{{ $data['enquiry']->full_name_with_title }}">
                                </div>
                            </div>
                            <!-- Your Client -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="your">Your Client:</label>
                                    <input type="text" id="your" name="your" class="form-control"
                                        value="{{ old('your', $data['lettertofirms']->your) }}">
                                    {!! isError($errors, 'your') !!}
                                </div>
                            </div>

                            <!-- Sponsor Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sponsor_name">Sponsor Name:</label>
                                    <input type="text" id="sponsor_name" name="sponsor_name" class="form-control"
                                        value="{{ old('sponsor_name', $data['rawInquiry']->sponsor_name ?? $data['lettertofirms']->sponsor_name) }}">
                                    {!! isError($errors, 'sponsor_name') !!}
                                </div>
                            </div>

                            <!-- Sponsor Relationship -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sponsor_relationship">Sponsor Relationship:</label>
                                    <input type="text" id="sponsor_relationship" name="sponsor_relationship" class="form-control"
                                        value="{{ old('sponsor_relationship', $data['rawInquiry']->sponsor_relationship ?? $data['lettertofirms']->sponsor_relationship) }}">
                                    {!! isError($errors, 'sponsor_relationship') !!}
                                </div>
                            </div>



                            <!-- Firm's Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firmsname">Firm's Name:</label>
                                    <input type="text" name="firmsname" class="form-control" value="{{ old('firmsname', optional($data['lettertofirms'])->firmsname) }}">
                                    {!! isError($errors, 'firmsname') !!}
                                </div>
                            </div>

                            <!-- Current Address -->
                            <div class="col-md-6">
                                @php
                                    $full_address = optional($data['enquiry']->address)->full_address;
                                @endphp
                                <div class="form-group">
                                    <label for="full_address">Current Address:</label>
                                    <p>{{ $full_address }}</p>
                                    <textarea name="full_address" class="form-control wysiwyg" rows="3">{{ nl2br(str_replace(',', "\n", $full_address)) }}</textarea>
                                </div>
                            </div>

                            <!-- Firm's Address -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firmsaddress">Firm's Address:</label>
                                    <textarea name="firmsaddress" class="form-control wysiwyg" rows="3">{{ old('firmsaddress', optional($data['lettertofirms'])->firmsaddress) }}</textarea>
                                    {!! isError($errors, 'firmsaddress') !!}
                                </div>
                            </div>

                            <!-- Client Date of Birth -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="your_date_of_birth">Client Date of Birth:</label>
                                     <input type="text" name="your_date_of_birth" id="your_date_of_birth" class="form-control datepicker2"
                                    value="{{ old('your_date_of_birth', optional($data['lettertofirms'])->your_date_of_birth ? \Carbon\Carbon::parse($data['lettertofirms']->your_date_of_birth)->format('d/m/Y') : '') }}" placeholder="dd/mm/yyyy">
                                    {!! isError($errors, 'your_date_of_birth') !!}
                                </div>
                            </div>

                           <!-- Sponsor Date of birth -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_of_birth">Sponsor Date of Birth:</label>
                                    <input type="text" name="date_of_birth" id="date_of_birth" class="form-control datepicker2"
                                    value="{{ old('date_of_birth', optional($data['lettertofirms'])->date_of_birth ? \Carbon\Carbon::parse($data['lettertofirms']->date_of_birth)->format('d/m/Y') : '') }}" placeholder="dd/mm/yyyy">

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
                                            <option value="{{ $advisor->id }}" {{ old('advisor_id', optional($data['lettertofirms'])->advisor_id) == $advisor->id ? 'selected' : '' }}>{{ $advisor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Firm's Email -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firmsemail">Firm's Email:</label>
                                    <input type="text" name="firmsemail" class="form-control" value="{{ old('firmsemail', optional($data['lettertofirms'])->firmsemail) }}">
                                    {!! isError($errors, 'firmsemail') !!}
                                </div>
                            </div>



                            <!-- Load Content Button -->
                            <div class="col-md-12">
                                <button type="button" id="loadBtn" class="btn btn-primary">Click on Save Button to Load Content</button>
                            </div>

                            <!-- Content Section -->
                            <div class="col-md-12 mt-4">
                                <div class="form-group">
                                    <label for="content_loa">Content:</label>
                                    <textarea name="content" id="content_loa" class="wysiwyg form-control" rows="10">
                                        <p>
                                            Dear Sirs,
                                          </p>

                                          <p>
                                            I act for<strong> {{ $data['enquiry']->full_name_with_title }}</strong> in an immigration matter. I understand that you previously represented <strong>{{ optional($data['lettertofirms'])->your }}</strong> in an immigration application/appeal. To assist you in identifying the case, the date of birth of<strong> {{ optional($data['lettertofirms'])->your }}</strong> is<strong> {{ \Carbon\Carbon::parse(old('your_date_of_birth', $data['lettertofirms']->your_date_of_birth ?? ''))->format('d M Y') }}</strong>.<br><br>
                                          The sponsor was<strong> {{ optional($data['lettertofirms'])->sponsor_name }}, {{ optional($data['lettertofirms'])->sponsor_relationship }}</strong>.
                                          </p>

                                          <p>
                                            You will find a letter of authority attached to this letter. I would be most grateful if you could please send a digital copy of the following material to me, <strong>{{ optional($data['advisor'])->name }}</strong> at <strong>{{ optional($data['advisor'])->email }}</strong>.
                                          </p>

                                          <ul>
                                            <li>Any bundle of evidence submitted to the Home Office or Entry Clearance Officer in connection with any application made;</li>
                                            <li>Any refusal of any application;</li>
                                            <li>All attendance notes, contemporaneous notes and work product (including client care letters etc) generated while working on the case;</li>
                                            <li>Any skeleton argument created for use in the case;</li>
                                            <li>Any Appellant’s bundle and supplementary bundles or evidence submitted;</li>
                                            <li>Any Respondent’s Bundle provided;</li>
                                            <li>Any determination in any appeal;</li>
                                            <li>Any advice, attendance notes or grounds of appeal provided by counsel;</li>
                                            <li>Any further decision of the First-tier or Upper Tribunal on permission to appeal or any appeal.</li>
                                          </ul>

                                          <p>
                                            Yours faithfully,
                                          </p>
                                    </textarea>
                                </div>
                            </div>
                        </div>

                        <h4 class="text-primary">Actions</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="shadow px-2 py-3 my-3 border">
                                    <h3 class="text-primary">Letter to Firms</h3>
                                    <button name="action" value="Save" class="btn btn-success">Save</button>
                                    <button name="action" formtarget="_blank" value="Preview" class="btn btn-warning">Preview</button>
                                    <button name="action" value="Download" class="btn btn-primary">Download</button>
                                </div>

                                <!-- File Attachments -->
                                <div class="card">
                                    <div class="card-body">
                                        <h3>Send Email</h3>
                                        <div class="attachment-list">
                                            <label for="attachments">Attachments (if any):</label>
                                            <input type="file" name="attachments[]" class="form-control">
                                        </div>
                                        <button class="btn-sm btn-primary mt-2" id="addField"><i class="fa fa-plus"></i></button>
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
