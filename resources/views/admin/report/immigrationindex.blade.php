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
                    <h6 class="h2 text-white d-inline-block mb-0">Immigration application report</h6>
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
                <h3 class="text-primary font-weight-600">Immigration applications

                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div>
                        <form class="form-inline my-4" id="filterform">
                            <div class="form-group mx-2">
                                <label for="">Start Date</label>
                                <input autocomplete="off" type="text" required class="ml-1 datepicker2 form-control" name="startdate">

                            </div>
                            <div class="form-group mx-2">
                                <label for="">End Date</label>
                                <input autocomplete="off" type="text" required class='ml-1 form-control datepicker2' name="enddate">

                            </div>
                            <input type="submit" class='btn btn-info' value="Filter">
                            <a href="#" class="btn btn-warning" id="resetbutton">Reset</a>

                        </form>
                    </div>

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
        // var oTable = $('#receiptreport-table').DataTable({
        //     autoWidth: false,
        //     language: {
        //         paginate: {
        //             previous: "<i class='fas fa-angle-left'>",
        //             next: "<i class='fas fa-angle-right'>"
        //         }
        //     },
        //     processing: true,
        //     serverSide: true,
        //     order: [
        //         [0, "desc"]
        //     ],
        //     ajax: {
        //         url: "{!! route('report.receipt') !!}",
        //         data: function(d) {
        //             d.startdate = $('input[name=startdate]').val();
        //             d.enddate = $('input[name=enddate]').val();
        //             console.log(d.startdate, d.enddate);
        //         }
        //     },
        //     dom: 'Bfrtip',
        //     columns: [{
        //         "data": "DT_RowIndex",
        //         "name": "DT_RowIndex",
        //         "title": "S/N",
        //         "orderable": false,
        //         "searchable": false
        //     }, {
        //         "data": "date",
        //         "name": "id",
        //         "title": "Receipt Date",
        //         "orderable": true,
        //         "searchable": true
        //     },{
        //         "data": "receipt_no",
        //         "name": "id",
        //         "title": "Receipt No",
        //         "orderable": true,
        //         "searchable": true
        //     },
        //     {
        //         "data": "invoice.invoice_no",
        //         "name": "invoice_id",
        //         "title": "Invoice No",
        //         "orderable": true,
        //         "searchable": true
        //     },
        //     {
        //         "data": "currency.title",
        //         "name": "iso_currency_id",
        //         "title": "Currency",
        //         "orderable": true,
        //         "searchable": false
        //     }, {
        //         "data": "amount_received",
        //         "name": "amount_received",
        //         "title": "Amount",
        //         "orderable": true,
        //         "searchable": true
        //     }],
        //     "buttons": [{
        //         "extend": "export"
        //     }, ]
        // });

        // window.LaravelDataTables = window.LaravelDataTables || {};
        // window.LaravelDataTables["receiptreport-table"] = oTable;

        $("#filterform").on("submit", function(e) {
            e.preventDefault();
            window.LaravelDataTables["immigration-table-receipt"].draw();
        })


        $("#resetbutton").on('click', function(e) {
            e.preventDefault();
            $('input[name=startdate]').val("");
            $('input[name=enddate]').val("");

            window.LaravelDataTables["immigration-table-receipt"].draw();
        })
        
          $('.datepicker2').datepicker({
        format: "{{ config('constant.date_format_javascript') }}",
    });

    });
</script>



@endpush