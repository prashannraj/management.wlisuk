@extends('layouts.master')

@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-6">
          <h6 class="h2 text-white d-inline-block mb-0 pl-4">Communication Logs</h6>
        </div>
        
      </div>
    </div>
  </div>
</div>
@endsection
@section('main-content')
<div class="row">
  <div class="col">
  	@php 
  		$indexpage = true;
  	@endphp
    @include('admin.communicationlog.list')

    {{$data['communicationlogs']->links()}}

  </div>
</div>


@endsection



