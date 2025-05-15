@extends('layouts.master')
@section('header')
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Settings</h6>

        </div>

      </div>
      <!-- Card stats -->
    </div>
  </div>
</div>
@endsection
@section('main-content')

<div class="card">

  <div class="card-body">
    <h3>Email address settings</h3>
    <form action="" method="POST">
      @csrf
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Info email details</label>
            <input type="email" class="form-control my-1" placeholder="Email" name='info_email' value="{{setting('info_email','info@wlisuk.com')}}">
            <input type="text" class="form-control my-1" placeholder="From" name='info_from' value="{{setting('info_from','West London Immigration Services')}}">

          </div>
        </div>





        <div class="col-md-6">
          <div class="form-group">
            <label for="">Admin email details</label>
            <input type="email" class="form-control my-1" placeholder="Email" name='admin_email' value="{{setting('admin_email','admin@wlisuk.com')}}">
            <input type="text" class="form-control my-1" placeholder="From" name='admin_from' value="{{setting('admin_from','Admin')}}">
          </div>

        </div>
        <div class="col-md-6">

          <div class="form-group">
            <label for="">Enquiries email details</label>
            <input type="email" class="form-control my-1" placeholder="Email" name='enquiries_email' value="{{setting('enquiries_email','enquiries@wlisuk.com')}}">
            <input type="text" class="form-control my-1" placeholder="From" name='enquiries_from' value="{{setting('enquiries_from','Enquiries')}}">
          </div>
        </div>




        <div class="col-md-6">
          <div class="form-group">
            <label for="">Applications email details</label>
            <input type="email" class="form-control my-1" placeholder="Email" name='applications_email' value="{{setting('applications_email','applications@wlisuk.com')}}">
            <input type="text" class="form-control my-1" placeholder="From" name='applications_from' value="{{setting('applications_from','Applications')}}">
          </div>
        </div>


        <div class="col-md-6">
          <div class="form-group">
            <label for="">Accounts email details</label>
            <input type="email" class="form-control my-1" placeholder="Email" name='accounts_email' value="{{setting('accounts_email','accounts@wlisuk.com')}}">
            <input type="text" class="form-control my-1" placeholder="From" name='accounts_from' value="{{setting('accounts_from','Accounts')}}">
          </div>
        </div>

      </div>

      <button class="btn btn-primary">Save</button>
    </form>
  </div>
</div>

@endsection