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
                    <h6 class="h2 text-white d-inline-block mb-0"> Enquiry Process Log for {{ $data['enquiry']->full_name }} </h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{route('enquiry.list')}}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back To list</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('main-content')


<!-- Passport Details -->
<div class="card" id="">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Activities
            <a href="{{ route('enquiry.list') }}" class="btn btn-sm btn-primary float-right"> Back</a>

        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if($data['activities']->count() == 0)
            <button data-toggle="modal" data-target="#add_log" class="btn btn-primary">Add new log</button>
            @endif
            <table class="table table-striped enquiry-activities">
                <thead class="thead-inverse">
                    <tr>
                        <th style="width:15%">S.No</th>
                        <th>Status</th>
                        <!-- <th>Note</th> -->
                        <th>Created_by</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['activities'] as $index=>$activity)
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>{{$activity->status_attr}}</td>
                        <td>{{$activity->activity_created_by}}</td>
                        <td>
                            <a href="{{ route('enquiry.show.log', $activity->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                            <!-- <a href="#sendEmail" data-toggle="modal" data-id="{{$activity->id}}" class="btn btn-sm btn-warning"><i class="fa fa-envelope"></i></a> -->
                            @if($index==0)
                            <a href="#" data-toggle="modal" data-target="#add_log" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>


                            <a href="#" data-target="#edit_log" data-toggle="modal" data-docid="{{$activity->id}}" data-note="{{$activity->note}}" data-status="{{$activity->status}}" data-followup_date="{{optional($activity->enquiryFollowUp)->date??''}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                            <a data-toggle="modal" data-target="#delete_log" data-docid="{{$activity->id}}" href="#" class="btn btn-warning btn-sm"><i class="fa fa-trash"></i></a>
                            @endif


                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <a href="{{route('enquiry.show',$data['enquiry']->id)}}" class="btn btn-primary">View this enquiry</a>
                            <a href="{{route('enquiry.edit',$data['enquiry']->id)}}" class="btn btn-info">Edit this enquiry</a>

                        </td>

                    </tr>
                </tfoot>
            </table>



        </div>

        <div>
            @foreach ($errors->all() as $error)
            <p class='alert alert-warning'>{{ $error }}</p>
            @endforeach
        </div>




    </div>
    <!-- Send information/documents dropdown -->
<!-- Send information/documents dropdown -->
<div class="card-footer">
    <div class="dropdown">
        <button class="btn btn-warning dropdown-toggle" type="button" id="sentDocumentsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Send information/documents
        </button>
        <div class="dropdown-menu" aria-labelledby="sentDocumentsDropdown">
            <a class="dropdown-item" href="{{route('enquiry.enquirycare',$data['enquiry']->id)}}">1. Enquiry Care/Requirements Letter</a>
            <div class="dropdown-divider"></div>

            <!-- Client Care Letter -->
            <a class="dropdown-item dropdown-toggle" href="#" id="clientCareDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">2. Client Care Letter</a>
            <div class="dropdown-menu" aria-labelledby="clientCareDropdown">
                <a class="dropdown-item" href="{{route('enquiry.newccl',$data['enquiry']->id)}}">a. CCL Applications</a>
                <a class="dropdown-item" href="{{route('enquiry.lteccl',$data['enquiry']->id)}}">b. CCL Appeal - Gurkha - Child (LTE)</a>
                <a class="dropdown-item" href="{{route('enquiry.cclapplication',$data['enquiry']->id)}}">c. CCL Appeal - Gurkha - Grandchild (LTE)</a>
                <a class="dropdown-item" href="{{route('enquiry.cclapplication',$data['enquiry']->id)}}">d. CCL Appeal - Appendix FM - Spouse/Child (LTE)</a>
                <a class="dropdown-item" href="{{route('enquiry.cclapplication',$data['enquiry']->id)}}">e. CCL Appeal - Appendix FM, §97 - Child (LTE)</a>
                <a class="dropdown-item" href="{{route('enquiry.cclapplication',$data['enquiry']->id)}}">f. CCL Appeal - EUSS FP (LTE)</a>
                <a class="dropdown-item" href="{{route('enquiry.cclapplication',$data['enquiry']->id)}}">g. CCL Appeal - Private Life Outside Rules (LTE)</a>
                <a class="dropdown-item" href="{{route('enquiry.cclapplication',$data['enquiry']->id)}}">h. CCL Appeal - Human Rights claim (LTR)</a>
                <a class="dropdown-item" href="{{route('enquiry.cclapplication',$data['enquiry']->id)}}">i. CCL Other matter/general</a>
            </div>

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('enquiry.fileopeningform',$data['enquiry']->id)}}">3. File Opening Form</a>
            <a class="dropdown-item" href="{{route('enquiry.clientofauthority',$data['enquiry']->id)}}">4. Letter of Authority - Client</a>
            <a class="dropdown-item" href="{{route('enquiry.letterofauthority',$data['enquiry']->id)}}">5. Letter of Authority - Non Client</a>
            <a class="dropdown-item" href="{{route('enquiry.requesttomedical',$data['enquiry']->id)}}">6. Request Access to Medical Records</a>
            <a class="dropdown-item" href="{{route('enquiry.subjectaccess',$data['enquiry']->id)}}">7. Subject Access Request (Home Office)</a>
            <a class="dropdown-item" href="{{route('enquiry.requesttofinance',$data['enquiry']->id)}}">8. Request Access to Financial Records</a>
            <a class="dropdown-item" href="{{route('enquiry.requesttotrbunal',$data['enquiry']->id)}}">9. Request Access to Tribunal Determination</a>
            <a class="dropdown-item" href="{{route('enquiry.lettertofirm',$data['enquiry']->id)}}">10. Letter to Firms When Requesting Data</a>
        </div>
    </div>
