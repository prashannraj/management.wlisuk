{{-- <a href="{{route('rawenquiry.toggle',$row->id)}}" class="btn btn-sm {{$row->active?'btn-info':'btn-danger'}}">
	<u>{{$row->active?"Active":"Inactive"}}</u></a>
<a href='{{route("rawenquiry.show",$row->id)}}' class='btn btn-sm btn-primary'><i class='fa fa-eye'></i></a>
<a href='{{route("rawenquiry.edit",$row->id)}}' class='btn btn-sm btn-info'><i class='fa fa-edit'></i></a>
<a class='btn btn-sm btn-info' href='{{route("rawenquiry.process",$row->id)}}'><i class='fa fa-cog'></i></a>

<form action="{{route('rawenquiry.destroy',$row->id)}}" style='display:inline' method="POST">
    @csrf @method('delete')
    <button class='btn btn-sm btn-danger' type="submit"><i class='fa fa-trash'></i></button>
</form> --}}

<style>
    .modal-sm {
    max-width: 300px;
}

/* Adjust the padding and margin of the modal body */
.modal-body {
    padding: 15px;
    margin: 10px;

}
</style>

<a href="{{route('rawenquiry.toggle',$row->id)}}" class="btn btn-sm {{$row->active?'btn-info':'btn-danger'}}">
    <u>{{$row->active?"Active":"Inactive"}}</u></a>
<a href='{{route("rawenquiry.show",$row->id)}}' class='btn btn-sm btn-primary'><i class='fa fa-eye'></i></a>
<a href='{{route("rawenquiry.edit",$row->id)}}' class='btn btn-sm btn-info'><i class='fa fa-edit'></i></a>
<a class='btn btn-sm btn-info' data-toggle="modal" data-target="#note-modal-{{$row->id}}" data-backdrop="false"><i class='fa fa-cog'></i></a>

<!-- Modal for note -->
<div class="modal fade" id="note-modal-{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Instruction/ discussion:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('rawenquiry.add-note', $row->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="note">Instruction/ discussion:</label>
                        <textarea class="form-control" id="note" name="note">{{ $row->additional_details }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="process">Process:</label>
                        <input type="checkbox" id="process" name="process">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<form action="{{route('rawenquiry.destroy',$row->id)}}" style='display:inline' method="POST">
    @csrf @method('delete')
    <button class='btn btn-sm btn-danger' type="submit"><i class='fa fa-trash'></i></button>
</form>
