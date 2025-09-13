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
          <h6 class="h2 text-white d-inline-block mb-0">Enquiry Forms</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('home') }}" class="btn btn-sm btn-neutral">
            <i class="fas fa-chevron-left"></i> Back To Dashboard
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
    <!-- Enquiry Forms Card -->
    <div class="card" id="documentCard">
      <div class="card-header">
        <h3 class="text-primary font-weight-600">Enquiry forms
          <a href="{{ route('enquiryform.create') }}" class="btn btn-sm btn-primary float-right" id="addBtnDocument">
            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i></span>
            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Add new form </span>
          </a>
        </h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-border table-striped" id="invoice_table">
            <thead>
              <th>Name</th>
              <th>Title</th>
              <th>Hits</th>
              <th>Actions</th>
            </thead>
            <tbody>
              @foreach($data['forms'] as $bank)
              <tr>
                <td>{{ $bank->title }}</td>
                <td>{{ $bank->name }}</td>
                <td>{{ $bank->hits }}</td>
                <td>
                  @php
                    $editUrl = route('enquiryform.edit', $bank->id);
                    $viewUrl = route('enquiryform.display', $bank->uuid);
                    $btn =' <a href="'. $viewUrl .'" target="_blank" class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>'.
                          ' <a href="'. $editUrl .'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i></a>';
                  @endphp
                  {!! $btn !!}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          <!-- Pagination -->
          <div class="mt-3">
            @if($data['forms']->hasPages())
            <nav>
              <ul class="pagination justify-content-center">
                {{-- Previous Page Link --}}
                @if($data['forms']->onFirstPage())
                  <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                @else
                  <li class="page-item"><a class="page-link" href="{{ $data['forms']->previousPageUrl() }}"> &laquo; </a></li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($data['forms']->getUrlRange(1, $data['forms']->lastPage()) as $page => $url)
                  @if ($page == $data['forms']->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                  @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                  @endif
                @endforeach

                {{-- Next Page Link --}}
                @if($data['forms']->hasMorePages())
                  <li class="page-item"><a class="page-link" href="{{ $data['forms']->nextPageUrl() }}"> &raquo; </a></li>
                @else
                  <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                @endif
              </ul>
            </nav>
            @endif
          </div>
          <!-- End Pagination -->

        </div>
      </div>
      <div class="card-footer">
        <a href="{{ route('enquiryform.create') }}" class="btn btn-sm btn-primary" id="addBtnDocument">
          <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> D</span>
          <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Create new form </span>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
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
