<!-- resources/views/auth/emails/otp.blade.php -->

<p>Dear user,</p>

<p>Verification needed.</p>
<p>Please confirm your sign-in request.</p>
<p>We have detected an account sign-in request from a device we don't recognise.</p>

<ul>
    <li>
        Account: <b>{{ $data['email'] ?? 'N/A' }}</b>
    </li>
    <li>
        When: <b>{{ now() }}</b>
    </li>
    @if(isset($data['device']))
        <li>
            Device: <b>{{ $data['device'] }}</b>
        </li>
    @endif
    @if(isset($data['location']))
        <li>
            Location: <b>{{ $data['location'] }}</b>
        </li>
    @endif
</ul>

<p>Location is approximate based on the login's IP address.</p>

<p>
    To verify your account is safe, please use the following code to enable your new device — it will expire in 15 minutes or when you refresh your browser:
</p>

<p>
    OTP Code: <b>{{ $data['otp'] ?? 'N/A' }}</b>
</p>

<br>

<p>
    That wasn't me! Report to the company manager or IT professional.
</p>

<p>Thank you.</p>

<p>
    {{ optional($data['companyinfo'])->name ?? 'Company Name' }}<br>
    {{ optional($data['companyinfo'])->address ?? 'Company Address' }}<br>
</p>
    