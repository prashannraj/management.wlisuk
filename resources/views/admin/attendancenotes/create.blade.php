@extends('layouts.master')



@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Add attendance note to {{$data['basic_info']->full_name}}</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('client.show',['id'=>$data['basic_info']->id,'click'=>'communication']) }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back To Dashboard</a>
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
                    <form class="" action="{{ route('attendancenote.store',$data['basic_info']->id )}}" method="POST" enctype="multipart/form-data">
                        @csrf


                        @include('admin.attendancenotes.form')
                        <div class=''>
                            <input class='btn btn-primary ml-auto' type="submit" value="Save" />
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection