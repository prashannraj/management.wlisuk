@extends('layouts.master')



@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Edit Receipt</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a 
          @if(request()->from_client )
          href="{{ route('client.show',['id'=>request()->from_client,'click'=>'finances']) }}"
          @elseif(request()->from_invoice)
          href="{{ route('finance.invoice.show',request()->from_invoice) }}"
          @else
          href="{{ route('finance.receipt.index') }}"
          @endif
           class="btn btn-sm btn-neutral">
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

      <div class="card-body">
        <form class="row" action="{{ route('finance.receipt.update',$data['receipt']->id )}}" method="POST" enctype="multipart/form-data">
          @csrf
          @method("PUT")

          @if(request()->from_client)
            <input type="text" hidden name='from_client' value="{{request()->from_client}}">
          @endif

          @if(request()->from_invoice)
            <input type="text" hidden name='from_invoice' value="{{request()->from_invoice}}">
          @endif

          @include('admin.receipt.form')
          <div class='col-lg-12 d-flex'>
            <input class='btn btn-primary ml-auto' type="submit" value="Save" />
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection