<!-- Passport Details -->
<div class="card" id="visaDetailCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">
            Current Visa Details
            <!-- <a href="{{ route('client.show', $data['basic_info']->id) }}" class="btn btn-sm btn-primary float-right"> Back</a> -->
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
                    @if(count($data['basic_info']->currentvisa))
                    @foreach($data['basic_info']->currentvisa as $index=>$visa)
                    <tr>
                        <td> {{ $index+1}} </td>
                        <td> {{ $visa->visa_type }} </td>
                        <td> {{ $visa->visa_number }} </td>

                        <td>
                            <a href="{{ route('visa.toggle',$visa->id)}}" class="btn btn-sm {{$visa->status=='Active'?'btn-info':'btn-danger'}} btn-sm">{{strtolower($visa->status)}}</a>

                            <a href="{{ route('client.show.visa',$visa->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('client.edit.visa',$visa->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a> 
                            <a href="#delete_visa" data-toggle="modal" data-id="{{$visa->id}}" class="btn btn-sm btn-danger">
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
        <a href="{{ route('client.add.visa',$data['basic_info']->id) }}" class="btn btn-sm btn-primary" id="addBtnVisaDetail">
            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> C</span>
            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Current Visa Detail </span>
        </a>
    </div>
</div>


<div class="modal" id="delete_visa">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('visa.destroy','_')}}" method="POST">
                @method('delete')
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Delete visa</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <input type="hidden" name="visa_id" value="">
                <!-- Modal body -->
                <div class="modal-body">
                    <h3>Are you sure you want to delete this current visa? This can't be undone.</h3>

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

    $('#delete_visa').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)

        var doc_id = button.data('id');
        var modal = $(this);
        modal.find('input[name=visa_id]').val(doc_id);
    })
</script>

@endpush