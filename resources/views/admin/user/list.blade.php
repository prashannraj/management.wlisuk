<!-- Passport Details -->
<div class="card" id="documentCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Users</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-border table-striped" id="documentTable">
                <thead>
                    <th>S/N</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </thead>
                <tbody class="document_details">
                    @if($users->count() > 0)
                    @foreach($users as $index=>$user)
                    <tr>
                        <td> {{ $index + 1 }} </td>
                        <td> {{ $user->username }} </td>
                        <td> {{ $user->email }} </td>

                        <td>
                            <a href="{{ route('user.show',$user->id)}}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('user.edit',['user'=>$user->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                        @if(auth()->user()->id != $user->id && auth()->user()->role_id == 1 )
                        <form style="display:inline-block" action="{{route('user.destroy',$user->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                        @endif

                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">
            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> IA</span>
            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> User </span>
        </a>
    </div>
</div>