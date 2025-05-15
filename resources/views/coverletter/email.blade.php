<p>Dear {{$data['coverletter']->application->client->full_name}},</p>
<p>Please find attached a copy of the cover letter uploaded to the visa authority with your application ({{$data['coverletter']->application->ref}}).
</p>
<p>We thank you for choosing {{$data['companyinfo']->name}} as your representative. <br>
    If you have any questions or spot an error please contact us immediately with {{$data['coverletter']->application->basic_info_id}}-{{$data['coverletter']->application->client->full_name}} on the email subject.
</p>
<br>
With regards,<br>
Administration team <br>
{{$data['companyinfo']->name}}<br>
{{$data['companyinfo']->address}}<br>
Tel: {{$data['companyinfo']->telephone}}<br>
Email: {{$data['companyinfo']->email}}<br>

<br>
<br>

{{$data['companyinfo']->footnote}}