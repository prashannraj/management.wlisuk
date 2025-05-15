@extends('layouts.master')


@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">View Service Providers</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('serviceprovider.index') }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back To list</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('main-content')

<!-- Passport Details -->
<div class="card" id="documentCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">serviceprovider Details - {{$data['serviceproviders']->company_name}}
            <a href="{{ route('serviceprovider.index') }}" class="btn btn-sm btn-primary float-right"> Back</a>

        </h4>
    </div>
    <div class="card-body">
        <div class="row">


            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Company Name</label>
                    <input disabled type="text" name="company_name" value="{{old('company_name',optional( $data['serviceproviders'] )->company_name)}}" class='form-control' id="">
                </div>

            </div>

            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Regulated By</label>
                    <input disabled type="text" name="regulated_by" value="{{old('regulated_by',optional( $data['serviceproviders'] )->regulated_by)}}" class='form-control' id="">
                </div>

            </div>



            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Main Contact</label>
                    <input disabled type="text" name="main_contact" value="{{old('main_contact',optional( $data['serviceproviders'] )->main_contact)}}" class='form-control' id="">
                </div>

            </div>


            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Contact two</label>
                    <input disabled type="text" name="contact_two" value="{{old('contact_two',optional( $data['serviceproviders'] )->contact_two)}}" class='form-control' id="">
                </div>

            </div>


            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Email one</label>
                    <input disabled type="text" name="email_one" value="{{old('email_one',optional( $data['serviceproviders'] )->email_one)}}" class='form-control' id="">
                </div>

            </div>


            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Email Two</label>
                    <input disabled type="text" name="email_two" value="{{old('email_two',optional( $data['serviceproviders'] )->email_two)}}" class='form-control' id="">
                </div>

            </div>



            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Main Telephone</label>
                    <input disabled type="text" name="main_tel" value="{{old('main_tel',optional( $data['serviceproviders'] )->main_tel)}}" class='form-control' id="">
                </div>

            </div>


            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Address</label>
                    <input disabled type="text" name="address" value="{{old('address',optional( $data['serviceproviders'] )->address)}}" class='form-control' id="">
                </div>

            </div>

            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Direct Contact</label>
                    <input disabled type="text" name="direct_contact" value="{{old('direct_contact',optional( $data['serviceproviders'] )->direct_contact)}}" class='form-control' id="">
                </div>

            </div>




        </div>

    </div>
    <div class="card-footer">
        <a href="{{route('serviceprovider.edit',$data['serviceproviders']->id)}}" class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>
    </div>
</div>






<!--View modal-->





@endsection
