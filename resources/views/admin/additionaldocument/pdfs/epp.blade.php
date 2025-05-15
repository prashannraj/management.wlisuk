<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title></title>
    <meta name="generator" content="LibreOffice 6.4.6.2 (Linux)" />
    <meta name="author" content="Rupak Paudyal" />
    <meta name="created" content="2020-10-22T14:39:00" />
    <meta name="changed" content="2020-11-05T16:14:16.402325692" />
    <meta name="AppVersion" content="16.0000" />
    <meta name="DocSecurity" content="0" />
    <meta name="HyperlinksChanged" content="false" />
    <meta name="LinksUpToDate" content="false" />
    <meta name="ScaleCrop" content="false" />
    <meta name="ShareDoc" content="false" />
    <title> Sponsor document </title>


    <style>
        body {
            background: "white";
            font-family: "Open Sans";
        }

        p {
            font-size: 15px;
            color: black;
        }

        .classic-table {
            width: 100%;
            color: #000;
        }

        th,
        tr {
            color: black;
        }

        .box {
            border: 0.5px solid black;
            width: 100%;
            height: 400px;
            margin: 20px 0px;
        }

        .ml-4 {
            margin-left: 4em;
        }

        .cover p {
            font-size: 16px
        }

        li {
            font-size: 16px;
        }
    </style>
</head>

