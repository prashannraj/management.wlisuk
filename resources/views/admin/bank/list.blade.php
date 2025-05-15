<!-- Passport Details -->
<div class="card" id="documentCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Invoices</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-border table-striped" id="documentTable">
                <thead>
                    <th>Invoice No.</th>
                    <th>Client's Name</th>
                    <th>Type</th>
                    <th>Actions</th>
                </thead>
                <tbody class="document_details">
                    @if(count($data['basic_info']->invoices))
                    @foreach($data['basic_info']->invoices as $index=>$invoice)
                    <tr>
                        <td> {{ $invoice->invoice_no }} </td>
                        <td> {{ $invoice->client_name }} </td>
                        <td> {{ $invoice->invoice_type }} </td>
                        <td>
                            <a href="{{ route('finance.invoice.show',$invoice->id)}}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('finance.invoice.edit',['from_client'=>$data['basic_info']->id,'invoice'=>$invoice->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> </td>
                        <td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('finance.invoice.create',['from_client'=>$data['basic_info']->id]) }}" class="btn btn-sm btn-primary">
            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> IA</span>
            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Invoice </span>
        </a>
    </div>
</div>


<div class="modal" id="confirmModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add new application</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <h3>Please select the type of application to add</h3>
                <div>
                    <a class='btn btn-primary m-2' href="{{ route('client.add.application.immigration',$data['basic_info']->id) }}">Immigration application</a>
                    <a class='btn btn-primary m-2' href="{{ route('client.add.application.admission',$data['basic_info']->id) }}">Admission application</a>
                    <a class='btn btn-primary m-2' href="#">Other</a>


                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>