
<form action="{{route('visa.destroy','_')}}" class='d-flex form-inline' method="POST">
    @method('delete')
    @csrf

    <a href="{{route('visa.restore',$row->id)}}" class="btn-sm btn-info mx-2">Restore</a>

    <input type="hidden" name="visa_id" value="{{$row->id}}">
    <input type="hidden" name="action" value="delete-permanently">
    <button class="btn btn-sm btn-warning" onclick="return confirm('Are you sure? This will wipe out every data.')" ><i class="fa fa-trash"></i></button>

</form>