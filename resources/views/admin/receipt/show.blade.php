@extends("layouts.master")
@section('header')

<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Receipt Detail</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                <a 
          @if(request()->from_client )
          href="{{ route('client.show',['id'=>request()->from_client,'click'=>'finances']) }}"
          @elseif(request()->from_invoice )
          href="{{ route('finance.invoice.show',request()->from_invoice) }}"
          @else
          href="{{ route('finance.receipt.index') }}"
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






<h2>Print Preview</h2>
@include("admin.receipt.pdf")



<div class="bg-white border mt-4 mb-4">
    <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" id="print_btn" class="btn btn-primary print mx-1" data-print="pdf_view"><i class='fa fa-print'></i> Print</button>
        @if($data['receipt']->client !=null)
        <a type="button" href="{{route('finance.receipt.generate',$data['receipt']->id)}}" class="btn btn-primary mx-1"><i class='fa fa-download'></i> Download Document</a>
        @endif
        <button type="button" data-toggle="modal" data-target="#sendEmail" class="btn btn-warning mx-1"><i class='fa fa-envelope'></i> Send Email</button>
    </div>
</div>



<div class="modal fade" id="sendEmail">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="{{route('finance.receipt.sendemail',$data['receipt']->id)}}" enctype="multipart/form-data" method='post'>

            <div class="modal-header">
                <div class="modal-title">
                    <h1> Add attachments
                    </h1>
                </div>


            </div>
            <div class="modal-body">
                    @csrf
                    <input type="hidden" name="receipt_id" value="{{$data['receipt']->id}}">
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