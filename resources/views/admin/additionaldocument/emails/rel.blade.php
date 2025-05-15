Dear {{$data['client_name']}},
<br>
<p>Thank you for requesting a confirmation of representation. </p>
<p>Please find a attached document for your representation.</p>
<p>If you have any queries, please contact your advisor/caseworker directly. <br>
</p>
<br>
Yours sincerely,<br>
Application Administration<br>
{{$data['company_info']->name}}<br>
{{$data['company_info']->address}}
<br>
<p> T: {{$data['company_info']->telephone}}
    <br>
    E: {{$data['company_info']->email}}
    <br>
    W: {{$data['company_info']->website}}
   </p>
   <br>
{{$data['company_info']->footnote}}