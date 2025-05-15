Dear {{$data['employee_name']}},
<br>
<p>Please find the attached employment immigration confirmation letter.</p>

<p>If you have a confusion or have a question about the attached documents or spot an error, please contact your supervisor directly. <br>
</p>
<br>
Yours sincerely,<br><br>
<p>
    Admin Department<br>
    {{$data['company_info']->name}}<br>
    {{$data['company_info']->address}}
    <br>
    T: {{$data['company_info']->telephone}}
    <br>
    E: {{$data['company_info']->email}}
    <br>
    W: {{$data['company_info']->website}}
</p>
<br>
{{$data['company_info']->footnote}}