<div class="d-flex">
   

    <a href="{{route('client.show',$row->id)}}" target="_blank" class="btn-sm btn-info mx-2"> <i class="fa fa-cog"></i> </a>
    <a href="{{route('client.restore',$row->id)}}" class="btn-sm btn-info mx-2">Restore</a>

    <form action="{{route('client.delete-permanently',$row->id)}}" class="form-inline mx-2" method="post">
        @csrf
        @method('delete')
        <button class="btn-sm btn-warning" onclick="return confirm('Are you sure? This will wipe out every data.')">Del permanently</button>
    </form>



</div>