<p>Dear {{$data['client']->title}}. {{$data['client']->l_name}},</p>
<br>
<p>Our records show that your visa ({{$data['visa']->visa_number}}) is coming to an end on {{$data['visa']->expiry_date}}.</p>
<p>As an existing and valued client, we are sending you a reminder to start preparing documents and get in touch with us for a no-obligation, free requirement information.
    We also offer a discount on our standard fee to our existing clients who are returning to us for their visa extension.</p>
<p>Please kindly complete a renewed enquiry form with your up-to-date contact details and information by clicking the link below.</p>
<a href="{{$data['form']->link}}" target="_blank" rel="noopeneformr noreferrer">{{$data['form']->name}}</a>

<p>We look forward to receiving your completed form at the earliest.
</p>

<p>Yours Sincerely</p>

<p>
    {{$data['sender']->name}} <br>
    {{$data['companyinfo']->name}} <br>
    {{$data['companyinfo']->address}} <br>
    {{$data['sender']->contact}} <br>
    {{$data['companyinfo']->telephone}}
</p>
<br>
<br>
<br>
<p>{{$data['companyinfo']->footnote}}</p>