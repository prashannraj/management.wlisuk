@extends('layouts.master')


@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">View Service fee Details</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('partner.index') }}" class="btn btn-sm btn-neutral">
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
        <h4 class="text-primary font-weight-600">Partner Details - {{$data['partner']->institution_name}}
            <a href="{{ route('partner.index') }}" class="btn btn-sm btn-primary float-right"> Back</a>

        </h4>
    </div>
    <div class="card-body">
        <div class="row">



            <div class="col-md-6">

                <div class="form-group">
                    <label for="">Country</label>
                    <select disabled name="iso_countrylist_id" class='form-control' id="">
                        <option value="">Select Country</option>
                        @foreach($data['countries'] as $country)

                        <option {{old('iso_countrylist_id',optional( $data['partner'] )->iso_countrylist_id)==$country->id ? "selected":""  }} value="{{$country->id}}">{{$country->title}}</option>
                        @endforeach
                    </select>
                </div>


            </div>
            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Institution Name</label>
                    <input disabled type="text" name="institution_name" value="{{old('institution_name',optional( $data['partner'] )->institution_name)}}" class='form-control' id="">
                </div>

            </div>

            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Contract Holder</label>
                    <input disabled type="text" name="contract_holder" value="{{old('contract_holder',optional( $data['partner'] )->contract_holder)}}" class='form-control' id="">
                </div>

            </div>



            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Contract Type</label>
                    <input disabled type="text" name="contract_type" value="{{old('contract_type',optional( $data['partner'] )->contract_type)}}" class='form-control' id="">
                </div>

            </div>


            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Contract Category</label>
                    <input disabled type="text" name="contract_category" value="{{old('contract_category',optional( $data['partner'] )->contract_category)}}" class='form-control' id="">
                </div>

            </div>


            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Contact Person</label>
                    <input disabled type="text" name="contact_person" value="{{old('contact_person',optional( $data['partner'] )->contact_person)}}" class='form-control' id="">
                </div>

            </div>


            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Position of contact person</label>
                    <input disabled type="text" name="contactperson_position" value="{{old('contactperson_position',optional( $data['partner'] )->contactperson_position)}}" class='form-control' id="">
                </div>

            </div>



            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Email of contact person</label>
                    <input disabled type="text" name="contactperson_email" value="{{old('contactperson_email',optional( $data['partner'] )->contactperson_email)}}" class='form-control' id="">
                </div>

            </div>


            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Contact number</label>
                    <input disabled type="text" name="contact_number" value="{{old('contact_number',optional( $data['partner'] )->contact_number)}}" class='form-control' id="">
                </div>

            </div>

            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Contact Person Two</label>
                    <input disabled type="text" name="contactperson_two" value="{{old('contactperson_two',optional( $data['partner'] )->contactperson_two)}}" class='form-control' id="">
                </div>

            </div>

            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Position of contact person two</label>
                    <input disabled type="text" name="contactperson_positiontwo" value="{{old('contactperson_positiontwo',optional( $data['partner'] )->contactperson_positiontwo)}}" class='form-control' id="">
                </div>

            </div>


            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Email of contact person two</label>
                    <input disabled type="text" name="contactperson_emailtwo" value="{{old('contactperson_emailtwo',optional( $data['partner'] )->contactperson_emailtwo)}}" class='form-control' id="">
                </div>

            </div>


            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Contact number of contact person two</label>
                    <input disabled type="text" name="contact_numbertwo" value="{{old('contact_numbertwo',optional( $data['partner'] )->contact_numbertwo)}}" class='form-control' id="">
                </div>

            </div>

            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Contact Address</label>
                    <input disabled type="text" name="contact_address" value="{{old('contact_address',optional( $data['partner'] )->contact_address)}}" class='form-control' id="">
                </div>

            </div>


            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Agreement</label>
                    <input disabled type="text" name="agreement" value="{{old('agreement',optional( $data['partner'] )->agreement)}}" class='form-control' id="">
                </div>

            </div>

            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Status</label>
                    <select disabled name="status" class='form-control' id="">
                        <option value="">Select status</option>
                        <option {{old('status',optional( $data['partner'] )->status) == "Active"?"selected":""}} value="Active">Active</option>
                        <option {{old('status',optional( $data['partner'] )->status) == "Inactive"?"selected":""}} value="Inactive">Inactive</option>
                    </select>
                </div>

            </div>

            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Contract Start Date</label>
                    <input disabled type="text" name="contract_start" value="{{old('contract_start',optional( $data['partner'] )->contract_start)}}" class='form-control datepicker' id="">
                </div>

            </div>

            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Contract End Date</label>
                    <input disabled type="text" name="contract_end" value="{{old('contract_end',optional( $data['partner'] )->contract_end)}}" class='form-control datepicker' id="">
                </div>

            </div>

            <div class="col-md-6">


                <div class="form-group">
                    <label for="">Note</label>
                    <input disabled type="text" name="note" value="{{old('note',optional( $data['partner'] )->note)}}" class='form-control' id="">
                </div>

            </div>



        </div>

    </div>
    <div class="card-footer">
        <a href="{{route('partner.edit',$data['partner']->id)}}" class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>
    </div>
</div>






<!--View modal-->





@endsection