@extends('layouts.master')



@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Sponsor declaration</h6>
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


                <form class="" action="{{ route('additionaldocument.spd.store',$data['basic_info_id'] )}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="">
                        <div class="">
                            <div class="px-2 py-3 my-3">
                                <div id="spd" class=" mt-2 row">
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Select or type declarant</label>
                                            <select name="" data-toggle="populate_authorised" data-target="#a_name,#a_relationship,#a_contact_number,#a_email,#a_address" class="form-control mb-2">
                                                <option value="">Manually enter all entry</option>
                                                @foreach($data['basic_info']->studentEmergencyDetails as $address)
                                                <option value="{{$address->id}}">{{$address->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col-md-4'>
                                        <div class="form-group">
                                            <label class=" col-form-label form-control-label" for="date">
                                                Declaration date: </label>
                                            <div class="">
                                                <input autocomplete="off" type="text" class="form-control datepicker2" name="date" placeholder="Date" value="{{ old('date',optional($data['payload'])['date']) }}">
                                                {!! isError($errors, 'date') !!}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Declarant's name</label>
                                            <input type="text" id="a_name" autocomplete="off" name='authorised_person_name' value="{{old('authorised_person_name',optional($data['payload'])['authorised_person_name'])}}" class="form-control">


                                            {!! isError($errors, 'authorised_person_name') !!}

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Declarant's DOB</label>
                                            <input type="text" id="a_dob" autocomplete="off" name='authorised_person_dob' class="form-control datepicker2" value="{{old('authorised_person_dob',optional($data['payload'])['authorised_person_dob'])}}">
                                            {!! isError($errors, 'authorised_person_dob') !!}

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Declarant's address</label>
                                            <input type="text" id="a_address" name='authorised_person_address' class="form-control" value="{{old('authorised_person_address',optional($data['payload'])['authorised_person_address'])}}">
                                            {!! isError($errors, 'authorised_person_address') !!}

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Declarant's contact</label>
                                            <input type="text" id="a_contact_number" name='authorised_person_contact' class="form-control" value="{{old('authorised_person_contact',optional($data['payload'])['authorised_person_contact'])}}">
                                            {!! isError($errors, 'authorised_person_contact') !!}

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Declarant's email</label>
                                            <input type="text" id="a_email" name='authorised_person_email' class="form-control" value="{{old('authorised_person_email',optional($data['payload'])['authorised_person_email'])}}">
                                            {!! isError($errors, 'authorised_person_email') !!}

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Declaration</label>
                                        <textarea name="declaration" class='wysiwyg'>{{old('declaration',optional($data['payload'])['declaration'])}}</textarea>
                                        </div>
                                    </div>

                                    

                                    <div class="col-md-12 d-flex align-items-end justify-content-end">
                                        <button type="submit" class='btn btn-primary' name='action' value="spd">Send</button>
                                        <button name="action" value="pdf_spd" class="btn btn-warning">Download</button>
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
    initiateTinymce('textarea.wysiwyg');
</script>
@endpush