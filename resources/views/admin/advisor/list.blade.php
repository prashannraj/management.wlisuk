<!-- Passport Details -->
<div class="card" id="documentCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Advisors</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-border table-striped" id="documentTable">
                <thead>
                    <th>S/N</th>
                    <th>Full Name</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Actions</th>
                </thead>
                <tbody class="document_details">
                    @if($advisors->count()>0 )
                    @foreach($advisors as $index=>$advisor)
                    <tr>
                        <td> {{ $index+1 }} </td>
                        <td> {{ $advisor->name }} </td>
                        <td> {{ $advisor->level }} </td>
                        <td> {{ ucfirst($advisor->status) }} </td>

                        <td>
                            <a href="{{ route('advisor.show',$advisor->id)}}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('advisor.edit',['advisor'=>$advisor->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>

                            <form style="display:inline-block" action="{{route('advisor.destroy',$advisor->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('advisor.create') }}" class="btn btn-sm btn-primary">
            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> IA</span>
            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Advisor </span>
        </a>
        <a href="{{ route('cpds.index') }}" class="btn btn-sm btn-primary">
            Advisor CPDs
        </a>
    </div>
</div>