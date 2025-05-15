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
                    <h6 class="h2 text-white d-inline-block mb-0">Editing passport</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('employee.show',$data['row']->employee_id) }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back to dashboard</a>
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
                <!-- Address Contact From Block -->
                <div id="">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Passport Contact Detail
                                <a href="{{ route('employee.show', $data['row']->employee_id) }}" class="btn btn-sm btn-primary float-right"> Back</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="address_details_error"></div>
                            <form action="{{ route('passportdetail.update', $data['row']->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input value="{{ $data['row']->employee_id }}" name="employee_id" type="hidden">
                                @include("admin.passport_detail.form",["passport"=>$data['row']])

                                <button class="btn btn-primary" type="submit">Edit</button>
                            </form>
                        </div>
                    </div>
                </div>




            </div>


        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('.datepicker2').datepicker({
            format: '{{config("constant.date_format_javascript")}}'
        });

    });
</script>
@endpush