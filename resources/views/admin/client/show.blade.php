@extends('layouts.master')

@push('styles')
@endpush
@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-6">
          <h6 class="h2 text-white d-inline-block mb-0 pl-4">{{ $data['panel_name'] }}</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('enquiry.list') }}" class="btn btn-sm btn-neutral">
            <i class="fas fa-plus-circle" ></i> New
          </a>
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
      <div class="card-header border-0 pb-0">
        <div class="card-wrapper">
        </div>
      </div>
      <div class="card-body">
      <div class="row">
                  <table class="table table-striped table-inverse table-responsive">
                        <thead>
                            <tr>
                                <th>User Detail</th>
                                <th>#</th>
                            </tr>
                        </thead>  
                        <tbody>
                              <tr>
                                  <th>Title</th>
                                  <td>{{ $data['enquiry']->title }}</td>
                              </tr>
                              <tr>
                                  <th>Full Name</th>
                                  <td>{{ $data['enquiry']->full_name }}</td>
                              </tr>
                              <tr>
                                  <th>Mobile</th>
                                  <td>{{ $data['enquiry']->country_mobile .' '. $data['enquiry']->mobile }}</td>
                             </tr>
                             <tr>
                                  <th>Tel</th>
                                  <td>{{ $data['enquiry']->country_tel .' '. $data['enquiry']->tel }}</td>
                             </tr>
                             <tr>
                                  <th>Email</th>
                                  <td>{{ $data['enquiry']->email }}</td>
                             </tr>
                             <tr>
                                  <th>Enquiry Type</th>
                                  <td>{!! $data['enquiry']->enquiry_type !!}</td>
                             </tr>
                             <tr>
                                  <th>Referral</th>
                                  <td>{{ $data['enquiry']->referral }}</td>
                             </tr>
                             <tr>
                                  <th>Note</th>
                                  <td>{{ $data['enquiry']->note }}</td>
                             </tr>
                          </tbody>
                  </table>
              </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')


@endpush