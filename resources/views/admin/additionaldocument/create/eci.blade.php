@extends('layouts.master')



@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Employee contact information</h6>
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


                <form class="" action="{{ route('additionaldocument.eci.store',$data['employee_id'] )}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="employee_id" value="{{$data['employee_id']}}">
                    <div class="">
                        <div class="">
                            <div class="px-2 py-3 my-3">
                                <div id="eci" class=" mt-2 row">


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



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Employee Name</label>
                                            <input type="text" disabled id="name" autocomplete="off" name='employee_name' value="{{ old('employee_name',optional($data['payload'])['employee_name'] ? optional($data['payload'])['employee_name']:$data['employee']->full_name) }}" class="form-control">


                                            {!! isError($errors, 'employee_name') !!}

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Current address</label>
                                            <select name="" data-toggle="populate" data-target="#address" id="" class="form-control mb-2">
                                                <option value="">Manually add address</option>
                                                @foreach($data['employee']->addresses as $address)
                                                <option value="{{$address->full_address}}">{{$address->full_address}}</option>
                                                @endforeach
                                            </select>

                                            <input type="text" id="address" name='address' class="form-control" value="{{old('address',optional($data['payload'])['address'])}}">
                                            {!! isError($errors, 'address') !!}

                                        </div>
                                    </div>


                                    <div class='col-md-6'>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label form-control-label" for="address">
                                                Mobile number: </label>
                                            <div class="col-9">
                                                <select name="" data-toggle="populate" data-target="#mobile" id="" class="form-control mb-2">
                                                    <option value="">Manually add mobile number</option>
                                                    @foreach($data['employee']->contact_details as $address)
                                                    <option value="{{$address->full_mobile_number}}">{{$address->full_mobile_number}}</option>
                                                    @endforeach
                                                </select>
                                                <input autocomplete="off" type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number" value="{{ old('mobile',optional($data['payload'])['mobile']) }}">
                                                {!! isError($errors, 'mobile') !!}
                                            </div>

                                        </div>
                                    </div>

                                    <div class='col-md-6'>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label form-control-label" for="address">
                                                Home Phone: </label>
                                            <div class="col-9">
                                                <select name="" data-toggle="populate" data-target="#contact" id="" class="form-control mb-2">
                                                    <option value="">Manually add contact number</option>
                                                    @foreach($data['employee']->contact_details as $address)
                                                    <option value="{{$address->full_contact_number}}">{{$address->full_contact_number}}</option>
                                                    @endforeach
                                                </select>
                                                <input autocomplete="off" type="text" class="form-control" name="contact" id="contact" placeholder="contact Number" value="{{ old('contact',optional($data['payload'])['contact']) }}">
                                                {!! isError($errors, 'contact') !!}
                                            </div>

                                        </div>
                                    </div>


                                    <div class='col-md-6'>
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label form-control-label" for="address">
                                                Email Address: </label>
                                            <div class="col-9">
                                                <select name="" data-toggle="populate" data-target="#email" id="" class="form-control mb-2">
                                                    <option value="">Manually add email address</option>
                                                    @foreach($data['employee']->contact_details as $address)
                                                    <option value="{{$address->primary_email}}">{{$address->primary_email}}</option>
                                                    @endforeach
                                                </select>
                                                <input autocomplete="off" type="text" class="form-control" name="email" id="email" placeholder="Address" value="{{ old('email',optional($data['payload'])['email']) }}">
                                                {!! isError($errors, 'email') !!}
                                            </div>

                                        </div>
                                    </div>







                                    <div class="col-md-4">
                                        <h2 class="text-primary">Employee contact information</h2>
                                        <div class="d-flex align-items-end">
                                            <button type="submit" class='btn btn-primary' name='action' value="eci">Send</button>
                                            <button name="action" value="pdf_eci" class="btn btn-warning">Download</button>
                                            <button name="action" value="preview_eci" class="btn btn-warning">Preview</button>

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

    var emergencyContacts = @json($data['employee']->emergency_contacts);


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
@endpush