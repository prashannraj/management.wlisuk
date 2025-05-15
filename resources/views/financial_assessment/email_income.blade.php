
<p>Dear {{$data['row']->client->full_name}},</p>
<p>
    Please find attached a copy of an income assessment statement we have prepared which is to be sent to the relevant authority as part of your application.
</p>
<p>
    If you spot any error, please do notify us immediately and if you are happy with the assessment please confirm to us either by replying to this email or directly to your advisor.
</p>
<br>
Many thanks,<br>
{{$data['advisor']->name}} <br>
{{$data['companyinfo']->name}}<br>
Tel: {{$data['advisor']->contact}}<br>
Email: {{$data['advisor']->email}}<br>

<br>
<br>

{{$data['companyinfo']->footnote}}