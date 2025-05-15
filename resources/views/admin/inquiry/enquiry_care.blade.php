@extends('layouts.master')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Send essential documents for {{$data['enquiry']->full_name}}</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{route('enquiry.log',$data['enquiry']->id)}}" class="btn btn-sm btn-neutral">
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



<div class="card" id="enquirycare_form">
    <div class="card-header">
        <h4 class='text-primary'>Send essential documents</h4>
    </div>

    <div class="card-body">
        <form action="{{route('enquiry.enquirycare',$data['enquiry']->id)}}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    @php
                    $full_address = optional($data['enquiry']->address)->full_address;
                    @endphp
                    <div class="form-group">
                        <label for="">Full address</label>
                        <p>{{$full_address}}</p>
                        <textarea name="full_address" class='form-control wysiwyg' rows='3'>{{ nl2br(str_replace(",", "\n", $full_address)) }}</textarea>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Date</label>
                        <input type="text" class="form-control datepicker2" value="{{optional($data['enquirycare'])->date ?? date('d/m/Y')}}" name='date'>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Cover letter content</label>
                        <div class="form-inline">
                            <select name="" id="" class="form-control">
                                <option value="0">Load from template</option>
                                @foreach($data['templates'] as $template)
                                <option value="{{$template->id}}">{{$template->title}}</option>
                                @endforeach
                            </select>
                            <button data-target="coverletter_content" class="template-load btn-small btn-primary mx-2">Load</button>
                            <span class="loading"></span>
                        </div>
                        <p class="text-small">Loading the template will overwrite the existing content. Click <atarget="_blank" href="{{route('template.index')}}">here</a> to manage templates</p>
                        <textarea name="coverletter_content" id='coverletter_content' class="form-control wysiwyg">{{old('coverletter_content',optional($data['enquirycare'])->coverletter_content )}}</textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Select Advisor</label>
                        <select name="advisor_id" class="template-select form-control mb-2">
                            <option value="">Select an advisor</option>
                            @foreach($data['advisors'] as $advisor)
                            <option {{optional($data['enquirycare'])->advisor_id == $advisor->id?"selected":""}} value="{{$advisor->id}}">{{$advisor->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="col-md-6">
                    <h4>Send email</h4>

                    <div class="documents-list">
                        <label for="">Attach from company documents</label>
                    </div>
                    <button class="btn-sm btn-primary" id="addDocumentField">
                        <i class="fa fa-plus"></i>
                    </button>


                    <div class="">

                        <div class="form-inline">
                            <div class="attachment-list">
                                <label for="">Attachments (If any)</label>
                                <input type="file" name='attachments[]' class="form-control">
                            </div>
                            <button class="btn-sm btn-primary" id="addField">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="button-group">
                        <input type="submit" name="action" value="Email" class="btn btn-primary float-right">

                        <input type="submit" formtarget="_blank" name="action" value="Download" class="btn btn-warning float-right">

                        <input type="submit" formtarget="_blank" name="action" value="Preview" class="btn btn-secondary float-right">

                        <input type="submit" name="action" value="Save" class="btn btn-warning float-right mr-2">
                    </div>
                </div>




            </div>








        </form>
    </div>
</div>







@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>


<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    function ajaxSearchTemplate($id, $loading, $target) {

        $loading.html("loading");
        $loading.show();
        var url = "/template/" + $id;
        // alert(url);
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                // alert(data); // show response from the php script.

                console.log(data);
                if (data.hasOwnProperty("content")) {
                    $loading.html("loaded...");

                    tinyMCE.get($target).setContent(data.content)
                } else {
                    $loading.html("");
                }

            },
            done: function() {

                // alert("done");
            }
        });
    }
</script>
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



    $('.servicefeeautocomplete').autoComplete({
        minLength: 1,
        resolverSettings: {
            url: '{{route("ajax.servicefee.index")}}'
        },
        events: {
            searchPost: function(data) {
                var da = [];
                data.map(function(e) {
                    da.push({
                        id: e.id,
                        value: e.id,
                        text: e.name + " - " + e.category,
                        address: e.address
                    });
                })
                return da;
            }
        },

    });

    $(".template-load").on('click', function(e) {
        e.preventDefault();
        $loading = $(this).siblings(".loading")
        var x = $(this).siblings("select").val();
        // alert($(this).data('target'));
        var target = $(this).data("target");
        ajaxSearchTemplate(x, $loading, target);
    })
</script>


<script>

</script>
<script src="{{asset('assets/js/tinymce/tinymce.min.js')}}"></script>

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
    file_picker_callback: function (callback, value, meta) {
        if (meta.filetype === 'image') {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function () {
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = function () {
                    // Call the callback to insert the image
                    callback(reader.result, { alt: file.name });
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


    function addDocumentField(e){
        e.preventDefault();
        var field = '<select name="documents[]" class="form-control">'+
        '<option>Select an option</option>'+
        '@foreach($data["documents"] as $doc) <option value="{{$doc->id}}">{{$doc->name}}</option>  @endforeach' +
        '</select>';
        $(".documents-list").append(field);

    }

    $("#addDocumentField").on('click',addDocumentField);
</script>
<script>
    document.getElementById('addNameButton').addEventListener('click', function() {
        var nameField = document.getElementById('nameField');
        var fullNameDisplay = document.getElementById('fullNameDisplay');
        var currentNames = nameField.value.split(',').map(name => name.trim()); // Get current names
        var newName = prompt("Enter the new name:"); // Prompt for a new name

        if (newName) {
            currentNames.push(newName); // Add new name to the array
            var updatedNames = currentNames.join(', '); // Create a string of names separated by commas

            nameField.value = updatedNames; // Update the input field
            fullNameDisplay.textContent = updatedNames; // Update the paragraph to display the names
        }
    });
</script>


@endpush
