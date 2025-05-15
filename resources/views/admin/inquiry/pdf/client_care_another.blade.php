<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>{{$data['filename']}}</title>

    <style type="text/css">
        body {
            font-size: 17px;
        }

        @page {
            size: 8.27in 11.69in;
            margin-left: 1.25in;
            margin-right: 1.25in;
            margin-top: 0.98in;
            margin-bottom: 0.49in
        }

        p {
            margin-bottom: 0.1in;
            direction: ltr;
            line-height: 115%;
            text-align: left;
            orphans: 2;
            widows: 2;
            background: transparent
        }

        li p {
            display: inline;
            vertical-align: bottom;
            direction: ltr;
            line-height: 125%;
            text-align: left;

        }

        li {
            margin-bottom: 0.1in;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
        }

        h1 {
            margin-top: 0.28in;
            margin-bottom: 0.14in;
            border-top: none;
            border-bottom: 3.00pt double #732117;
            border-left: none;
            border-right: none;
            padding-top: 0in;
            padding-bottom: 0.01in;
            padding-left: 0in;
            padding-right: 0in;
            direction: ltr;
            text-transform: uppercase;
            color: #4d160f;
            font-size: 14pt;
            letter-spacing: 1.0pt;
            line-height: 120%;
            text-align: center;
            orphans: 2;
            widows: 2;
            background: transparent
        }

        a:link {
            color: #0000ff;
            text-decoration: underline
        }

        a:visited {
            color: #96a9a9;
            text-decoration: underline
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
                    <td width="300px">
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

    <p style="text-align:center;
                font-weight: bold;
                margin-top: 0.35in; margin-bottom: 0.21in;
                /* border-top: 1px dotted #4d160f; border-bottom: 1px dotted #4d160f;  */
                border-left: none; border-right: none; padding-top: 0.01in; padding-bottom: 0.08in;
                padding-left: 0in; padding-right: 0in; text-transform: uppercase;
                letter-spacing: 2.5pt; line-height: 120%">
        <span color="#4d160f">
            <span size="6" style="font-size: 22pt">
                <span style="font-family:'Courier New', Courier, monospace">
                    <span size="2" style="font-size: 11pt">Client Care Letter</span>
                </span>
            </span>
        </span>
    </p>
    <p style="margin-bottom: 0in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">
    {{$data['enquiry']->full_name_with_title}}<br>
    @foreach($addedNames as $name)
    <span>{{ $name }}</span><br>
@endforeach
        {!!$data['full_address']!!}</span>
            @if(isset($data['enquiry']->email))
                <span style="font-family:'Courier New', Courier, monospace">By email to: {!!$data['enquiry']->email!!}<br /></span>
            @endif
        <span style="font-family:'Courier New', Courier, monospace"><br /></span>

    </p>

    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">{{$data['date']}}</span><br />
        <br />
    </p>
    <p style="margin-bottom: 0in; line-height: 120%">
    <p class="No_20_Spacing"><span>Dear {{$data['enquiry']->full_name_with_title}},</span>@foreach($addedNames as $key => $name)
        {{ $name }}
        @if($key < count($addedNames) - 2)
            ,
        @elseif($key == count($addedNames) - 2)
            &
        @endif
    @endforeach
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Thank
            you for your instructions. We are delighted to have the opportunity
            to act for you and trust we can bring your instructions to a
            satisfactory conclusion. </span>
    </p>
    <p>{!! $data['discussion_details'] !!}</p>

    {{-- <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>WHO
                    IS DEALING WITH YOUR CASE?</b></span>
        </span>
    </h1>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">My
            name is {{$data['advisor']->name}} and I will be handling your case. I am authorised to provide
            immigration advice and services at <b>{{$data['advisor']->level}}</b> in the categories of <b>{{$data['advisor']->category}}.</b></span>


    </p>
    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>INSTRUCTIONS</b></span>
        </span>
    </h1>
    <br>
    <div style="">
        {!!$data['discussion_details']!!}
    </div>

    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Further
            documents are requested with this client care letter which can be
            sent to us either via email or posted at our address below.</span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">I
            have also advised the application decisions may take longer, and the
            published guidelines suggest 3 - 6 months and priority application
            being decided within 6 weeks from overseas and 24 hours upon
            biometric enrolment in country which attracts additional charges. </span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">I
            confirm that based on the information you have provided; we believe
            that you are eligible to apply for</span>
        <span style="font-family:'Courier New', Courier, monospace;font-weight:bold">{{$data['servicefee']->category}},</span>
        <span style="font-family:'Courier New', Courier, monospace;font-weight:bold">{{$data['servicefee']->name}}</span>
        <span style="font-family:'Courier New', Courier, monospace">application and we can bring the
            application to a satisfactory conclusion. </span>
    </p>
    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>OPENING
                    TIMES</b></span>
        </span>
    </h1>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">We
            are based at,</span>
        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->address}}. The normal hours of work are from 10 am to 5 pm Monday to Friday.</span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Appointments
            can be arranged outside these hours when essential for your interest.
        </span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">My
            emergency number is {{$data["advisor"]->contact}}. Please only use in an urgent situation.</span>
    </p>
    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>COST</b></span>
        </span>
    </h1>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Our
            fee for this matter is <b>{{$data['servicefee']->currency->title}}
                {{$data['servicefee']->total}}</b> per applicant.</span>

    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Our
            agreed fee for this matter is <b>{{$data['agreed_fee_currency']->title}} {{$data['agreed_fee']}}</b>.</span>

    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">The
            invoice is to be paid into our business account below on completion
            of the application form and prior to the application being sent or in
            advance to our client account if applicable. An invoice will be
            raised on completion of the instruction and on receipt of the
            payment.</span>
    </p>
    <p align="center" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace"><b>{!!$data['bank']->bank_details()!!}</b></span>
        <span style="font-family:'Courier New', Courier, monospace"><b>{!! "Payment reference: ENQ".$data['enquiry_id'] !!}</b></span>
    </p>

    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace"><i><u>Please
                    note that this </u></i></span>
        <span style="font-family:'Courier New', Courier, monospace"><i><u><b>does
                        not</b></u></i></span>
        <span style="font-family:'Courier New', Courier, monospace"><i><u> include
                    UKVI Application fee, the postal cost for the return of the
                    documents. </u></i></span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">We
            charge for the work carried out on the case irrespective of the
            outcome. We do not operate on a “no win no fee basis”.</span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace"><b>Payment
                terms: </b></span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Payment
            in full on completion of work prior to the application being sent or
            as advised by the advisor (instruction will be sent).</span>
    </p>
    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>FREE
                    HELP AND ASSISTANCE</b></span>
        </span>
    </h1>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">You
            should also be aware that firms such as Citizens Advice Bureau and
            Law Centres could provide you with advice and representation in
            immigration matters free of charge. If you wish to consult them,
            their number can be found in the Local Telephone Directory.</span>
    </p>
    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>OUTCOME
                    OF THE MATTER</b></span>
        </span>
    </h1>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">We
            will try our best to get a favourable outcome on all matters.
            However, success is not guaranteed, and the outcome is dependent upon
            the merit of your case. We do not operate on a “no win no fee
            basis”.</span>
    </p>
    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>REPORT
                    ON PROGRESS (In country)</b></span>
        </span>
    </h1>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">We
            will update you by telephone or in writing with progress on your
            matter regularly but at least every six weeks and we will always try
            to keep you informed of any unexpected delays or changes in the
            character of the work. You may enquire at any time from me about a
            progress report.</span>
    </p>
    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>REPORT
                    ON PROGRESS (OUT OF country)</b></span>
        </span>
    </h1>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">We
            would expect you to update us by email on receipt of the
            correspondence or a decision on the application as its usually not
            communicated to us.</span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">However,
            if require us to contact the UKVI we will contact them online and
            there is a fee standard fee of £30 we charge inclusive of the UKVI
            approved contractor (SITEL UK Ltd) charges of £5.48. We will only
            offer a telephone contact in an emergency and charges remains £30
            plus the telephone charge (£1.37 per minute) paid on your behalf.</span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Alternatively
            please visit
            <a href="https://www.gov.uk/contact-ukvi-inside-outside-uk/y/outside-the-uk/english">https://www.gov.uk/contact-ukvi-inside-outside-uk/y/outside-the-uk/english</a>
            and follow the process.</span>
    </p>

    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>HOW
                    LONG IT TAKE TO RESOLVE THE MATTER</b></span>
        </span>
    </h1>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">At
            this stage, I am unable to give you an exact time in which your
            matter will be concluded. The time taken varies depending upon your
            case and the complexity of the matter. </span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">You
            should be aware that the Home Office and High Commissions decide on
            cases according to their own time scales and we have no control over
            this.</span>
    </p>
    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>EQUALITY
                    AND DIVERSITY </b></span>
        </span>
    </h1>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">We
            are committed to promoting equality and diversity in all our dealings
            with clients, third parties and employees. Please contact us if you
            would like a copy of our equality and diversity policy.</span>
    </p>
    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>COMPLAINTS</b></span>
        </span>
    </h1>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">We
            are committed to high-quality legal advice and client care. When
            something goes wrong, we need you to tell us about it. This will help
            us to maintain and improve our standards. </span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">If
            you are unhappy about any aspect of the service you have received,
            please contact me on </span>
        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->telephone}}</span>
        <span style="font-family:'Courier New', Courier, monospace">
            or </span>
        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->email}}</span>
        <span style="font-family:'Courier New', Courier, monospace">
            or by post to our office at Complaints, </span>
        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->name}},</span>
        <span style="font-family:'Courier New', Courier, monospace">
        </span>
        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->address}}.</span>
    </p>
    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>Our
                    complaints procedure</b></span>
        </span>
    </h1>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">If
            you have a complaint, please contact us with the details. If we have
            to change any of the timescales set out below, we will let you know.</span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span color="#4c160f">
            <span face="Perpetua, serif"><i>
                    <span style="font-family:'Courier New', Courier, monospace">What
                        will happen next?</span>
                </i></span>
        </span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">1. Within
            2 weeks of receiving your complaint, I will send you a letter
            acknowledging your complaint and asking you to confirm or explain the
            details. I may suggest that we meet to clarify any details.</span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">2. I
            will then record your complaint in our central register and open a
            file for your complaint and investigate your complaint. This may
            involve one or more of the following steps.</span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace"> 3. I
            will consider your complaint again. I will then send you my detailed
            reply or invite you to a meeting to discuss the matter. </span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">4. Within
            two days of the meeting I will write to you to confirm what took
            place and any solutions I have agreed with you. Inappropriate cases,
            I could offer an apology, a reduction of any bill or a repayment in
            relation to any payment received.</span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 0.15in">
        <span face="Arial, serif">
            <span size="2" style="font-size: 9pt">
                <span style="font-family:'Courier New', Courier, monospace">
                    <span size="2" style="font-size: 11pt">{{$data['company_info']->name}} intends to resolve any complaint within
                        6 weeks of receiving it.</span>
                </span>
            </span>
        </span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Please
            note that alternatively, you can make yours complain directly to the
            OISC, who regulate all Immigration Advisors, by completing the OISC
            complaint’s form. This form is available in a range of languages on
            the website, www.oisc.gov.uk office of any regulated adviser or
            community advice organisations. You can also make yours complain in
            writing to the OISC office, 5th Floor, 21 Bloomsbury Street, London
            WC1B 3HF or by email at info@oisc.gov.uk. </span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Telephone:
            0345 000 0046 Fax: 020 7211 1553 Website: www.oisc.gov.uk </span>
    </p>
    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>CONFIDENTIALITY</b></span>
        </span>
    </h1>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">We
            are under the duty to keep your affairs confidential to our firm and
            to ensure that our staffs do the same. If we are to release any
            confidential information which is unauthorised then this can lead to
            disciplinary action against us. The duty of confidentiality applies
            to information about your affairs and general information.</span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">It
            is likely that during the course of the work we undertake certain
            information may have to be disclosed to the third parties, for
            example, experts’ reports. We will only disclose such information
            having discussed the matter with you, having obtained your consent to
            disclose information or where we are under a professional obligation
            to do so.</span>
    </p>
    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>INSPECTION
                    OF FILES AND QUALITY STANDARDS</b></span>
        </span>
    </h1>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">The
            Office of The Immigration Services Commissioner may need to access
            your file whilst checking my competence. The OISC does not require
            permission to inspect my client files. Please be assured that they
            will maintain your confidentiality at all times.</span>
    </p>
    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>TRANSFER
                    OF FILE</b></span>
        </span>
    </h1>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">If
            you wish to instruct other Firms to deal with your matter, we will
            transfer your file to another adviser, but you will still pay our
            fees. We will always release your file whether you have paid us or
            not. We may take action in the county courts to recover our fees
            should you refuse to pay.</span>
    </p>
    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>INSURANCE
                    COVER</b></span>
        </span>
    </h1>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">We
            maintain Professional Indemnity Insurance. </span>
    </p>
    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>PAPERS
                    HELD BY US AND DOCUMENT CUSTODY</b></span>
        </span>
    </h1>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">On
            completion of matters, I will return your original documents to you
            unless otherwise agreed with you. We will undertake to retain files
            for at least six years in line with Commissioners Code of Standards.
            We reserve the right to destroy the files without further reference
            to you after retaining the files for the period stated above.</span>
    </p>
    <h1>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>ACTION
                    BY YOURSELF </b></span>
        </span>
    </h1>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">To
            enable us to provide you with an efficient service, you are
            committing yourself to ensure that:</span>
    </p>
    <ul>
        <li>
            <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
                <span style="font-family:'Courier New', Courier, monospace">You always keep us updated whenever
                    any of your contact details change. We need to be able to contact
                    you when necessary. </span>
            </p>
        <li>
            <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
                <span style="font-family:'Courier New', Courier, monospace">You will provide us with clear,
                    timely and accurate instructions. </span>
            </p>
        <li>
            <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
                <span style="font-family:'Courier New', Courier, monospace">You will provide all documentation
                    required to complete the transaction in a timely manner. </span>
            </p>
        <li>
            <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
                <span style="font-family:'Courier New', Courier, monospace">You will safeguard and provide any
                    documents which are likely to be required for the matter. </span>
            </p>
    </ul>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Please
            sign and date one copy of this client care letter in the space
            provided below and return to us either by post, email or in-person. </span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Thank
            you for choosing to come with us. </span>
    </p>
    <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">If
            you have any questions, please do not hesitate to let me know and I
            will be pleased to help.</span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Kind
            regards,</span>
    </p>
    <br>
    <table class=''>
        <tbody>
            <tr>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <img style="height:auto" src="{{public_path($data['advisor']->signature_url)}}" width="120" alt="">
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
                    <img style="height:auto" src="{{public_path($data['company_info']->stamp_url)}}" width="150" alt="">

                </td>
            </tr>
        </tbody>
    </table>

    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace"><u><b>Application
                    process (in country):</b></u></span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">We
            will file an online application on the Access UK website.</span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Supporting
            documents will either be sent to the Home Office or submitted to
            Sopra Steria an approved UKVI partner and depends on an application
            type.</span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">We
            will offer to upload documents where possible if the client is
            comfortable providing us with an access to the online portal for
            submission. </span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace"><u><b>Application
                    process (overseas):</b></u></span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">We
            will file an online application on the Access UK website.</span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Please
            note there will be an online visa application fee and Immigration
            Health Surcharge (IHS) to pay as part of the application (EU
            Applicant and ILE/ILR/AF are exempt). </span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Fees
            from overseas are either charged in their local currency or in USD.</span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%"><a href="https://www.immigration-health-surcharge.service.gov.uk/checker/type">
            <span style="font-family:'Courier New', Courier, monospace;text-align:left"><span style="background: #ffffff">Immigration
                    Health Surcharge (IHS) information:</span></span>
        </a>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">The
            IHS can only be paid online and cannot be paid at the Visa
            Application Centre (VAC). E.g. for Appendix FM Entry Clearance visa
            application for a client based in Hong Kong their IHS fee is charged
            in HKD and Nepal-based applicants are charged in USD. Applicants are
            required to pay the IHS in their local currency where available and
            the precise amount is only known at the time of the application.</span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Please
            note: We have no control or influence over this charge and it is
            automatically populated for each application.</span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace"><u><b>Document
                    submission process:</b></u></span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Copies
            of the documents are submitted to the UKVI through the VFS Global or
            Teleperformance either online or by visiting the approved centre. </span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">In
            some instances where online submissions are not possible due to the
            website being unresponsive or the file sizes being too large; we
            suggest the sponsor submit documents at the VFS/Teleperformance
            office, be this in the UK or at the Visa application centre.</span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Note:
            VFS charges £100 in the UK per application. If you would like us to
            travel and submit it on your behalf, we are happy to offer the
            service without any additional charge other than the travel cost (to
            Edinburgh, Manchester or London) and a submission fee. </span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace"><b>Photocopies:</b>
            Colour copies are charged 80p per page and black and white copies are
            charged 30p per page. Kindly note copy charges are additional to our
            fees.</span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace"><u><b>Where
                    to send supporting documents: </b></u></span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Our
            address is</span>
        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->name}},</span>
        <span style="font-family:'Courier New', Courier, monospace">
        </span>
        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->address}},</span>
        <span style="font-family:'Courier New', Courier, monospace">T:</span>
        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->telephone}},</span>E:</span>
        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->email}}.</span>

    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace"><u><b>Method
                    of communication</b></u></span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Due
            to relocating from London to Durham we have changed the way we
            communicate and engage with our clients.</span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace"><b>1. Telphone</b></span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">We
            would contact you to discuss your case at a pre-arranged time that
            suits you.</span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace"><b>2. Documents</b></span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">We
            prefer to receive scanned documents (minimum 300 dpi) via email. If
            this is not convenient, documents can be posted to us with a pre-paid
            return envelope. Documents posted to the above address will be
            scanned and returned via the pre-paid envelope provided.</span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace"><b>3. Direct Contact</b></span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Your
            representative</span>
        <span style="font-family:'Courier New', Courier, monospace">({{$data['advisor']->name}})</span>
        <span style="font-family:'Courier New', Courier, monospace">can be contacted by
            WhatsApp, Viber or iMessage on</span>
        <span style="font-family:'Courier New', Courier, monospace">{{$data['advisor']->contact}}</span>
        <span style="font-family:'Courier New', Courier, monospace">however documents sent on these apps</span>
        <span style="font-family:'Courier New', Courier, monospace"><b>CANNOT</b></span>
        <span style="font-family:'Courier New', Courier, monospace">be used for official purpose and can only be used for a quick
            assessment to advise you. </span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">We
            will delete the files and will NOT use them under any circumstances
            other than for our internal processes to the purpose of making an
            immigration application.</span>
    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%"><br />
        <br />

    </p>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">Client
            Care Letter agreeing and contractually entering person’s name and
            signature</span>
    </p>

    <table style="width:100%">
        <tbody>
            <tr style="width:100%">
                <td style="width: 100%; text-align:center;vertical-align:bottom">
                    <span>{{$data['enquiry']->full_name_with_title}}</span>
                    <div style="width:90%;margin-top:4px;margin-bottom:4px;margin-right:auto;margin-left:auto;height:1px;background-color:black"></div>
                    <span>Your Name</span>
                </td>
                <td style="width: 100%; text-align:center;vertical-align:bottom">
                    <p><br></p>
                    <div style="width:90%;margin-top:4px;margin-bottom:4px;margin-right:auto;margin-left:auto;height:1px;background-color:black"></div>
                    <span>Your Signature</span>
                </td>
                <td style="width: 100%; text-align:center;vertical-align:bottom">
                    <p><br></p>

                    <div style="width:90%;margin-top:4px;margin-bottom:4px;margin-right:auto;margin-left:auto;height:1px;background-color:black"></div>
                    <span>Date</span>
                </td>
            </tr>
        </tbody>
    </table>


    <h1 style="page-break-before: always;text-align:left">
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>{{$data['company_info']->name}}</b></span>
        </span>
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="2" style="font-size: 11pt"><b>General Data Protection Regulation Consent – Terms and Conditions</b></span>
        </span>
    </h1>
    <ol>
        <li>
            <p align="justify" style="margin-bottom: 0.14in; line-height: 120%">
                <span style="font-family:'Courier New', Courier, monospace"><b>General Terms and Conditions</b></span>
            </p>
            <ol>
                <li>
                    <p style="margin-bottom: 0.14in; line-height: 120%">
                        <span style="font-family:'Courier New', Courier, monospace">Purpose
                            of the application:</span>
                    </p>
                </li>
                <li>
                    <p style="margin-bottom: 0.14in; line-height: 120%">
                        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->name}}</span>
                        <span style="font-family:'Courier New', Courier, monospace">
                            reserves the right to vary these Terms and Conditions or the
                            Consent at any time. The latest version of the Terms and Conditions
                            apply to all applications and will supersede previous Terms and
                            Conditions unless otherwise stated.</span>
                    </p>
                </li>
            </ol>
        </li>
        <li>
            <p style="margin-bottom: 0.14in; line-height: 120%">
                <span style="font-family:'Courier New', Courier, monospace"><b>Consent</b></span>
            </p>
            <ol>
                <li>
                    <p style="margin-bottom: 0.14in; line-height: 120%">
                        <span style="font-family:'Courier New', Courier, monospace">I
                            agree to provide </span>
                        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->name}}</span>
                        <span style="font-family:'Courier New', Courier, monospace">
                            and its advisor(s) with any relevant data (including personal data)
                            required by the Home Office or UK Visa and Immigration for the
                            ‘Purpose of the Application’ as stated in Paragraph 1.1.</span>
                    </p>
                </li>
                <li>
                    <p style="margin-bottom: 0.14in; line-height: 120%">
                        <span style="font-family:'Courier New', Courier, monospace">Where
                            any information or documentation relates to someone else or a Third
                            Party, I confirm that I have consulted and have received consent
                            from any Third Party to provide their data (including personal
                            data) to </span>
                        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->name}}</span>
                        <span style="font-family:'Courier New', Courier, monospace">
                            for the ‘Purpose of the Application’ as stated in Paragraph
                            1.1. I understand that information about the applicant may also
                            reveal information about me.</span>
                    </p>
                </li>
                <li>
                    <p style="margin-bottom: 0.14in; line-height: 120%">
                        <span style="font-family:'Courier New', Courier, monospace">I
                            agree for </span>
                        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->name}}</span>
                        <span style="font-family:'Courier New', Courier, monospace">
                            and its advisor to pass on the details provided by me to the
                            relevant authority such as the Home Office, visa issuance authority
                            or another relevant institution.</span>
                    </p>
                </li>
                <li>
                    <p style="margin-bottom: 0.14in; line-height: 120%">
                        <span style="font-family:'Courier New', Courier, monospace">I
                            confirm that the services provided by </span>
                        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->name}}</span>
                        <span style="font-family:'Courier New', Courier, monospace">
                            are non-refundable and binding on signing of these Terms and
                            Conditions.</span>
                    </p>
                </li>
                <li>
                    <p style="margin-bottom: 0.14in; line-height: 120%">
                        <span style="font-family:'Courier New', Courier, monospace">I
                            confirm that all the information and documentations that I have
                            currently provided or will provide is genuine and correct to the
                            best of my knowledge.</span>
                    </p>
                </li>
                <li>
                    <p style="margin-bottom: 0.14in; line-height: 120%">
                        <span style="font-family:'Courier New', Courier, monospace">I
                            understand that </span>
                        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->name}}</span>
                        <span style="font-family:'Courier New', Courier, monospace">
                            and its advisors may contact me in the future regarding the
                            ‘Purpose of the Application’ as stated in Paragraph 1.1.</span>
                    </p>
                </li>
                <li>
                    <p style="margin-bottom: 0.14in; line-height: 120%">
                        <span style="font-family:'Courier New', Courier, monospace">I
                            consent for </span>
                        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->name}}</span>
                        <span style="font-family:'Courier New', Courier, monospace">
                            to hold my data digitally and in paper form where applicable.</span>
                    </p>
                </li>
                <li>
                    <p style="margin-bottom: 0.14in; line-height: 120%">
                        <span style="font-family:'Courier New', Courier, monospace">I
                            understand that </span>
                        <span style="font-family:'Courier New', Courier, monospace">{{$data['company_info']->name}}</span>
                        <span style="font-family:'Courier New', Courier, monospace">
                            will store my data online in their server based either in the UK or
                            the EU.</span>
                    </p>
                </li>
            </ol>
        </li>
    </ol>
    <p style="margin-bottom: 0.14in; line-height: 120%">
        <span style="font-family:'Courier New', Courier, monospace">By
            signing below, I agree to all the Terms and Conditions listed above.</span>
    </p>
    <table style="width:100%">
        <tbody>
            <tr style="width:100%">
                <td style="width: 100%; text-align:center;vertical-align:bottom">
                    <span>{{$data['enquiry']->full_name_with_title}}</span>
                    <div style="width:90%;margin-top:4px;margin-bottom:4px;margin-right:auto;margin-left:auto;height:1px;background-color:black"></div>
                    <span>Your Name</span>
                </td>
                <td style="width: 100%; text-align:center;vertical-align:bottom">
                    <p><br></p>
                    <div style="width:90%;margin-top:4px;margin-bottom:4px;margin-right:auto;margin-left:auto;height:1px;background-color:black"></div>
                    <span>Your Signature</span>
                </td>
                <td style="width: 100%; text-align:center;vertical-align:bottom">
                    <p><br></p>

                    <div style="width:90%;margin-top:4px;margin-bottom:4px;margin-right:auto;margin-left:auto;height:1px;background-color:black"></div>
                    <span>Date</span>
                </td>
            </tr>
        </tbody>
    </table>


    <p style="margin-bottom: 0.14in; line-height: 120%; page-break-before: always">
        <span style="font-family:'Courier New', Courier, monospace">
            <span size="4" style="font-size: 14pt"><u><b>Useful
                        Links: </b></u></span>
        </span>
    </p>
    <ol>
        <li>
            <p style="margin-bottom: 0.14in; line-height: 120%"><a href="https://assets.publishing.service.gov.uk/government/uploads/system/uploads/attachment_data/file/903098/Approved_Secure_English_Language_Tests_22.7.2020_.pdf">
                    <span style="font-family:'Courier New', Courier, monospace">UKVI
                        APPROVED SECURE ENGLISH LANGUAGE TEST</span>
                </a></p>
        </li>
        <li>
            <p style="margin-bottom: 0.14in; line-height: 120%"><a href="https://www.gov.uk/government/publications/visa-regulations-revised-table/2020">
                    <span style="font-family:'Courier New', Courier, monospace">Visa
                        application fee</span>
                </a></p>
        </li>
        <li>
            <p style="margin-bottom: 0.14in; line-height: 120%">
                <span style="font-family:'Courier New', Courier, monospace">UK-Pre
                    departure TB clearance certificate from an <a href="https://www.gov.uk/tb-test-visa/countries-where-you-need-a-tb-test-to-enter-the-uk">approved
                        clinic</a></span>
                <span color="#0000ff"><u>
                        <span style="font-family:'Courier New', Courier, monospace">
                        </span>
                    </u></span>
            </p>
        </li>
        <li>
            <p style="margin-bottom: 0.14in; line-height: 120%"><a href="https://www.immigration-health-surcharge.service.gov.uk/checker/type">
                    <span style="font-family:'Courier New', Courier, monospace"><span style="background: #ffffff">Immigration
                            Health Surcharge (IHS) Fee</span></span>
                </a>
                <span color="#0000ff"><u>
                        <span style="font-family:'Courier New', Courier, monospace"><span style="background: #ffffff">
                            </span></span>
                    </u></span>
            </p>
        </li>
    </ol> --}}
</body>

</html>
