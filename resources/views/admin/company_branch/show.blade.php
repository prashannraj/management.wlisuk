@extends('layouts.master')


@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">View Branch Details</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('companybranch.index') }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back To list</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('main-content')

<!-- Passport Details -->
<div class="card" id="documentCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Branch Details
          <a href="{{ route('companybranch.index') }}" class="btn btn-sm btn-primary float-right"> Back</a>

        </h4>
    </div>
    <div class="card-body">
        
        <h3>Name</h3>
        <p>{{$data['row']->name}}</p>
        <br>
        <h3>Email</h3>
        <p>{{$data['row']->email}}</p>
        <br>
        <h3>Address</h3>
        <p>{{$data['row']->address}}</p>
		<br>
        <h3>Telephone Number</h3>
        <p>{{$data['row']->telephone}}</p>
		<br>
        <h3>Added on</h3>
         <p>{{$data['row']->created_at}}</p>
		<br>
		<h3>Updated on</h3>
         <p>{{$data['row']->updated_at}}</p>
		<br>
        <div>
	
	</div>

    </div>
    <div class="card-footer">
    </div>
</div>






<!--View modal-->





@endsection
