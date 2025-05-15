<p>Dear {{$data['enquiry']->title}}. {{$data['enquiry']->full_name}},</p>
<br>
<p>
    Thank you for enquiring with {{$data['company_info']->name}}. Please find an attached a documentary requirement regarding your enquiry.
</p>
<p>
    If you have any concern or are in difficulty in gathering information or documentary evidence,
    please get in touch with your advisor ({{$data['advisor']->name}}) on {{$data['advisor']->contact}}
    directly or email to {{$data['advisor']->email}}.
</p>

<p> We are looking forward to hearing from you soon and assisting you ahead with your enquiry.
</p>
<br><br>

With Regards,<br>
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