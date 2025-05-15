<div class="card" id="documentCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Application assessments</h4>
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
                    @if(count($data['basic_info']->application_assessments))
                    @foreach($data['basic_info']->application_assessments as $index=>$immapp)
                    <tr>
                        <td> {{ $index+1 }} </td>
                        <td>{{$immapp->created_at->format(config('constant.date_format'))}}</td>
                        <td>{{$immapp->name}}</td>
                        <td> {{ ucfirst($immapp->type) }} </td>
                        <td> <form action="{{route('application_assessment.toggle',$immapp->id)}}" method="post">
                            @csrf
                            <button class="btn-sm {{$immapp->status_class}}">{{ $immapp->status}}</button>
                        </form> </td>
                        <td>
                            <form action="{{ route('application_assessment.destroy',$immapp->id)}}" method="POST">
                                @csrf
                                @method("DELETE")
                                <a href="{{ route('financial_assessment.show',$immapp->id)}}" class="btn btn-success btn-sm"><i class="fa fa-dollar-sign"></i></a>

                                <a href="{{ route('application_assessment.show',$immapp->id)}}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>

                                <a href="{{ route('application_assessment.edit',$immapp->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                                <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-trash"></i></a>
                            </form>

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
        <a href="{{ route('application_assessment.create',$data['basic_info']->id) }}" class="btn btn-sm btn-primary" id="addBtnImmigrationApplication">
            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> IA</span>
            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Application Assessment </span>
        </a>
    </div>
</div>


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


<div class="modal" id="delete_application_assessment">
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
                    <h3>Are you sure you want to delete this application assessment? This can't be undone.</h3>

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
    $('#delete_application_assessment').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)

        var doc_id = button.data('id');
        var modal = $(this);
        modal.find('input[name=application_id]').val(doc_id);
    })
</script>

@endpush