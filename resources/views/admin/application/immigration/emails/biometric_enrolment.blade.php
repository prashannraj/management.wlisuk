Dear {{optional($data['application_process']->application->client)->full_name}},
    <br>
    <br>
Please find attached an update regarding your {{$data['application_process']->application->type()}} application.
    <br>
    <br>
If you have any queries, please contact your advisor/case worker directly.
<br>
<br>
Yours sincerely,<br><br>
Application Administration<br>
{{$data['companyinfo']->name}}<br>
{{$data['companyinfo']->address}}<br>
Tel: {{$data['companyinfo']->telephone}}<br>
Email: {{$data['companyinfo']->email}}<br>
<br>
<br>
<br>

{{$data['companyinfo']->footnote}}
