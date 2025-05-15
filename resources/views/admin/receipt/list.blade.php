<!-- Passport Details -->
<div class="card" id="documentCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Receipts</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-border table-striped" id="documentTable">
                <thead>
                    <th>Receipt No.</th>
                    <th>Client's Name</th>
                    <th>Invoice No</th>
                    <th>Actions</th>
                </thead>
                <tbody class="document_details">
                    @if(count($data['basic_info']->receipts))
                    @foreach($data['basic_info']->receipts as $index=>$receipt)
                    <tr>
                        <td> {{ $receipt->receipt_no }} </td>
                        <td> {{ $receipt->client_name }} </td>
                        <td> {{ $receipt->invoice->invoice_no }} </td>
                        <td>
                            <a href="{{ route('finance.receipt.show',['from_client'=>$data['basic_info']->id,'receipt'=>$receipt->id])}}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('finance.receipt.edit',['from_client'=>$data['basic_info']->id,'receipt'=>$receipt->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> 
                            <a href="#deleteReceipt" data-id="{{$receipt->id}}" data-toggle='modal' class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a> </td>

                        <td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('finance.receipt.create',['from_client'=>$data['basic_info']->id]) }}" class="btn btn-sm btn-primary">
            <span class="d-sm-block d-md-none"> <i class="fas fa-plus"></i> IA</span>
            <span class="d-none d-md-block d-lg-block"> <i class="fas fa-plus"></i> Receipt </span>
        </a>
    </div>
</div>


<div id="deleteReceipt" class='modal fade'>
  <div class="modal-dialog modal-confirm">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title w-100">Are you sure?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <form action="{{route('finance.receipt.destroy',"_")}}" method="POST">
        @csrf
        @method("DELETE")
        <div class="modal-body">
          <input id="data_id" name="id" type="hidden">

          <p>Do you really want to delete this document? This process cannot be undone.</p>

        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <input type="submit" class="btn btn-danger" value="Delete">
        </div>
      </form>
    </div>
  </div>
</div>


@push('scripts')
<script>
  $("#deleteReceipt").on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)

    var doc_id = button.data('id')
    var modal = $(this)

    modal.find('.modal-body #data_id').val(doc_id);
  });
</script>

@endpush