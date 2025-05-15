@extends('layouts.master')



@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Edit Applicant Saving Info</h6>
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
                <form action="{{route('applicantsavinginfo.update',$data['row']->id)}}" method="POST">
                    @csrf
                    <!-- Modal Header -->

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
                            <label for="">Country:</label>
                            <select required name="country_id" id="" class="form-control">
                                <option value="">Select an option</option>
                                @foreach($data['countries'] as $country)
                                <option {{$data['row']->country_id==$country->id?"selected":""}} value="{{$country->id}}">{{$country->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Bank name:</label>
                            <input type="text" value="{{old('bank_name',$data['row']->bank_name)}}" name="bank_name" class="form-control">
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
                            <label for="">Account name:</label>
                            <input type="text" value="{{old('account_name',$data['row']->account_name)}}" name="account_name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Account number:</label>
                            <input type="text" value="{{old('account_number',$data['row']->account_number)}}" name="account_number" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="">Saving start date:</label>
                            <input required type="text" name="start_date" value="{{old('start_date',$data['row']->start_date_formatted)}}" class="form-control datepicker2">
                        </div>


                        <div class="form-group">
                            <label for="">Minimum balance on any given date during the last 6 months:</label>
                            <input required type="text" value="{{old('minimum_balance',$data['row']->minimum_balance)}}" name="minimum_balance" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Closing balance:</label>
                            <input required type="text" value="{{old('closing_balance',$data['row']->closing_balance)}}" name="closing_balance" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Closing balance date:</label>
                            <input required type="text" name="closing_date" value="{{old('closing_date',$data['row']->closing_date_formatted)}}" class="form-control datepicker2">
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