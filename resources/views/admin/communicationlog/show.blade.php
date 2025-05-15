@extends('layouts.master')


@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">View Communication Log</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a 
                    @if(request()->from_client)
                    
                    href="{{ route('client.show',request()->from_client) }}"

                    @else
                    href="{{ route('communicationlog.index') }}"

                    @endif
                     class="btn btn-sm btn-neutral">
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
        <h4 class="text-primary font-weight-600">Communication Log Details
          <a 
          @if(request()->from_client)
                    
                    href="{{ route('client.show',request()->from_client) }}"

                    @else
                    href="{{ route('communicationlog.index') }}"

                    @endif
          class="btn btn-sm btn-primary float-right"> Back</a>

        </h4>
    </div>
    <div class="card-body">
        
        <h3>Client name</h3>
        <p>{{$data['row']->client_name}}</p>
        <br>
        <h3>Subject</h3>
        <textarea name="" disabled id="" class='form-control'>{{$data['row']->description}}</textarea>
        <br>
        <h3>Date</h3>
        <p>{{$data['row']->created_at}}</p>
		<br>
        <h3>Email Content</h3>
        <div>
        {!! $data['row']->email_content !!}
        </div>
		<br>
        
        <div>
	
	</div>

    </div>
    <div class="card-footer">
    </div>
</div>

<style>
    .card-body h3{
        text-decoration: underline;
    }
</style>






<!--View modal-->





@endsection
