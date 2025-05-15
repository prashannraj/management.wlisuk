<p>Dear {{$data['enquiry']->title}}. {{$data['enquiry']->full_name}},</p>
<p>
    Please find attached a File Opening Form which needs a signature and date from {{$data['fileopeningform']->client_name}}.

</p>
<p>Instruction:</p>
<ol>
    <li>{{$data['fileopeningform']->client_name}} to sign and date the signature field at the bottom of the document attached.</li>
</ol>
<p>
    If you have a confusion or have a question about the attached documents or spot an error, please contact your advisor/caseworker {{$data['advisor']->name}} at {{$data['advisor']->email}}.

</p>
<br><br>

Kind regards,<br>
{{$data['advisor']->name}}<br>
{{$data['company_info']->name}}<br>
{{$data['company_info']->address}}
<br>
Tel: {{$data['company_info']->telephone}}
<br>

Mob/WhatsApp/Viber: {{$data['advisor']->contact}}
<br>

Email: {{$data['advisor']->email}}
<br>

<br>
{{$data['company_info']->footnote}}
