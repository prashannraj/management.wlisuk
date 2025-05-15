<!-- Passport Details -->
<div class="card" id="contactDetailsCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Passport Details</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-border table-striped" id="contactDetailTable">
                <thead>
                    <th>SN</th>
                    <th>Issuing Country</th>
                    <th>Passport Number</th>
                    <!-- <th>Birth Place</th>   -->
                    <!-- <th>Issuing Author</th>   -->
                    <!-- <th>citizenship_number</th>   -->
                    <!-- <th>Issue Date</th>   -->
                    <th>Expiry Date</th>
                    <th>Actions</th>
                </thead>
                <tbody class="passport_contact_details">
                    @if(count($data['basic_info']->passport))
                    @foreach($data['basic_info']->passport as $key => $passport)
                    <tr>
                        <td @if ($key===0) @endif>
                            {{ $key+1 }}
                        </td>
                        <td> {{ ($passport->country)? ucfirst(strtolower($passport->country->title)) : '' }} </td>
                        <td> {{ $passport->passport_number }} </td>
                        <td> {{ $passport->expiry_date }} </td>
                        <td>
                            <a href="{{ route('client.show.passport',$passport->id)}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('client.edit.passport',$passport->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                            <a href="#delete_passport" data-toggle="modal" data-id="{{$passport->id}}" class="btn btn-sm btn-danger">
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
        <a href="{{ route('client.add.passport',$data['basic_info']->id) }}" class="btn btn-sm btn-primary" id="addBtnPassportDetail">
            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> C</span>
            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Passport Detail </span>
        </a>
    </div>
</div>

<div class="modal" id="delete_passport">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('passportdetail.destroy','_')}}" method="POST">
                @method('delete')
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Delete passport</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <input type="hidden" name="passport_id" value="">
                <!-- Modal body -->
                <div class="modal-body">
                    <h3>Are you sure you want to delete this current passport? This can't be undone.</h3>

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
    $('#delete_passport').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)

        var doc_id = button.data('id');
        var modal = $(this);
        modal.find('input[name=passport_id]').val(doc_id);
    })
</script>

@endpush