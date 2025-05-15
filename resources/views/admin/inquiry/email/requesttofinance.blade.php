<p>Dear {{$data['enquiry']->title}}. {{$data['enquiry']->full_name}},</p>
<p>
    Please find attached a completed financial data request form for <strong>{{$data['requesttofinance']->client_name}}</strong>.
</p>
<p>
   Please print the attached from, have it signed by <strong>{{ optional($data['requesttofinance'])->client_name}}</strong>, email it back to
   <strong>{{$data['advisor']->name}}</strong> at <strong>{{$data['advisor']->email}}</strong>.
</p>

<p>
    Please ensure that <strong>{{$data['requesttofinance']->client_name}}</strong>'s signature matches their passport/photo ID document. If <strong>{{$data['requesttofinance']->client_name}}</strong> is unable to sign,
    please mark it with an "X" for prompt processing.
</p>
<p>
    Your swift response to this request would be immensely valued.
</p>
<br>

Kind Regards,<br>
{{$data['advisor']->name}}<br>
{{$data['company_info']->name}}<br>
{{$data['company_info']->address}}
<br>
Tel: {{$data['company_info']->telephone}}
<br>

<br>
{{$data['company_info']->footnote}}
