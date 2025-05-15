<!-- Passport Details -->
<div class="card" id="documentCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Documents</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-border table-striped" id="documentTable">
                <thead>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Note</th>
                    <th>Document</th>
                    <th>Actions</th>
                </thead>
                <tbody class="document_details">
                    @if(count($data['basic_info']->documents))
                    @foreach($data['basic_info']->documents as $index=>$doc)
                    <tr>
                        <td> {{ $index+1 }} </td>
                        <td> {{ $doc->name }} </td>
                        <td> {{ $doc->note }} </td>
                        <td>
                            @if($doc->documents)
                            <a href="{{ $doc->file_url }}" class="form-control" style="border: 0;">
                                <i class="{{ $doc->file_type }} fa-2x"></i>
                            </a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('client.edit.document',$doc->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                            <form class='d-inline-block' action="{{ route('client.delete.document',$doc->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>

                            </form>
                        </td>
                        <td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('client.add.document',$data['basic_info']->id) }}" class="btn btn-sm btn-primary" id="addBtnDocument">
            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> D</span>
            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Document Detail </span>
        </a>

        <form action="{{route('client.store.documents')}}" enctype="multipart/form-data" method="POST">
            @csrf
            <input type="hidden" name="basic_info_id" value="{{$data['basic_info']->id}}">
            <div class="form-group mt-4">
                <label for="">Multiple documents uploader</label>
                <input type="file" name="documents[]" multiple class="form-control file-control">
            </div>
            {!! isError($errors,'documents') !!}
            @if($errors->any())

                <span class="text-danger mt-1">Invalid document type. Try again!!</span><br>

            @endif
            <button class='btn btn-sm btn-primary'>Submit</button>
        </form>
    </div>
</div>






<div class="card" id="documentCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Immigration application process documents</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-border table-striped" id="documentTable">
                <thead>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Actions</th>
                </thead>
                <tbody class="document_details">
                    @if(count($data['immigration_documents']))
                    @foreach($data['immigration_documents'] as $index=>$doc)
                    <tr>
                        <td> {{ $index+1 }} </td>
                        <td>
                            {{$doc->applicationStatus->title}}
                        </td>
                        <td>

                            <a href="{{ $doc->file_url }}" class="btn btn-sm btn-warning" target="_blank" style="border: 0;">
                                <i class="fa fa-eye"></i>
                            </a>

                        </td>


                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>