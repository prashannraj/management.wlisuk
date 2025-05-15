Dear {{$data['row']->employee->full_name}},
<br>
<br>
<p>
    <br>
    We thank you for your valuable service provided to {{$data['company_info']->name}}.
    <br>
    On behalf of {{$data['company_info']->name}} we wish you a bright future and success on your future endeavour.
    <br>
    Please find your P45 attached to this email.
    <br>
    If you have any queries regarding the attached document, please contact us by replying to the
accounts department.
</p>
<br><br>

Regards,<br><br><br>
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