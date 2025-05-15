Dear {{$data['invoice']->client_name}},
<br>
<br>
<p>
    Thank you for choosing {{$data['company_info']->name}}.
    <br>
    Please find your invoice attached, you can pay through either a bank transfer or
    online banking. <br>Please note we do not accept payments over the phone.
    As payment reference please input our invoice number <b>{{$data['invoice']->invoice_no}}</b>.

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