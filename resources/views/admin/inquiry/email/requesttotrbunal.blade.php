<p>Dear {{$data['enquiry']->title}}. {{$data['enquiry']->full_name}},</p>
<p>
    Attached, please find a completed request for the tribunal determination letter. Kindly ensure it is signed by <strong>{{ optional($data['requesttotrbunal'])->appellant_name}} </strong> and email the signed document back to us.
</p>
<p>
    Additionally, please include a copy of <strong>{{ optional($data['requesttotrbunal'])->appellant_name}} </strong>’s passport.
    Ensure that the signature on the document matches the signature on <strong>{{ optional($data['requesttotrbunal'])->appellant_name}} </strong>’s passport or photo ID.

</p>

<p>
    If  <strong>{{ optional($data['requesttotrbunal'])->appellant_name}} </strong> is unable to provide a signature, please mark the signature field with an “X” and submit it along with the passport or photo ID to facilitate prompt processing.
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
