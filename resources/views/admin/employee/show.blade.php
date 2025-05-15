@extends('layouts.master')
@section('header')
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Employee Details</h6>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('main-content')

<div class="row">
  <div class="col-xl-3">
    <div class="card card-profile">
      <img src="{{asset('assets/img/theme/img-1-1000x600.jpg')}}" alt="Image placeholder" class="card-img-top">
      <div class="row justify-content-center">
        <div class="col-lg-3 order-lg-2">
          <div class="card-profile-image">
            <a href="#">
              <img src="{{asset('assets/img/theme/team-4.jpg')}}" class="rounded-circle">
            </a>
          </div>
        </div>
      </div>
      <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
        <div class="d-flex justify-content-between">
          <a href="{{ route('employee.edit',$data['employee']->id) }}" class="btn btn-sm btn-info mr-4"><i class="fas fa-edit"></i></a>
          <a href="#" class="btn btn-sm btn-danger float-right"><i class="fas fa-times"></i></a>
        </div>
      </div>
      <div class="card-body pt-0">
        <div class="">
          <h5 class="h3">{{ $data['employee']->full_name }}</span></h5>
          <div class="h4 font-weight-500">
            <i class=""></i>Age: <i> {{ $data['employee']->age }} </i> <br />
            <i class=""></i>D.O.B: <b> {{ $data['employee']->dob->format('d F Y') }} </b>
            <hr>
          </div>
          <div class=" mt-2">
            <span class="heading">WLIS ID:</span><span class="description float-right">{{ $data['employee']->id }}</span>
          </div>
          <div class="">
            <span class="heading">Gender:</span><span class="description float-right">{{ $data['employee']->gender }}</span>
          </div>
          <div class="">
            <span class="heading">Status:</span><span class="description float-right">{{ $data['employee']->status }}</span>
          </div>
          <div class="">
            <span class="heading">National of:</span><span class="description float-right">{{$data['employee']->nationality}}</span>
          </div>

          <div class="row">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-9">
    <div class="card">
      <div class="card-header">
        <div class="row align-items-center">
          <!-- <div class="col-lg-8 col-sm-12"> -->
          <ul class="nav nav-tabs dashboard" id="dashboard-tabs">
            <li><a data-toggle="tab" href="#administrative" class="active">Administrative</a></li>
            <li class="nav-item">
              <a data-toggle="tab" href="#employment_info">Employment info</a>
            </li>
            <li><a data-toggle="tab" href="#payroll">Payroll</a></li>
            <li><a data-toggle="tab" href="#communication_log">Communication Log</a></li>

          </ul>
          <!-- </div> -->
          <!-- <div class="col-4 text-right">
              <a href="#!" class="btn btn-sm btn-primary">Settings</a>
            </div> -->
        </div>
      </div>
      <div class="card-body">
        @foreach($data['active_visas'] as $currVisa)
        @php
        $diffInDays = $currVisa->expiry_date_raw->diffInDays(now(),false) * -1;
        @endphp
        @if($diffInDays < 0) <p class="alert alert-error">The visa with visa number <b>{{$currVisa->visa_number}}</b> has already expired. Please take an appropriate action for that.</p>

          @elseif($diffInDays < config('constant.employee_visa_expiry_days')) <p class="alert alert-warning">The visa with visa number <b>{{$currVisa->visa_number}}</b> is expiring in <b>{{$diffInDays}} days</b>. Please take appropriate action.</p>
            @endif

            @endforeach
            <div class="tab-content">
              <div id="administrative" class="tab-pane active">
                <div class="administrative_subs">
                  <ul class="nav nav-tabs nav-pills administrative_subs_links" id="administrative_subs_links" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="contact-details-tab" data-toggle="tab" href="#contact_details" role="tab" aria-controls="contact_details" aria-selected="true">Contact Details</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" class="nav-link" href="#immigration_info">Immigration info</a>
                    </li>

                    <li class="nav-item">
                      <a data-toggle="tab" class="nav-link" href="#documents">Documents</a>
                    </li>
                    <li class="nav-item">
                      <a data-toggle="tab" class="nav-link" href="#send_documents">Send essential documents</a>
                    </li>
                  </ul>
                  <div class="administrative_subs_contents tab-content">
                    <div class="tab-pane fade show active" id="contact_details" role="tabpanel" aria-labelledby="contact-details-tab">
                      <!-- Contact Details -->
                      <div class="card" id="contactDetailsCard">
                        <div class="card-header">
                          <h4 class="text-primary font-weight-600">Current Contact Details</h4>
                        </div>
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-border table-striped" id="contactDetailTable">
                              <thead>
                                <th>SN</th>
                                <th>Primary Number</th>
                                <th>Email Address</th>
                                <th>Contact Number 2</th>
                                <th>Actions</th>
                              </thead>
                              <tbody class="current_contact_details">
                                @if($data['employee']->contact_details)
                                @foreach($data['employee']->contact_details as $index=>$contactDetail)
                                <tr>
                                  <td> {{$index+1}} </td>
                                  <td> {{$contactDetail->country_code_mobile." " . $contactDetail->mobile_number }} </td>
                                  <td> {{ $contactDetail->primary_email}}</td>
                                  <td> {{$contactDetail->country_code_contact." " .$contactDetail->contact_number}} </td>
                                  <td> <a href="{{ route('employeecontact.edit',$contactDetail->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a> </td>
                                  <td>
                                </tr>
                                @endforeach
                                @endif
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class='card-footer'>
                          <div class="mr-2" role="group" aria-label="First group">
                            <a href="" class="btn btn-sm btn-primary" id="addBtnContactDetail">
                              <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> C</span>
                              <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Contact Details </span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <!-- Address -->
                      <div class="card" id="addressCard">
                        <div class="card-header">
                          <h4 class="text-primary font-weight-600">Address</h4>
                        </div>
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-border table-striped" id="addressContactTable">
                              <thead>
                                <th>SN</th>
                                <th>Country</th>
                                <th>Address</th>
                                <th>Post Code</th>
                                <th>Actions</th>
                              </thead>
                              <tbody>
                                @if($data['employee']->addresses)
                                @foreach($data['employee']->addresses as $index=>$addressDetail)
                                <tr>
                                  <td> {{ $index+1 }} </td>
                                  <td> {{$addressDetail->country_name}} </td>
                                  <td> {{ $addressDetail->address }} </td>
                                  <td> {{ $addressDetail->postal_code }} </td>
                                  <td> <a href="{{ route('employeeaddress.edit',$addressDetail->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a> </td>
                                  <td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                  <td colspan="5"> Data not found</td>
                                </tr>
                                @endif
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class='card-footer'>
                          <div class="mr-2" role="group" aria-label="First group">
                            <a href="" class="btn btn-sm btn-success" id="addBtnAddressDetail">
                              <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> A</span>
                              <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Add Address Details</span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <!-- Emergency Contact -->
                      <div class="card" id="emergencyContactCard">
                        <div class="card-header">
                          <h4 class="text-primary font-weight-600">Emergency Contact</h4>
                        </div>
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-border table-striped" id="emergencyContactTable">
                              <thead>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Relationship</th>
                                <th>Contact Number</th>
                                <th>Actions</th>
                              </thead>
                              <tbody>
                                @if($data['employee']->emergency_contacts)
                                @foreach($data['employee']->emergency_contacts as $index=>$emergencyDetail)
                                <tr>
                                  <td> {{ $index+1 }} </td>
                                  <td> {{ $emergencyDetail->name }} </td>
                                  <td> {{ $emergencyDetail->relationship }} </td>
                                  <td> {{ $emergencyDetail->contact_number }} </td>
                                  <td> <a href="{{ route('employeeemergency.edit',$emergencyDetail->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a> </td>
                                </tr>
                                @endforeach
                                @endif
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class='card-footer'>
                          <div class="mr-2" role="group" aria-label="First group">
                            <a href="" class="btn btn-sm btn-warning" id="addBtnEmergencyDetail">
                              <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> E</span>
                              <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Add Emergency Contact</span>
                            </a>
                          </div>
                        </div>
                      </div>
                      <!-- Button -->
                      <div class="btn-toolbar" role="toolbar" aria-label="">

                      </div>
                    </div>




                    <div class="tab-pane fade" id="immigration_info" role="tabpanel" aria-labelledby="immigration-info-tab">
                      <div class="card" id="contactDetailsCard">
                        <div class="card-header">
                          <h4 class="text-primary font-weight-600">Passport Details</h4>
                        </div>
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-border table-striped" id="contactDetailTable">
                              <thead>
                                <th>SN</th>
                                <th>Issuing Country</th>
                                <th>Passport Number</th>
                                <!-- <th>Birth Place</th>   -->
                                <!-- <th>Issuing Author</th>   -->
                                <!-- <th>citizenship_number</th>   -->
                                <!-- <th>Issue Date</th>   -->
                                <th>Expiry Date</th>
                                <th>Actions</th>
                              </thead>
                              <tbody class="passport_contact_details">
                                @if(count($data['employee']->passports))
                                @foreach($data['employee']->passports as $key => $passw)
                                <tr>
                                  <td @if ($key===0) @endif>
                                    {{ $key+1 }}
                                  </td>
                                  <td> {{ ($passw->country)? ucwords(strtolower($passw->country->title)) : '' }} </td>
                                  <td> {{ $passw->passport_number }} </td>
                                  <td> {{ $passw->expiry_date }} </td>
                                  <td>
                                    <form class="form-inline" action="{{route('passportdetail.destroy',$passw->id)}}" method="post">
                                      @csrf
                                      @method('delete')
                                      <a href="{{ route('passportdetail.show',$passw->id)}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                      <a href="{{ route('passportdetail.edit',$passw->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                      <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                  </td>
                                  <td>
                                </tr>
                                @endforeach
                                @endif
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="card-footer">
                          <a href="#PassportDetailAddForm" data-toggle="modal" class="btn btn-sm btn-primary" id="addBtnPassportDetail">
                            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> C</span>
                            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Passport Detail </span>
                          </a>
                        </div>
                      </div>


                      <!-- Passport Details -->
                      <div class="card" id="visaDetailCard">
                        <div class="card-header">
                          <h4 class="text-primary font-weight-600">
                            Current Visa Details
                          </h4>
                        </div>
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-border table-striped" id="contactDetailTable">
                              <thead>
                                <th>SN</th>
                                <th>Visa Type</th>
                                <th>Visa Number</th>
                                <!-- <th>Issue Date</th>  
                <th>Expiry Date</th>   -->
                                <th>Actions</th>
                              </thead>
                              <tbody class="visa_contact_details">
                                @if($data['employee']->currentvisas)
                                @foreach($data['employee']->currentvisas as $index=>$currentvisa)
                                <tr>
                                  <td> {{ $index+1}} </td>
                                  <td> {{ $currentvisa->visa_type }} </td>
                                  <td> {{ $currentvisa->visa_number }} </td>

                                  <td>
                                    <form class="form-inline" action="{{route('visa.destroy',$currentvisa->id)}}" method="post">
                                      @csrf
                                      @method('delete')
                                      <a href="{{ route('visa.toggle',$currentvisa->id)}}" class="btn btn-sm {{$currentvisa->status=='Active'?'btn-info':'btn-danger'}} btn-sm">{{strtolower($currentvisa->status)}}</a>
                                      <a href="{{ route('visa.show',$currentvisa->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                      <a href="{{ route('visa.edit',$currentvisa->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                      <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>

                                    </td>
                                  </form>
                                  <td>
                                </tr>
                                @endforeach
                                @endif
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="card-footer">
                          <a href="#VisaDetailAddForm" data-toggle="modal" class="btn btn-sm btn-primary" id="addBtnVisaDetail">
                            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> C</span>
                            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Current Visa Detail </span>
                          </a>
                        </div>
                      </div>



                    </div>

                    <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                      <div class="card" id="documentCard">
                        <div class="card-header">
                          <h4 class="text-primary font-weight-600">Documents</h4>
                        </div>
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-border table-striped" id="documentTable">
                              <thead>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Note</th>
                                <th>Document</th>
                                <th>Actions</th>
                              </thead>
                              <tbody class="document_details">
                                @if($data['employee']->documents)
                                @foreach($data['employee']->documents as $index=>$doc)
                                <tr>
                                  <td> {{ $index+1 }} </td>
                                  <td> {{ $doc->name }} </td>
                                  <td> {{ $doc->note }} </td>
                                  <td>
                                    @if($doc->document)
                                    <a href="{{ $doc->file_url }}" target="_blank" class="form-control" style="border: 0;">
                                      <i class="{{ $doc->file_type }} fa-2x"></i>
                                    </a>
                                    @endif
                                  </td>
                                  <td>
                                    <a href="{{ route('employeedocument.edit',$doc->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                    <form class='d-inline-block' action="{{ route('employeedocument.destroy',$doc->id)}}" method="post">
                                      @csrf
                                      @method('delete')
                                      <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>

                                    </form>
                                  </td>
                                  <td>
                                </tr>
                                @endforeach
                                @endif
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="card-footer">
                          <a href="#DocumentAddForm" data-toggle="modal" class="btn btn-sm btn-primary">
                            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> D</span>
                            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Document Detail </span>
                          </a>
                        </div>
                      </div>
                    </div>

                    <div class="tab-pane fade" id="send_documents" role="tabpanel" aria-labelledby="immigration-info-tab">
                      <div class="content">
                        <ul class="list-group">
                          <li class="list-group-item">
                            <a href="{{route('additionaldocument.coe.create',$data['employee']->id)}}" class="">Contract of employment</a>
                          </li>
                          <li class="list-group-item">
                            <a href="{{route('additionaldocument.coe.create',$data['employee']->id)}}" class="">Employee privacy notice</a>
                          </li>
                          <li class="list-group-item">
                            <a href="{{route('additionaldocument.eci.create',$data['employee']->id)}}" class="">Employee Contact</a>
                          </li>
                          <li class="list-group-item">
                            <a href="{{route('additionaldocument.nok.create',$data['employee']->id)}}" class="">Next of Kin</a>
                          </li>
                          <li class="list-group-item">
                            <a href="{{route('additionaldocument.ec.create',$data['employee']->id)}}" class="">Confirmation of employment</a>
                          </li>
                          <li class="list-group-item">
                            <a href="{{route('additionaldocument.eicl.create',$data['employee']->id)}}" class="">Employment visa confirmation letter</a>
                          </li>

                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


              <div class="tab-pane fade" id="employment_info" role="tabpanel" aria-labelledby="immigration-info-tab">
                <div class="card" id="">
                  <div class="card-header">
                    <h4 class="text-primary font-weight-600">Employment info</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-border table-striped" id="">
                        <thead>
                          <th>SN</th>
                          <th>Job Title</th>
                          <th>Employment Type</th>
                          <th>Start and End</th>
                          <th>Actions</th>
                        </thead>
                        <tbody>
                          @if($data['employee']->employment_infos)
                          @foreach($data['employee']->employment_infos as $index=>$employment_info)
                          <tr>
                            <td> {{ $index+1 }} </td>
                            <td> {{ $employment_info->job_title }} </td>
                            <td> {{ ucfirst($employment_info->type) }} </td>
                            <td> {{ $employment_info->start_and_end }} </td>
                            <td>
                              <a href="{{ route('employmentinfo.show',$employment_info->id)}}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                              <a href="{{ route('employmentinfo.edit',$employment_info->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>

                            </td>
                          </tr>
                          @endforeach
                          @endif
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class='card-footer'>
                    <div class="mr-2" role="group" aria-label="First group">
                      <a href="{{route('employmentinfo.create',$data['employee']->id)}}" class="btn btn-sm btn-warning" id="">
                        <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> E</span>
                        <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Add Employment info</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>


              <div class="tab-pane fade" id="payroll" role="tabpanel" aria-labelledby="immigration-info-tab">
                <div class="card" id="">
                  <div class="card-header">
                    <h4 class="text-primary font-weight-600">Payslips</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-border table-striped" id="">
                        <thead>
                          <th>SN</th>
                          <th>Year</th>
                          <th>Month</th>
                          <th>Document</th>
                        </thead>
                        <tbody>
                          @if($data['employee']->payslips)
                          @foreach($data['employee']->payslips()->latest()->get() as $index=>$payslip)
                          <tr>
                            <td> {{ $index+1 }} </td>
                            <td> {{ $payslip->year }} </td>
                            <td> {{ ucfirst($payslip->month_string) }} </td>
                            <td>
                              <a href="{{ $payslip->file_url }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                              <a href="{{ route('payslip.edit',$payslip->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                              <a href="{{ route('payslip.email',$payslip->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-envelope"></i></a>

                            </td>
                          </tr>
                          @endforeach
                          @endif
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class='card-footer'>
                    <div class="mr-2" role="group" aria-label="First group">
                      <a href="{{route('payslip.create',$data['employee']->id)}}" class="btn btn-sm btn-warning" id="">
                        <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> E</span>
                        <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Add pay slip</span>
                      </a>
                    </div>
                  </div>
                </div>

                <div class="card" id="">
                  <div class="card-header">
                    <h4 class="text-primary font-weight-600">P45/P60</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-border table-striped" id="">
                        <thead>
                          <th>SN</th>
                          <th>Year</th>
                          <th>Type</th>
                          <th>Document</th>
                        </thead>
                        <tbody>
                          @if($data['employee']->p4560s)
                          @foreach($data['employee']->p4560s()->latest()->get() as $index=>$payslip)
                          <tr>
                            <td> {{ $index+1 }} </td>
                            <td> {{ $payslip->year }} </td>
                            <td> {{ strtoupper($payslip->type) }} </td>
                            <td>
                              <a href="{{ $payslip->file_url }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                              <a href="{{ route('p4560.edit',$payslip->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                              <a href="{{ route('p4560.email',$payslip->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-envelope"></i></a>

                            </td>
                          </tr>
                          @endforeach
                          @endif
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class='card-footer'>
                    <div class="mr-2" role="group" aria-label="First group">
                      <a href="{{route('p4560.create',$data['employee']->id)}}" class="btn btn-sm btn-warning" id="">
                        <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> E</span>
                        <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Add P45/P60</span>
                      </a>
                    </div>
                  </div>
                </div>


              </div>

              <div id="communication_log" class="tab-pane fade">

                <div class="content">
                  @php
                  $data['communicationlogs'] = $data['employee']->communicationlogs
                  @endphp

                  @include('admin.employee.communicationlog')

                </div>

                {{-- <div id="applications" class="tab-pane fade">
            <div class="content">
              @include('admin.application.list')
            </div>
          </div>
          <div id="finances" class="tab-pane fade">
            <div class="content">
              @include('admin.invoice.list')

              @include('admin.receipt.list')
            </div>
          </div>
         
          </div> --}}
              </div>
            </div>
      </div>
    </div>
  </div>

  @include('admin.employee.add_form')

  @endsection

  @push('scripts')

  <script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>


  @if($errors->any())
  <script>
    $.notify({
      icon: 'fas fa-info-circle p-2 fa-1x',
      message: 'Incomplete or invalid fields.',
    }, {
      type: 'warning'
    });
  </script>
  @endif


  <script>
    $(document).ready(function() {
      init();

      $('.datepicker2').datepicker({
        format: "{{ config('constant.date_format_javascript') }}",
      });


      $("#submitStudentContactForm").bind("submit", function(event) {
        console.log($("#submitStudentContactForm").serialize());
        $.ajax({
          async: true,
          data: $("#submitStudentContactForm").serialize(),
          dataType: "html",
          success: function(response) {
            console.log(response);
            $(".current_contact_details").html('');
            var res = JSON.parse(response);
            console.log(res.data);
            $(".current_contact_details").html(res.data);
            $.notify({
              icon: 'far fa-check-circle p-2 fa-1x',
              message: res.message,
            }, {
              type: 'success',
              placement: {
                from: "bottom",
                align: "right"
              },
            });
            if (response.status === true) {

            }
            init();
          },
          error: function(response) {
            $(".contact_details_error").html('');
            if (response.status === 400) {
              console.log(response.status === 400);
              var res = JSON.parse(response.responseText);
              $(".contact_details_error").html(res.message);
            }
          },
          type: "POST",
        });
        return false;
      });


      $("#submitEmergencyForm").bind("submit", function(event) {
        console.log($("#submitEmergencyForm").serialize());
        $.ajax({
          async: true,
          data: $("#submitEmergencyForm").serialize(),
          dataType: "html",
          success: function(response) {
            console.log(response);
            $(".emergency_details_error").html('');
            var res = JSON.parse(response);
            console.log(res.data);
            // $("#emergencyContactTable").html(res.data);
            $.notify({
              icon: 'far fa-check-circle p-2 fa-1x',
              message: res.message,
            }, {
              type: 'success',
              placement: {
                from: "bottom",
                align: "right"
              },
            });
            if (res.status === true) {
              $('#emergencyContactTable tbody').empty('');
              $('#emergencyContactTable tbody').html(res.data);
            }
            init();

          },
          error: function(response) {
            $(".emergency_details_error").html('');
            if (response.status === 400) {
              console.log(response.status === 400);
              var res = JSON.parse(response.responseText);
              $(".emergency_details_error").html(res.message);
            }
          },
          type: "POST",
          url: "{!! route('client.studentEmergencyAdd') !!}"
        });
        return false;
      });


      $("#submitAddressForm").bind("submit", function(event) {
        console.log($("#submitAddressForm").serialize());
        $.ajax({
          async: true,
          data: $("#submitAddressForm").serialize(),
          dataType: "html",
          success: function(response) {
            console.log(response);
            $(".address_details_error").html('');
            var res = JSON.parse(response);
            console.log(res.data);
            // $("#addressContactTable").html(res.data);
            $.notify({
              icon: 'far fa-check-circle p-2 fa-1x',
              message: res.message,
            }, {
              type: 'success',
              placement: {
                from: "bottom",
                align: "right"
              },
            });
            if (res.status === true) {
              $('#addressContactTable tbody').empty('');
              $('#addressContactTable tbody').html(res.data);
            }
            init();
          },
          error: function(response) {
            $(".address_details_error").html('');
            if (response.status === 400) {
              console.log(response.status === 400);
              var res = JSON.parse(response.responseText);
              $(".address_details_error").html(res.message);
            }
          },
          type: "POST",
          url: "{!! route('client.studentAddressAdd') !!}"
        });
        return false;
      });
    });



    $("#closeAll").click(function(e) {
      e.preventDefault();
      init();
    });

    $("#addBtnContactDetail").click(function(e) {
      e.preventDefault();
      init();
      $("#StudentContactDetailAddForm").modal();
    });

    $("#addBtnAddressDetail").click(function(e) {
      e.preventDefault();
      init();
      $("#AddressContactDetailAddForm").modal();
    });

    $("#addBtnEmergencyDetail").click(function(e) {
      e.preventDefault();
      init();
      $("#EmergencyContactDetailAddForm").modal();
    });

    function init() {
      $("#StudentContactDetailAddForm").modal("hide");
      $("#AddressContactDetailAddForm").modal("hide");
      $("#EmergencyContactDetailAddForm").modal("hide");
    }
  </script>
  @if(request()->click)
  <script>
    $(document).ready(function() {

      $("a[href='#{{request()->click}}']").click();
    })
  </script>

  @endif


  @endpush