<body lang="en-US" link="#000080" vlink="#800000" dir="ltr">
@include('partials.page_number')

    @include('admin.partials.pdf_header',['company_info'=>$data['company_info'],'export'=>true])

    <div class='cover'>
        <br><br><br>
        <p style="text-align: center; font-size:18px;font-weight:bold">Date: {{$data['date']}}
            <br><br><br><br><br>
            {{$data['company_info']->name}}
            <br>
            and
            <br>
            {{$data['employee_name']}}
            <br><br><br>

            Employment Privacy Notice
        </p>


    </div>
    <p class="style" style="page-break-before:always"></p>
    <p lang="en-GB"><strong>{{$data['company_info']->name}} Privacy Policy</strong></p>
    <p lang="en-GB"><strong>INTRODUCTION</strong></p>
    <ol>
        <li>{{$data['company_info']->name}} is the trading name of {{$data['company_info']->name}} and
            is registered under company registration no. {{$data['company_info']->registration_no}}; with
            the registered (main) office at {{$data['company_info']->address}} where a list of Directors
            and other members of staff is available for inspection.</li>
        <li>{{$data['company_info']->name}} are registered with and regulated by {{$data['company_info']->regulated_by}} with the main office registered under {{$data['company_info']->regulation_no}}.</li>
        <li>{{$data['company_info']->name}} provide legal services only to clients above the age of 18 unless where an express consent has been provided by a person with parental responsibility who remains at all times liable to explain this Privacy Policy and the Terms of Use Agreement to their dependents.</li>
        <li>{{$data['company_info']->name}} conduct a non-stop surveillance of its office premises by way of CCTV for quality, safety and training purposes and retains video materials so obtained (where applicable).</li>
    </ol>
    <p lang="en-GB"><strong>COLLECTION OF PERSONAL DATA</strong></p>
    <ol start="6">
        <li>{{$data['company_info']->name}} collect personal data of all prospective and current employees for the purposes of legal compliance and providing services.</li>
    </ol>
    <ol start="7">
        <li>{{$data['company_info']->name}} also collect personal data of individuals other than employees where such data is provided by employees, who are authorised to disclose any such data, in the course of providing requested or contracted legal services or pursuant to statutory obligations.</li>
    </ol>
    <ol start="8">
        <li>{{$data['company_info']->name}} collect all forms of personal data which is required to effectively provide requested or contracted legal services or pursuant to statutory obligations and therefore may include, but not be limited to:</p>
            <ol type="a">
                <li>Identity;</li>
                <li>Contact;</li>
                <li>Finances;</li>
                <li>Health;</li>
                <li>Family;</li>
                <li>Employment;</li>
                <li>Criminal record;</li>
                <li>Immigration status.</li>
            </ol>
        </li>
    </ol>
    <ol start="9">
        <li>{{$data['company_info']->name}} collect prospective and current clients&rsquo; personal data by way of telephone, email, post, through its websites and in person.</li>
    </ol>
    <p lang="en-GB"><strong>ACCESS TO PERSONAL DATA</strong></p>
    <ol start="10">
        <li>Access to employees&rsquo; personal data stored by {{$data['company_info']->name}} is at all times restricted only to the current senior employees of {{$data['company_info']->name}}.</li>
    </ol>
    <ol start="11">
        <li>Access to employees&rsquo; personal data stored by {{$data['company_info']->name}} may be made from the main office and the branch office (where applicable) as well as remotely from other locations.</li>
    </ol>
    <ol start="12">
        <li>Access to employees&rsquo; personal data stored by {{$data['company_info']->name}} is at all times restricted only to the purposes of providing requested or contracted legal services and other statutory purposes such as anti-money-laundering checks or audits.</li>
    </ol>
    <ol start="13">
        <li>{{$data['company_info']->name}} allow current employees&rsquo; to access their personal data and obtain a copy thereof, free of charge, while their employment is ongoing.</li>
    </ol>
    <ol start="14">
        <li>{{$data['company_info']->name}} allow employees&rsquo; to update their personal data at any time by way of email (<strong>{{$data['company_info']->email}}</strong>), telephone ({{$data['company_info']->telephone}}), post or at its premises.</li>
    </ol>
    <p lang="en-GB"><strong>PROCESSING OF PERSONAL DATA</strong></p>
    <ol start="15">
        <li>{{$data['company_info']->name}} process personal data based on requested or contracted legal services or pursuant to statutory obligations including, but not be limited to, countering of money-laundering schemes.</li>
    </ol>
    <ol start="16">
        <li>{{$data['company_info']->name}} use collected personal data in the course of providing requested or contracted legal services for the purposes including, but not limited to:</p>
            <ol type="a">
                <li>Verifying their authenticity;</li>
                <li>Conducting required anti-money-laundering checks;</li>
                <li>Communicating with clients and other interested parties;</li>
                <li>Preparing legal documentation;</li>
                <li>Seeking advice from 3<sup>rd</sup>&nbsp;parties;</li>
                <li>Responding to complaints.</li>
            </ol>
        </li>
    </ol>
    <p lang="en-GB"><strong>STORAGE OF PERSONAL DATA</strong></p>
    <ol start="17">
        <li>{{$data['company_info']->name}} store clients&rsquo; personal data in the form of soft copy and hard copy.</li>
    </ol>
    <ol start="18">
        <li>Soft copy of employees&rsquo; personal data is stored securely on {{$data['company_info']->name}} computers and an online cloud.</li>
    </ol>
    <ol start="19">
        <li>Hard copy of employees&rsquo; personal data is stored securely at the {{$data['company_info']->name}} office premises and an additional storage location.</li>
    </ol>
    <p lang="en-GB"><strong>SHARING OF PERSONAL DATA</strong></p>
    <ol start="20">
        <li>{{$data['company_info']->name}} may share employees&rsquo; personal data with 3<sup>rd</sup>&nbsp;parties only where it is required to effectively provide contracted legal services or pursuant to statutory obligations, which may include, but not be limited to:</p>
            <ol type="a">
                <li>HM Courts &amp; Tribunals;</li>
                <li>The Home Office, UKVI</li>
                <li>HM Revenue and Customs (HMRC);</li>
                <li>The Office of the Immigration Services Commissioner (OISC);</li>
                <li>External auditors;</li>
                <li>Company Chartered certified accountant(s);</li>
                <li>Legal counsels;</li>
                <li>Other parties to legal proceedings.</li>
            </ol>
        </li>
    </ol>
    <ol start="21">
        <li>{{$data['company_info']->name}} do not at any time share employees&rsquo; personal data with 3<sup>rd</sup>&nbsp;parties for marketing or any other commercial purposes.</li>
    </ol>
    <p lang="en-GB"><strong>DISPOSAL OF PERSONAL DATA</strong></p>
    <ol start="22">
        <li>{{$data['company_info']->name}} return all of employees&rsquo; original documentation upon scanning/copying.</li>
    </ol>
    <ol start="23">
        <li>{{$data['company_info']->name}} store employees&rsquo; personal data for a period of 6 years after the termination of employment/contract, according to the requirements imposed by the HMRC.</li>
    </ol>
    <ol start="24">
        <li>{{$data['company_info']->name}} allow former employees&rsquo; to obtain, within 7 days of making a request, a copy of their personal data anytime during a period of 6 years after the termination of employment/contract.</li>
    </ol>
    <ol start="25">
        <li>{{$data['company_info']->name}} may transfer a copy of former employees&rsquo; personal data after the end of their employment/contract of their file to other organisations where such a transfer is requested on behalf of such former employee&rsquo;s.</li>
    </ol>
    <ol start="26">
        <li>{{$data['company_info']->name}} delete all personal data of all former employees&rsquo; after 6 years of the termination of employment.</li>
    </ol>
    <p lang="en-GB"><strong>FINAL REMARKS</strong></p>
    <ol start="27">
        <li>{{$data['company_info']->name}} have designated <b>{{$data['director']->full_name}}</b>, the Managing Director or a senior manager
            of {{$data['company_info']->name}}, as the <b>Data Protection Officer (DPO)</b> being responsible for the protection of employees&rsquo; personal data.</li>
    </ol>
    <ol start="28">
        <li>Employees of {{$data['company_info']->name}} who are not satisfied with the manner in which their personal data is collected, stored, used or retained may in the first place submit a complaint to the Data Protection Officer (DPO) at&nbsp;{{$data['director']->email}}.</li>
        <li>Employees of {{$data['company_info']->name}} who are not satisfied with the manner in which their personal data is collected, stored, used or retained and who fail to receive satisfactory response from the Data Protection Officer (DPO) have a right to submit an official complaint to the Information Commissioner&rsquo;s Office (<a href="https://ico.org.uk/"><strong>https://ico.org.uk/</strong></a>).</li>
    </ol>
    <ol start="30">
        <li>By requesting the provision of legal services from {{$data['company_info']->name}}, or contracting with {{$data['company_info']->name}} for the same, prospective and current employees of {{$data['company_info']->name}} consent to the collection, storage, use and retention of their personal data for a period of up to 6 years on the terms of this Privacy Policy.</li>
    </ol>
    <p lang="en-GB"><strong>The effective date of this Privacy Policy is 6th June 2018.</strong></p>
    <p lang="en-GB" style="page-break-before: always;"><strong>I {{$data['employee']->full_name}} do hereby confirm
            I have read the above Employee Privacy Policy and consent {{$data['company_info']->name}} to hold the information I have provided in line with The&nbsp;Data Protection&nbsp;Act&nbsp;2018&nbsp;(GDPR).</strong></p>

    <div style="width:100%">
        <div style="width:50%;float:left">
            <p style="text-align: center;">
                ----------------------------------------<br />
                Signature
            </p>

        </div>
        <div style="width:50%;float:right">
            <p style='text-align: center;'>
                ----------------------------------------<br />
                Date
            </p>

        </div>
    </div>

</body>

</html>