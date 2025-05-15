@extends('layouts.master')

@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-6">
          <h6 class="h2 text-white d-inline-block mb-0 pl-4">{{ $data['panel_name'] }}</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('companybranch.create') }}" class="btn btn-sm btn-neutral">
            <i class="fas fa-plus-circle" ></i> Add New Branch
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
          <table class="table table-bordered table-flush" id="enquiry-table">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <!-- <th>Middle Name</th> -->
                    <!-- <th>Mobile</th> -->
                    <!-- <th>Email</th> -->
                    <th>Telephone</th>

                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            	@foreach($data['branches'] as $branch)
            	<tr>
            		<td>{{$branch->id}}</td>
            		<td>{{$branch->name}}</td>
            		<td>{{$branch->telephone}}</td>
            		<td>
            			@php
            			 $editUrl = route('companybranch.edit',$branch->id);
                        $viewUrl = route('companybranch.show', $branch->id);
                         $deleteUrl = route('companybranch.destroy',$branch->id);
                        $btn ='   <a href="'. $viewUrl .'" class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>'.

                                '   <a href="'. $editUrl .'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i></a>';
            			@endphp
            			{!!$btn!!}
            			 <a href="#" data-toggle="modal" data-target="#delete_branch" data-id="{{$branch->id}}"  class="edit btn btn-warning btn-sm"><i class="fas fa-trash"></i></a>

            		</td>
            	</tr>
            	
            	@endforeach
            	
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>



<div id="delete_branch" class='modal fade'>
<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
								
				<h4 class="modal-title w-100">Are you sure?</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<form action="{{route('companybranch.destroy',"_")}}" method="POST">
				@csrf
				@method("DELETE")
			<div class="modal-body">
				<input id="data_id" name="id" type="hidden">

				<p>Do you really want to delete this company branch? This process cannot be undone.</p>
			
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
	$("#delete_branch").on('show.bs.modal',function(event){
	  var button = $(event.relatedTarget) 

      var doc_id = button.data('id') 
      var modal = $(this)

      modal.find('.modal-body #data_id').val(doc_id);
	});
</script>
@endpush


