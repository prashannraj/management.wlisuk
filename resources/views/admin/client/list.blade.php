@extends('layouts.master')

@push('styles')
  {{-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"> --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
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
          <a href="{{ route('enquiry.create') }}" class="btn btn-sm btn-neutral">
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
        <div class="table-responsive py-4">
        	<div class="form-group">
                          <label class="form-control-label" for="filterByActivity">Filter By Status</label>
                          <select class="form-control bg-primary text-white" id="filterByStatus" name="status">
                            <option value="">Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Pending">Pending</option>
                            <option value="Inactive">Inactive</option>
                          </select>
                </div>
          <table class="table table-bordered table-flush" id="enquiry-table">
            <thead class="thead-light">
                <tr>
                    <th>SNo.</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <!-- <th>Mobile</th> -->
                    <!-- <th>Email</th> -->
                    <th>Gender</th>
                    <th>Action</th>
                </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')

<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <script type="text/javascript">
  $(function() {
      var oTable = $('#enquiry-table').DataTable({
        autoWidth: false,
        language: {
          paginate: {
            previous: "<i class='fas fa-angle-left'>",
            next: "<i class='fas fa-angle-right'>"
          }
        },
        processing: true,
        serverSide: true,
        order: [[ 0, "desc" ]],
        ajax: {
            url: '{!! route('client.list') !!}',
            data: function (d) {
                d.status =  $('select[name=status]').val();
            }
        },
        columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: 'id', name: 'id' },
                { data: 'f_name', name: 'f_name' },
                { data: 'm_name', name: 'm_name' },
                { data: 'l_name', name: 'l_name' },
                // { data: 'mobile', name: 'mobile' },
                // { data: 'email', name: 'email' },
                {data:'gender',name:'gender'},
                { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
      });
      oTable.draw();
      
      // $('#filter-form').on('submit', function(e) {
      //     oTable.draw();
      //     e.preventDefault();
      // });
      
      $('#filterByStatus').on('change',function(e){
        oTable.draw();
        e.preventDefault();          
      });

      $('#filterByEnquiryType').on('change',function(e){
          oTable.draw();
          e.preventDefault();
      });

      $('#btnReset').on('click',function(e){
          $(this).toggleClass("down"); 
          $('#filterByActivity').val('');
          $('#filterByEnquiryType').val('');
          oTable.draw();
          e.preventDefault();
      });

      $('.statusModification').change(function(e){
        if($(this).val() == 2){
            $('.follow-up-section').show();
        }else{
            $('.follow-up-section').hide();
        };
      });

      $('#status-modification-form').hide();

      $('.follow-up-section').hide();

      $('.follow-up-date').datepicker({
        format: 'dd-mm-yyyy',
      });

  });

  function renderTable(elmt,id){
    console.log(id);
    if(id){
      $.ajax({
        method: 'GET',
        data: {'id' : id},
        url: '{!! route("enquiry.status") !!}',
        context: document.body
      }).done(function(result) {
        console.log(result);
        resetFormFields();
        // $('table.enquiry-activities').html('');
        if(result.activities && result.activities.length > 0){
          var activities = result.activities;
          $('table.enquiry-activities tbody').html('');
          activities.forEach(element => {
            console.log('item >> ',element);
            var newAction = '';
            if(element.status == 1){
            newAction = '<a href="#" class="btn btn-default btn-sm next_process" onclick="getStatusBox(this,' + 
            element.id + ')" data-target="#nextprocess" ' + 
            'data-id="' + element.id + 
            '" data-enquiryListId="' + element.enquiry_list_id + 
            '" data-status="' + element.status + 
            // '" data-note="' + element.note + 
            '" data-exist=""><i class="fa fa-cog"></i></a>';
            }
            var actions = newAction + 
            '<a href="#" class="btn btn-primary btn-sm change_status" onclick="getStatusBox(this,' + 
            element.id + ')" data-target="#changeStatus" ' + 
            'data-id="' + element.id +
            '" data-enquiryListId="' + element.enquiry_list_id + 
            '" data-status="' + element.status + 
            // '" data-note="' + element.note + 
            '" data-exist=""><i class="fa fa-edit"></i></i></a>';
            $('table.enquiry-activities tbody').append(
                '<tr>' + 
                '<td id="">' + element.id + '</td>' +
                '<td>' + element.status_attr + '</td>' +
                '<td>' + element.process_status + '</td>' +
                // '<td>' + element.note + '</td>' +
                '<td>' + element.activity_created_by + '</td>' +
                '<td>' + actions + '</td>' + 
                '</tr>');
          });
        }
        // S.N
        // status	
        // Follow Up
        // note
        // created_by
        // Actions
        $( this ).addClass( "done" );
      });
    }
  }

  function getModal(elmnt,id) {
    renderTable(elmnt,id);
    $('#editStatus').modal({
        show: true
    }); 
  }

  function resetFormFields(){
    $('.statusModification').val('');
    $('#status-modification-form').hide();
    $('.follow-up-section').hide();
    $('#form-heading').text('');
    $('#activity-id').val('');
  }

  function getStatusBox(elmnt,id) {
    console.log(id);
    if(id){
      $('#updateStatus').prop('disabled',false);
      console.log($(elmnt).data('target'));
      var heading = ($(elmnt).data('target') == '#nextprocess')? 'Next Process' : 'Update Status';
      var activityType = ($(elmnt).data('target') == '#nextprocess')? 1 : 0;
      var enquiryListId = $(elmnt).data('enquirylistid');
      console.log(heading,activityType,enquiryListId);
      resetFormFields();
      $('#activity-id').val($(elmnt).data('id'));
      $('#activity-type').val(activityType);
      $('#enquiry-id').val(enquiryListId);
      $('#form-heading').text(heading);
      $("[name='status_note']").val($(elmnt).data('note'));
        if($(elmnt).data('status') == 1){

        }else if($(elmnt).data('status') == 2){
          $("select.statusModification").val($(elmnt).data('status'));
        }else{
          $("select.statusModification").val($(elmnt).data('status'));
        }
      $('#status-modification-form').show(); 
    }
  }

  $(document).ready(function() {
    
    $("#updateStatus").attr("disabled", true);

    $( "#updateStatus" ).on( "click" , function(e){
      var activityType = $( "#activity-type" ).val();
      var enquiryListId = $( "#enquiry-id" ).val();
      var activityId = $( "#activity-id" ).val();
      var statusNote = $( "[name='status_note']" ).val();
      var statusSelection = $( "[name='status_modification']" ).val();
      var followUpDate = $( "[name='followUpDate']" ).val();
      var followUpNote = $( "[name='followUpNote']" ).val();
      var error = false;

      var data = {
        'activityType': activityType,
        'activityId': activityId,
        'statusNote': statusNote,
        'statusSelection': statusSelection,
        'followUpDate': followUpDate,
        'followUpNote': followUpNote,
        '_token': "{{ csrf_token() }}",
      };

      error = validateData(data);

      if(Object.keys(error).length > 0){
        console.log(error);
        var list = '';
        var output = '';
        Object.entries(error).forEach(([key, value]) => {
          list += '<li>' + value + '<li>';
        });
        var output = '<ul class="alert alert-danger">' + list + '</ul>';
        $('#errorDiv').html('');
        $('#errorDiv').append(output);
      }else{
        $('#errorDiv').html('');
          $.ajax({
            method: 'POST',
            url: "{!! route('enquiry.postStatusUpdate') !!}",
            data: data
          }).done(function(result) {
            console.log(result.status);
            if(result.status){
              // render table
              // enquiry-activities
              console.log('test');
              renderTable(null,enquiryListId);
              $("#updateStatus").attr("disabled", true);
            }
          });
      }
    });
  });

  function validateData(data){
    var error = [];

    if(data['activityType'] === null ){
      error['activityType'] = "Selected type is not applicable"; 
    }
    if(data['activityId'] === null){
        error['activityId'] = "No selected data for update status"; 
    }
    if(data['statusSelection'].length == 0){
      error['statusSelection'] = "Please select the status type"; 
    }

    if(data['statusSelection'].length > 0 && parseInt(data['statusSelection']) === 2 ){
      if(data['followUpDate'].length == 0){
        error['followUpDate'] = "Follow up date must be selected";
      }
    }

    return (Object.keys(error).length > 0)? error:false;
  }

  </script>
@endpush