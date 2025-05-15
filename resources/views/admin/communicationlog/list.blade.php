<!-- Passport Details -->
<div class="card" id="communicationlogCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Communication Logs</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-border table-striped" id="communicationlogTable">
                <thead>
                    <th>SN</th>
                    @if(isset($indexpage) && $indexpage==true)
                    <th>Client Name</th>
                    @endif
                    <th>Subject</th>
                    <th>Date Sent</th>
                    <th>Actions</th>
                </thead>
                <tbody class="communicationlog_details">
                    @if(count($data['communicationlogs']))
                    @foreach($data['communicationlogs'] as $index=>$communicationlog)
                    <tr>
                        <td> {{ $index + 1}} </td>
                     @if(isset($indexpage) && $indexpage==true)
                    <td>
                    	{{$communicationlog->client_name}}
                    </td>
                    @endif
                        <td style="white-space: pre-wrap;"> {{ ucfirst($communicationlog->description) }} </td>
                        <td>{{$communicationlog->updated_at->format(config('constant.date_format'))}}</td>
                        <td>
                            <a 
                            @if(isset($data['basic_info']))
                            href="{{ route('communicationlog.show',['from_client'=>$data['basic_info']->id,'communicationlog'=>$communicationlog->id])}}"
                            @else
                            href="{{ route('communicationlog.show',['communicationlog'=>$communicationlog->id])}}"

                            @endif
                            class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                            <form class='d-inline-block' action="{{ route('communicationlog.destroy',$communicationlog->id)}}" method="post">
                                @csrf 
                                @method('delete')
                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>

                            </form>
                            <td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>


        </div>
    </div>
   
</div>



