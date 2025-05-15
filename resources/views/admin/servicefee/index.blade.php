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
        <h3 class="text-primary font-weight-600">Service Fee
          <a href="{{ route('servicefee.create') }}" class="btn btn-sm btn-primary float-right" id="addBtnDocument">
            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i></span>
            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Add new Service Fee </span>
          </a>
        </h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <form class="form-inline my-4" id="filterform">
            <div class="form-group">
              <label class="mx-1" for="">Filter by status</label>
              <select name="status" id="" class="form-control-sm mx-1">
                <option value="1">Active</option>

                <option value="0">Inactive</option>

              </select>


            </div>
            <input type="submit" class='btn btn-info' value="Filter">
            <a href="#" class="btn btn-warning" id="resetbutton">Reset</a>

          </form>

          {!! $dataTable->table() !!}

        </div>
      </div>
      <div class="card-footer">
        <a href="{{ route('servicefee.create') }}" class="btn btn-sm btn-primary" id="addBtnDocument">
          <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> D</span>
          <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Add new Service Fee </span>
        </a>
      </div>
    </div>
  </div>
</div>
<div id="delete_servicefee" class='modal fade'>
  <div class="modal-dialog modal-confirm">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title w-100">Are you sure?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form action="{{route('servicefee.destroy','_')}}" method="POST">
        @csrf
        @method("DELETE")
        <div class="modal-body">
          <input id="data_id" name="id" type="hidden">

          <p>Do you really want to delete this service fee? This process cannot be undone.</p>

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
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
{!! $dataTable->scripts() !!}

<script>
  $("#delete_servicefee").on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)

    var doc_id = button.data('id')
    var modal = $(this)

    modal.find('.modal-body #data_id').val(doc_id);
  });
</script>
<script>
  $(function() {


    $("#filterform").on("submit", function(e) {
      e.preventDefault();
      window.LaravelDataTables["servicefee-table"].draw();
    })


    $("#resetbutton").on('click', function(e) {
      e.preventDefault();
      $('select[name=status]').val("");


      window.LaravelDataTables["servicefee-table"].draw();
    })

    $('.datepicker2').datepicker({
      format: "{{ config('constant.date_format_javascript') }}",
    });

  });
</script>
@endpush