@extends("layouts.master")
@section('header')

<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Invoice Detail</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                <a 
          @if(request()->from_client )
          href="{{ route('client.show',['id'=>request()->from_client,'click'=>'finances']) }}"
          @else
          href="{{ route('finance.invoice.index') }}"
          @endif
           class="btn btn-sm btn-neutral">
            <i class="fas fa-chevron-left"></i> Back To List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('main-content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<h2>Invoice Items</h2>

<div class="bg-white mt-4">
    <table class=' table table-striped' width="100%" style="">

        <thead>
            <tr>
                <th class='pl-2'>S/N</th>
                <th class='pl-2'>Quantity</th>
                <th class='text-center'>Detail</th>
                <th class='text-center'>Unit Price ({{optional($data['invoice']->currency)->title??"GBP"}})</th>
                <th class='text-center'>Vat (%)</th>
                <th class='text-right pr-2'>Net Subtotal ({{optional($data['invoice']->currency)->title??"GBP"}})</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $invtotal = 0;
            @endphp
            @foreach($data['invoice']->invoice_items as $index=>$invoice_item)
            @php 
                $invtotal += $invoice_item->sub_total;
            @endphp
            <tr>
                <td class='pl-2'>{{$index+1}}</td>

                <td class='pl-2'>{{$invoice_item->quantity}}</td>
                <td class='text-center'>{{$invoice_item->detail}}</td>
                <td class='text-center'>{{$invoice_item->unit_price}}</td>
                <td class='text-center'>{{$invoice_item->vat ?? 0}}</td>

                <td class='text-right pr-2'>{{$invoice_item->sub_total}}</td>
                <td>
                    <a href="#editModal" data-toggle="modal" data-id="{{$invoice_item->id}}" data-id="{{$invoice_item->id}}" data-detail="{{$invoice_item->detail}}" data-unit="{{$invoice_item->unit_price}}" data-vat="{{$invoice_item->vat}}" data-quantity="{{$invoice_item->quantity}}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                    <a href="#deleteModal" data-id="{{$invoice_item->id}}" data-toggle="modal" class="btn btn-sm btn-warning"><i class="fa fa-trash"></i></a>

                </td>

            </tr>
            @endforeach

        </tbody>
        <tfoot>
        <tr>
                <td>Grand Total: </td>
                <td>{{$invtotal}} </td>
            </tr>
            
            <tr>
                <td>
                    <a href="#addModal" data-toggle="modal" class="btn btn-primary">Add invoice item</a>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Receipt Items -->
<h2>Receipt Items</h2>

<div class="bg-white mt-4">
    <table class=' table table-striped' width="100%">

        <thead>
            <tr>
                <th class='pl-2'>S/N</th>
                <th class='pl-2'>Receipt no</th>
                <th>Date</th>
                <th class='text-center'>Amount Received ({{optional($data['invoice']->currency)->title??"GBP"}})</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $total = 0;
            @endphp
            @foreach($data['invoice']->receipts as $index=>$receipt)
            @php 
                $total += $receipt->amount_received;
            @endphp
            <tr>
                <td class='pl-2'>{{$index+1}}</td>

                <td class='pl-2'>{{$receipt->receipt_no}}</td>
                <td class='text-center'>{{$receipt->date}}</td>
                <td class='text-center'>{{$receipt->amount_received}}</td>
              
                <td>
               <a href="{{ route('finance.receipt.show',['from_invoice'=>$data['invoice']->id,'receipt'=>$receipt->id])}}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>

                <a href="{{route('finance.receipt.edit',['receipt'=>$receipt->id,'from_invoice'=>$data['invoice']->id])}}" data-date="{{$receipt->date}}" data-id="{{$receipt->id}}" data-amount_received="{{$receipt->amount_received}}" data-remarks="{{$receipt->remarks}}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>

                    <!-- <a href="#editReceipt" data-toggle="modal" data-date="{{$receipt->date}}" data-id="{{$receipt->id}}" data-amount_received="{{$receipt->amount_received}}" data-remarks="{{$receipt->remarks}}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a> -->
                    <a href="#deleteReceipt" data-id="{{$receipt->id}}"  data-toggle="modal" class="btn btn-sm btn-warning"><i class="fa fa-trash"></i></a>

                </td>

            </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <td>Grand Total: </td>
                <td>{{$total}} </td>
            </tr>
            
            <tr>
                <td>
                    <a  href="{{route('finance.receipt.create',['from_invoice'=>$data['invoice']->id])}}" class="btn btn-primary @if(($invtotal-$total) <= 0) disabled @endif">Add Receipt</a>
                </td>
            </tr>
        </tfoot>
    </table>
</div>





<h2>Print Preview</h2>
@include("admin.invoice.pdf")



<div class="bg-white border mt-4 mb-4">
    <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" id="print_btn" class="btn btn-primary print mx-1" data-print="pdf_view"><i class='fa fa-print'></i> Print</button>
        @if($data['invoice']->client !=null)
        <a type="button" href="{{route('finance.invoice.generate',$data['invoice']->id)}}" class="btn btn-primary mx-1"><i class='fa fa-download'></i> Download Document</a>
        @endif
        <button type="button" data-toggle="modal" data-target="#sendEmail" class="btn btn-warning mx-1"><i class='fa fa-envelope'></i> Send Email</button>
    </div>
</div>

<div id="addModal" class='modal fade'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    Add new Invoice Item
                </div>
            </div>
            <div class="modal-body">
                <form action="{{route('finance.invoiceitem.store')}}" class="form-horizontal" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="form-group row">
                        <label class="control-label col-4">Quantity :</label>
                        <div class="controls col-8"><input name="quantity" class="span20 form-control" maxlength="255" type="text" id="InvoiceItemQuantity"></div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-4">Details :</label>
                        <div class="controls col-8"><textarea name="detail" rows="2" class="span20 form-control" cols="30" id="InvoiceItemDetail"></textarea></div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-4">Unit Price ( ):</label>
                        <div class="controls col-8"><input name="unit_price" class="span20 form-control" step="any" type="number" id="InvoiceItemUnitPrice">Enter discounts and credits as negative.</div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-4">Vat (%):</label>
                        <div class="controls col-8"><input name="vat" class="span20 form-control" step="any" type="number" id="InvoiceItemVat"></div>
                    </div><input type="hidden" name="invoice_id" value="{{$data['invoice']->id}}" id="invoice_id">
                    <div class="submit"><input type="submit" class='btn btn-primary' value="Create Item"></div>
                </form>
            </div>
        </div>
    </div>
</div>




<div id="editModal" class='modal fade'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    Edit Invoice Item
                </div>
            </div>
            <div class="modal-body">
                <form action="{{route('finance.invoiceitem.update','_')}}" class="form-horizontal" method="post" accept-charset="utf-8">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        <label class="control-label col-4">Quantity :</label>
                        <div class="controls col-8"><input name="quantity" class="span20 form-control" maxlength="255" type="text" id="Quantity"></div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-4">Details :</label>
                        <div class="controls col-8"><textarea name="detail" rows="2" class="span20 form-control" cols="30" id="Detail"></textarea></div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-4">Unit Price ( ):</label>
                        <div class="controls col-8"><input name="unit_price" class="span20 form-control" step="any" type="number" id="UnitPrice">Enter discounts and credits as negative.</div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-4">Vat (%):</label>
                        <div class="controls col-8"><input name="vat" class="span20 form-control" step="any" type="number" id="Vat"></div>
                    </div><input type="hidden" name="invoice_item_id" value="" id="InvoiceId">
                    <div class="submit"><input type="submit" class='btn btn-primary' value="Update Item"></div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <form action="{{route('finance.invoiceitem.destroy','_')}}" method="post">
                {{method_field('delete')}}
                {{csrf_field()}}
                <div class="modal-body">
                    <p class="text-center">
                        Are you sure you want to delete this?
                    </p>
                    <input type="hidden" name="invoice_item_id" id="deleteId" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">No, Cancel</button>
                    <button type="submit" class="btn btn-success">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- receipt -->

<div id="editReceipt" class='modal fade'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    Edit Receipt
                </div>
            </div>
            <div class="modal-body">
                <form action="{{route('finance.receipt.updateFromInvoice','_')}}" class="form-horizontal" method="post" accept-charset="utf-8">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        <label class="control-label col-4">Amount Received:</label>
                        <div class="controls col-8"><input name="amount_received" class="span20 form-control" maxlength="255" type="text" id="receipt_amount_received"></div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-4">Remarks:</label>
                        <div class="controls col-8"><textarea name="remarks" rows="2" class="span20 form-control" cols="30" id="receipt_remarks"></textarea></div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-4">Date:</label>
                        <div class="col-8"><input name="date" autocomplete="off" type="text"  class="form-control " id="receipt_date"></div>
                    </div>
                    <input type="hidden" name="invoice_id" value="" id="receipt_invoice_id">
                    <input type="hidden" name="receipt_id" value="" id="receipt_receipt_id">

                    <div class="submit"><input type="submit" class='btn btn-primary' value="Update Receipt"></div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteReceipt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <form action="{{route('finance.receipt.destroy','_')}}" method="post">
                {{method_field('delete')}}
                {{csrf_field()}}
                <div class="modal-body">
                    <p class="text-center">
                        Are you sure you want to delete this?
                    </p>
                    <input type="hidden" name="id" id="deleteReceiptId" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">No, Cancel</button>
                    <button type="submit" class="btn btn-success">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="sendEmail">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="{{route('finance.invoice.sendemail',$data['invoice']->id)}}" enctype="multipart/form-data" method='post'>

            <div class="modal-header">
                <div class="modal-title">
                    <h1> Add attachments
                    </h1>
                </div>


            </div>
            <div class="modal-body">
                    @csrf
                    <input type="hidden" name="invoice_id" value="{{$data['invoice']->id}}">
                    <div class="attachment-list">
                        <input type="file" name='attachments[]' class="form-control">
                    </div>
                    <button class="btn-sm btn-primary" id="addField">
                        <i class="fa fa-plus"></i>
                    </button>


            </div>

            <div class="modal-footer">
                <button type="submit" class='btn btn-primary'>Submit</button>

            </div>
            </form>

        </div>
    </div>
</div>


@endsection


@push('scripts')

<script src="{{asset('assets/js/print.js')}}"></script>
<script>
    $("#editModal").on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);

        var id = button.data('id');
        var detail = button.data('detail');
        var unit = button.data('unit');
        var vat = button.data('vat');
        var qty = button.data('quantity');

        modal.find(".modal-body #Detail").val(detail);
        modal.find(".modal-body #Quantity").val(qty);
        modal.find(".modal-body #UnitPrice").val(unit);
        modal.find(".modal-body #Vat").val(vat);
        modal.find(".modal-body #InvoiceId").val(id);

    });


    $("#editReceipt").on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);

        var id = button.data('id');
        var amount_received = button.data('amount_received');
        var remarks = button.data('remarks');
        var dates = button.data('date');
        var invoice_id = button.data('invoice_id');

        modal.find(".modal-body #receipt_amount_received").val(amount_received);
        modal.find(".modal-body #receipt_remarks").val(remarks);
        modal.find(".modal-body #receipt_date").val(dates);
        modal.find(".modal-body #receipt_invoice_id").val(invoice_id);
        modal.find(".modal-body #receipt_receipt_id").val(id);

    });

    $("#deleteModal").on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var modal = $(this);

        var id = button.data('id');



        modal.find(".modal-body #deleteId").val(id);

    });

    //Print Command
    $(document).on('click', '.print', function() {
        var div = "#" + $(this).data("print");
        $(div).print();
    });

    function addField(e) {
        e.preventDefault();
        var field = '<input type="file" name="attachments[]" class="form-control">';
        $(".attachment-list").append(field);
    }

    $("#addField").on('click', addField);
</script>


@endpush