@extends('layouts.master')



@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Letter of authority</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('client.show',$data['basic_info_id']) }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back to Client</a>
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


                <form id='form_loa' class="" enctype="multipart/form-data" action="{{ route('additionaldocument.loa.store',$data['basic_info_id'] )}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h4 class="text-primary">Enter primary details</h4>
                    <div class="row">
                        <input type="text" class='d-none' id='basic_info_id' id="basic_info_id" name="basic_info_id" value="{{old('basic_info_id')}}">



                        <div class='col-md-6'>
                            <div class="form-group row">
                                <label class="col-3 col-form-label form-control-label" for="surname">
                                    Client Name: </label>
                                <div class="col-9">
                                    <input id="client_name" type="text" class="form-control" name="client_name" placeholder="Name" value="{{ old('client_name',optional($data['payload'])['client_name'] ? optional($data['payload'])['client_name']:$data['basic_info']->full_name_with_title) }}">
                                    {!! isError($errors, 'client_name') !!}
                                </div>

                            </div>
                        </div>

                        <div class='col-md-6'>
                            <div class="form-group row">
                                <label class="col-3 col-form-label form-control-label" for="address">
                                    Current Address: </label>
                                <div class="col-9">
                                    <select name="" data-toggle="populate" data-target="#address" id="" class="form-control mb-2">
                                        <option value="">Manually add address</option>
                                        @foreach($data['basic_info']->studentAddressDetails as $address)
                                        <option value="{{$address->full_address}}">{{$address->full_address}}</option>
                                        @endforeach
                                    </select>
                                    <input autocomplete="off" type="text" class="form-control" name="address" id="address" required placeholder="Address" value="{{ old('address',optional($data['payload'])['address'] ) }}">
                                    {!! isError($errors, 'address') !!}
                                </div>

                            </div>
                        </div>

                        <div class='col-md-6'>
                            <div class="form-group row">
                                <label class="col-3 col-form-label form-control-label" for="address">
                                    Parental Address (if child): </label>
                                <div class="col-9">
                                    <select name="" data-toggle="populate" data-target="#parental_address" id="" class="form-control mb-2">
                                        <option value="">Manually add address</option>
                                        @foreach($data['basic_info']->studentAddressDetails as $address)
                                        <option value="{{$address->full_address}}">{{$address->full_address}}</option>
                                        @endforeach
                                    </select>
                                    <input autocomplete="off" type="text" class="form-control" name="parental_address" id="parental_address" placeholder="Parental Address (for child)" value="{{ old('parental_address',optional($data['payload'])['parental_address']) }}">
                                    {!! isError($errors, 'parental_address') !!}
                                </div>

                            </div>
                        </div>

                        <div class='col-md-6 d-none'>
                            <div class="form-group row">
                                <label class="col-3 col-form-label form-control-label" for="address">
                                    Mobile number: </label>
                                <div class="col-9">
                                    <select name="" data-toggle="populate" data-target="#mobile" id="" class="form-control mb-2">
                                        <option value="">Manually add mobile number</option>
                                        @foreach($data['basic_info']->studentContactDetails as $address)
                                        <option value="{{$address->contact_mobile}}">{{$address->contact_mobile}}</option>
                                        @endforeach
                                    </select>
                                    <input autocomplete="off" type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number" value="{{ old('mobile',optional($data['payload'])['mobile']) }}">
                                    {!! isError($errors, 'mobile') !!}
                                </div>

                            </div>
                        </div>


                        <div class='col-md-6 d-none'>
                            <div class="form-group row">
                                <label class="col-3 col-form-label form-control-label" for="address">
                                    Email Address: </label>
                                <div class="col-9">
                                    <select name="" data-toggle="populate" data-target="#email" id="" class="form-control mb-2">
                                        <option value="">Manually add email address</option>
                                        @foreach($data['basic_info']->studentContactDetails as $address)
                                        <option value="{{$address->primary_email}}">{{$address->primary_email}}</option>
                                        @endforeach
                                    </select>
                                    <input autocomplete="off" type="text" class="form-control" name="email" id="email" placeholder="Address" value="{{ old('email',optional($data['payload'])['email']) }}">
                                    {!! isError($errors, 'email') !!}
                                </div>

                            </div>
                        </div>


                        <div class='col-md-6'>
                            <div class="form-group row">
                                <label class="col-3 col-form-label form-control-label" for="date">
                                    Date: </label>
                                <div class="col-9">
                                    <input autocomplete="off" type="text" class="form-control datepicker2" name="date" placeholder="Date" value="{{ old('date',optional($data['payload'])['date']) }}">
                                    {!! isError($errors, 'date') !!}
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                                    <div class="d-flex flex-row">
                                    <button type="submit" id="load_loa" class='btn btn-primary mb-2' name='action' value="load_loa">Load Content</button>
                                    <span id="loading"></span>
                                    </div>

                                        <div class="form-group">

                                            <label for="">Content</label>
                                            <textarea name="content" id="content_loa" cols="30" rows="10" class="wysiwyg">{{old('content',optional($data['payload'])['content'])}}</textarea>
                                        </div>
                                    </div>

                    </div>

                    <h4 class="text-primary">Actions</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="shadow px-2 py-3 my-3 border">
                                <h3 class="text-primary">Letter of authority</h3>
                                <button formtarget="_blank" name="action" value="preview_loa" class="btn btn-outline-warning">Preview</button>

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
<script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/cities.js') }}"></script>

