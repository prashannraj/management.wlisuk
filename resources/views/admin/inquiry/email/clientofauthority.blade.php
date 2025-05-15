<p>Dear {{$data['enquiry']->title}}. {{$data['enquiry']->full_name}},</p>
<br>
<p>
    Thank you for providing us with your information. To proceed with your instructions, we kindly request you to sign and return the attached Letter of Authority.
</p>
<p>
    If you have any concerns or face any difficulties, please do not hesitate to contact your advisor,
    ({{$data['advisor']->name}}), directly on {{$data['advisor']->contact}} or via email at {{$data['advisor']->email}}.
</p>

<p> We look forward to receiving the signed document from you soon.
</p>
<br><br>

With Regards,<br>

{{$data['advisor']->name}}<br>
{{$data['company_info']->name}}<br>
{{$data['company_info']->address}}
<br>

<br>
{{$data['company_info']->footnote}}
