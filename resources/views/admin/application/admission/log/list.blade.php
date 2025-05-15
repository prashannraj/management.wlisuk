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
                    <a href="{{ route('application.admission.index') }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back to list</a>
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
        <h4 class="text-primary font-weight-600">Applications
            <a href="{{ route('client.show', $data['basic_info_id']) }}" class="btn btn-sm btn-primary float-right"> Back to Client</a>

        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-border table-striped" id="documentTable">
                <thead>
                    <th>S/N</th>
                    <th>Added Date</th>

                    <th>Status</th>
                    <th>Elapsed Days</th>
                    <th>Document</th>
                    <th>Actions</th>
                </thead>
                <tbody class="document_details">
                    @php
                    $count = count($data['applicationLogs']);
                    @endphp
                    @if($count > 0)
                    @foreach($data['applicationLogs'] as $index=>$logs)
                    <tr>
                        <td>{{$count-$index}}</td>
                        <td> {{ $logs->created_at }} </td>

                        <td>{{$logs->applicationStatus->title}}</td>
                        <td> {{ $logs->elapsed_days }} </td>
                        <td>
                            @if($logs->document)
                            <a href="{{ $logs->file_url }}" class="form-control" style="border: 0;">
                                <i class="fa fa-image fa-2x"></i>
                            </a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('client.application.view.admission.process', $logs->id) }}" data-target="#view_application_process" data-id="{{$logs->id}}" data-application_status_id="{{$logs->application_status_id}}" data-note={{base64_encode($logs->note)}} data-document="{{$logs->document?$logs->file_url: '-1'}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="#sendEmail" data-toggle="modal" data-id="{{$logs->id}}" class="btn btn-sm btn-warning"><i class="fa fa-envelope"></i></a>
                            @if($index==0)
                            <a href="#" data-toggle="modal" data-target="#add_application_log" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>


                            <a href="{{ route('client.edit.application.admission', $logs->id) }}" data-date="{{$logs->date}}" data-reason="{{$logs->reason}}" data-toggle="modal" data-target="#update_application_process" data-id="{{$logs->id}}" data-application_status_id="{{$logs->application_status_id}}" data-note="{{base64_encode($logs->note)}}" data-document="{{$logs->document?$logs->file_url: '-1'}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                            <a data-toggle="modal" data-target="#deleteApplicationProcess" data-docid="{{$logs->id}}" href="#" class="btn btn-warning btn-sm"><i class="fa fa-trash"></i></a>
                            @endif


                        </td>
                        <td>
                    </tr>
                    @endforeach
                    @else

                    <tr>
                        <td>No application process</td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#add_application_log" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>

                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>

        <div>
            @foreach ($errors->all() as $error)
            <p class='alert alert-warning'>{{ $error }}</p>
            @endforeach
        </div>

    </div>
    <div class="card-footer">
    </div>
</div>



<div class='modal' id="add_application_log">
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                Add new application process
            </div>
            <div class='modal-body'>
                <div class='border shadow-sm p-2'>
                    <form action="{{route('client.list.application.admission.store,logs',['id'=>$data['application']->id])}}" enctype='multipart/form-data' method="POST">
                        @csrf
                        <input type="hidden" value="" id="data-id" name="application_process_id">
                        <div class="form-group">
                            <label for="">Status</label>
                            <select required class='form-control application_status' name="application_status_id">
                                @foreach($data['applicationLogsStatuses'] as $status)
                                <option value="{{$status->id}}">{{$status->title}}</option>

                                @endforeach
                            </select>
                        </div>

                        <div class="reason" style='display:none'>
                            <div class="form-group">
                                <label for="">Reason</label>
                                <select class='form-control' name="reason">
                                    <option value="">Select the reason</option>
                                    @foreach(config('constant.reasons') as $status)
                                    <option value="{{$status}}">{{$status}}</option>

                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Date</label>
                                <input type="text" name="date" class='form-control datepicker' id="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Document</label>
                            <input type="file" class='file-control' name="document" id="">
                        </div>

                        <div class="form-group">
                            <label for="">Note</label>
                            <textarea class='form-control' name="note" id="" id="data-note" rows='1'></textarea>
                        </div>

                        <input type="submit" value="Add">
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>



