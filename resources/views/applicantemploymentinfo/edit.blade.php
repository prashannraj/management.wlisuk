@extends('layouts.master')



@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Edit Applicant Employment Info</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('financial_assessment.show',$data['row']->application_assessment_id) }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back</a>
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

                {!! showErrors($errors) !!}
                <form action="{{route('employment_detail.update',$data['row']->id)}}" method="POST">
                    @csrf
                    <!-- Modal Header -->

                    <input type="hidden" name="contact_id" value="">
                    <!-- Modal body -->
                    <div class="">

                        <div class="form-group">
                            <label for="">Sponsor name (if it is of sponsor)</label>
                            <select name="" data-toggle="populate" data-target="#a_sponsor_name" id="" class="form-control mb-2">
                                <option value="">It is applicant's detail</option>
                                @foreach($data['sponsors'] as $sponsor)
                                <option {{$sponsor->sponsor_name==$data['row']->sponsor_name?"selected":""}} value="{{$sponsor->sponsor_name}}">{{$sponsor->sponsor_name}}</option>
                                @endforeach
                            </select>

                            <input placeholder="Leave empty if applicant's detail" type="text" id="a_sponsor_name" name='sponsor_name' class="form-control" value="{{old('sponsor_name',$data['row']->sponsor_name)}}">
                            {!! isError($errors, 'client_address') !!}

                        </div>
                        <div class="form-group">
                            <label for="">Company name:</label>
                            <input required type="text" name="company_name" value="{{old('company_name',$data['row']->company_name)}}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Employment start date:</label>
                            <input required type="text" name="start_date" value="{{old('start_date',$data['row']->start_date_formatted)}}" class="form-control datepicker2">
                        </div>

                        <div class="form-group">
                            <label for="">Employment end date:</label>
                            <input type="text" name="end_date" value="{{old('end_date',$data['row']->end_date_formatted)}}" id="end_date" class="form-control datepicker2">
                            <label for="ongoing">Ongoing</label>
                            <input type="checkbox" name="ongoing" {{$data['row']->end_date == null? "checked":""}} id="ongoing">
                        </div>

                        <div class="form-group">
                            <label for="">Position:</label>
                            <input required type="text" value="{{old('position',$data['row']->position)}}" name="position" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Currency</label>
                            <select required name="currency_id" id="" class="form-control">
                                <option value="">Select an option</option>
                                @foreach($data['currencies'] as $currency)
                                <option {{ $data['row']->currency_id == $currency->id?"selected":"" }} value="{{$currency->id}}">{{$currency->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Currency rate</label>
                            <input type="text" name='currency_rate' value="{{$data['row']->currency_rate}}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Calculation type</label>
                            <select required name="calculation_type" id="" class="form-control">
                                <option value="">Select an option</option>
                                @foreach(["6 months","12 months"] as $currency)
                                <option {{$data['row']->calculation_type == $currency ?"selected":""}} value="{{$currency}}">{{$currency}}</option>
                                @endforeach
                            </select>
                        </div>

                       
                    </div>

                    <!-- Modal footer -->
                    <div class="">
                        <input type="submit" value="Update" class="btn btn-info">
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')

<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $('.datepicker2').datepicker({
        format: "{{ config('constant.date_format_javascript') }}",
    });

    $("#ongoing").on("change", function() {
        var checked = $(this).is(":checked");
        if (checked) $("#end_date").hide();
        else $("#end_date").show();
    })

    $("#ongoing").trigger("change");

    $("select[data-toggle='populate']").on('change', function(e, value) {
        var selector = $(this).data("target");
        $(selector).val($(this).val());
    })
</script>
@endpush