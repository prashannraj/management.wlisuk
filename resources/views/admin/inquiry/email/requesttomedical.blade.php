<p>Dear {{$data['enquiry']->title}}. {{$data['enquiry']->full_name}},</p>
<br>
<p>
    Please find attached a completed medical data request form for .
</p>
<p>
   Please print the attached from, get it signed by <strong>{{ optional($data['requesttomedical'])->paitent_name}}</strong>, and take it to
   <strong>{{ optional($data['requesttomedical'])->practice_name}} </strong>. Please specifically tell them to send the requested data to the advisor's email address as stated on the consent form.
</p>

<p> If <strong>{{ optional($data['requesttomedical'])->practice_name}} </strong> tells you that we would have to email it to them,
please provide this signed form to us along with their email/contact detail.
</p>
<p>
    Please ensure the signature matches your passport/photo ID document. If the patient requesting the data does not know how to sign,
    please mark it as X and take it th the <strong>{{ optional($data['requesttomedical'])->practice_name}} </strong> with the passport/photo ID so it can be promptly
    processed.
</p>
<p>
    Your swift response to this request would be immensely valued.
</p>

Kind Regards,<br>
{{$data['advisor']->name}}<br>
{{$data['company_info']->name}}<br>
{{$data['company_info']->address}}
<br>
Tel: {{$data['company_info']->telephone}}
<br>

<br>
{{$data['company_info']->footnote}}
