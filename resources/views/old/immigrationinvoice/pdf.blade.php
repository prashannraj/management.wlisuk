<div class="" id="pdf_view">


    <table class='classic-table'>
        <tbody>
            <tr>
                <td>
                    <table>
                        <tbody>
                            <tr>

                                <td>
                                    @if(isset($export) && $export)
                                    <img src="{{public_path($data['company_info']->logourl)}}" alt="">

                                    @else
                                    <img src="{{url($data['company_info']->logourl)}}" alt="">

                                    @endif
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </td>
                <td class='float-right'>
                    <table>
                        <tbody>
                            <tr>
                                <td colspan="2"><b>{{$data['company_info']->name}}</b></td>
                            </tr>
                            <tr>
                                <td colspan="2">{{$data['company_info']->address}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">T: {{$data['company_info']->telephone}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">E: {{$data['company_info']->email}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">W: {{$data['company_info']->website}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table class='classic-table' style="margin-top: 20px;margin-bottom: 20px;">
        <tbody>
            <tr>
                <td colspan="3" style="margin-top:10px;margin-bottom:10px">
                    <table>
                        <tbody>
                            <tr>
                                <td> {{$data['invoice']->client_name}}</td>
                            </tr>
                            <tr>
                                <td>{{$data['invoice']->address}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td class='float-right'>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <h2>{{$data['invoice']->invoice_no}}</h2>
                                </td>
                            </tr>
                            <tr>
                                <td><b>{{$data['invoice']->date}}</b></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Payment Due By:</b>
                                </td>
                                <td>
                                    {{$data['invoice']->payment_due_by ?? "On Application Date"}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table class='table-bordered' width="100%" style="">

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
            $total=0;
            @endphp
            @foreach($data['invoice_items'] as $index=>$invoice_item)
            @php
            $total += $invoice_item->sub_total;
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
            <td class='text-right pr-2' colspan="5"><b>Grand Total:</b></td>
            <td class='text-right pr-2'>
                {{$total}}
            </td>
        </tfoot>
    </table>

    <table class='classic-table' style="margin-top: 30px;margin-bottom: 20px;">
        <tbody>
            <tr>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <b>Payment Details</b>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{$data['invoice']->bank->title}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Name:</b>
                                </td>
                                <td>
                                    {{$data['invoice']->bank->account_name}}
                                </td>
                            </tr>
                            <tr>
                                <td><b>Account No:</b>

                                </td>
                                <td>
                                    {{$data['invoice']->bank->account_number}}
                                </td>
                            </tr>

                            <tr>
                                <td><b>Swift/BIC:</b>
                                </td>
                                <td> {{$data['invoice']->bank->swift_code_bic}}
                                </td>
                            </tr>

                            <tr>
                                <td><b>Branch Address:</b>
                                </td>
                                <td>
                                    {{$data['invoice']->bank->branch_address}}

                                </td>
                            </tr>
                            <tr>
                                <td><b>Payment Reference:</b>
                                </td>
                                <td> {{$data['invoice']->payment_reference}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td class='float-right'>
                    <table>
                        <tbody>
                            <tr>
                                <b>Other Information</b>

                            </tr>
                            <tr>
                                <td><b>Name:</b></td>
                                <td>West London Immigration Services</td>
                            </tr>
                            <tr>
                                <td><b>Sort Code:</b></td>
                                <td>
                                    {{$data['invoice']->bank->sort_code}}
                                </td>
                            </tr>

                            <tr>
                                <td><b>IBAN NO:</b></td>
                                <td>
                                    {{$data['invoice']->bank->iban}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

        </tbody>
    </table>
    <table class='classic-table'>
        <tbody>
            <tr>
                <td><b>Note:</b></td>
            </tr>
            <tr>
                <td>{{ $data['invoice']->remarks }}</td>
            </tr>
        </tbody>
    </table>
    
    <br><br>
    <table style="border:1px">
    	<tbody>
    		<tr>
    			<td width="100%">
    				{{$data['company_info']->name}}. Registered in {{$data['company_info']->registered_in}}, Company Registration No. {{$data['company_info']->registration_no}}
    			</td>
    		</tr>
    	</tbody>
    </table>

</div>




<style>
    .classic-table {
        width: 100%;
        color: #000;
    }

    th,
    tr {
        color: #000;
    }

    .table-bordered td {
        border-color: #000;
    }

    .table-bordered th {
        border-color: #000;
    }
</style>

@push('scripts')
<script>

</script>

@endpush