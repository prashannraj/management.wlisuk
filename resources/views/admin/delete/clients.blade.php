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
          <h6 class="h2 text-white d-inline-block mb-0 pl-4">Clients</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('enquiry.create') }}" class="btn btn-sm btn-neutral">
            <i class="fas fa-plus-circle"></i> New
          </a>
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
        <div class="table-responsive py-4">


          {!! $dataTable->table() !!}


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
{!! $dataTable->scripts() !!}

<script>
  $(function() {


    $("#filterByStatus").on("change", function(e) {
      e.preventDefault();
      window.LaravelDataTables["deletedclients-table"].draw();
    })


    $("#resetbutton").on('click', function(e) {
      e.preventDefault();
      $('select[name=status]').val("");

      window.LaravelDataTables["deletedclients-table"].draw();
    })

    $('.datepicker2').datepicker({
      format: "{{ config('constant.date_format_javascript') }}",
    });



  });
</script>

@endpush