<script type="text/javascript">
    $('.datepicker2').datepicker({
        format: "{{ config('constant.date_format_javascript') }}",
    });


    $('.clientautocomplete').autoComplete({
        resolverSettings: {
            url: '{{url("/ajax/clients")}}'
        },
        events: {
            searchPost: function(data) {
                var da = [];
                data.map(function(e) {
                    da.push({
                        id: e.id,
                        value: e.id,
                        text: e.full_name_with_title,
                        address: e.address,
                        mobile_number: e.mobile_number,
                        email_address: e.email_address
                    });
                })
                return da;
            }
        },

    });

    var emergencyContacts = @json($data['basic_info']->studentEmergencyDetails);


    $('.clientautocomplete').on('autocomplete.select', function(evt, item) {
        $("#basic_info_id").val(item.id);
        $("#address").val(item.address);
        $("#client_name").val(item.text);
        $("#mobile").val(item.mobile_number);
        $("#email").val(item.email_address);

        var url = "{{route('client.show','%%')}}";
        url = url.replace("%%", item.id);
        var p = `This form is currently linked to the client. <a target="_blank" href="${url}">${item.text}</a>.`;
        $("#text_linked").html(p);
        $("#text_linked").fadeIn();
        $("#btn_unlink").fadeIn();
    })

    $("#btn_unlink").on('click', function(e) {
        e.preventDefault();
        $("#basic_info_id").val("");
        $("#text_linked").html("");
        $("#text_linked").fadeOut();
        $("#btn_unlink").fadeOut();


    });

    $("select[data-toggle='populate']").on('change', function(e, value) {
        var selector = $(this).data("target");
        $(selector).val($(this).val());
    })


    $("select[data-toggle='populate_authorised']").on('change', function(e) {
        var selector = $(this).data("target");
        var target = $(e.currentTarget);

        var data = emergencyContacts.find(element => element.id == target.val());
        console.log(data);
        if (data !== null) {
            Object.keys(data).map(function(i) {
                $("#a_" + i).val(data[i]);

            })
        }
    })

    function fillAuthorisationCode() {
        var random_word = getRandomCountry();
        if ($("input[name='authorisation_word'").val().length == 0) {
            $("input[name='authorisation_word'").val(random_word)
        };
    }

    function fillAuthorisationPersons() {
        emergencyContacts.map(function(e) {

        });
    }


    $(document).ready(function() {
        fillAuthorisationCode();
    })
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
    $("#load_loa").on('click',function(e){
        e.preventDefault();
        var data = $("#form_loa").serializeJSON();
        var loading = $("#loading");
        data['content']=undefined;
        data['action']='load_loa';
        // alert("lol");
        console.log(data);
        $.ajax({
            type: "POST",
            url: "{{route('ajax.content.loa',$data['basic_info_id'])}}",
            data: data, // serializes the form's elements.
            success: function(d) {
                // alert(data); // show response from the php script.
                loading.html("done...");
                tinyMCE.get("content_loa").setContent(d)


            },
            done: function() {
                // alert("done");

            },
            error:function(e){
                console.log(e);
                loading.html("error occured, check the fields");
            }
        });
    })
</script>
<script>
    function addField(e) {
        e.preventDefault();
        var field = '<input type="file" name="attachments[]" class="form-control">';
        $(".attachment-list").append(field);
    }

    $("#addField").on('click', addField);
</script>

@endpush
