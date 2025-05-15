
@extends('layouts.master')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
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
          <i class="fas fa-chevron-left" ></i> Back To list</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('main-content')

<!-- Passport Details -->
<div class="card" id="contactDetailsCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Details
        <a href="{{ route('client.show', ['id'=> $data['row']->basic_info_id, 'click'=>'immigration_info' ]) }}" class="btn btn-sm btn-primary float-right"> Back</a></h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-border table-striped"id="contactDetailTable">
                <tbody class="passport_contact_details">
                    <tr>
                        <th>SN</th>
                        <td></td>  
                    </tr>
                    <tr>
                        <th>Issuing Country</th>  
                        <td> {{ ($data['row']->country)? ucfirst(strtolower($data['row']->country->title)) : '' }} </td>
                    </tr>
                    <tr>
                        <th>Passport Number</th>
                        <td> {{ $data['row']->passport_number }} </td>
                    </tr>
                    <tr>
                        <th>Place of Birth</th>
                        <td> {{ $data['row']->birth_place }} </td>
                    </tr>
                    <tr>
                        <th>Issuing Authority</th>
                        <td> {{ $data['row']->issuing_authority }} </td>
                    </tr>
                    <tr>
                        <th>Issue Date</th>
                        <td> {{ $data['row']->issue_date }} </td>
                    </tr>
                    <tr>
                        <th>Expiry Date</th>
                        <td> {{ $data['row']->expiry_date }} </td>
                    </tr>
                    <tr>
                        <th>Citizenship Number</th>
                        <td> {{ $data['row']->citizenship_number }} </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('client.edit.passport',$data['row']->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Edit details</a>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
 $(function() {
    $('#issue_date').datepicker({ format: 'dd-mm-yyyy' });
    $('#expiry_date').datepicker({ format: 'dd-mm-yyyy' });
 });
</script>
@endpush
