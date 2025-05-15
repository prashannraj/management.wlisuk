@extends('layouts.master')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush
@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-6">
                    <h6 class="h2 text-white d-inline-block mb-0 pl-4">Trash</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">

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
            <div class="card-header border-0 pb-0">
                <div class="card-wrapper">

                </div>
            </div>
            <div class="card-body">
                <div class=" py-4">

                    <ul class="nav nav-pills administrative_subs_links" id="administrative_subs_links" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="contact-details-tab" data-toggle="tab" href="#clients" role="tab" aria-controls="contact_details" aria-selected="true">Clients</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#employees">Employees</a>
                        </li>

                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#passports">Passports</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#visas">Visas</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active show" id="clients">
                            <h3>Deleted Clients</h3>

                            <div>
                                {!!$data['deletedClientsDatatable']->table(['class'=>'table table-responsive table-sm table-striped']) !!}

                            </div>
                        </div>

                        <div class="tab-pane active show" id="employees">
                            <h3>Deleted Employees</h3>

                            <div>
                                {!!$data['deletedEmployeeDataTable']->table(['class'=>'table table-responsive table-sm table-striped']) !!}

                            </div>
                        </div>

                        <div class="tab-pane active show" id="passports">
                            <h3>Deleted Passports</h3>
                            <div>
                                {!!$data['deletedPassportDatatable']->table(['class'=>'table table-responsive table-sm table-striped']) !!}

                            </div>
                        </div>

                        <div class="tab-pane active show" id="visas">
                            <h3>Deleted Visas</h3>
                            {!! $data['deletedVisaDataTable']->table(['class'=>'table table-responsive table-sm table-striped']) !!}

                        </div>
                    </div>






                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

{!!$data['deletedClientsDatatable']->scripts() !!}
{!!$data['deletedEmployeeDataTable']->scripts() !!}
{!!$data['deletedPassportDatatable']->scripts() !!}
{!! $data['deletedVisaDataTable']->scripts() !!}

<script>
    $("#filterform").on("submit", function(e) {
        e.preventDefault();
        window.LaravelDataTables["{{$data['deletedEmployeeDataTable']->getTableAttributes()['id']}}"].draw();
    })
</script>


@endpush