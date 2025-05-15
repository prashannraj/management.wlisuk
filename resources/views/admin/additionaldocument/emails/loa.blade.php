Dear {{$data['client_name']}},
<br>
<p>Please find attached a document(s) which needs a signature and date from the relevant person as outlined. </p>
<p>Instruction:</p>
<p>
    1. Person named on the document to sign and date the relevant form(s) attached.
</p>
<p>If you have a confusion or have a question about the attached documents or spot an error, please contact your advisor/caseworker direct. <br>
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