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
      <!-- -->
      <div class="card-body">
        <!-- Address Contact From Block -->
        <div id="DocumentAddForm">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Document
                      <a href="{{ route('client.show', ['id'=>$data['row']->basic_info_id, 'click'=>'documents' ]) }}" class="btn btn-sm btn-primary float-right"> Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="document_error"></div>
                    <form action="{{ route('client.update.document', $data['row']->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input value="{{ $data['row']->basic_info_id }}" name="basic_info_id" type="hidden">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Document Name</label>
                                    <input type="text" autocomplete="off" class="form-control" name="name" id="name" placeholder="Document Name" value="{{ $data['row']->name }}">
                                    {!! isError($errors, 'name') !!}
                                  </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Document</label>
                                    <input type="file" class="form-control" name="documents" id="documents">
                                    {!! isError($errors, 'documents') !!}
                                  </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Note</label>
                                    <textarea autocomplete="off" class="form-control" name="note" id="note" placeholder="Notes">{{ $data['row']->note }}</textarea>
                                    {!! isError($errors, 'note') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                              @if($data['row']->documents)
                                <div class="form-group">
                                  <label for="">View File</label>
                                  <a href="{{ $data['row']->file_url }}" class="form-control" style="border: 0;">
                                    <i class="{{ $data['row']->file_type }} fa-3x"></i>
                                  </a>
                              </div>
                              @endif
                            </div>
                        </div>
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
    $('#issue_date').datepicker({ format: 'dd-mm-yyyy' });
    $('#expiry_date').datepicker({ format: 'dd-mm-yyyy' });
 });
</script>
@endpush