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
          <h6 class="h2 text-white d-inline-block mb-0">Add employment information for {{$data['employee']->full_name}}</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('employee.show',['employee'=>$data['employee']->id,'click'=>'employment_info']) }}" class="btn btn-sm btn-neutral">
          <i class="fas fa-chevron-left" ></i> Back to dashboard</a>
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
        <form  action="{{ route('employmentinfo.store') }}" method="POST">
          @csrf

        <div class="row">
            @include('admin.employee.employmentinfo.form')
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


