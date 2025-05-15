<a href="{{route('partner.show',$row->id)}}" class="btn btn-sm btn-primary">
<i class="fa fa-eye"></i>
</a>
<a href="{{route('partner.edit',$row->id)}}" class="btn btn-sm btn-info">
<i class="fa fa-edit"></i>
</a>
<a href="{{route('partner.toggle',$row->id)}}" class="btn btn-sm {{strtolower($row->status)=='active'?'btn-info':'btn-danger' }}">
{{ucfirst($row->status)}}
</a>
<form action="{{route('partner.destroy',$row->id)}}" method="POST" class="form-inline d-inline-block">
    @csrf 
    @method("delete")
<button class="btn btn-sm btn-warning"><i class="fa fa-trash"></i></button>
</form>