</div>


</div>



<div class="card" id="documentCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Emails sent

        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(count($data['enquiry']->communicationlogs))

            <table class="table table-border table-striped" id="communicationlogTable">
                <thead>
                    <th>SN</th>

                    <th>Subject</th>
                    <th>Date Sent</th>
                    <th>Actions</th>
                </thead>
                <tbody class="communicationlog_details">
                    @foreach($data['enquiry']->communicationlogs()->latest()->get() as $index=>$communicationlog)
                    <tr>
                        <td> {{ $index + 1}} </td>

                        <td style="white-space: pre-wrap;"> {{ ucfirst($communicationlog->description) }} </td>
                        <td>{{$communicationlog->updated_at->format(config('constant.date_format'))}}</td>
                        <td>
                            <a href="{{ route('communicationlog.show',['communicationlog'=>$communicationlog->id])}}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                            <form class='d-inline-block' action="{{ route('communicationlog.destroy',$communicationlog->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>

                            </form>
                        <td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
            @else

            <p>No emails sent</p>
            @endif


        </div>






    </div>

</div>




<div class="card" id="documentCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Sent documents

        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(count($data['enquiry']->documents))

            <table class="table table-border table-striped" id="communicationlogTable">
                <thead>
                    <th>SN</th>

                    <th>Name</th>
                    <th>Note</th>
                    <th>Actions</th>
                </thead>
                <tbody class="communicationlog_details">
                    @foreach($data['enquiry']->documents as $index=>$doc)
                    <tr>
                        <td> {{ $index+1 }} </td>
                        <td> {{ $doc->name }} </td>
                        <td> {{ $doc->note }} </td>

                        <td>
                            @if($doc->documents)
                            <a href="{{ $doc->file_url }}" class="btn btn-sm">
                                <i class="{{ $doc->file_type }} fa-2x"></i>
                            </a>
                            @endif
                            <form class='d-inline-block' action="{{ route('document.destroy',$doc->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>

                            </form>
                        </td>
                        <td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
            @else

            <p>No documents sent</p>
            @endif


        </div>






    </div>

</div>






<!-- Add enquiry log -->


<div class='modal' id="add_log">
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                Add new Enquiry process Log
            </div>
            <div class='modal-body'>
                <div class='border shadow-sm p-2'>
                    <form action="{{route('enquiry.store.log',['id'=>$data['enquiry']->id])}}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="">Status</label>
                            <select required class='form-control status' name="status">
                                <option value="">Select enquiry status</option>
                                @foreach(config('constant.ENQUIRY_STATUS') as $key=>$status)
                                <option value="{{$key}}">{{$status}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="followup" style='display:none'>

                            <div class="form-group">
                                <label for="">Followup Date</label>
                                <input type="text" name="followup_date" class='form-control datepicker2' id="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Note</label>
                            <textarea class='form-control' name="note" id="" id="data-note" rows='1'></textarea>
                        </div>

                        <input class='btn btn-primary' type="submit" value="Add">
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- Delete enquiry log -->

<div class="modal fade" id="delete_log" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <form action="{{route('enquiry.destroy.log',$data['enquiry']->id)}}" method="post">
                {{method_field('delete')}}
                {{csrf_field()}}
                <div class="modal-body">
                    <p class="text-center">
                        Are you sure you want to delete this?
                    </p>
                    <input type="hidden" name="log_id" id="doc_id" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">No, Cancel</button>
                    <button type="submit" class="btn btn-success">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Update Enquiry Log -->


<div class='modal' id="edit_log">
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                Update Enquiry process Log
            </div>
            <div class='modal-body'>
                <div class='border shadow-sm p-2'>
                    <form action="{{route('enquiry.update.log',['id'=>$data['enquiry']->id])}}" method="POST">
                        @csrf
                        @method('put')

                        <input type="hidden" name="activity_id" value="" id="activity_id">
                        <div class="form-group">
                            <label for="">Status</label>
                            <select required class='form-control status' name="status" id="status">
                                <option value="">Select enquiry status</option>
                                @foreach(config('constant.ENQUIRY_STATUS') as $key=>$status)
                                <option value="{{$key}}">{{$status}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="followup" style='display:none'>

                            <div class="form-group">
                                <label for="">Followup Date</label>
                                <input type="text" name="followup_date" class='form-control datepicker2' id="followup_date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Note</label>
                            <textarea class='form-control' name="note" id="note"></textarea>
                        </div>

                        <input class='btn btn-primary' type="submit" value="Update">
                    </form>
                </div>
            </div>
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


<div class='modal fade' id="addAddress">
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
            <div class="modal-header">
                <h5 class="modal-title" id="">Add Address Contact Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card">

                <div class="card-body">
                    <div class="address_details_error"></div>
                    <form action="" id="submitAddressForm">
                        @csrf
                        <input value="{{ $data['enquiry']->id }}" name="enquiry_list_id" type="hidden">
                        <input value="{{ $data['enquiry']->id }}" name="enquiry_id" type="hidden">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Country</label>
                                    <select class="form-control" id="iso_countrylist_id" name="iso_countrylist_id">
                                        <option value="">Select Options</option>
                                        @foreach ($data['country_code'] as $countryCode)
                                        <option value="{{ $countryCode->id }} " {{ (old("iso_countrylist_id") == $countryCode->id ? "selected":"") }}>{{ $countryCode->title }}</option>
                                        @endforeach
                                    </select>
                                    {!! isError($errors, 'iso_countrylist_id') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Post Code</label>
                                    <input type="text" autocomplete="off" class="form-control" name="overseas_postcode" id="overseas_postcode" aria-describedby="helpId" placeholder="">
                                </div>
                            </div>
                            <!-- <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Address</label>
                            <input type="text"autocomplete="off" class="form-control" name="overseas_address" id="overseas_address" aria-describedby="helpId" placeholder="">
                        </div>
                    </div> -->
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <textarea name="overseas_address" id="overseas_address" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit">Add</button>
                    </form>
                </div>
            </div>


        </div>

    </div>
</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>


<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $('.datepicker2').datepicker({
        format: "{{ config('constant.date_format_javascript') }}",
    });


    $('.status').on('change', function(evt) {
        var $this = $(evt.currentTarget);
        if ($this.val() == 2) {
            $this.parent().parent().find('.followup').show();
        } else {
            $this.parent().parent().find('.followup').hide();
        }
    })

    $('#delete_log').on('show.bs.modal', function(evt) {
        var button = $(evt.relatedTarget);
        var modal = $(evt.currentTarget);
        var id = button.data('docid');

        modal.find('#doc_id').val(id);
    });

    $('#edit_log').on('show.bs.modal', function(evt) {
        var button = $(evt.relatedTarget);
        if (button.html() === undefined || button.hasClass('datepicker2')) {
            return;
        }


        var modal = $(evt.currentTarget);
        var id = button.data('docid');
        var note = button.data('note');
        var status = button.data('status');
        var followup_date = button.data('followup_date');

        modal.find('#activity_id').val(id);
        modal.find('#note').val(note);
        modal.find('#status').val(status);
        modal.find('#status').change();

        modal.find('#followup_date').val(followup_date);




    });
</script>


<script>

</script>
<script src="{{asset('assets/js/tinymce/tinymce.min.js')}}"></script>

<script>
    $('#delete_address').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)

        var doc_id = button.data('id');
        var modal = $(this);
        modal.find('input[name=address_id]').val(doc_id);
    })
</script>
@endpush
