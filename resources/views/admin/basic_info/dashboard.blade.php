@extends('layouts.master')
@section('header')
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Client Details</h6>
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
      <img src="../../assets/img/theme/img-1-1000x600.jpg" alt="Image placeholder" class="card-img-top">
      <div class="row justify-content-center">
        <div class="col-lg-3 order-lg-2">
          <div class="card-profile-image">
            <a href="#">
              <img src="../../assets/img/theme/team-4.jpg" class="rounded-circle">
            </a>
          </div>
        </div>
      </div>
      <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
        <div class="d-flex justify-content-between">
          <a href="{{ route('edit.basic_info',$data['basic_info']->id) }}" class="btn btn-sm btn-info mr-4"><i class="fas fa-edit"></i></a>
          <a href="#" class="btn btn-sm btn-danger float-right"><i class="fas fa-times"></i></a>
        </div>
      </div>
      <div class="card-body pt-0">
        <div class="">
          <h5 class="h3">{{ $data['basic_info']->full_name }}</span></h5>
          <div class="h4 font-weight-500">
            <i class=""></i>Age: <i> {{ $data['basic_info']->age }} </i> <br />
            <i class=""></i>D.O.B: <b> {{ $data['basic_info']->dob }} </b>
            <hr>
          </div>
          <div class=" mt-2">
            <span class="heading">WLIS ID:</span><span class="description float-right">{{ $data['basic_info']->id }}</span>
          </div>
          <div class="">
            <span class="heading">Gender:</span><span class="description float-right">{{ $data['basic_info']->gender }}</span>
          </div>
          <div class="">
            <span class="heading">Status:</span><span class="description float-right">{{ $data['basic_info']->status }}</span>
          </div>
          <div class="">
            <span class="heading">Nationality:</span><span class="description float-right">{{ ($data['basic_info']->passport()->latest()->first())? $data['basic_info']->passport()->latest()->first()->country->title: '' }}</span>
          </div>
          <div class="">
            <span class="heading">Visa Expiry:</span><span class="description float-right">{{ ($data['basic_info']->currentvisa()->latest()->first())? $data['basic_info']->currentvisa()->latest()->first()->expiry_date: '' }}</span>
          </div>
          <div class="">
            <span class="heading">Passport Expiry:</span><span class="description float-right">{{ ($data['basic_info']->passport()->latest()->first())? $data['basic_info']->passport()->latest()->first()->expiry_date: '' }}</span>
          </div>
          <div class="">
            <span class="heading">Parent enquiry:</span><span class="description float-right"><a target="_blank" href="{{route('enquiry.show',$data['basic_info']->enquiry_list_id)}}">{{optional($data['basic_info']->enquiry)->full_name}}</a></span>
          </div>


          <div class="row">
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">Linked enquiries <button data-target="#link_enquiry" data-toggle="modal" class="btn-sm btn-warning float-right"><i class="fa fa-plus"></i></button> </div>
      <div class="card-body">
        <div class="list-group">

          @foreach($data['basic_info']->enquiries as $enq)
          <div class="list-group-item">
            <a target="_blank" class="smaller" href="{{route('enquiry.show',$enq->id)}}">{{$enq->full_name}}</a>
            <form class="form-inline float-right" action="{{route('enquiry.unlink',$enq->id)}}" method="POST">
              @csrf 
              <button class="btn-danger btn-sm"><i class="fa fa-unlink"></i></button>

            </form>
          </div>
          @endforeach

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
            <li><a data-toggle="tab" href="#applications">Applications</a></li>
            <li><a data-toggle="tab" href="#finances">Finance</a></li>
            <li><a data-toggle="tab" href="#communication">Communication</a></li>

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
                      <a data-toggle="tab" class="nav-link" href="#immigration_info">Immigration Info</a>
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
                                @if(count($data['basic_info']->studentContactDetails))
                                @foreach($data['basic_info']->studentContactDetails as $index=>$contactDetail)
                                <tr>
                                  <td> {{$index+1}} </td>
                                  <td> {{ $contactDetail->contact_mobile }} </td>
                                  <td> {{$contactDetail->primary_email}} </td>
                                  <td> {{ $contactDetail->contact_tel }}</td>
                                  <td> <a href="{{ route('edit.contact',$contactDetail->id)}}" class="btn btn-success btn-sm">
                                      <i class="fa fa-edit"></i></a>
                                    <a href="#delete_contact" data-toggle="modal" data-id="{{$contactDetail->id}}" class="btn btn-sm btn-danger">
                                      <i class="fa fa-trash"></i>
                                    </a>
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
                                @if(count($data['basic_info']->studentAddressDetails))
                                @foreach($data['basic_info']->studentAddressDetails as $index=>$addressDetail)
                                <tr>
                                  <td> {{ $index+1 }} </td>
                                  <td> {{$addressDetail->country_name}} </td>
                                  <td> {{ $addressDetail->overseas_address }} </td>
                                  <td> {{ $addressDetail->overseas_postcode }} </td>
                                  <td> <a href="{{ route('edit.address',$addressDetail->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>

                                    <a href="#delete_address" data-toggle="modal" data-id="{{$addressDetail->id}}" class="btn btn-sm btn-danger">
                                      <i class="fa fa-trash"></i>
                                    </a>
                                  </td>

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
                                @if(count($data['basic_info']->studentEmergencyDetails))
                                @foreach($data['basic_info']->studentEmergencyDetails as $index=>$emergencyDetail)
                                <tr>
                                  <td> {{ $index+1 }} </td>
                                  <td> {{ $emergencyDetail->name }} </td>
                                  <td> {{ $emergencyDetail->relationship }} </td>
                                  <td> {{ $emergencyDetail->contact_number }} </td>
                                  <td> <a href="{{ route('edit.emergency',$emergencyDetail->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="#delete_emergency" data-toggle="modal" data-id="{{$emergencyDetail->id}}" class="btn btn-sm btn-danger">
                                      <i class="fa fa-trash"></i>
                                    </a>
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
                      @include('admin.basic_info.immigration.passport_list')
                      @include('admin.basic_info.immigration.visa.list')
                    </div>
                    <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                      @include('admin.basic_info.document.list')
                    </div>

                    <div class="tab-pane fade" id="send_documents" role="tabpanel" aria-labelledby="immigration-info-tab">
                      <div class="content">
                        <ul class="list-group">
                          <li class="list-group-item">
                            <a href="{{route('additionaldocument.loa.create',$data['basic_info']->id)}}" class="">Letter of authority</a>
                          </li>
                          <li class="list-group-item">
                            <a href="{{route('additionaldocument.fof.create',$data['basic_info']->id)}}" class="">File opening form</a>
                          </li>
                          <li class="list-group-item">
                            <a href="{{route('additionaldocument.loc.create',$data['basic_info']->id)}}" class="">Third party consent</a>
                          </li>
                          <li class="list-group-item">
                            <a href="{{route('additionaldocument.rel.create',$data['basic_info']->id)}}" class="">Representation Letter</a>
                          </li>

                          <li class="list-group-item">
                            <a href="{{route('additionaldocument.spd.create',$data['basic_info']->id)}}" class="">Sponsor declaration</a>
                          </li>
                          <li class="list-group-item">
                            <a href="{{route('additionaldocument.apd.create',$data['basic_info']->id)}}" class="">Applicant declaration</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div id="applications" class="tab-pane fade">
                <ul class="nav nav-tabs application_sub_links" id="application_sub_links" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="" data-toggle="tab" href="#application_tab" role="tab" aria-selected="true">Applications</a>
                  </li>
                  <li class="nav-item">
                    <a data-toggle="tab" class="nav-link" href="#application_assessments">Application Assessments</a>
                  </li>
                </ul>

                <div class="tab-content">
                  <div class="tab-pane show active" id="application_tab">
                    <div class="content">
                      @include('admin.application.list')
                    </div>
                  </div>
                  <div class="tab-pane" id="application_assessments">
                    @include('admin.application_assessment.list')
                  </div>
                  <div class="tab-pane" id="immigration_appeal">
                      @include('admin.immigration_appeal.list')
                  </div>
                </div>

              </div>
              <div id="finances" class="tab-pane fade">
                <div class="content">
                  @include('admin.invoice.list')

                  @include('admin.receipt.list')
                </div>
              </div>
              <div id="communication" class="tab-pane fade">
                <ul class="nav nav-tabs communication_sub_links" id="communication_sub_links" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="communication-logs-tab" data-toggle="tab" href="#communicationlogs" role="tab" aria-controls="communication_logs" aria-selected="true">Communication Logs</a>
                  </li>
                  <li class="nav-item">
                    <a data-toggle="tab" class="nav-link" href="#attendance">Attendance Notes</a>
                  </li>
                </ul>

                <div class="communication_sub_links tab-content">
                  <div class="tab-pane fade show active" id="communicationlogs" role="tabpanel" aria-labelledby="communication-logs-tab">
                    <div class="content">
                      @php
                      $data['communicationlogs'] = $data['basic_info']->communicationlogs
                      @endphp

                      @include('admin.communicationlog.list')

                    </div>
                  </div>
                  <div id="attendance" class="tab-pane fade">
                    <div class="content">
                      @include('admin.attendancenotes.list')
                    </div>
                  </div>
                </div>

              </div>


            </div>
      </div>
    </div>
  </div>
