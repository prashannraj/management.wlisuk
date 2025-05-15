Dear {{$data['row']->full_name}},
<br>
<br>
Please find an attached enquiry details you have lodged with {{$data['companyinfo']->name}}. We are processing your enquiry
and a member of our team will be in touch with you soon.
<br>
<br>
If any of the details entered are incorrect, please get in touch with us immediately by replying this email to {{$data['company_info']->email}}

<br>

<br>
With regards,<br><br>
Web Enquiries<br>
{{$data['companyinfo']->name}}<br>
{{$data['companyinfo']->address}}<br>
Tel: {{$data['companyinfo']->telephone}}<br>
Email: {{$data['companyinfo']->email}}<br>
<br>
<br>
<br>

{{$data['companyinfo']->footnote}}