<div class='modal' id="update_application_process">
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                Edit application process
            </div>
            <div class='modal-body'>
                <div class='border shadow-sm p-2'>
                    <form action="{{route('client.application.update.admission.process',['id'=>'_'])}}" enctype='multipart/form-data' method="POST">
                        @csrf
                        @method("PUT")
                        <input type="hidden" value="" id="data-id" name="application_process_id">
                        <div class="form-group">
                            <label for="">Status</label>
                            <select required class='form-control application_status' id="data-application_status_id" name="application_status_id">
                                @foreach($data['applicationLogsStatuses'] as $status)
                                <option value="{{$status->id}}">{{$status->title}}</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="reason" style="display:none">

                            <div class="form-group">
                            <label for="">Reason</label>
                            <select id='data-reason' class='form-control' name=" reason">
                                <option value="">Select the reason</option>
                                @foreach(config('constant.reasons') as $status)
                                <option value="{{$status}}">{{$status}}</option>

                                @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Date</label>
                                <br>
                                <span class='text-primary'>Fill this only if you need to change the date.</span>
                                <input type="text" name="date" autocomplete="off" class='form-control datepicker2' id="data-date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Document</label>
                            <input type="text" disabled id="data-document" class='form-control' placeholder="" />
                            <span class='my-1'>Uploading new document will replace old document</span>
                            <input type="file" class='file-control' name="document" id="">
                        </div>

                        <div class="form-group">
                            <label for="">Note</label>
                            <textarea class='form-control' name="note" id="data-note" rows='3'></textarea>
                        </div>

                        <input type="submit" class='btn btn-primary' value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="deleteApplicationProcess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <form action="{{route('client.application.delete.admission.process','_')}}" method="post">
                {{method_field('put')}}
                {{csrf_field()}}
                <div class="modal-body">
                    <p class="text-center">
                        Are you sure you want to delete this?
                    </p>
                    <input type="hidden" name="application_process_id" id="doc_id" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">No, Cancel</button>
                    <button type="submit" class="btn btn-success">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- send email -->

<div class="modal fade" id="sendEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title text-center" id="myModalLabel">Send Email</h4>
            </div>
            <form action="{{route('client.application.email.admission.process')}}" enctype="multipart/form-data" method="post">
                {{csrf_field()}}
                <div class="modal-body">
                    @include("admin.application.partials.email_form")
                    <input type="hidden" name="application_process_id" id="doc_id" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">No, Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes, Send</button>
                </div>
            </form>
        </div>
    </div>
</div>






<!--View modal-->





@endsection

@push('scripts')
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('#issue_date').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#expiry_date').datepicker({
            format: 'dd-mm-yyyy'
        });
    });
</script>
<script>
    $('#deleteApplicationProcess').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)

        var doc_id = button.data('docid')
        var modal = $(this)

        modal.find('.modal-body #doc_id').val(doc_id);
    })


    $('#sendEmail').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)

        var doc_id = button.data('id')
        var modal = $(this)

        modal.find('.modal-body #doc_id').val(doc_id);
    });

    $('#update_application_process').on('show.bs.modal', function(event) {
        if ($(event.target).hasClass('datepicker2')) {
            return;
        }
        var button = $(event.relatedTarget)

        var doc_id = button.data('id');
        var application_status = button.data('application_status_id');
        try {
            console.log(button.data('note'));
            var note = atob(button.data('note'));
        } catch (e) {
            console.log("no note");

            note = "";
        }
        var reason = button.data('reason');

        var date = button.data('date');
        var file = button.data('document');
        if (file === -1) file = "No document has been uploaded";

        var modal = $(this);

        modal.find('.modal-body #data-id').val(doc_id);
        modal.find('.modal-body #data-application_status_id').val(application_status);
        modal.find('.modal-body #data-note').val(note);
        modal.find('.modal-body #data-document').val(file);
        modal.find('.modal-body #data-reason').val(reason);
        modal.find('.modal-body #data-date').val(date);



        // alert("lol");
    })
</script>
<script>
    $(".application_status_").on('change', function(evt) { //disabled for a while todo
        var x = $(this).val();
        var source = $(evt.currentTarget);

        if (x == {{config('constant.file_closed_id')}}){
            source.parent().parent().find('.reason').show()
        } else {
            source.parent().parent().find('.reason select').val('');
            source.parent().parent().find('.reason').hide()
        }
    });
</script>

<script>
    $('.datepicker').datepicker({
        format: "{{ config('constant.date_format_javascript') }}",
    });

    $('.datepicker2').datepicker({
        format: "{{ config('constant.date_format_javascript') }}",
    });
</script>
@endpush