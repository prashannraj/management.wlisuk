<a href="{{route('serviceprovider.show',$row->id)}}" class="btn btn-sm btn-primary">
<i class="fa fa-eye"></i>
</a>
<a href="{{route('serviceprovider.edit',$row->id)}}" class="btn btn-sm btn-info">
<i class="fa fa-edit"></i>
</a>
{{-- <a href="{{route('serviceprovider.toggle',$row->id)}}" class="btn btn-sm {{strtolower($row->status)=='active'?'btn-info':'btn-danger' }}">
{{ucfirst($row->status)}}
</a> --}}
<form action="{{route('serviceprovider.destroy',$row->id)}}" method="POST" class="form-inline d-inline-block">
    @csrf
    @method("delete")
<button class="btn btn-sm btn-warning"><i class="fa fa-trash"></i></button>
</form>
