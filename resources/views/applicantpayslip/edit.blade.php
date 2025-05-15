@extends('layouts.master')



@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Edit Applicant Payslip</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('financial_assessment.show',['id'=>$data['row']->employment_info->application_assessment_id,'clicked'=>$data['row']->employment_info_id]) }}" class="btn btn-sm btn-neutral">
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
                <form action="{{route('applicantpayslip.update',$data['row']->id)}}" method="POST">
                    @csrf
                    <!-- Modal Header -->

                    <!-- Modal body -->
                    <div class="">
                    <div class="form-group">
                        <label for="">Date:</label>
                        <input required type="text" name="date" value="{{old('date',$data['row']->date_formatted)}}" class="form-control datepicker2">
                    </div>

                    <div class="form-group">
                        <label for="">Paid into bank date:</label>
                        <input required type="text" name="bank_date" value="{{old('bank_date',$data['row']->bank_date_formatted)}}" class="form-control datepicker2">
                    </div>


                    <div class="form-group">
                        <label for="">Gross pay:</label>
                        <input required type="text" value="{{old('gross_pay',$data['row']->gross_pay)}}" name="gross_pay" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Net pay:</label>
                        <input required type="text" value="{{old('net_pay',$data['row']->net_pay)}}" name="net_pay" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Proof sent:</label>
                        <select required name="proof_sent" id="" class="form-control">
                            <option value="">Select an option</option>
                            @foreach(["Yes","No"] as $currency)
                            <option {{$data['row']->proof_sent==$currency?"selected":""}} value="{{$currency}}">{{$currency}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Note:</label>
                        <input type="text" value="{{old('note',$data['row']->note)}}" name="note" class="form-control">
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
</script>
@endpush