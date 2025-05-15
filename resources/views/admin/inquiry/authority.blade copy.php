@extends('layouts.master')



@section('header')
    <!-- Header -->
    <div class="header bg-wlis pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Letter of authority (Non Client)</h6>
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
                <!-- Card header -->

                <div class="card-body">

                    <form id='form_loa' class="" action="{{ route('enquiry.letterofauthority', $data['enquiry']->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <h4 class="text-primary">Enter primary details</h4>
                        <div class="row">
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label for="client_name">Client Name:</label>
                                    <input type="text" name="client_name" class="form-control" value="{{ old('client_name', optional($data['letterofauthority'])->client_name) }}">
                                    {!! isError($errors, 'client_name') !!}
                                </div>
                            </div>

                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label for="parent_address">Parent Address (if child):</label>
                                    <input type="text" id="parent_address" name="parent_address" class="form-control" value="{{ old('parent_address', optional($data['letterofauthority'])->parent_address) }}">
                                    {!! isError($errors, 'parent_address') !!}
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label for="full_address">Full Address:</label>
                                    <input type="text" id="full_address" name="full_address" class="form-control"
                                        value="{{ old('full_address', optional($data['letterofauthority'])->full_address) }}">
                                    {!! isError($errors, 'full_address') !!}
                                </div>
                            </div>

                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label for="date_of_birth">Date of Birth:</label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control"
                                        value="{{ old('date_of_birth', optional($data['letterofauthority'])->date_of_birth) }}">
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
                                                {{ old('iso_country_id', session('data.iso_country_id', optional($data['letterofauthority'])->iso_country_id)) == $country->id ? 'selected' : '' }}>
                                                {{ ucfirst($country->title) }}</option>
                                        @endforeach
                                    </select>
                                    {!! isError($errors, 'iso_country_id') !!}
                                </div>
                            </div>

                            <div class='col-md-6'>
                                <div class="form-group row">
                                    <label for="">Date</label>
                                    <input type="text" class="form-control datepicker2"
                                        value="{{ old('date', optional($data['letterofauthority'])->date) ?? date('d/m/Y') }}"
                                        name='date'>
                                    {!! isError($errors, 'date') !!}
                                </div>

                            </div>

                            <div class='col-md-6'>
                                <div class="form-group">
                                    <label for="email">Client Email:</label>
                                    <input type="text" id="email" name="email" class="form-control"
                                        value="{{ old('email', optional($data['letterofauthority'])->email) }}">
                                    {!! isError($errors, 'email') !!}
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="action" value="Load" class="btn btn-primary">Load Content</button>



                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="">Content</label>
                                <textarea name="content" id="content_loa" cols="30" rows="10" class="wysiwyg">
                                                <p class="mt-4" style="margin-bottom: 0.14in; margin-top: 10px;" align="justify">I, <strong>{!! old('client_name', $data['letterofauthority']->client_name ?? '') !!}</strong> do hereby instruct <strong>{{ $data['company_info']->name }}</strong> of <strong>{{ $data['company_info']->address }}</strong> to act and represent me in respect of my Immigration matter.</p>
                                                <p style="margin-bottom: 0.14in;" align="justify">My personal details are given below:</p>
                                                <table style="width: 1000px; margin-right: auto; margin-left: auto;" cellspacing="0" cellpadding="7">
                                                <tbody>
                                                <tr valign="top">
                                                <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                                <p>Full Name:</p>
                                                </td>
                                                <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                                <p><strong>{!! old('client_name', $data['letterofauthority']->client_name ?? '') !!}</strong></p>
                                                </td>
                                                </tr>
                                                <tr valign="top">
                                                <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                                <p>D.O.B:</p>
                                                </td>
                                                <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                                <p><strong>{!! old('date_of_birth', $data['letterofauthority']->date_of_birth ?? '') !!}</strong></p>
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
                                                <p>Applicant Current Address</p>
                                                </td>
                                                <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                                <p><strong>{!! old('full_address', $data['letterofauthority']->full_address ?? '') !!}</strong></p>
                                                </td>
                                                </tr>
                                                <tr valign="top">
                                                <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="132">
                                                <p>Parental address (child applicant)</p>
                                                </td>
                                                <td style="border: 1px solid #000000; padding: 0in 0.08in;" width="100%">
                                                <p><strong>{!! old('parent_address', $data['letterofauthority']->parent_address ?? '') !!}</strong></p>
                                                </td>
                                                </tr>
                                                </tbody>
                                                </table>
                                                <p style="margin-bottom: 0.14in;" align="justify"><br /><br /></p>
                                                <p style="margin-bottom: 0.14in;" align="justify">I further authorise {{ $data['company_info']->name }} to communicate with my previous representatives, IAC, Home office and Data Protection Unit to obtain all necessary information, records and documentary evidence.</p>
                                </textarea>
                            </div>
                        </div>

                </div>

                <h4 class="text-primary">Actions</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="shadow px-2 py-3 my-3 border">
                            <h3 class="text-primary">Letter of authority</h3>
                            <button formtarget="_blank" name="action" value="preview_loa"
                                class="btn btn-outline-warning">Preview</button>

                            <button name="action" value="pdf_loa" class="btn btn-warning">Download</button>

                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h3>Send Email</h3>
                                <div class="attachment-list">
                                    <label for="">Attachments (if any)</label>
                                    <input type="file" name='attachments[]' class="form-control">
                                </div>
                                <button class="btn-sm btn-primary" id="addField">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <br>
                                <br>
                                <button name="action" value="loa" class="btn btn-primary">Send</button>

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
            format: "{{ config('constant.date_format_javascript') }}",
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


    <script></script>
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
