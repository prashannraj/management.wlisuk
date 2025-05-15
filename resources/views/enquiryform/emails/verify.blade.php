Dear {{$data['row']->full_name}},
<br>
<br>
Thank you for completing an online enquiry with {{$data['companyinfo']->name}}.
Before we get started, we'll need to make sure we've got your email right.
<br>
<br>
Please verify your email by clicking the link below so your enquiry is received by us.
<br>
<a href="{{$data['row']->verify_url}}" target="_blank" rel="noopener noreferrer">Click here to verify</a>
<br>
Many Thanks,<br><br>
Web Enquiries<br>
{{$data['companyinfo']->name}}<br>
{{$data['companyinfo']->address}}<br>
Tel: {{$data['companyinfo']->telephone}}<br>
Email: {{$data['companyinfo']->email}}<br>
<br>
<br>
<br>

{{$data['companyinfo']->footnote}}