</div>



@include('admin.basic_info.add_form')



<div class="modal" id="delete_contact">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('delete.contact','_')}}" method="POST">
        @method('delete')
        @csrf
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Delete contact details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <input type="hidden" name="contact_id" value="">
        <!-- Modal body -->
        <div class="modal-body">
          <h3>Are you sure you want to delete this current contact? This can't be undone.</h3>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="submit" value="Yes" class="btn btn-info">
          <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="modal" id="delete_emergency">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('delete.emergency','_')}}" method="POST">
        @method('delete')
        @csrf
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Delete emergency details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <input type="hidden" name="emergency_id" value="">
        <!-- Modal body -->
        <div class="modal-body">
          <h3>Are you sure you want to delete this emergency details? This can't be undone.</h3>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="submit" value="Yes" class="btn btn-info">
          <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="modal" id="delete_address">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('delete.address','_')}}" method="POST">
        @method('delete')
        @csrf
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Delete address details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <input type="hidden" name="address_id" value="">
        <!-- Modal body -->
        <div class="modal-body">
          <h3>Are you sure you want to delete this current address? This can't be undone.</h3>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="submit" value="Yes" class="btn btn-info">
          <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="modal" id="link_enquiry">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="" method="POST">
        @csrf
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add enquiry</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <select name='enquiry_id' placeholder="Type here to quickly fill up enquiry name" class='form-control enquiryautocomplete'>
          </select>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="submit" value="Link" class="btn btn-info">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </form>

    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>
