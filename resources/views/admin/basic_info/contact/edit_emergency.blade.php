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
          <a href="{{ route('enquiry.list') }}" class="btn btn-sm btn-neutral">
          <i class="fas fa-chevron-left" ></i>Back</a>
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
        <h3 class="mb-0"></h3>
      </div> --}}
      <div class="card-body">
        <!-- Address Contact From Block -->
        <div id="AddressContactDetailAddForm">
            <div class="card">
                <div class="card-header">
                    <h4>Client Emergency Contact
                    <a href="{{ route('client.show', ['id'=> $data['row']->basic_info_id, 'click'=>'contact_details' ]) }}" class="btn btn-sm btn-primary float-right"> Back</a>

                    </h4>
                </div>
                <div class="card-body">
                    <div class="address_details_error"></div>
                    <form action="{{ route('update.client.emergency', $data['row']->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input value="{{ $data['row']->basic_info_id }}" name="basic_info_id" type="hidden">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text"autocomplete="off" class="form-control" name="name" id="name" value="{{ $data['row']->name}}" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Relationship</label>
                                    <input type="text"autocomplete="off" class="form-control" name="relationship" id="relationship" value="{{ $data['row']->relationship}}" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Contact Number</label>
                                    <input type="text"autocomplete="off" class="form-control" name="contact_number" id="contact_number" value="{{ $data['row']->contact_number }}" placeholder="Enter Contact Number">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text"autocomplete="off" class="form-control" name="email" id="email" value="{{ $data['row']->email }}" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <textarea name="address" id="" cols="30" rows="10" class="form-control">{{ $data['row']->address }}</textarea>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary float-right" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
      
    
    
    
        </div>


    </div>
  </div>
</div>
@endsection

@push('scripts')

<script type="text/javascript">


</script>
@endpush