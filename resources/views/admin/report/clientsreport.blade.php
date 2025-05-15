@extends("layouts.master")

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
                    <h6 class="h2 text-white d-inline-block mb-0">Client's Report</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back To Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('main-content')
<div class="row">
    <div class="col">
        <!-- Passport Details -->
        <div class="card" id="documentCard">
            <div class="card-header">
                <h3 class="text-primary font-weight-600">Clients

                </h3>
            </div>
            <div class="card-body">
                <div>
                    <form class="form-inline my-4" id="filterform">
                        <div class="form-group">
                            <label class="mx-1" for="">Filter by visa expiry</label>
                            <select name="visa_expiry" id="" class="form-control-sm mx-1">
                                <option>Select an option</option>
                                <option {{request()->visa_expiry == '6'?"selected":""}} value="6">6 months</option>
                                <option {{request()->visa_expiry == '3'?"selected":""}} value="3">3 months</option>
                                <option {{request()->visa_expiry == '1'?"selected":""}} value="1">1 month</option>
                                <option {{request()->visa_expiry == '1w'?"selected":""}} value="1w">1 week</option>
                                <option {{request()->visa_expiry == '0'?"selected":""}} value="0">Today</option>

                            </select>
                        </div>
                        <input type="submit" class='btn btn-info' value="Filter">
                        <a href="#" class="btn btn-warning" id="resetbutton">Reset</a>

                    </form>
                </div>
                <div class="table-responsive">


                    {!! $dataTable->table() !!}

                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>

@endsection

@push("scripts")
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="/vendor/datatables/buttons.server-side.js"></script>
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
{!! $dataTable->scripts() !!}

<script>
    $(function() {


        $("#filterform").on("submit", function(e) {
            e.preventDefault();
            window.LaravelDataTables["clientsreport-table"].draw();
        })


        $("#resetbutton").on('click', function(e) {
            e.preventDefault();
            $('input[name=visa_expiry]').val("");

            window.LaravelDataTables["clientsreport-table"].draw();
        })

        $('.datepicker2').datepicker({
            format: "{{ config('constant.date_format_javascript') }}",
        });

    });
</script>



@endpush