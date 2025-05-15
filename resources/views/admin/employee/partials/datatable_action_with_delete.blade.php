



    <form action="{{route('employee.destroy',$row->id)}}" class="form-inline mx-2" method="post">
        @csrf
        @method('delete')
        <a href="{{route('employee.restore',$row->id)}}" class="btn-sm btn-info mx-2">Restore</a>


        <button class="btn-sm btn-warning" name='action' value="delete-permanently" onclick="return confirm('Are you sure? This will wipe out every data.')">Del permanently</button>

    </form>



