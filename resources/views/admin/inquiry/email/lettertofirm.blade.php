<p>Dear {{$data['lettertofirms']->firmsname}},</p>
<p>
   I am writing to request specific data pertaining to the client you represented.

</p>
<p>
    Enclosed, please find the letter of authority from your client together with their ID.
    This documentation authorises the release of the requested information.

</p>
<p>
    Your swift response to this request would be immensely valued.

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
