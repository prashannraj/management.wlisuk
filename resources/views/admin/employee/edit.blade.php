@extends('layouts.master')

@push('styles')

@endpush

@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Edit Employee</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('employee.index') }}" class="btn btn-sm btn-neutral">
          <i class="fas fa-chevron-left" ></i> Back To list</a>
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
      <div class="card-header border-0">
        <h3 class="mb-0 text-primary">Edit employee - {{$data['row']->full_name}}
            <a href="{{route("employee.show",$data['row']->id)}}" class="btn btn-sm btn-primary float-right"> Back to employee</a>
        </h3>
      </div>
      <div class="card-body">
        <form  action="{{ route('employee.update',$data['row']->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method("PUT")

        <div class="row">
            @include('admin.employee.form')
        </div>

          <button class="btn btn-icon btn-success float-right" type="submit">
            <span class="btn-inner--icon"><i class="ni ni-check-bold"></i></span>
            <span class="btn-inner--text">Submit</span>
        </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection


