Dear {{$data['receipt']->invoice->client_name}},
<br>

<p>
Please find attached your payment receipt for Invoice # {{$data['receipt']->invoice->invoice_no}},
for {{$data['receipt']->currency->title}} {{$data['receipt']->amount_received}}.    
    <br>
    If you have any questions, please let us know.

</p>
<br><br>

Many thanks<br><br><br>
{{$data['company_info']->name}}<br>
{{$data['company_info']->address}}
<br>
T: {{$data['company_info']->telephone}}
<br>
<tr>
    E: {{$data['company_info']->email}}
    <br>
<tr>
    W: {{$data['company_info']->website}}
    <br>