@extends('layouts.master')



@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Application assessment cover letter</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('client.show',$data['application']->basic_info_id) }}" class="btn btn-sm btn-neutral">
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


                <form class="" action="{{ route('aacl.store',$data['application_id'] )}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="application_id" value="{{$data['application_id']}}">
                    <div class="">
                        <div class="">
                            <div class="px-2 py-3 my-3">
                                <div id="ec" class=" mt-2 row">


                                    <div class='col-md-6'>
                                        <div class="form-group">
                                            <label class=" form-control-label" for="date">
                                                Date: </label>
                                            <div class="">
                                                <input autocomplete="off" type="text" class="form-control datepicker2" name="date" placeholder="Date" value="{{ old('date',optional($data['payload'])->date_formatted) }}">
                                                {!! isError($errors, 'date') !!}
                                            </div>

                                        </div>
                                    </div>

                                    <div class='col-md-6'>
                                        <div class="form-group">
                                            <label class=" form-control-label" for="re">
                                                Select application assessment: </label>
                                            <div class="">
                                                <select name="application_assessment_id" id="" class="form-control">
                                                    <option value="">Select an option</option>
                                                    @foreach($data['application_assessments'] as $row)
                                                        <option {{$row->id == $data['payload']->application_assessment_id?"selected":""}} value="{{$row->id}}">
                                                            {{$row->name}} - {{$row->application_detail->name}} - {{$row->id}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                {!! isError($errors, 'application_assessment_id') !!}
                                            </div>

                                        </div>
                                    </div>

                                    <div class='col-md-6'>
                                        <div class="form-group">
                                            <label class=" form-control-label" for="re">
                                                Re: </label>
                                            <div class="">
                                                <input autocomplete="off" type="text" class="form-control" name="re" placeholder="re" value="{{ old('re',optional($data['payload'])->re) }}">
                                                {!! isError($errors, 're') !!}
                                            </div>

                                        </div>
                                    </div>

                                   




                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""> To Address</label>
                                         

                                            <textarea type="text" id="a_address" name='to_address'
                                             class="form-control wysiwyg" 
                                             value="">{{old('to_address',optional($data['payload'])->to_address)}}</textarea>
                                            {!! isError($errors, 'to_address') !!}

                                        </div>
                                    </div>


                                  
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for=""> Coverletter text</label>
                                         

                                            <textarea type="text" id="a_address" name='text'
                                             class="form-control wysiwyg" 
                                             value="">{{old('text',optional($data['payload'])->text)}}</textarea>
                                            {!! isError($errors, 'text') !!}

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Include Financial Assessment</label>
                                            <input type="checkbox" {{optional($data['payload'])->include_financial_assessment?"checked":""}} name="include_financial_assessment" class='checkbox-control' id="">
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <h2 class="text-primary">Cover Letter</h2>
                                        <div class="d-flex align-items-end">
                                            <button type="submit" class='btn btn-primary' name='action' value="aacl">Send</button>
                                            <button name="action" value="pdf_aacl" class="btn btn-warning">Download</button>
                                            <button name="action" formtarget="_blank" value="preview_aacl" target="_blank" class="btn btn-warning">Preview</button>

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
        format: "{{config('constant.date_format_javascript')}}",
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
@endpush