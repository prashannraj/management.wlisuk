<div class="card" id="documentCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Immigration Appeal Applications</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-border table-striped" id="documentTable">
                <thead>
                    <th>SN</th>
                    <th>Date</th>
                    <th>Applicant's Name</th>
                    <th>Application Type</th>
                    <th>Application status</th>
                    <th>Actions</th>
                </thead>
                @php
                $endindex = 0;
                @endphp
                <tbody class="document_details">
                    @if(count($data['basic_info']->immigrationAppealApplication))
                    @foreach($data['basic_info']->immigrationAppealApplication as $index=>$immapp)
                    <tr>
                        <td> {{ $index+1 }} </td>
                        <td>{{$immapp->created->format(config('constant.date_format'))}}</td>
                        <td>{{$immapp->student_name}}</td>
                        <td> {{ ucfirst($immapp->application_type) }} </td>
                        <td> {{ $immapp->status->title }} </td>
                        <td>
                            <a href="{{ route('client.edit.application.immigration',$immapp->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('client.list.application.immigration.logs',$immapp->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-cog"></i></a>

                            @if($immapp->applicationProcesses->count()==0)
                            <a href="#delete_immigration_application" data-toggle="modal" data-id="{{$immapp->id}}" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                            @endif
                            <a href="{{route('aacl.create',$immapp->id)}}" class="btn btn-sm btn-info"><i class="fa fa-image"></i></a>
                        </td>

                    </tr>
                    @php
                    $endindex = $index+1;
                    @endphp
                    @endforeach
                    @endif


                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
 <a href="{{ route('client.add.application.immigration',$data['basic_info']->id) }}" data-target="#confirmModal" data-toggle="modal" class="btn btn-sm btn-primary" id="addBtnImmigrationApplication">
            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> IA</span>
            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Application Detail </span>
        </a>
    </div>
</div>

@if(count($data['basic_info']->admissionApplications))
<div class="card-header">
    <h4 class="text-primary font-weight-600">Admission applications</h4>
</div>
<div class="card">
    <div class="card-body">

        <table class="table table-responsive table-striped">
            <thead>
                <th>SN</th>
                <th>Date</th>
                <th>Applicant's Name</th>
                <th>Institution</th>
                <th>Start date</th>
                <th>Application status</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach($data['basic_info']->admissionApplications as $index=>$admapp)
                <tr>
                    <td> {{ $index+ 1 + $endindex }} </td>
                    <td>{{$admapp->created->format(config('constant.date_format'))}}</td>
                    <td>{{$admapp->student_name}}</td>
                    <td>{{optional($admapp->partner)->institution_name}}</td>

                    <td> {{ $admapp->course_start }} </td>
                    <td> {{ $admapp->status->title }} </td>
                    <td>
                        <a href="{{ route('client.edit.application.admission',$admapp->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('client.list.application.admission.logs',$admapp->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-cog"></i>
                        </a>
                        @if($admapp->applicationProcesses->count()==0)
                        <a href="#delete_admission_application" data-toggle="modal" data-id="{{$admapp->id}}" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <div class="card-footer">
        <a href="{{ route('client.add.application.immigration',$data['basic_info']->id) }}" data-target="#confirmModal" data-toggle="modal" class="btn btn-sm btn-primary" id="addBtnImmigrationApplication">
            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> IA</span>
            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Application Detail </span>
        </a>
    </div>
</div>
@endif



<div class="modal" id="confirmModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add new application</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <h3>Please select the type of application to add</h3>
                <div>
                    <a class='btn btn-primary m-2' href="{{ route('client.add.application.immigration',$data['basic_info']->id) }}">Immigration application</a>
                    <a class='btn btn-primary m-2' href="{{ route('client.add.application.admission',$data['basic_info']->id) }}">Admission application</a>
                    <a class='btn btn-primary m-2' href="{{ route('client.add.application.immigrationappeal',$data['basic_info']->id) }}">Immigration Appeal</a>
                    <a class='btn btn-primary m-2' href="#">Other</a>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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

<div class="modal" id="delete_admission_application">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('client.delete.application.admission')}}" method="POST">
                @method('delete')
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Delete admission application</h4>
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

@push('scripts')
<script>
    $('#delete_immigration_application').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)

        var doc_id = button.data('id');
        var modal = $(this);
        modal.find('input[name=application_id]').val(doc_id);
    })

    $('#delete_admission_application').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)

        var doc_id = button.data('id');
        var modal = $(this);
        modal.find('input[name=application_id]').val(doc_id);
    })
</script>

@endpush