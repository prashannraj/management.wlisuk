@extends("layouts.master")

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
                    <h6 class="h2 text-white d-inline-block mb-0">Client's Visa Report</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back To Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('main-content')

@include('adminlte-templates::common.errors')

<div class="row">
    <div class="col">
        <!-- Passport Details -->
        <div class="card" id="documentCard">
            <div class="card-header">
                <h3 class="text-primary font-weight-600">Client visas

                </h3>
            </div>
            <div class="card-body">
                <div>
                    <form class="form-inline my-4" id="filterform">
                        <div class="form-group">
                            <label class="mx-1" for="">Filter by visa expiry</label>
                            <select name="visa_expiry" id="" class="form-control-sm mx-1">
                                <option>Select an option</option>
                                <option {{request()->visa_expiry == '6'?"selected":""}} value="6">6 months</option>
                                <option {{request()->visa_expiry == '3'?"selected":""}} value="3">3 months</option>
                                <option {{request()->visa_expiry == '1'?"selected":""}} value="1">1 month</option>
                                <option {{request()->visa_expiry == '1w'?"selected":""}} value="1w">1 week</option>
                                <option {{request()->visa_expiry == '0'?"selected":""}} value="0">Today</option>

                            </select>

                            <div class="form-group mx-2">
                                <label for="">Start Date</label>
                                <input autocomplete="off" type="text" class="ml-1 datepicker2 form-control" name="startdate">

                            </div>
                            <div class="form-group mx-2">
                                <label for="">End Date</label>
                                <input autocomplete="off" type="text" class='ml-1 form-control datepicker2' name="enddate">

                            </div>
                        </div>
                        <input type="submit" class='btn btn-info' value="Filter">
                        <a href="#" class="btn btn-warning" id="resetbutton">Reset</a>

                    </form>
                </div>
                <div class="table-responsive">


                    {!! $dataTable->table() !!}

                </div>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
</div>

@endsection

