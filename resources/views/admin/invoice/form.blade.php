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


                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="mobile">Invoice type </label>
                            <div class="col-9">
                                <select name="invoice_type_id" class='form-control' value="{{old('invoice_type_id',optional($data['invoice'])->invoice_type_id)}}">
                                    <option value="">Select the invoice type</option>
                                    @foreach($data['invoicetypes'] as $currency)

                                    <option {{old('invoice_type_id',optional($data['invoice'])->invoice_type_id) == $currency->id?"selected":"" }} value="{{$currency->id}}">{{$currency->title}}</option>

                                    @endforeach
                                </select>

                                {!! isError($errors, 'invoice_type_id') !!}
                            </div>
                        </div>
                    </div>


                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="email">Invoice No: </label>
                            <div class="col-9">
                                <input autocomplete="off" type="text" disabled class='form-control' value="{{optional($data['invoice'])->id ?? $data['next_id']}}">
                            </div>
                        </div>
                    </div>



                    <input type="text" class='d-none' id='basic_info_id' id="basic_info_id" name="basic_info_id" value="{{old('basic_info_id',optional($data['invoice'])->basic_info_id)}}">


                    @if( $data['fromClient']==null)
                    <div class='col-md-8'>
                        <div class="form-group row">
                            <label class="col-4 col-form-label form-control-label" for="mobile">Search Existing Client </label>
                            <div class="col-8">
                                <input placeholder="Type here to quickly fill up client details" class='form-control clientautocomplete' value="">


                                {!! isError($errors, '') !!}
                            </div>
                        </div>
                        <p id="text_linked" class='text-warning' style="display:none">
                        </p>
                        <button style="display:none" class='btn btn-sm btn-danger' id="btn_unlink">Unlink</button>


                    </div>
                    @endif



                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="surname">
                                Client Name: </label>
                            <div class="col-9">
                                <input id="client_name" type="text" class="form-control" name="client_name" placeholder="Name" value="{{ old('client_name',optional($data['invoice'])->client_name) }}">
                                {!! isError($errors, 'client_name') !!}
                            </div>

                        </div>
                    </div>

                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="address">
                                Address: </label>
                            <select name="" data-toggle="populate" data-target="#address" id="select_address" class="form-control mb-2">
                                <option value="">Select an option</option>
                                <option value="">Manually enter address</option>
                                @if($data['fromClient'])
                                @foreach($data['fromClient']->addresses as $address)
                                    <option value="{{$address->full_address}}">{{$address->full_address}}</option>
                                @endforeach
                                @endif
                            </select>
                            <div class="col-9">
                                <input autocomplete="off" type="text" class="form-control" name="address" id="address" required placeholder="Address" value="{{ old('address',optional($data['invoice'])->address) }}">
                                {!! isError($errors, 'address') !!}
                            </div>

                        </div>
                    </div>


                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="mobile">Bank </label>
                            <div class="col-9">
                                <select name="bank_id" class='form-control' value="{{old('bank_id',optional($data['invoice'])->bank_id)}}">
                                    <option value="">Select the bank type</option>
                                    @foreach($data['banks'] as $bank)
                                    <option {{old('bank_id',optional($data['invoice'])->bank_id) == $bank->id ? "selected":''}} value="{{$bank->id}}">{{$bank->title}}</option>

                                    @endforeach
                                </select>

                                {!! isError($errors, 'bank_id') !!}
                            </div>
                        </div>
                    </div>





                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="date">
                                Date: </label>
                            <div class="col-9">
                                <input autocomplete="off" type="text" class="form-control datepicker" value="{{old('date',optional($data['invoice'])->date ?? date('d/m/Y') )}}" name="date" id="date" required placeholder="Date">
                                {!! isError($errors, 'date') !!}
                            </div>

                        </div>
                    </div>



                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="payment_due_by">
                                Payment Due By: </label>
                            <div class="col-9">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input on_application_check" {{optional($data['invoice'])->payment_due_by==null?"checked":""}} value="on">On Application Date
                                    </label>
                                </div>
                                <input autocomplete="off" type="text" class="form-control datepicker due-date" value="{{old('payment_due_by',optional($data['invoice'])->payment_due_by ?? date('d/m/Y') )}}" name="payment_due_by" placeholder="Payment due by">
                                {!! isError($errors, 'payment_due_by') !!}
                            </div>

                        </div>
                    </div>


                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="mobile">Currency </label>
                            <div class="col-9">
                                <select name="iso_currencylist_id" class='form-control' value="{{old('iso_currencylist_id',optional($data['invoice'])->iso_currencylist_id)}}">
                                    @foreach($data['currencies'] as $currency)

                                    <option {{old('iso_currencylist_id',optional($data['invoice'])->iso_currencylist_id) == $currency->id ?"selected":"" }} value="{{$currency->id}}">{{$currency->currency_name}} - {{$currency->title}}</option>

                                    @endforeach
                                </select>

                                {!! isError($errors, 'iso_currencylist_id') !!}
                            </div>
                        </div>
                    </div>




                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="remarks">
                                Remarks: </label>
                            <div class="col-9">
                                <textarea autocomplete="off" type="text" class="form-control" name="remarks" id="remarks" placeholder="remarks">{{ old('remarks',optional($data['invoice'])->remarks) }}</textarea>
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

    $('.clientautocomplete').autoComplete({
        resolverSettings: {
            url: '{{url("/ajax/clients")}}'
        },
        events: {
            searchPost: function(data) {
                var da = [];
                data.map(function(e) {
                    da.push({
                        id: e.id,
                        value: e.id,
                        text: e.full_name,
                        address: e.address,
                        addresses :e.addresses
                    });
                })
                return da;
            }
        },

    });

    function populateAddresses(data){
        var p = $("#select_address");
        var default_val = "<option value=''>Select an option</option><option value=''>Enter address manually</option>";
        data.map(function(e){
            default_val += `"<option value='${e.full_address}'>${e.full_address}</option>"`;
        });
        p.html(default_val);
    }



    $('.clientautocomplete').on('autocomplete.select', function(evt, item) {
        $("#basic_info_id").val(item.id);
        $("#address").val(item.address);
        $("#client_name").val(item.text);
        var url = "{{route('client.show','%%')}}";
        url = url.replace("%%", item.id);
        var p = `This invoice is currently linked to the client. <a target="_blank" href="${url}">${item.text}</a>.`;
        $("#text_linked").html(p);
        $("#text_linked").fadeIn();
        $("#btn_unlink").fadeIn();

        populateAddresses(item.addresses);
    })

    $("#btn_unlink").on('click', function(e) {
        e.preventDefault();
        $("#basic_info_id").val("");
        $("#text_linked").html("");
        $("#text_linked").fadeOut();
        $("#btn_unlink").fadeOut();


    });

    @if(optional($data['invoice'])-> client != null)
    var item = {
        id: "{{$data['invoice']->client->id}}",
        value: "{{$data['invoice']->client->id }}",
        text: "{{$data['invoice']->client_name}}",
        address: "{{$data['invoice']->address}}",
        client_name: "{{$data['invoice']->client_name}}"
    };

    $("#basic_info_id").val(item.id);
    $("#address").val(item.address);
    $("#client_name").val(item.text);
    var url = "{{route('client.show','%%')}}";
    url = url.replace("%%", item.id);
    var p = `This invoice is currently linked to the client. <a target="_blank" href="${url}">${item.client_name}</a>.`;
    $("#text_linked").html(p);
    $("#text_linked").fadeIn();
    $("#btn_unlink").fadeIn();

    @endif

    var currentDate = "{{$data['invoice']->payment_due_by ?? date('d/m/Y')}}";

    $(".on_application_check").on('change', function(e) {
        if ($(this).prop('checked')) {
            $('.due-date').val(null);
            $('.due-date').fadeOut();
        } else {
            $('.due-date').val(currentDate);

            $('.due-date').fadeIn();
        }
    })


    $(".on_application_check").trigger('change');



</script>
<script>
    $("select[data-toggle='populate']").on('change', function(e, value) {
        var selector = $(this).data("target");
        $(selector).val($(this).val());
    })
</script>

@endpush