<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>{{$data['filename']}}</title>

    <style type="text/css">
        .classic-table {
            width: 100%;
            color: #000;

        }
        .discussion-details {
        font-size: 20px;

        }

         @page {
            size: 9in 11.69in;
            margin-left: 1.0in;
            margin-right: 1.00in;
            margin-top: 0.49in;
            margin-bottom: 0.49in
        }

        p {
            margin-top: 4px;
            margin-bottom: 20px;
            text-align: justify;
            line-height: 1.2;

        }

        li {
            margin-top: 4px;
            text-align: justify;
            line-height: 1.2;
            font-size: 20px;

        }



        .courier {
            font-family: 'Courier New', Courier, monospace;
        }

	body {
    	font-family: 'Cambria', serif;
    	/*font-size: initial !important;*/
	}

    </style>
</head>

<body lang="en-GB" link="#0000ff" vlink="#96a9a9" dir="ltr">
    @include('partials.page_number')

    <header style='border-bottom:2px solid red'>
        <table class='classic-table'>
            <tbody>
                <tr>
                    <td colspan="3">
                        <table>
                            <tbody>
                                <tr>

                                    <td>
                                        <img src="{{public_path($data['company_info']->logourl)}}" alt="">


                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="100%">
                    </td>
                    <td width="450px">
                        <table>
                            <tbody>
                                <tr>
                                    <td colspan="2"><b>{{$data['company_info']->name}}</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2">{{$data['company_info']->address}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">T: {{$data['company_info']->telephone}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">E: {{$data['company_info']->email}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">W: {{$data['company_info']->website}}</td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
            </tbody>
        </table>
    </header>

    <div class="">
        <br>
        <p style="text-align:center; font-size: 30px; font-family:'Cambria', serif, monospace"><b><u>CLIENT CARE LETTER </u></b></p>
        <br><br>
        <p style="margin-bottom: 0in; line-height: 120%; font-size: 20px;">
        <span style="font-family: 'Cambria', serif, monospace;">{{$data['lteccl']->full_name_with_title ?? $data['enquiry']->full_name_with_title}}</span>
        </p>

        <p style="margin-bottom: 0in; line-height: 120%; font-size: 20px;">
            <span style="font-family: 'Cambria', serif, monospace;">{!!$data['full_address']!!}</span>
            <span style="font-family: 'Cambria', serif, monospace;"><br /></span>
        </p>

        <p style="font-size: 20px;">By email to: <strong>{{$data['enquiry']->email}}</strong></p><br>

        <p style="font-size: 20px;">Your reference number: <strong>ENQ{{$data['enquiry']->id}}</strong></p><br>

        <p style="margin-bottom: 0.14in; line-height: 120%; font-size: 20px;">
            <span style="font-family: 'Cambria', serif, monospace;">{{ \Carbon\Carbon::parse($data['date'])->format('d F Y') }}</span><br />
            <br />
        </p>

        <p style="margin-bottom: 0in; line-height: 120%; font-size: 20px;">
            <span style="font-family: 'Cambria', serif, monospace;">Dear {{$data['lteccl']->full_name_with_title ?? $data['enquiry']->full_name_with_title}},</span>
        </p><br>

        <div class="discussion-details">
            {!! $data['discussion_details'] !!}
        </div>
        <p>We are committed to assisting you with your Immigration Appeal and look forward to receiving the necessary documents to move forward. Thank you for choosing to come with us. If you have any questions, please do not hesitate to let me know and I will be pleased to help.</p>

                                <p>Kind regards,</p>
                                <br>
                                <table class=''>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <img src="{{ public_path($data['advisor']->signature_url)}}" width="120" alt="">
                                                            </td>

                                                        </tr>
                                                        <tr>

                                                            <td>{{$data['advisor']->name}}</td>

                                                        </tr>
                                                        <tr>
                                                            <td>{{$data['company_info']->name}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>
                                                <img src="{{ public_path($data['company_info']->stamp_url) }}" width="120" alt="">

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>

                                <h3 style="text-decoration: underline;">Document submission process:</h3>
                                <p>Copies of the documents are submitted to the tribunal online via HMCTS or by email.</p>
                                <h3 style="text-decoration: underline;"> Where to send supporting documents:</h3>
                                <p>Our address is <strong>{{ $data['company_info']->name ?? 'Default text here' }}</strong>, <strong>{{ $data['company_info']->address ?? 'Default text here' }}</strong>, T: <strong>{{ $data['company_info']->telephone ?? 'Default text here' }}</strong>, E: <strong>{{ $data['company_info']->email ?? 'Default text here' }}</strong>.</p>

                                <h3 style="text-decoration: underline;">Method of communication</h3>
                                <p>We have changed the way we communicate and engage with our clients.</p>
                                <ol>
                                    <li><strong>Telephone:{{ $data['company_info']->telephone }}</strong> We would contact you to discuss your case at a pre-arranged time that suits you.</li>
                                    <li><strong>Documents:</strong> We prefer to receive scanned documents (minimum 300 dpi) via email {{ $data['company_info']->email }}. If this is not convenient, documents can be posted to us with a pre-paid return envelope. Documents posted to the above address will be scanned and returned via the pre-paid envelope provided.</li>
                                    <li><strong>Direct Contact:</strong> Your representative (<strong>{{ $data['advisor']->name ?? '' }}</strong>) can be reached by WhatsApp, Viber or iMessage on <strong>{{ $data['advisor']->contact ?? '' }}</strong>. Please note that sending documents through these platforms is at your own risk. They may not be suitable for official submissions and are better suited for a quick review to provide advice. We recommend sending documents to us via email for formal purposes.</li>
                                </ol>

                                <h3 style="text-decoration: underline;">Client Care Letter agreeing and contractually entering person’s name and signature.</h3>
                                <p>Client’s name (please print): <strong>{{$data['lteccl']->full_name_with_title ?? '' }}</strong></p>
                                <p>Client’s signature:</p>
                                <p>Date (e.g. 1 January 2025):</p>

                                <h3 style= "page-break-before: always; text-decoration: underline;">General Data Protection Regulation Consent – Terms and Conditions</h3>
                                <h4>General Terms and Conditions</h4>
                                <ol>
                                    <li>Purpose of the application or appeal:</li>
                                    <li><strong>{{ $data['company_info']->name ?? 'Default text here' }}</strong> reserves the right to vary these Terms and Conditions or the Consent at any time. The latest version of the Terms and Conditions apply to all applications and will supersede previous Terms and Conditions unless otherwise stated.</li>
                                </ol>

                                <h4>Consent</h4>
                                <ol>
                                    <li>I agree to provide <strong>{{ $data['company_info']->name ?? 'Default text here' }}</strong> and its advisor(s) or counsel any relevant data (including personal data) required by the Tribunal, Home Office or UK Visa and Immigration for the ‘Purpose of the application or appeal’ as stated in Paragraph 1.</li>
                                    <li>Where any information or documentation pertains to another person or a third party, I confirm that I have consulted them and obtained their consent to share their data (including personal data) with <strong>{{ $data['company_info']->name ?? 'Default text here' }}</strong> or its representative for the purpose of the application or appeal, as outlined in Paragraph 1. They fully understand that their information will be used in connection with the applicant’s/appellant’s case and may also be disclosed to the relevant authorities involved in the case.</li>
                                    <li>I agree for <strong>{{ $data['company_info']->name ?? 'Default text here' }}</strong> and its advisor to pass on the details provided by me to the relevant authority such as the Counsels, Tribunals and the Home Office, visa issuance authority or another relevant institution.</li>
                                    <li>I confirm that the services provided by <strong>{{ $data['company_info']->name ?? 'Default text here' }}</strong> are non-refundable and binding on signing of these Terms and Conditions.</li>
                                    <li>I confirm that all the information and documentations that I have currently provided or will provide is genuine and correct to the best of my knowledge.</li>
                                    <li>I understand that <strong>{{ $data['company_info']->name ?? 'Default text here' }}</strong> and its advisors may contact me in the future regarding the ‘Purpose of the visa application or appeal’ as stated in Paragraph 1.</li>
                                    <li>I consent for <strong>{{ $data['company_info']->name ?? 'Default text here' }}</strong> to hold my data digitally or in paper form where applicable.</li>
                                    <li>I understand that <strong>{{ $data['company_info']->name ?? 'Default text here' }}</strong> will store my data online in their server based either in the UK or the EU.</li>
                                </ol>

                                <p>By signing below, I agree to all the Terms and Conditions listed above.</p>
                                <p>Client’s name: <strong>{{$data['lteccl']->full_name_with_title ?? '' }}</strong></p>
                                <p>Client’s signature:</p>
                                <p>Date (e.g. 1 January 2025):</p>

    </div>

</body>

</html>
