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
        <h3 class="text-primary font-weight-600">Receipt
          <a href="{{ route('finance.receipt.create') }}" class="btn btn-sm btn-primary float-right" id="addBtnDocument">
            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i></span>
            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Create new receipt </span>
          </a>
        </h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-border table-striped" id="receipt_table">
            <thead>
              <th>Receipt No.</th>
              <th>Client's Name</th>
              <th>Invoice No</th>
              <th>Actions</th>
            </thead>
            <tbody class="document_details">

            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer">
        <a href="{{ route('finance.receipt.create') }}" class="btn btn-sm btn-primary" id="addBtnDocument">
          <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> D</span>
          <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Create new receipt </span>
        </a>
      </div>
    </div>
  </div>
</div>
<div id="deleteModal" class='modal fade'>
  <div class="modal-dialog modal-confirm">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title w-100">Are you sure?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form action="{{route('finance.receipt.destroy',"_")}}" method="POST">
        @csrf
        @method("DELETE")
        <div class="modal-body">
          <input id="data_id" name="id" type="hidden">

          <p>Do you really want to delete this document? This process cannot be undone.</p>

        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <input type="submit" class="btn btn-danger" value="Delete">
        </div>
      </form>
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
    var oTable = $('#receipt_table').DataTable({
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
        url: '{!! route("finance.receipt.index") !!}',
        data: function(d) {
          d.enquiry_type = $('select[name=enquiry_type]').val();
          d.activity = $('select[name=activity]').val();
        }
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
          data: 'invoice',
          name: 'invoice'
        },
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
<script>
  $("#deleteModal").on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)

    var doc_id = button.data('id')
    var modal = $(this)

    modal.find('.modal-body #data_id').val(doc_id);
  });
</script>
@endpush