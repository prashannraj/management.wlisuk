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
          <h6 class="h2 text-white d-inline-block mb-0">{{ $data['panel_name']}}</h6>
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
        <h3 class="text-primary font-weight-600">Old Immigration Invoices
        </h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-border table-striped" id="invoice_table">
            <thead>
              <th>Invoice No.</th>
              <th>Client's Name</th>
              <th>Actions</th>
            </thead>
            <tbody class="document_details">

            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer">
       
      </div>
    </div>
  </div>
</div>

@endsection

@push("scripts")
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
  $(function() {
    var oTable = $('#invoice_table').DataTable({
      autoWidth: false,
      language: {
        paginate: {
          previous: "<i class='fas fa-angle-left'>",
          next: "<i class='fas fa-angle-right'>"
        }
      },
      processing: true,
      serverSide: true,
      order: [
        [0, "desc"]
      ],
      ajax: {
        url: '{!! route("old.immigrationinvoice.index") !!}',
      },
      columns: [
        // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {
          data: 'id',
          name: 'id'
        },
        {
          data: 'client_name',
          name: 'client_name'
        },
        // { data: 'middle_name', name: 'middle_name' },
        // { data: 'mobile', name: 'mobile' },
        // { data: 'email', name: 'email' },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false
        },
      ]
    });
    oTable.draw();
  });
</script>

@endpush