<p>Dear user,</p>

<p>Verification needed.</p>
<p>Please confirm your sign-in request.
</p>
<p>We have detected an account sign-in request from a device we don't recognise.
</p>
<ul>
    <li>
        Account: <b>{{$data['email']}}</b>

    </li>
    <li>When: <b>{{now()}}</b></li>
    <!-- <li>Device: <b>{{$data['device']}}</b>
    </li>
    <li>Location: <b>{{$data['location']}}</b>
    </li> -->
</ul>
Location is aproximate based on the login's IP address

<p>To verify your account is safe, please use the following code to enable your new device — it will expire in 15 minutes or when you refresh your browser:
</p>
<p>OTP Code: <b>{{$data['otp']}}</b>
</p><br>
<p>That wasn't me! Report to the company manager or IT professional.
</p>
<p>Thank you.</p>
<p>
    {{$data['companyinfo']->name}}<br>
    {{$data['companyinfo']->address}}<br>
</p>