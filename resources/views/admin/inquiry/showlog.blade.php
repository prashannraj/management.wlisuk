@extends('layouts.master')


@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">View Enquiry log</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('enquiry.log',$data['log']->enquiry_list_id) }}" class="btn btn-sm btn-neutral">
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
        <h4 class="text-primary font-weight-600">Enquiry activity of {{$data['log']->enquiry->full_name}}
          <a href="{{ route('enquiry.log',$data['log']->enquiry_list_id) }}" class="btn btn-sm btn-primary float-right"> Back</a>

        </h4>
    </div>
    <div class="card-body">
        
        <h3>Status</h3>
        <p>{{$data['log']->status_attr}}</p>
        <h3>Followup Date</h3>
        <p>
        	{{optional($data['log']->enquiryFollowUp)->date ?? "-"}}
        </p>

        
        <h3>Note</h3>
        <p>
        	{{$data['log']->note}}
        </p>

        <h3>Date added</h3>
        {{$data['log']->created}}
        <div>
	
	</div>

    </div>
    <div class="card-footer">
    </div>
</div>






<!--View modal-->





@endsection
