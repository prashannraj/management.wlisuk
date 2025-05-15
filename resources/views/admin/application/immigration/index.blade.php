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
                    <h6 class="h2 text-white d-inline-block mb-0">Immigration Applications</h6>
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
<div class="row">
    <div class="col">
        <!-- Passport Details -->
        <div class="card" id="documentCard">
            <div class="card-header">
                <h3 class="text-primary font-weight-600">Immigration Applications

                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div>
                        <form class="form-inline my-4" id="filterform">
                            <div class="form-group mx-2">
                                <label for="">Application Status</label>
                                <select autocomplete="off" type="text" class="ml-1 form-control" name="application_status_id">
                                    <option value="">Select application status</option>
                                    @foreach($data['application_statuses'] as $status)
                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                    @endforeach
                                </select>



                            </div>
                            <div class="form-group mx-2 form-inline">
                                <label for="">Start Date</label>
                                <input autocomplete="off" type="text" class="ml-1 datepicker2 form-control" name="startdate">

                            </div>
                            <div class="form-group form-inline mx-2">
                                <label for="">End Date</label>
                                <input autocomplete="off" type="text" class='ml-1 form-control  datepicker2' name="enddate">

                            </div>
                            <div class="form-group mx-2 d-none">
                                <label for="">Active/Inative</label>
                                <select autocomplete="off" type="text" class="ml-1 form-control" name="status">
                                    <option value="">Select application status</option>
                                    @foreach(['active','inactive'] as $status)
                                    <option value="{{$status}}">{{ucfirst($status)}}</option>
                                    @endforeach
                                </select>



                            </div>

                            <input type="submit" class='btn btn-info' value="Filter">
                            <a href="#" class="btn btn-warning" id="resetbutton">Reset</a>

                        </form>



                    </div>


                    {!! $dataTable->table() !!}
                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>
<div class="modal" id="delete_immigration_application">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('client.delete.application.immigration')}}" method="POST">
                @method('delete')
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Delete application</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <input type="hidden" name="application_id" value="">
                <!-- Modal body -->
                <div class="modal-body">
                    <h3>Are you sure you want to delete the application? This can't be undone.</h3>

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

@endsection

@push("scripts")
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="/vendor/datatables/buttons.server-side.js"></script>
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
{!! $dataTable->scripts() !!}

<script>
    $(function() {

        var oTable = window.LaravelDataTables["immigrationapplication-table"].draw();

        $("#filterform").on("submit", function(e) {
            e.preventDefault();
            oTable.draw();
        })


        $("#resetbutton").on('click', function(e) {
            e.preventDefault();
            $('select[name=application_status_id]').val("");
            $('input[name=startdate]').val("");
            $('input[name=enddate]').val("");
            $('input[name=status]').val("");

            oTable.draw();
        })

        $('.datepicker2').datepicker({
            format: "{{ config('constant.date_format_javascript') }}",
        });

    });
</script>
<script>
    $('#delete_immigration_application').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)

        var doc_id = button.data('id');
        var modal = $(this);
        modal.find('input[name=application_id]').val(doc_id);
    })
</script>



@endpush