@push('modals')
<div class="modal fade" id='sendEmailModal'>
    <div class="modal-dialog modal-dialog-lg modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <p>Send visa expiry email</p>
                <p class="status"></p>
                <form action="{{route('send.visaexpiry.email')}}" id="sendForm" enctype="multipart/form-data" method="post">
                    @csrf

                    <input type="hidden" id='receivers' name="receivers">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Select sender</label>
                                <select name="sender_id" id="" class="form-control">
                                    <option value="">Select an option</option>
                                    @foreach($data['senders'] as $sender)
                                    <option value="{{$sender->id}}">{{$sender->name}} - {{$sender->email}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Select receiver (from client)</label>
                                <select name="client_email" id="client_email" class="form-control">
                                    <option value="">Select an option</option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Select receiver (from kin)</label>
                                <select name="kin_email" id="kin_email" class="form-control">
                                    <option value="">Select an option</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <h3>Send Email</h3>
                                <div class="documents-list">
                                    <label for="">Attach from company documents</label>
                                </div>
                                <button class="btn-sm btn-primary" id="addDocumentField">
                                    <i class="fa fa-plus"></i>
                                </button>

                                <div class="form-inline">
                                    <div class="attachment-list">
                                        <label for="">Attachment (If any)</label>
                                        <input type="file" name='attachments[]' class="form-control">
                                    </div>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Enquiry Form</label>
                        <select name="form_id" id="" class="form-control">
                            <option value="">Select an option</option>
                            @foreach($data['forms'] as $form)
                            <option value="{{$form->id}}">{{$form->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Email Content</label>

                        <div class="form-inline">
                            <button data-target="email_content" class="template-load btn-small btn-primary mx-2">Load</button>
                            <span class="loading"></span>
                        </div>

                        <div class="form-group">
                            <label for="">Subject</label>
                            <input type="text" readonly name='subject' id='subject' class="form-control">
                        </div>
                        <textarea name="email_content" id='email_content' class="form-control wysiwyg">{{old('email_content')}}</textarea>

                    </div>
                    <p>Please load subject and email content first before pressing submit button.</p>
                    <button class="btn btn-primary">Submit</button>
                    <button data-dismiss="modal" class="btn btn-secondary">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endpush



@push("scripts")
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="/vendor/datatables/buttons.server-side.js"></script>
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
{!! $dataTable->scripts() !!}

<script>
    $(function() {


        $("#filterform").on("submit", function(e) {
            e.preventDefault();
            window.LaravelDataTables["visareport-table"].draw();
        })


        $("#resetbutton").on('click', function(e) {
            e.preventDefault();
            $('input[name=visa_expiry]').val("");
            $('input[name=startdate]').val("");
            $('input[name=enddate]').val("")

            window.LaravelDataTables["visareport-table"].draw();
        })

        $('.datepicker2').datepicker({
            format: "{{ config('constant.date_format_javascript') }}",
        });

    });

    function loadReceivers() {
        var data = window.LaravelDataTables['visareport-table'].data();
        var ids = [];
        data.map(function(e) {
            ids.push(e.id);
        })

        return ids.join(',');
    }
    var obje;
    $("#sendEmailModal").on('show.bs.modal', function(e) {
        var modal = $(e.target);
        var button = $(e.relatedTarget);
        var val = $(e.relatedTarget).data('id');
        modal.find('.status').html(button.attr('title'));
        modal.find('#receivers').val(val);
        $.get("/ajax/visa/" + val, function(data) {
            // console.log(data['kins']);
            if ($('#client_email').hasClass("select2-hidden-accessible")) {
                // Select2 has been initialized
                $('#client_email').select2('destroy');

            }
            if ($('#kin_email').hasClass("select2-hidden-accessible")) {
                // Select2 has been initialized
                $('#kin_email').select2('destroy');

            }
            $("#client_email").html("");
            $("#kin_email").html("");

            var kin_emails = data.client.kins.map(function(e) {
                return e.email
            });
            
            var emails = data.client.contact_details.map(function(e) {
                return e.primary_email
            });
            emails.unshift("Select an option");
            kin_emails.unshift("Select an option");
            $('#client_email').select2({
                data: emails,
                placeholder: 'Select an option'
            });

            $('#kin_email').select2({
                data: kin_emails,
                placeholder: 'Select an option'
            });
        });
    });
</script>

<style>
    .select2-container .select2-selection--single {
        height: auto
    }
</style>
<script src="{{asset('assets/js/tinymce/tinymce.min.js')}}"></script>

<script>
    initiateTinymce('textarea.wysiwyg');
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

<script>
    function ajaxSearchTemplate($id, $loading, $target) {

        $loading.html("loading");
        $loading.show();
        var url = "/template/" + $id;
        // alert(url);
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                // alert(data); // show response from the php script.

                console.log(data);
                if (data.hasOwnProperty("content")) {
                    $loading.html("loaded...");

                    tinyMCE.get($target).setContent(data.content)
                } else {
                    $loading.html("");
                }

            },
            done: function() {

                // alert("done");
            }
        });
    }

    function addField(e) {
        e.preventDefault();
        var field = '<input type="file" name="attachments[]" class="form-control">';
        $(".attachment-list").append(field);
    }

    $("#addField").on('click', addField);

    $(".template-load").on('click', function(e) {
        e.preventDefault();
        $loading = $(this).siblings(".loading")
        // var x = $(this).siblings("select").val();
        // // alert($(this).data('target'));
        var $target = $(this).data("target");
        // ajaxSearchTemplate(x, $loading, target);
        $("#sendForm").ajaxSubmit({
            type: 'post',
            success: function(data) {
                tinyMCE.get($target).setContent(data.content);
                $('#' + $target).parents('.modal-content').find('#subject').val(data.subject);
                $loading.html("Success");
            },
            error: function(err) {
                $loading.html("Error occurred");
            },

        });

        $(".edit-input").on('click', function(e) {
            e.preventDefault();
            var $target = $(this).siblings('input');
            if ($target.attr('readonly'))
                $target.removeAttr("readonly");
            else {
                $target.attr('readonly', 'readonly');
            }
        })
    })


    function addDocumentField(e) {
        e.preventDefault();
        var field = '<select name="documents[]" class="form-control">' +
            '<option>Select an option</option>' +
            '@foreach($data["documents"] as $doc) <option value="{{$doc->id}}">{{$doc->name}}</option>  @endforeach' +
            '</select>';
        $(".documents-list").append(field);

    }

    $("#addDocumentField").on('click', addDocumentField);
</script>


@endpush