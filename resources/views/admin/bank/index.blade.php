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
        <h3 class="text-primary font-weight-600">Bank
          <a href="{{ route('finance.bank.create') }}" class="btn btn-sm btn-primary float-right" id="addBtnDocument">
            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i></span>
            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Add new bank </span>
          </a>
        </h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-border table-striped" id="invoice_table">
            <thead>
              <th>Name</th>
              <th>Account Name</th>
              <th>Status</th>
              <th>Actions</th>
            </thead>
            <tbody class="">
              @foreach($data['banks'] as $bank)
              <tr>
                <td>{{$bank->title}}</td>
                <td>{{$bank->account_name}} </td>
                <td> {{$bank->status}} </td>
                <td>
                  @php
                  $editUrl = route('finance.bank.edit',$bank->id);
                  $viewUrl = route('finance.bank.show', $bank->id);
                  $btn =' <a href="'. $viewUrl .'" class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>'.

                  ' <a href="'. $editUrl .'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i></a>';
                  @endphp
                  {!!$btn!!}

                </td>
              </tr>

              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer">
        <a href="{{ route('finance.bank.create') }}" class="btn btn-sm btn-primary" id="addBtnDocument">
          <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> D</span>
          <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Create new Bank </span>
        </a>
      </div>
    </div>
  </div>
</div>
<div id="delete_bank" class='modal fade'>
  <div class="modal-dialog modal-confirm">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title w-100">Are you sure?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form action="#" method="POST">
        @csrf
        @method("DELETE")
        <div class="modal-body">
          <input id="data_id" name="id" type="hidden">

          <p>Do you really want to delete this bank? This process cannot be undone.</p>

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

<script>
  $("#delete_bank").on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)

    var doc_id = button.data('id')
    var modal = $(this)

    modal.find('.modal-body #data_id').val(doc_id);
  });
</script>
@endpush
