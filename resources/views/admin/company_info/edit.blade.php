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
          <i class="fas fa-chevron-left" ></i> Back To Dashboard</a>
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
      <form class="row" action="{{ route('companyinfo.update',$data['row']->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
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
                        <input autocomplete="off" type="text" class="form-control" name="name" id="surname" placeholder="Name" value="{{ $data['row']->name }}">
                        {!! isError($errors, 'name') !!}
                      </div>

                    </div>
                    	</div>
                    	
                    		<div class='col-md-6'>
                    		<div class="form-group row">
                      <label class="col-3 col-form-label form-control-label" for="address">
                      Address: </label>
                      <div class="col-9">
                        <input autocomplete="off" type="text" class="form-control" name="address" id="address" required placeholder="Address" value="{{ $data['row']->address }}">
                        {!! isError($errors, 'address') !!}
                      </div>

                    </div>
                    	</div>
                    	
                    	<div class='col-md-6'>
                    		 <div class="form-group row">
                        <label class="col-3 col-form-label form-control-label" for="mobile">Telephone: </label>
                        <div class="col-9">
                          
                          {!! isError($errors, 'mobile_code') !!}
                          <input autocomplete="off" type="text" class="form-control mt-3" name="telephone" id="mobile" placeholder="Mobile" required value="{{ $data['row']->telephone }}">
                          {!! isError($errors, 'telephone') !!}
                        </div>
                    </div>
                    	</div>
                    	
                    	<div class='col-md-6'>
                    		<div class="form-group row">
                      <label class="col-3 col-form-label form-control-label" for="email">Email: </label>
                      <div class="col-9">
                        <input autocomplete="off" type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $data['row']->email }}" required>
                        {!! isError($errors, 'email') !!}
                      </div>
                    </div>
                    	</div>
                    	
                    	<div class='col-md-6'>
                    		<div class="form-group row">
                      <label class="col-3 col-form-label form-control-label" for="website">Website: </label>
                      <div class="col-9">
                        <input autocomplete="off" type="text" class="form-control" id="website" name="website" placeholder="Website" value="{{ $data['row']->website }}" required>
                        {!! isError($errors, 'website') !!}
                      </div>
                    </div>
                    	</div>
                    	
                    	<div class='col-md-6'>
                    		<div class="form-group row">
                      <label class="col-3 col-form-label form-control-label" for="registration_no">Registration No: </label>
                      <div class="col-9">
                        <input autocomplete="off" type="text" class="form-control" id="registration_no" name="registration_no" placeholder="Registration No:" value="{{ $data['row']->registration_no }}" required>
                        {!! isError($errors, 'registration_no') !!}
                      </div>
                    </div>
                   
                    	</div>
                    	
                    	<div class='col-md-12'>
                    		<div class="form-group row">
                      <label class="col-3 col-form-label form-control-label" for="registration_date">Company Registered In: </label>
                      <div class="col-9">
                        <input autocomplete="off" type="text" required class="form-control" id="registration_date" name="registered_in" placeholder="Registered In:" value="{{ $data['row']->registered_in }}" required>
                        {!! isError($errors, 'registered_in') !!}
                      </div>
                    </div>
                    	</div>
                    	
                    	
                    	
                    	<div class='col-md-6'>
                    		<div class="form-group row">
                      <label class="col-3 col-form-label form-control-label" for="regulated_by">Regulated by: </label>
                      <div class="col-9">
                        <input autocomplete="off" type="text" class="form-control" id="regulated_by" name="regulated_by" placeholder="Regulated by:" value="{{ $data['row']->regulated_by }}" required>
                        {!! isError($errors, 'regulated_by') !!}
                      </div>
                    </div>
                   
                    	</div>
                    	
                    	
                    	<div class='col-md-6'>
                    		<div class="form-group row">
                      <label class="col-3 col-form-label form-control-label" for="regulation_no">Regulation No: </label>
                      <div class="col-9">
                        <input autocomplete="off" type="text" class="form-control" id="regulation_no" name="regulation_no" placeholder="Regulation No:" value="{{ $data['row']->regulation_no }}" required>
                        {!! isError($errors, 'regulation_no') !!}
                      </div>
                    </div>
                   
                    	</div>

                      <div class='col-md-6'>
                        <div class="form-group row">
                      <label class="col-3 col-form-label form-control-label" for="vat">Vat No: </label>
                      <div class="col-9">
                        <input autocomplete="off" type="text" class="form-control" id="vat" name="vat" placeholder="Vat No:" value="{{ $data['row']->vat }}" required>
                        {!! isError($errors, 'vat') !!}
                      </div>
                    </div>
                   
                      </div>
                  
                    	<div class='col-md-4'>
                    			@if($data['row']->logo !=null || true)
                    		 <p>Logo Image</p>

                    		<img src="{{$data['row']->logo_url}}" style="height:100px" class='img img-fluid'/>
                    		@endif
                    		<div class='form-group row'>
                    		
                    			<label class="col-3 col-form-label form-control-label">Change Logo Image</label>
                    	<div class='col-9'>
                    		<input type='file' class='file-control' name="logo"/>
</div>
                    		</div>
                    	{!! isError($errors, 'logo') !!}

                    	</div>
                    	
                    	<div class='col-md-4'>
                    			@if($data['row']->regulator_logo !=null || true)
                    		 <p>Regulator logo image</p>

                    		<img src="{{$data['row']->regulator_logo_url}}" style="height:100px" class='img img-fluid'/>
                    		@endif
                    		<div class='form-group row'>
                    		
                    			<label class="col-3 col-form-label form-control-label">Change Regulator logo image</label>
                    	<div class='col-9'>
                    		<input type='file' class='file-control' name="regulator_logo"/>
</div>
                    		</div>
                    	{!! isError($errors, 'regulator_logo') !!}

                    	</div>
                    	
                    		<div class='col-md-4'>
                    		@if($data['row']->stamp !=null || true)
                    		 <p>Stamp Image</p>

                    		<img src="{{$data['row']->stamp_url}}"  style="height:100px" height=300px class='img img-fluid'/>
                    		@endif
                    		<div class='form-group row'>
                    		<label class="col-3 col-form-label form-control-label">Change Stamp Image</label>

	<div class='col-9'>
                    		<input type='file' class='file-control' name="stamp"/>
</div>                    		</div>
                        {!! isError($errors, 'stamp') !!}

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


        <h2>Email Footnote</h2>
        <hr>
        <form action="{{ route('companyinfo.update.footnote',$data['row']->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="col-md-12 mb-4">
            <label for="">Email Footnote</label>

            <textarea name="footnote" id="" rows='4' class='form-control'>{{ $data['row']->footnote }}</textarea>
            {!! isError($errors, 'footnote') !!}

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