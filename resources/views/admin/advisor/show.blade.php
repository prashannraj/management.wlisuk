@extends('layouts.master')


@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">View Advisor Details</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('advisor.index') }}" class="btn btn-sm btn-neutral">
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
        <h4 class="text-primary font-weight-600">Advisor Details
            <a href="{{ route('advisor.index') }}" class="btn btn-sm btn-primary float-right"> Back</a>

        </h4>
    </div>
    <div class="card-body">
        <h3>Category</h3>
        <p>{{ucfirst($data['row']->category)}}</p>
        
        <h3>Full Name</h3>
        <p>{{$data['row']->name}}</p>
        
        <h3>Email</h3>
        <p>{{$data['row']->email}}</p>
        
        <h3>Level</h3>
        <p>{{$data['row']->level}}</p>
        

        <h3>Emergency Contact</h3>
        <p>{{$data['row']->contact}}</p>
        
        @if($data['row']->signature != null)
        <h3>Signature</h3>
        <img src="{{$data['row']->signature_url}}" width="300px" alt="" class="img img-fluid">
        @endif
        <div>

        </div>

    </div>
    <div class="card-footer">
    </div>
</div>






<!--View modal-->





@endsection