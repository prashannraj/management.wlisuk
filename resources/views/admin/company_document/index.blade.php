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
          <i class="fas fa-chevron-left" ></i> Back To Dashboard</a>
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
        <h4 class="text-primary font-weight-600">Company Documents</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-border table-striped"id="documentTable">
                <thead>
                <th>SN</th>  
                <th>Name</th>  
                <th>Document</th>  
                <th>Actions</th>  
                </thead>
                <tbody class="document_details">
                    @if(count($data['documents']))
                            @foreach($data['documents'] as $index=>$doc)
                            <tr>  
                                <td> {{ $index+1 }} </td>
                                <td> {{ $doc->name }} </td>
                                <td> 
                                    @if($doc->document)
                                        <a href="{{ $doc->file_url }}" class="form-control" style="border: 0;">
                                            <i class="{{ $doc->file_type }} fa-2x"></i>
                                        </a>
                                    @endif
                                </td>
                                <td> 
                                <a href="{{ route('companydocument.show',$doc->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('companydocument.edit',$doc->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a> 
                                <a href="#" data-target="#delete_document" data-id="{{$doc->id}}" data-toggle="modal" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                
                                </td>
                                
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            <div>
              {{$data['documents']->links()}}
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('companydocument.create') }}" class="btn btn-sm btn-primary" id="addBtnDocument">
                    <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> D</span> 
                    <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Add Document </span>
        </a>
    </div>
</div>
  </div>
</div>
<div id="delete_document" class='modal fade'>
<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
								
				<h4 class="modal-title w-100">Are you sure?</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<form action="{{route('companydocument.destroy',"_")}}" method="POST">
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
<script>
	$("#delete_document").on('show.bs.modal',function(event){
	  var button = $(event.relatedTarget) 

      var doc_id = button.data('id') 
      var modal = $(this)

      modal.find('.modal-body #data_id').val(doc_id);
	});
</script>
@endpush


