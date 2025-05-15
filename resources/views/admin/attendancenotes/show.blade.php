@extends('layouts.master')



@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Showing attendance note of {{$data['row']->client->full_name}}</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('client.show',['id'=>$data['row']->client->id,'click'=>'communication']) }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back To Dashboard</a>
                        <br>
                      
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

            <div class="card-body">
                <div class="container">
                  
                <p>
                    <b>Type: </b> {{$data['row']->type_string}}
                </p>
                <p>
                    <b>Date: </b> {{$data['row']->date_formatted}}
                </p>
                @if($data['row']->type=='attendance')
                <p>
                    <b>Mode: </b> {{$data['row']->mode_string}}
                </p>
                <p>
                    <b>Duration : </b> {{$data['row']->duration}}
                </p>
                @endif
                <p>
                    <b>Advisor: </b> {{$data['row']->advisor->name}}
                </p>
               
                   <p> <b>Details</b></p>
                   <div>
                       {!! $data['row']->details !!}
                   </div>

               



                </div>
            </div>
        </div>
    </div>
</div>
@endsection