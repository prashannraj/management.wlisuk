@extends('layouts.master')


@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">View application log</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('client.list.application.immigration.logs',$data['application_id']) }}" class="btn btn-sm btn-neutral">
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
        <h4 class="text-primary font-weight-600">Application Process of {{$data['applicationProcess']->application->student_name}}
          <a href="{{ route('client.list.application.immigration.logs', $data['applicationProcess']->application_id) }}" class="btn btn-sm btn-primary float-right"> Back</a>

        </h4>
    </div>
    <div class="card-body">
        
        <h3>Status</h3>
        <p>{{$data['applicationProcess']->applicationStatus->title}}</p>
        <h3>Reason</h3>
        <p>
        	{{$data['applicationProcess']->reason ?? "-"}}
        </p>

        <h3>Date</h3>
        <p>
        	{{$data['applicationProcess']->date ?? "-"}}
        </p>
        <h3>Document</h3>
        <a target="_blank" href="{{$data['applicationProcess']->file_url}}">Click here to view</a>
        <h3>Note</h3>
        <p>
        	{{$data['applicationProcess']->note}}
        </p>


        <h3>Date added</h3>
        {{$data['applicationProcess']->created_at}}
        <div>
	
	</div>

    </div>
    <div class="card-footer">
    </div>
</div>






<!--View modal-->





@endsection
