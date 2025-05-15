@extends('layouts.master')



@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Representation letter</h6>
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
<div class="row">
    <div class="col">
        <div class="card">
            <!-- Card header -->

            <div class="card-body">


                <form class="" action="{{ route('additionaldocument.rel.store',$data['basic_info_id'] )}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h4 class="text-primary">Enter primary details</h4>
                    <div class="row">
                        <input type="text" class='d-none' id='basic_info_id' id="basic_info_id" name="basic_info_id" value="{{old('basic_info_id')}}">

                        <input id="client_name" type="text" class="form-control" hidden name="client_name" placeholder="Name" value="{{ old('client_name',optional($data['payload'])['client_name'] ? optional($data['payload'])['client_name']:$data['basic_info']->full_name_with_title) }}">


                        <div class='col-md-6'>
                            <div class="form-group row">
                                <label class="col-3 col-form-label form-control-label" for="surname">
                                    Client Name: </label>
                                <div class="col-9">
                                    <input id="client_name" type="text" class="form-control" disabled name="" placeholder="Name" value="{{ old('client_name',optional($data['payload'])['client_name'] ? optional($data['payload'])['client_name']:$data['basic_info']->full_name_with_title) }}">
                                    {!! isError($errors, 'client_name') !!}
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

                        


                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-3 col-form-label form-control-label" for="">Passport/ID Number</label>
                                <div class="col-9">
                                    <select name="" data-toggle="populate" data-target="#passport_number" id="" class="form-control mb-2">
                                        <option value="">Manually add passport number</option>
                                        @foreach($data['basic_info']->passport as $passport)
                                        <option value="{{$passport->passport_number}}">{{$passport->passport_number}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" id="passport_number" name='passport_number' value="{{old('passport_number',optional($data['payload'])['passport_number'])}}" class="form-control">


                                    {!! isError($errors, 'passport_number') !!}
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-3 col-form-label form-control-label" for="">Application Type</label>
                                <div class="col-9">
                                   
                                    <input type="text" id="application_type" name='application_type' value="{{old('application_type',optional($data['payload'])['application_type'])}}" class="form-control">


                                    {!! isError($errors, 'application_type') !!}
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class='col-3 col-form-label form-control-label' for="">Immigration Application</label>
                                <div class="col-9">
                                    <select name="immigration_application_id" id="" class="form-control mb-2">
                                        <option value="">Select Application</option>
                                        @foreach($data['basic_info']->immigrationApplicationDetails as $application)
                                        <option {{old('immigration_application_id',optional($data['payload'])['immigration_application_id'])==$application->id?"selected":"" }} value="{{$application->id}}">{{$application->student_name}} - Immigration - {{$application->status->title}} ({{$application->date_submitted_format("d/m/Y")}})</option>
                                        @endforeach
                                    </select>
                                    {!! isError($errors, 'immigration_application_id') !!}
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class='btn btn-primary' name='action' value="rel">Send</button>
                        <button name="action" value="pdf_rel" class="btn btn-warning">Download</button>

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
@endpush