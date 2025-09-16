@php
    // Safe initialization
    $addedNames = $addedNames ?? [];
    $enquiry    = $data['enquiry'] ?? null;
    $company    = $data['company_info'] ?? null;
    $advisor    = $data['advisor'] ?? null;
    $newccl     = $data['newccl'] ?? null;
@endphp

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
            font-size: 20px;

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
                                        @if(optional($company)->logourl)
                                            <img src="{{ public_path(optional($company)->logourl) }}" alt="Company Logo">
                                        @endif
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
                               <td width="450px">
                                    <b>{{ optional($company)->name ?? '' }}</b><br>
                                    {{ optional($company)->address ?? '' }}<br>
                                    T: {{ optional($company)->telephone ?? '' }}<br>
                                    E: {{ optional($company)->email ?? '' }}<br>
                                    W: {{ optional($company)->website ?? '' }}
                                </td>
                            </tbody>
                        </table>

                    </td>
                </tr>
            </tbody>
        </table>
    </header>

    <div class="">
        <br>
        <p style="text-align:center; font-size: 30px; font-family:'Cambria', serif, monospace"><b><u>CLIENT CARE LETTER</u></b></p>
        <br><br>
        <p style="margin-bottom: 0in; line-height: 120%; font-size: 20px;">
        <span style="font-family: 'Cambria', serif, monospace;">{{ optional($newccl)->full_name_with_title ?? optional($enquiry)->full_name_with_title ?? '' }}</span>
        </p>

        <p style="margin-bottom: 0in; line-height: 120%; font-size: 20px;">
            <span style="font-family: 'Cambria', serif, monospace;">{!! $data['full_address'] ?? '' !!}</span>
            <span style="font-family: 'Cambria', serif, monospace;"><br /></span>
        </p>

        <p style="font-size: 20px;">By email to: <strong>{{ optional($enquiry)->email ?? '' }}</strong></p><br>

        <p style="font-size: 20px;">Your reference number: <strong>ENQ{{ $enquiry->id ?? '' }}</strong></p><br>

        <p style="margin-bottom: 0.14in; line-height: 120%; font-size: 20px;">
            <span style="font-family: 'Cambria', serif, monospace;">{{ isset($data['date']) ? \Carbon\Carbon::parse($data['date'])->format('d F Y') : '' }}</span><br />
            <br />
        </p>

        <p style="margin-bottom: 0in; line-height: 120%; font-size: 20px;">
            <span style="font-family: 'Cambria', serif, monospace;">Dear {{ optional($newccl)->full_name_with_title ?? optional($enquiry)->full_name_with_title ?? '' }},</span>
        </p><br>

        <p><b><u>Re: Your Immigration application(s)</u></b></p>
        <div class="discussion-details">
            {!! $data['discussion_details'] ?? '' !!}
        </div>
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
                                                                @if(optional($advisor)->signature_url)
                                                                    <img src="{{ public_path(optional($advisor)->signature_url) }}" width="120" alt="Advisor Signature">
                                                                @endif
                                                            </td>
                        
                                                        </tr>
                                                        <tr>
                        
                                                            <td>{{ optional($advisor)->name ?? 'Advisor Name' }}</td>
                        
                                                        </tr>
                                                        <tr>
                                                            <td>{{ optional($company)->name ?? 'Company Name' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>
                                                @if(optional($company)->stamp_url)
                                                    <img src="{{ public_path(optional($company)->stamp_url) }}" width="120" alt="Company Stamp">
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>

                                <h2 style="text-decoration: underline;">Procedure and information</h2>
                                <h3 style="text-decoration: underline;">Application process (in country):</h3>
                                <p>We will file an online application on the Access UK website.</p>
                                <p>Supporting documents will either be sent to the Home Office or submitted to an approved UKVI partner and depends on an application type.</p>
                                <p>We will offer to upload documents where possible if the client is comfortable providing us with an access to the online portal for submission. </p>
                                <h3 style="text-decoration: underline;">Application process (overseas):</h3>
                                <p>We will file an online application on the Access UK website.</p>
                                <p>Please note there will be an online visa application fee and Immigration Health Surcharge (IHS) to pay as part of the application (EU Applicant and ILE/ILR/AF are exempt). </p>
                                <p>Fees from overseas are either charged in their local currency or in USD.</p>
                                <p><b><u>Immigration Health Surcharge (IHS) information:</u></b></p>
                                <p>The Immigration Health Surcharge (IHS) can only be paid online and cannot be paid at the Visa Application Centre (VAC). For example, for an Appendix FM Entry Clearance visa application, a client based in Hong Kong will have their IHS fee charged in HKD, while applicants in Nepal are charged in NPR or USD. Applicants are required to pay the IHS in their local currency, where available, and the exact amount is only determined at the time of the application.</p>
                                <p><b>Please note: We have no control or influence over this charge, as it is automatically calculated and applied to each application.</b></p>
                                <h3 style="text-decoration: underline;">Document submission process:</h3>
                                <p>Copies of documents are submitted to the UKVI via VFS Global/ Teleperformance or another method instructed by the Home Office.  It is submitted either online or by visiting an approved application centre.</p>
                                <p>In cases where online submission is not possible, such as due to an unresponsive website or large file sizes, we recommend that the sponsor submits the documents at the VFS/Teleperformance office, either in the UK or at the visa application centre.</p>
                                <p><b>Note: </b>Providers charge a fee for submissions made in the UK per application. Please visit their website for the most up-to-date fees.</p>
                                <p><b>Photocopies: </b>Colour copies are charged at £1.50 per page, and black-and-white copies are charged at £1 per page (if we have to make it for them). Please note that these copy charges are additional to our fees.<b> We suggest opting for online digital submission to avoid unnecessary costs.</b></p>

                                <h3 style="text-decoration: underline;">Where to send supporting documents</h3>
                                <p>Our address is <strong>{{ $data['company_info']->name ?? 'Default text here' }}</strong>, <strong>{{ $data['company_info']->address ?? 'Default text here' }}</strong>, T: <strong>{{ $data['company_info']->telephone ?? 'Default text here' }}</strong>, E: <strong>{{ $data['company_info']->email ?? 'Default text here' }}</strong>.</p>

                                <h3 style="text-decoration: underline;">Method of communication</h3>
                                <p>We have changed the way we communicate and engage with our clients.</p>
                                <ol>
                                    <li><strong>Telephone:</strong> would contact you to discuss your case at a pre-arranged time that suits you.</li>
                                    <li><strong>Documents:</strong> We prefer to receive scanned documents (minimum 300 dpi) via email. If this is not convenient, documents can be posted to us with a pre-paid return envelope. Documents posted to the above address will be scanned and returned via the pre-paid envelope provided.</li>
                                    <li><strong>Direct contact:</strong> Your representative (<strong>{{ $data['advisor']->name ?? '' }}</strong>) can be reached by WhatsApp, Viber or iMessage on <strong>{{ $data['advisor']->contact ?? '' }}</strong>. Please note that sending documents through these platforms is at your own risk. They may not be suitable for official submissions and are better suited for a quick review to provide advice. We recommend sending documents to us via email for formal purposes.</li>
                                </ol>

                                <h3 style="text-decoration: underline;"><b>Client Care Letter agreeing and contractually entering person’s name and signature.</b></h3>
                                <p>Client’s name (please print): <strong>{{$data['newccl']->full_name_with_title ?? '' }}</strong></p><br>
                                <p>Client’s signature:</p><br>
                                <p>Date (e.g. 1 January 2025):</p>

                                <h3 style="page-break-before: always; text-align: left; text-decoration: underline;">General Data Protection Regulation consent – Terms and conditions</h3>
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
                                <p>Client’s name: <strong>{{$data['newccl']->full_name_with_title ?? '' }}</strong></p><br>
                                <p>Client’s signature:</p><br>
                                <p>Date (e.g. 1 January 2025):</p>
       <h4 style= "page-break-before: always;" class="font-bold text-lg underline">Useful Links:</h4>
        <ol class="list-decimal pl-6 mt-2">
            <li class="mt-2">
                <a href="#" class="text-blue-700 underline">UKV&I approved Secure English Language Test (SELT)</a>
            </li>
            <li class="mt-2">
                <a href="#" class="text-blue-700 underline">UK Visa application fee</a>
            </li>
            <li class="mt-2">
                <a href="#" class="text-blue-700 underline">UK-Pre departure TB clearance certificate from an approved clinic</a>
            </li>
            <li class="mt-2">
                <a href="#" class="text-blue-700 underline">Immigration Health Surcharge (IHS) Fee</a>
            </li>
        </ol>

    </div>
    
</body>

</html>