<script>
  $('.enquiryautocomplete').autoComplete({
    resolverSettings: {
      url: '{{url("/ajax/enquiries?unlinked=1")}}'
    },
    events: {
      searchPost: function(data) {
        var da = [];
        data.map(function(e) {
          da.push({
            id: e.id,
            value: e.id,
            text: e.id + "-" + e.full_name,
            address: e.address,
            addresses: e.addresses
          });
        })
        return da;
      }
    },

  });
</script>
<script>
  $(document).ready(function() {
    init();

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
        url: "{!! route('client.studentContactDetailsAdd') !!}"
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



@push('scripts')
<script>
  $('#delete_contact').on('show.bs.modal', function(event) {

    var button = $(event.relatedTarget)

    var doc_id = button.data('id');
    var modal = $(this);
    modal.find('input[name=contact_id]').val(doc_id);
  })

  $('#delete_address').on('show.bs.modal', function(event) {

    var button = $(event.relatedTarget)

    var doc_id = button.data('id');
    var modal = $(this);
    modal.find('input[name=address_id]').val(doc_id);
  })

  $('#delete_emergency').on('show.bs.modal', function(event) {

    var button = $(event.relatedTarget)

    var doc_id = button.data('id');
    var modal = $(this);
    modal.find('input[name=emergency_id]').val(doc_id);
  })
</script>

@endpush