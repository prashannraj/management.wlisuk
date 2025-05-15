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
          href="{{ route('client.show',request()->from_client) }}"
          @else
          href="{{ route('old.generalinvoice.index') }}"
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
            </tr>
        </thead>
        <tbody>
            @php 
                $invtotal = 0;
            @endphp
            @foreach($data['invoice_items'] as $index=>$invoice_item)
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
              

            </tr>
            @endforeach

        </tbody>
        <tfoot>
        <tr>
                <td>Grand Total: </td>
                <td>{{$invtotal}} </td>
            </tr>
            
          
        </tfoot>
    </table>
</div>

<!-- Receipt Items -->




<h2>Print Preview</h2>
@include("old.immigrationinvoice.pdf")



<div class="bg-white border mt-4 mb-4">
    <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" id="print_btn" class="btn btn-primary print mx-1" data-print="pdf_view"><i class='fa fa-print'></i> Print</button>
       
        <button type="button" data-toggle="modal" data-target="#sendEmail" class="btn btn-warning mx-1"><i class='fa fa-envelope'></i> Send Email</button>
    </div>
</div>



<div class="modal fade" id="sendEmail">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="{{route('old.generalinvoice.sendemail',$data['invoice']->id)}}" enctype="multipart/form-data" method='post'>

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