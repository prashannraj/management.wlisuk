Dear {{$data['row']->employee->full_name}},
<br>
<br>
<p>
    <br>
    Please find your payslip for {{$data['row']->month_string . " ".$data['row']->year}} attached to this email. 
    <br>
    If you have any queries regarding the attached payslip, please contact us by replying to the accounts department.
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