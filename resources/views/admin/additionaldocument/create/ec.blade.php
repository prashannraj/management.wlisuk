@extends('layouts.master')



@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Employment Confirmation</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('employee.show',$data['employee_id']) }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back to Employee</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('main-content')
<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->

            <div class="card-body">


                <form class="" id="form_ec" action="{{ route('additionaldocument.ec.store',$data['employee_id'] )}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="employee_id" value="{{$data['employee_id']}}">
                    <div class="">
                        <div class="">
                            <div class="px-2 py-3 my-3">
                                <div id="ec" class=" mt-2 row">


                                    <div class='col-md-4'>
                                        <div class="form-group">
                                            <label class=" form-control-label" for="date">
                                                Date: </label>
                                            <div class="">
                                                <input autocomplete="off" type="text" class="form-control datepicker2" name="date" placeholder="Date" value="{{ old('date',optional($data['payload'])['date']) }}">
                                                {!! isError($errors, 'date') !!}
                                            </div>

                                        </div>
                                    </div>

                                    <div class='col-md-4'>
                                        <div class="form-group">
                                            <label class=" form-control-label" for="to_address">
                                                To address: </label>
                                            <div class="">
                                                <input autocomplete="off" id='to_address' type="text" class="form-control" name="to_address" placeholder="Address" value="{{ old('to_address',optional($data['payload'])['to_address']) }}">
                                                {!! isError($errors, 'to_address') !!}
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Employee Name</label>
                                            <input type="text" id="a_name" autocomplete="off" name='employee_name' value="{{ old('employee_name',optional($data['payload'])['employee_name'] ? optional($data['payload'])['employee_name']:$data['employee']->full_name) }}" class="form-control">


                                            {!! isError($errors, 'employee_name') !!}

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Employment Info</label>

                                            <select name="employment_info_id" class='form-control' id="">
                                                <option value="">Select employment info</option>
                                                @foreach($data['employee']->employment_infos as $info)
                                                <option {{old('employment_info_id',optional($data['payload'])['employment_info_id']) == $info->id?"selected":"" }} value="{{$info->id}}">{{$info->job_title}}</option>
                                                @endforeach
                                            </select>
                                            {!! isError($errors, 'employment_info_id') !!}

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Permanent/Temporary</label>

                                            <select name="type" class='form-control' id="">
                                                <option value="">Select option</option>
                                                @foreach(['permanent','temporary'] as $info)
                                                <option {{old('type',optional($data['payload'])['type']) == $info?"selected":"" }} value="{{$info}}">{{ucfirst($info)}}</option>
                                                @endforeach
                                            </select>
                                            {!! isError($errors, 'type') !!}

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Current address</label>
                                            <select name="" data-toggle="populate" data-target="#a_address" id="" class="form-control mb-2">
                                                <option value="">Manually add address</option>
                                                @foreach($data['employee']->addresses as $address)
                                                <option value="{{$address->full_address}}">{{$address->full_address}}</option>
                                                @endforeach
                                            </select>

                                            <input type="text" id="a_address" name='address' class="form-control" value="{{old('address',optional($data['payload'])['address'])}}">
                                            {!! isError($errors, 'address') !!}

                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Letter Signing Person</label>

                                            <select name="letter_signer_id" class='form-control' id="">
                                                <option value="">Select signing person</option>
                                                @foreach($data['employees'] as $info)
                                                <option {{old('letter_signer_id',optional($data['payload'])['letter_signer_id']) == $info->id?"selected":"" }} value="{{$info->id}}">{{$info->full_name}}</option>
                                                @endforeach
                                            </select>
                                            {!! isError($errors, 'letter_signer_id') !!}

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                    <div class="d-flex flex-row">
                                    <button type="submit" id="load_ec" class='btn btn-primary mb-2' name='action' value="load_ec">Load Content</button>
                                    <span id="loading"></span>
                                    </div>

                                        <div class="form-group">

                                            <label for="">Content</label>
                                            <textarea name="content" id="content_ec" cols="30" rows="10" class="wysiwyg">{{old('content',optional($data['payload'])['content'])}}</textarea>
                                        </div>
                                    </div>

                                    



                                    <div class="col-md-4">
                                        <h2 class="text-primary">Employment confirmation</h2>
                                        <div class="d-flex align-items-end">
                                            <button type="submit" class='btn btn-primary' name='action' value="ec">Send</button>
                                            <button name="action" formtarget="_blank" value="preview_ec" class="btn btn-outline-warning">Preview</button>

                                            <button name="action" value="pdf_ec" class="btn btn-warning">Download</button>

                                        </div>
                                    </div>

                                  

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
        format: "dd M yyyy",
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


    $('.clientautocomplete').on('autocomplete.select', function(evt, item) {
        $("#employee_id").val(item.id);
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
        $("#employee_id").val("");
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
    initiateTinymce('textarea.wysiwyg');
</script>

<script>
    $("#load_ec").on('click',function(e){
        e.preventDefault();
        var data = $("#form_ec").serializeJSON();
        var loading = $("#loading");
        data['content']=undefined;
        data['action']='load_ec';
        // alert("lol");
        console.log(data);
        $.ajax({
            type: "POST",
            url: "{{route('ajax.content.ec',$data['employee_id'])}}",
            data: data, // serializes the form's elements.
            success: function(d) {
                // alert(data); // show response from the php script.
                loading.html("done...");
                tinyMCE.get("content_ec").setContent(d)


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
@endpush