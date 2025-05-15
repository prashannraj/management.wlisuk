@extends('layouts.master')


@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">View Web Enquiry Details</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('rawenquiry.index') }}" class="btn btn-sm btn-neutral">
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
        <h4 class="text-primary font-weight-600">Raw Enquiry Details
            <a href="{{ route('rawenquiry.index') }}" class="btn btn-sm btn-primary float-right"> Back</a>

        </h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h3>Status</h3>
                <p>{{ucfirst($data['row']->status_text)}}</p>
                <br>
                <h3>Full Name</h3>
                <p>{{$data['row']->full_name}}</p>
                <br>
                <h3>Nationality</h3>
                <p>{{$data['row']->nationality_country}}</p>
                <br>
                <h3>Date of Birth (DD/MM/YYYY):</h3>
                <p>{{$data['row']->birthDate}}</p>
                <br>
                {{-- <h3>Address</h3>
                <p>{{$data['row']->full_address}}</p>
                <br>--}}
                <h3>Contact Number</h3>
                <p>{{$data['row']->contact_number}}</p>
                <br>

            </div>
            <div class="col-md-6">
                <h3>Email</h3>
                <p>{{$data['row']->email}}</p>
                <br>

                <h3>Enquiry/Instruction</h3>
                <p>{{$data['row']->additional_details}}</p>
                <br>

                <h3>Created on:</h3>
                <p>{{$data['row']->created_at_formatted}}</p>
                <br>


                <h3>Validation status</h3>
                <p>{{$data['row']->validated_status}}</p>
                <br>

                <h3>IP Address and Location details</h3>
                <p>{{$data['row']->ip_address}}</p>
                <br>
            </div>
        </div>
        @if(isset($data['row']->form_type) && $data['row']->form_type == 'immigration')
            <div class="card p-4 row">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Refusal letter date (DD/MM/YYYY):</h3>
                        <p>{{$data['row']->refusalLetterDate}}</p>
                        <br>
                        <h3>Refusal received date (DD/MM/YYYY):</h3>
                        <p>{{$data['row']->refusalReceived}}</p>
                        <br>
                        <h3>Did you apply in the UK or outside the UK?</h3>
                        <p>{{$data['row']->applicationLocation}}</p>
                        <br>
                        <h3>How was the decision received</h3>
                        <p>{{$data['row']->method_decision_received}}</p>
                        <br>
                    </div>
                    <div class="col-md-6">
                        <h3>Authorise additional contact who you wish to authorise to discuss your appeal matter</h3>
                        <p>{{$data['row']->validated_status}}</p>
                        <br>

                        <h3>Visa application (UAN/GWF Number)</h3>
                        <p>{{$data['row']->uan}}</p>
                        <br>

                        <h3>Post Reference/Ho Ref:</h3>
                        <p>{{$data['row']->ho_ref}}</p>
                        <br>


                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h2>UK sponsor/ main contact if appellant based abroad</h2>

                        <h3>Sponsor Name:</h3>
                        <p>{{$data['row']->sponsor_name}}</p>
                        <br>

                        <h3>Relationship with Sponsor:</h3>
                        <p>{{$data['row']->sponsor_relationship}}</p>
                        <br>

                        <h3>Sponsor's Contact Email (if any):</h3>
                        <p>{{$data['row']->sponsor_email}}</p>
                        <br>

                        <h3>UK Sponsor Mobile/Contact:</h3>
                        <p>{{$data['row']->sponsor_phone}}</p>
                        <br>

                        <h3>Sponsor's Address:</h3>
                        <p>{{$data['row']->sponsor_address}}</p>
                        <br>

                        <h3>UK preferred contact person, if different to the sponsor:</h3>
                        <p>{{$data['row']->sponsor_preferred}}</p>
                        <br>

                        <h3>UK preferred contact person's Email:</h3>
                        <p>{{$data['row']->sponsor_preEmail}}</p>
                        <br>

                    </div>
                    <div class="col-md-6">
                        <h3>Refusal Document</h3>
                            @if(isset($data['row']->refusal_document_url))
                                <a href="{{$data['row']->refusal_document_url}}" class="btn btn-sm"><i class="fa fa-file"></i></a>
                            @endif
                        <br>

                        <h3>Appellant Passport</h3>
                            @if(isset($data['row']->appellant_passport_url))
                                <a href="{{$data['row']->appellant_passport_url}}" class="btn btn-sm"><i class="fa fa-file"></i></a>
                            @endif
                        <br>

                        <h3>Proof Address</h3>
                            @if(isset($data['row']->proff_address_url))
                                <a href="{{$data['row']->proff_address_url}}" class="btn btn-sm"><i class="fa fa-file"></i></a>
                            @endif
                        <br>
                        {{-- <h3>Proof Address</h3>
                            @if(isset($data['row']->proff_address_url))
                                @foreach($data['row']->proff_address_url as $additionalDocumentUrl)
                                    <a href="{{$additionalDocumentUrl}}" class="btn btn-sm"><i class="fa fa-file"></i></a>
                                @endforeach
                            @endif
                        <br> --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h2>Tell us Who prepared your application?</h2>

                        <h3>Application prepared by (Name/contact):</h3>
                        <p>{{$data['row']->preparedby}}</p>
                        <br>

                        <h3>Visa Application type:</h3>
                        <p>{{$data['row']->visa}}</p>
                        <br>

                        <h3>Their Contact details (Email/Telephone):</h3>
                        <p>{{$data['row']->appellant_email}}</p>
                        <br>

                    </div>
                    <div class="col-md-6">
                        <h2>Would you like to authorise additional contact who you wish to authorise to discuss your appeal matter?</h2>
                        <h3>Their Name’s, contact phone number & email ID:</h3>
                        <p>{{$data['row']->authorise_name}}</p>
                        <br>

                    </div>
                </div>

            </div>
        @endif
        <div>
        </div>

    </div>
    <div class="card-footer">
        <a href="{{route('rawenquiry.toggle',$data['row']->id)}}" class="btn btn-sm {{$data['row']->active?'btn-info':'btn-danger'}}"><u>{{$data["row"]->active?"Active":"Inactive"}}</u></a>
        <a href='{{route("rawenquiry.show",$data["row"]->id)}}' class='btn btn-sm btn-primary'><u>View</u></a>
        <a href='{{route("rawenquiry.edit",$data["row"]->id)}}' class='btn btn-sm btn-info'><u>Edit</u></a>
        <form action="{{route('rawenquiry.destroy',$data['row']->id)}}" style='display:inline-block' method="POST">
            @csrf @method('delete')
            <button class='btn btn-sm btn-danger' type="submit"><u>Delete</u></button>
        </form>
        <a class='btn btn-sm btn-info' href='{{route("rawenquiry.process",$data['row']->id)}}'><u>Process</u></a>

    </div>
</div>

<!--View modal-->
@endsection
