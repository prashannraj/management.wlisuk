<p>Dear {{$data['subjectaccess']->appellant_name}},</p>
<br>
<p>
    Please find attached a completed medical data request form for.
</p>
<p>
   please print the attached from, get it signed by<strong>{{ optional($data['subjectaccess'])->agency}}</strong>, and take it to
   <strong>{{ optional($data['subjectaccess'])->agency}} </strong>. Please specifically tell them to send the requested data to the advisor's email address as stated on the consent form.
</p>

<p> If <strong>{{ optional($data['subjectaccess'])->agency}} </strong> tells you that we would have to email it to them,
please provide this signed form to us along with their email/contact detail.
</p>
<p>
    Please ensure the signature matchesyour passport/photo ID document. If the patient requesting the data does not know how to sign,
    please mark it as X and take it th the <strong>{{ optional($data['subjectaccess'])->agency}} </strong> with the passport/photo ID so it can be promptly
    processed.
</p>
<br>
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
