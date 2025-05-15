<!-- Passport Details -->
<div class="card" id="visaDetailCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">UK Visa Detail</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-border table-striped" id="ukVisaDetailTable">
                <thead>
                    <th>SN</th>
                    <th>Visa Type</th>
                    <th>Course Title</th>
                    <th>Course Start</th>
                    <th>Course End</th>
                    <th>Course Level</th>
                    <th>Visa valid From/Expiry</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </thead>
                <tbody class="visa_contact_details">
                    @if(count($data['basic_info']->ukvisa))
                    @foreach($data['basic_info']->ukvisa as $index=>$ukVisa)
                    <tr>
                        <td> {{ $index+1}} </td>
                        <td> {{ $ukVisa->visa_type }} </td>
                        <td> {{ $ukVisa->course_title }} </td>
                        <td> {{ $ukVisa->course_start_date }} </td>
                        <td> {{ $ukVisa->course_end_date }} </td>
                        <td> {{ $ukVisa->level_of_study }} </td>
                        <td> {{ $ukVisa->issue_date }} - {{ $ukVisa->expiry_date }} </td>
                        <td> {{ $ukVisa->level_of_study }} </td>
                        <td> <a href="{{ route('client.edit.ukvisa',$ukVisa->id)}}" class="btn btn-success btn-sm">
                        <i class="fa fa-edit"></i></a>
                        <a href="#delete_ukvisa" data-toggle="modal" data-id="{{$ukVisa->id}}" class="btn btn-sm btn-danger">
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
    <div class="card-footer">
        <a href="{{ route('client.add.ukvisa',$data['basic_info']->id) }}" class="btn btn-sm btn-primary" id="addBtnVisaDetail">
            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> C</span>
            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> UK Visa Detail </span>
        </a>
    </div>
</div>



<div class="modal" id="delete_ukvisa">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('ukvisa.destroy')}}" method="POST">
                @method('delete')
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Delete uk visa</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <input type="hidden" name="ukvisa_id" value="">
                <!-- Modal body -->
                <div class="modal-body">
                    <h3>Are you sure you want to delete this current uk visa? This can't be undone.</h3>

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

    $('#delete_ukvisa').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)

        var doc_id = button.data('id');
        var modal = $(this);
        modal.find('input[name=ukvisa_id]').val(doc_id);
    })
</script>

@endpush