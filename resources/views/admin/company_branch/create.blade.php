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
          <h6 class="h2 text-white d-inline-block mb-0">{{ $data['panel_name']}}</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('home') }}" class="btn btn-sm btn-neutral">
          <i class="fas fa-chevron-left" ></i> Back To List</a>
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
      {{-- <div class="card-header border-0">
        <h3 class="mb-0">Enquiry Form</h3>
      </div> --}}
      <div class="card-body">
      <form class="row" action="{{ route('companybranch.store' )}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="col-lg-12">
            <div class="card-wrapper">
              <!-- Form controls -->
              <div class="card">
                <!-- Card body -->
                <div class="card-body">
                    
                    <div class='row'>
                    	<div class='col-md-6'>
                    		<div class="form-group row">
                      <label class="col-3 col-form-label form-control-label" for="surname">
                      Name: </label>
                      <div class="col-9">
                        <input autocomplete="off" type="text" class="form-control" name="name" id="surname" placeholder="Name" value="{{ old('name') }}">
                        {!! isError($errors, 'name') !!}
                      </div>

                    </div>
                    	</div>
                    	
                    		<div class='col-md-6'>
                    		<div class="form-group row">
                      <label class="col-3 col-form-label form-control-label" for="address">
                      Address: </label>
                      <div class="col-9">
                        <input autocomplete="off" type="text" class="form-control" name="address" id="address" required placeholder="Address" value="{{ old('address') }}">
                        {!! isError($errors, 'address') !!}
                      </div>

                    </div>
                    	</div>
                    	
                    	<div class='col-md-6'>
                    		 <div class="form-group row">
                        <label class="col-3 col-form-label form-control-label" for="mobile">Telephone: </label>
                        <div class="col-9">
                          
                          {!! isError($errors, 'mobile_code') !!}
                          <input autocomplete="off" type="text" class="form-control mt-3" name="telephone" id="mobile" placeholder="Mobile" required value="{{ old('telephone') }}">
                          {!! isError($errors, 'telephone') !!}
                        </div>
                    </div>
                    	</div>
                    	
                    	<div class='col-md-6'>
                    		<div class="form-group row">
                      <label class="col-3 col-form-label form-control-label" for="email">Email: </label>
                      <div class="col-9">
                        <input autocomplete="off" type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                        {!! isError($errors, 'email') !!}
                      </div>
                    </div>
                    	</div>
                    
                    	
                    
                    	
                    </div>
                  
                  
                  
                    
                </div>
              </div>
            </div>
          </div>
          <div class='col-lg-12 d-flex'>
          	<input class='btn btn-primary ml-auto' type="submit" value="Save"/>
          </div>
        
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')

<script type="text/javascript">


</script>
@endpush