@extends('layouts.master')



@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Edit Partner - {{$data['partner']->institution_name}}</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('partner.index') }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back To List</a>
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

            @if($errors->any())
            @foreach ($errors->all() as $error)
            <div class='alert alert-warning'>{{ $error }}</div>
            @endforeach
            @endif

            <div class="card-body">
                <form class="row" action="{{ route('partner.update',$data['partner']->id )}}" method="POST">
                    @csrf
                    @method("PUT")

                    @include('admin.partner.form')
                    <div class='col-lg-12 d-flex'>
                        <input class='btn btn-primary ml-auto' type="submit" value="Save" />
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection