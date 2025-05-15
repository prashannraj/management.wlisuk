@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

@endpush


<div class="col-lg-12">
    <div class="card-wrapper">
        <!-- Form controls -->
        <div class="card">
            <!-- Card body -->
            <div class="card-body">

                <div class='row'>


					
                    @if(request()->from_client)
                        <input type="hidden" name="from_client" value="{{request()->from_client}}">
                    @endif

                    

                   

                    <input type="text" class='d-none' id='invoice_id' name="invoice_id" value="{{old('invoice_id',optional($data['receipt'])->invoice_id)}}">


                    <div class='col-md-8'>
                        <div class="form-group row">
                            <label class="col-4 col-form-label form-control-label" for="mobile">Search Existing Invoice </label>
                            <div class="col-8">
                                <input placeholder="Type here to quickly fill up client details and invoice details" class='form-control invoiceautocomplete' value="" id="">


                                {!! isError($errors, 'invoice_id') !!}
                            </div>
                        </div>
                        <p id="text_linked" class='text-warning' style="display:none">
                        </p>
                        <button style="display:none" class='btn btn-sm btn-danger' id="btn_unlink">Unlink</button>

                    </div>



                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="date">
                                Date: </label>
                            <div class="col-9">
                                <input autocomplete="off" type="text" class="form-control datepicker" value="{{old('date',optional($data['receipt'])->date ?? date('d/m/Y') )}}" name="date" id="date" required placeholder="Date">
                                {!! isError($errors, 'date') !!}
                            </div>

                        </div>
                    </div>


                  


                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="mobile">Currency </label>
                            <div class="col-9">
                               <input type="text" class="form-control" disabled id="currency_id" value="">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group row">
                        <label class="col-3 col-form-label form-control-label" for="mobile">Amount Received </label>
                            <div class="col-9">
                                <input name="amount_received" class='form-control' value="{{old('amount_received',optional($data['receipt'])->amount_received)}}" id="">
                                   

                                {!! isError($errors, 'amount_received') !!}
                            </div>
                        </div>
                    </div>




                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="remarks">
                                Remarks: </label>
                            <div class="col-9">
                                <textarea autocomplete="off" type="text" class="form-control" name="remarks" id="remarks" placeholder="remarks">{{ old('remarks',optional($data['receipt'])->remarks ?? "Payment Received. Thank you") }}</textarea>
                                {!! isError($errors, 'remarks') !!}
                            </div>

                        </div>
                    </div>




                </div>




            </div>
        </div>
    </div>


</div>



@push('scripts')
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>

<script type="text/javascript">
    $('.datepicker').datepicker({
        format: "{{ config('constant.date_format_javascript') }}",
    });

    $('.invoiceautocomplete').autoComplete({
        minLength: 1,
        resolverSettings: {
            url: '{{url("/ajax/invoices")}}'
        },
        events: {
            searchPost: function(data) {
                var da = [];
                data.map(function(e) {
                    da.push({
                        id: e.id,
                        value: e.id,
                        text: e.invoice_no,
                        address: e.address,
                        client_name: e.client_name,
                        currency:e.currency.title,
                        total : e.total
                    });
                })
                return da;
            }
        },

    });



    $('.invoiceautocomplete').on('autocomplete.select', function(evt, item) {
        $("#invoice_id").val(item.id);
        $("#invoice_total").html(item.total);

        var url = "{{route('finance.invoice.show','%%')}}";
        url = url.replace("%%", item.id);
        var p = `This receipt is currently linked to the invoice. <a target="_blank" href="${url}">${item.text}</a>.`;
       
        $("#currency_id").val(item.currency);

        $("#text_linked").html(p);
        $("#text_linked").fadeIn();
        $("#btn_unlink").fadeIn();
    })

    $("#btn_unlink").on('click', function(e) {
        e.preventDefault();
        $("#invoice_id").val("");
        $("#currency_id").val("");
        $("#invoice_total").html("");
        $("#text_linked").html("");
        $("#text_linked").fadeOut();
        $("#btn_unlink").fadeOut();


    });

    @if(optional($data['receipt'])->invoice != null)
    var item={
        id: {{$data['receipt']->invoice->id}},
        value: {{$data['receipt']->invoice->id}},
        text: "{{$data['receipt']->invoice->invoice_no}}",
        address: "{{$data['receipt']->address}}",
        client_name:"{{$data['receipt']->client_name}}",
        currency:"{{$data['receipt']->invoice->currency->title}}",
        total:"{{$data['receipt']->invoice->total}}",
    };

        $("#invoice_id").val(item.id);
        $("#address").val(item.address);
        $("#client_name").val(item.text);
        $("#currency_id").val(item.currency);
        $("#invoice_total").html(item.total);


        var url = "{{route('client.show','%%')}}";
        url = url.replace("%%", item.id);
        var p = `This receipt is currently linked to the invoice. <a target="_blank" href="${url}">${item.text}</a>.`;
        $("#text_linked").html(p);
        $("#text_linked").fadeIn();
        $("#btn_unlink").fadeIn();

    @endif
</script>


@endpush