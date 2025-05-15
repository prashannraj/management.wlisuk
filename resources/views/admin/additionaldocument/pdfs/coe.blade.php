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

        .cover p{
            font-size:16px
        }

        li{
            font-size:16px;
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

        Employment Agreement
         </p>
        
        
</div>
<p class="style" style="page-break-before:always"></p>
    <h2 lang="en-GB" style="text-align: center;"><u>{{$data['employee']->full_name}}</u><u>&rsquo;s Employment Contract</u></h2>
    <p lang="en-GB">Date: {{$data['date']}}</p>
    <p lang="en-GB">This is your {{$data['company_info']->name}} employment contract for the role of {{$data['employment_info']->job_title}}.</p>
    <p lang="en-GB">The main terms and conditions on which {{$data['company_info']->name}} employs you, {{$data['employee']->full_name}} are set out in this Agreement (which complies with Section One of the Employment Rights Act 1996). The Agreement is effective from the date that it is signed by both you and {{$data['company_info']->name}}.</p>
    <p lang="en-GB">It supersedes any and all other agreements relating to any relationship between you ({{$data['employee']->full_name}}) and {{$data['company_info']->name}}.</p>
    <p lang="en-GB">Throughout this Agreement, You ({{$data['employee']->full_name}}) of {{$data['address']}} are referred to as the Employee, and You or Your.</p>
    <p lang="en-GB">We, {{$data['company_info']->name}} (company number {{$data['company_info']->registration_no}}; and registered office at {{$data['company_info']->address}}) are called the Company, We, Us and Our, in this Agreement.</p>
    <ol>
        <li>
            <strong lang="en-GB">Key details relating to your employment with {{$data['company_info']->name}}</strong>
        </li>
    </ol>
    <ol>
        <ol>
            <li>
                Your job title is <strong>{{$data['employment_info']->job_title}}</strong>. Please ensure that you use it consistently and accurately in all communications relating to your employment with us.
            </li>
        </ol>
    </ol>
    <ol>
        <ol start="2">
            <li>
                Your employment start date with us is {{$data['employment_info']->start_date_formatted}}.</li>
        </ol>
    </ol>
    <ol>
        <ol start="3">
            <li>
                Your normal place of work is <b>{{$data['employment_info']->place_of_work}}</b> or any other premises to which we may move or to which we may reasonably direct you, within the {{$data['employment_info']->region}}. You will not be required to work outside the UK for any continuous period of more than one month during the term of your employment.</li>
        </ol>
    </ol>
    <ol>
        <ol start="4">
            <li>
                Your normal working hours are {{$data['employment_info']->working_hours}} {{$data['employment_info']->working_time}} inclusive. You&rsquo;re entitled to a one-hour lunch break {{$data['employment_info']->working_days}} {{$data['employment_info']->working_time}} (lunch breaks do not apply to employee working part-time less than 5 hours on any working days). We may request that you work additional hours from time to time, including a weekend or during public holidays, if we consider this is necessary for the proper performance of your duties. No extra remuneration is applicable to these additional hours worked.</li>
        </ol>
    </ol>
    <ol>
        <ol start="5">
            <li>
                We will pay you a basic salary of GBP {{$data['employment_info']->salary}} per 
                {{$data['employment_info']->salary_arrangement}}. This salary will:</li>
        </ol>
          <ol type="a" class='ml-4'>
        <li>
            accrue from day to day
        </li>
        <li>
            be payable monthly in arrears on or around last working day of each calendar month
        </li>
        <li>
            be paid directly by us into your designated bank account, the details of which we will ask you to provide to us during your first week of working for us.
        </li>
        <li>
            be reviewed by us annually. Although there is no-obligation on us to increase your salary, as part of this review, we may decide, in our discretion, to increase your basic salary. If we do so, this will not affect any other terms of this Agreement
        </li>
        <li>
            not be subject to any review after either you or we have given notice to terminate this employment
        </li>
    </ol>
    </ol>
  
    <ol>
        <ol start="6">
            <li>
                We are entitled to deduct from your salary or from any other payments due to you, any money that you may owe to <strong>{{$data['company_info']->name}}</strong> at any time.</li>
        </ol>
    </ol>
    <ol>
        <ol start="7">
            <li>
                This is the first time that you have been employed by us and so there is no relevant period of continuous employment applicable to the terms of this Agreement.</li>
            <li>
                Probation period of <b>{{$data['employment_info']->probation_period}}</b>, which starts on the date specified at clause 1.2 above and ends on <b>{{$data['employment_info']->probation_end_date_formatted}}</b>. During this probation period:</li>
        </ol>
    </ol>
    <ol type="a" class="ml-4">
        <li>
            we will monitor your progress and how well you&rsquo;re carrying out your duties, so that we may assess and/or confirm your capability and suitability for the role, and
        </li>
        <li>
            your employment may be terminated by us at any time on one week&rsquo;s notice in advance of the termination date that we give you.
        </li>
    </ol>
    <ol>
        <ol start="9">
            <li>
                We also have the right to decide, in our discretion, to extend your probation period if we are unable to reach a positive conclusion about your suitability for the role during the probation period set out at clause [1.8].]</li>
            <li>
                You may join the registered pension scheme that {{$data['company_info']->name}} has in place 
                provided that you fulfil certain eligibility criteria and the scheme rules as 
                amended from time to time. Full details of the scheme are available 
                from <b>{{$data['employment_info']->supervisor}}</b>.</li>
        </ol>
    </ol>
    <ol>
        <ol start="11">
            <li>
                There is no trade union or collective agreement that directly affects your employment.</li>
        </ol>
    </ol>
    <ol start="2">
        <li>
            <strong>Your duties as a {{$data['company_info']->name}} employee</strong></li>
    </ol>
    <ol>
        <ol>
            <li>
                On a day-to-day basis, you must report to your line manager or company manager.</li>
        </ol>
    </ol>
    <ol>
        <ol start="2">
            <li>
                Your duties are contained in the job description attached at Annex 1 and you are required to carry them out to what we consider to be an acceptable standard. This job description does not form part of your contract of employment.</li>
        </ol>
    </ol>
    <ol>
        <ol start="3">
            <li>
                The list of duties at Annex 1 is not exhaustive or inflexible and we may reasonably request that you carry out other duties for {{$data['company_info']->name}} for time to time.</li>
        </ol>
    </ol>
    <ol>
        <ol start="4">
            <li>
                You warrant that you are fully entitled to work for us and to carry out your duties in this role, including working in the UK, and that no additional approvals are required for you to do so. You agree to notify us, specifically to {{$data['employment_info']->supervisor}} or HR department immediately if any aspect of this entitlement changes while you are working for us.</li>
        </ol>
    </ol>
    <ol start="2">
        <ol start="5">
            <li>
                You may not work for anyone similar services provider as us during your employment with us.</li>
        </ol>
    </ol>
    <ol start="2">
        <ol start="6">
            <li>
                While they do not form part of this Agreement, you must always comply with our rules, policies and procedures in force from time to time, including the Company&rsquo;s policies on the use of email, the internet and computers, and health and safety as set out in the Staff Handbook. These rules, policies, procedures and Handbook may be altered by us in our discretion, when we consider it necessary to do so. {{$data['company_info']->name}} requires all its staff to take the safety of our working conditions very seriously and to co-operate with {{$data['company_info']->name}} to ensure this and to avoid any action that might place the health, safety, and/or welfare of themselves and others at risk. Please ensure you have read and understood these policies and their related rules.</li>
        </ol>
    </ol>
    <ol start="2">
        <ol start="7">
            <li>
                You must keep any records that we request and permit any monitoring or restrictions of your working time as we require.</li>
        </ol>
    </ol>
    <ol start="3">
        <li>
            <strong>Holidays</strong></li>
    </ol>
    <ol start="3">
        <ol>
            <li>
                In addition to normal public holidays, your holiday entitlement is [20] days if employed full time and 10 days if employed part-time&rsquo; paid holiday in each holiday year. {{$data['company_info']->name}}&rsquo;s holiday year runs from 1 January and 31 December inclusive. (If you start or leave our business during this holiday year, your entitlement during that year will be pro-rated and rounded up to the nearest half day.) You accrue your holiday entitlement on a pro-rata basis throughout each holiday year.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="2">
            <li>
                {{$data['company_info']->name}} will increase your holiday entitlement by one day for each complete year of continuous employment, up to a maximum of 30 days for full time and 15 days for a part-time employment in any holiday year.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="3">
            <li>
                If we need you to work on a public holiday, we will also give you an additional day of holiday to replace that day off.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="4">
            <li>
                We strongly encourage all our staff to take holidays and we always endeavour to balance the operational needs of the business with your entitlement to take time off. So that we can achieve this balance and ensure that holidays are taken in a manner that is workable for the business and all your colleagues, holidays must be requested and pre- approved by {{$data['director']->full_name}} or HR/accounts departments. We may require you to take holiday on specific days that we will notify you in advance.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="5">
            <li>
                Where you have not taken all your holiday entitlement for reasons other than sickness absence or statutory family-related leave, we will agree to you carrying over a maximum of five days untaken holiday entitlement in one holiday year to the next one. Carry-over requests must be pre-approved by the Line Manager and you must take those days within the first six months of the new holiday year. If the carried over days have not been taken by the end of those six months, your entitlement to take them will expire.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="6">
            <li>
                If you have been unable to take your full holiday entitlement due to sickness absence or statutory family-related leave, you may carry-over a maximum of 20 days of holiday entitlement in any holiday year.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="7">
            <li>
                The only circumstances where we will pay you instead of you taking your holiday entitlement will be where your employment has been terminated by you or by us. {{$data['company_info']->name}} calculates that entitlement as 1/260 of your salary for each untaken day of your entitlement. If you&rsquo;ve exceeded your accrued holiday entitlement at the date your employment with us terminates, {{$data['company_info']->name}} is permitted to deduct the excess holiday pay from any payment that we are due to make to you. (Deductions will also be calculated on the same basis: at 1/260 of your salary for each excess day.)</li>
        </ol>
    </ol>
    <ol start="4">
        <li>
            <strong>Expenses</strong></li>
    </ol>
    <ol start="3">
        <ol>
            <li>
                All expenses incurred by you in the course of carrying out your employment duties should be pre-approved by the Line Manager or a company manager or alternatively, another director of our business. If, exceptionally, it&rsquo;s not practically possible to gain pre-approval for an expense, {{$data['company_info']->name}} will reimburse those expenses reasonably incurred by you in performing your duties.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="2">
            <li>
                {{$data['company_info']->name}} aims to reimburse all expenses incurred by you in compliance with clause 4.1 above, within 7 days of you presenting VAT receipts or other adequate evidence of an expense that you have reasonably incurred while acting for our business. You must present appropriate evidence of your payment for us to be able to reimburse your expense.</li>
        </ol>
    </ol>
    <ol start="5">
        <li>
            <strong>Absence because of sickness</strong></li>
    </ol>
    <ol start="5">
        <ol>
            <li>
                You can find the details of how we generally handle sickness absence and sick pay in our absence management policy located at employee handbook.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="2">
            <li>
                If you fall sick or suffer an injury and you can&rsquo;t come in to work, please let your manager or supervisor know that you won&rsquo;t be working as soon as possible on the first day that you intend to be absent.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="3">
            <li>
                {{$data['company_info']->name}} has a self-certification form for sickness absence that you can get from your line manager via email and you must complete this form when you return to work.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="4">
            <li>
                If your sickness or injury causes you to be absent for seven or more consecutive calendar days, you must obtain and provide to us a certificate explaining your absence, including its likely duration, from your doctor. You will need to obtain further certificates from your doctor if your absence continues for longer than the period indicated in the original doctor&rsquo;s certificate. ({{$data['company_info']->name}} does not cover the cost of any charge for obtaining this certificate.)</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="5">
            <li>
                If we require it, you agree to consent to a medical examination by a doctor nominated by us. We will cover the expense of this examination. You also agree to disclose to {{$data['company_info']->name}} any medical report produced as a result of this examination and that {{$data['company_info']->name}} can talk to the relevant doctor about the content of this report.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="6">
            <li>
                You will be eligible for statutory sick pay (SSP) if you satisfy the relevant requirements. Details of these can be found in {{$data['company_info']->name}}&rsquo;s absence management policy. Your qualifying days for SSP purposes are Monday to Sunday or the contracted hours during these days.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="7">
            <li>
                On successful completion of your probation period, and at the sole discretion of {{$data['company_info']->name}}, you may benefit from Company Sick Pay (CSP). Again, you can find details of how we calculate and handle this in our [absence management policy]. Any CSP paid to you will include (and not be additional to) your entitlement to SSP for the same period of sickness absence. Subject to the provision of satisfactory evidence of the reason for your absence, the maximum entitlement to CSP, at {{$data['company_info']->name}}&rsquo;s discretion, will be [20] days at full salary and [20] days at half salary per year for full time employee and will be [10] days at full salary and [10] days at half salary per year for part time employee .</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="8">
            <li>
                If your sickness absence is due to an injury or other health or medical condition caused by a third party, you must notify your supervisor or manager immediately and provide all information and co-operation as we may reasonably request, so that we may consider whether to take legal proceedings as a result and, if we decide to start legal proceedings, you agree to continue this co-operation to support our action.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="9">
            <li>
                In the circumstances described at clause [5.8] above, and/or if you decide to take your own legal action, you are not entitled to double payment of compensation for an incapacity causing sickness absence or other consequences. This means that where you receive compensation from the responsible third party for your loss of earnings during the period where you suffer this injury, we have the right to recover from you the amount of sick pay that we have been paying you, minus any costs that you&rsquo;ve incurred in connection with the recovery of this compensation (provided that the amount to be refunded to us shall not exceed the total amount paid to you by {{$data['company_info']->name}} in respect of the period of absence. This repayment by you to us is due once you receive the compensation payment and includes any interest on the recovered amount.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="10">
            <li>
                If you are absent on full pay according to any of the relevant terms of this Agreement, your pension contributions by {{$data['company_info']->name}} will continue as normal. If you are being paid SSP or reduced pay during this period of absence, the level of contributions may continue, depending on the relevant pension scheme rules in force at the time of your sickness absence.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="11">
            <li>
                {{$data['company_info']->name}} is not prevented from terminating this Agreement even when termination would or might cause you to lose any entitlement to sick pay or other benefits.</li>
        </ol>
    </ol>
    <ol start="6">
        <li>
            <strong>Confidential Information</strong></li>
    </ol>
    <ol start="3">
        <ol>
            <li>
                Except in the proper performance of your duties (or as required by law), you will not, either during your, employment or at any time after the termination of your employment, without the prior written approval of {{$data['company_info']->name}}, use Confidential Information for your own benefit, or for the benefit of any other person, firm, company or organisation (other than {{$data['company_info']->name}}) or directly or indirectly disclose Confidential Information to any person (other than any person employed/engaged by the Company whose province it is to have access to that Confidential Information).</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="2">
            <li>
                Within this Agreement, we agree that:</p>
                <ol type="a">
                    <li>
                        &lsquo;<strong>Confidential Information</strong>&rsquo; means: all information of a confidential or commercially sensitive nature and includes, but is not limited to, information in any format and however presented, stored or recorded, relating to {{$data['company_info']->name}}&rsquo;s business, such as financial plans, forecasts and all financial and accounting records, minutes of meetings and consequent action plans, business plans and strategic reviews, pricing, sales and costs information, discount programmes, marketing plans, surveys and statistical analysis, research and development projects and reports, lists of previous, current and prospective customers, suppliers, agents, distributors and/or licensees, personal data relating to workers, customers, suppliers and other third parties whose data is controlled or processed by {{$data['company_info']->name}}, customer accounts, proposals and negotiations, trade secrets, recipes and formulae, software code, systems architecture, Inventions, all unpublished intellectual property, including designs, drawings and databases and know-how, {{$data['company_info']->name}}&rsquo;s employees and officers and of the remuneration and other benefits paid to them, any incident or investigation relating to our operations or business, and including, without limitation, information that you create, develop, receive or obtain in connection with your engagement by {{$data['company_info']->name}} pursuant to this Agreement, whether or not such information is identified to you in any manner as confidential;
                    </li>
                    <li>
                        <strong>Inventions: </strong>means anything devised and/or created by {{$data['company_info']->name}}, whether an idea, process, product, system, or programme, for example, and regardless of whether it is patented or patentable, or otherwise capable of protection by registration and/or whether it is devised or created in the UK or abroad. It need not be formally recorded in any given format and might be represented by any one or combination of designs, images, plans or drawings, code, specifications, written or recorded narrative, for example; and
                    </li>
                    <li>
                        {{$data['company_info']->name}}<strong> Property </strong>: means all documents, books, manuals, materials, records, correspondence, papers and information (on whatever media and wherever located) relating to the business or affairs of the Company or its clients and business contacts, and any equipment, keys, hardware or software provided for your use by the Company during your employment, and any data or documents (including copies) produced, maintained or stored by you on your or the Company&rsquo;s computer systems or other electronic equipment during your employment.
                    </li>
                </ol>
            </li>
            <li>
                You acknowledge that during your employment you will have access to Confidential Information and in recognition of this, you agree that while employed by us you will:
                <ol type="a">
                    <li>
                        agree to the restrictions in clause 6.1
                    </li>
                    <li>
                        use your best endeavours to prevent the unauthorised publication or disclosure by third parties of any Confidential Information; and
                    </li>
                    <li>
                        not make (otherwise than for the benefit of {{$data['company_info']->name}}) any notes, records, sound recordings (in any format), computer programs, photographs, imprints, screen shots, or any other form of record (whether electronic or paper) relating to any matter within the scope of the business of {{$data['company_info']->name}} or concerning any of the dealings or affairs of {{$data['company_info']->name}}.
                    </li>
                </ol>
            </li>
            <li>
                The restrictions contained in this clause will not apply to any Confidential Information or other information that (otherwise than through your default) becomes available to, or within knowledge of the public, or to information disclosed for the purpose of making in good faith a protected disclosure within the meeting of Part IVA of the Employment Rights Act 1996, or to a relevant pay disclosure made in compliance with section 77 of the Equality Act 2010.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="5">
            <li>
                {{$data['company_info']->name}} Property is and always remains the property of {{$data['company_info']->name}} and, at any stage during your employment, you will promptly on request return to us all and any {{$data['company_info']->name}} Property in your possession.</li>
        </ol>
    </ol>
    <ol start="7">
        <li>
            <strong>Data protection and monitoring</strong></li>
    </ol>
    <ol start="3">
        <ol>
            <li>
                You acknowledge that we will collect, hold and process personal data relating to you. We have set out in detail the types of personal data that {{$data['company_info']->name}} will collect and process about you, the purposes for which it processes the personal data relating to employees, the lawful reason for which it is processing personal data and an explanation of the rights that you may exercise in relation to your personal data, amongst other matters, in our Privacy Notice for employees, workers and contractors (<strong>Privacy Notice)</strong>. {{$data['company_info']->name}}&rsquo;s current Privacy Notice is available from {{$data['director']->full_name}}.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="2">
            <li>
                <strong>A copy of the Privacy Notice has been provided to you with this Agreement and you agree to return a signed version of the Notice to the company manager as evidence that you have received a copy of it and you </strong><strong>have </strong><strong>read and understood it.</strong></li>
            <li>
                You must comply with our Data Protection Policy and all laws and regulations relating 
                to data protection when processing personal data during the course of employment.
                 The current Data Protection Policy is available from <b>{{$data['director']->full_name}}</b> 
                 and this Data Protection Policy may be updated from time to time.</li>
        </ol>
    </ol>
    <ol start="3">
        <ol start="4">
            <li>
                In addition to the Data Protection Policy, there are a number of other policies that relate to {{$data['company_info']->name}}&rsquo;s compliance with, and obligations under, data protection laws and regulations. You must comply with these policies, including those relating to Computers, Phones and Other Devices Policy, Social Media, emails, websites and management software.</li>
        </ol>
    </ol>
    <p lang="en-GB" style="font-weight:bold">Any failure by you to comply with the Data Protection Policy or any of our other polices 
        listed in this section may result in disciplinary action being taken, which may include dismissal for gross misconduct.</p>
        <ol start="3">
            <ol start="5">
                <li>
                    Our systems enable us to monitor telephone, email, voicemail, internet and other communications. So that we can carry out our legal obligations as an employer (such as ensuring your compliance with our IT-related policies), and for other business reasons, {{$data['company_info']->name}} may monitor use of systems including the telephone and computer systems, and any personal use of them, by automated software or otherwise. Monitoring is only carried out to the extent permitted or as required by law and as necessary and justifiable for business purposes.</li>
            </ol>
        </ol>
        <ol start="8">
            <li>
                <strong>Intellectual Property</strong></li>
        </ol>
        <ol start="3">
            <ol>
                <li>
                    Within this Agreement, we agree that:
                    <ol type="a">
                        <li>
                            <strong>Intellectual Property: </strong>means all legally recognised intellectual property rights,
                            including for example, any registered or unregistered, trade mark, copyright, design, patent, trading name,
                            goodwill, get-up, or know-how, as well as the right to enforce those rights in law in order to protect their
                            scope and the ownership of them. These rights include, but are not limited to, rights in software code
                            and databases, to the protection of confidential information (e.g. know-how and trade secrets),
                            to defend against passing off or unfair competition, as well as all rights to apply for
                            protection of these and newly created, future rights, renewals and extensions, and to claim
                            priority of rights where expansion of any of those rights is sought in other countries.
                        </li>
                        <li>
                            <strong>Inventions: </strong>has the meaning given at clause 6.2(b) above.
                        </li>
                    </ol>
                </li>
            </ol>
        </ol>
        <ol start="3">
            <ol start="2">
                <li>
                    You agree to give {{$data['company_info']->name}} full
                    written details of all Inventions and of all works embodying
                    Intellectual Property Rights made wholly or partially by you at
                    any time during your employment that relate to, or are reasonably
                    capable of being used in, our business. You acknowledge that all Intellectual
                    Property Rights subsisting (or that may in the future subsist) in all such Inventions
                    and works shall automatically, on creation, vest in {{$data['company_info']->name}}
                    absolutely. To the extent that they do not vest automatically, you hold them on trust
                    for {{$data['company_info']->name}}. You agree promptly to execute all documents and do
                    all acts as may, in our opinion, be necessary to give effect to this clause.</li>
            </ol>
        </ol>
        <ol start="3">
            <ol start="3">
                <li>
                    This Agreement also obliges you irrevocably to waive all moral rights under the Copyright, Designs and Patents Act 1988 (and all similar rights in other jurisdictions) that you have or will have in any existing or future works referred to in this clause.</li>
            </ol>
        </ol>
        <ol start="3">
            <ol start="4">
                <li>
                    You also irrevocably appoint {{$data['company_info']->name}} to be your attorney, in your name and on your behalf to execute documents, use your name and do all the things that are necessary or desirable for {{$data['company_info']->name}} to obtain for itself, or its nominee, the full benefit of this clause. A certificate in writing, signed by any director or the secretary of {{$data['company_info']->name}}, that any instrument or act falls within the authority conferred by this Agreement, shall be conclusive evidence that such is the case so far as any third party is concerned.</li>
            </ol>
        </ol>
        <ol start="3">
            <ol start="5">
                <li>
                    All materials, of whatever nature and however stored or accessed, which are provided by {{$data['company_info']->name}}for your use as an employee, remain at all times the property of {{$data['company_info']->name}}.</li>
            </ol>
        </ol>
        <ol start="9">
            <li>
                <strong>Termination and Notice Period</strong></li>
        </ol>
        <p lang="en-GB">9.1. After successful completion of the probationary period referred to in clause 1.8, the prior written notice required from you or {{$data['company_info']->name}} to terminate your employment shall be as follows:</p>
        <ol type="a">
            <li>
                in the first [five] years of continuous employment: [one] calendar months&rsquo; notice; and
            </li>
        </ol>
        <ol start="2" type="a">
            <li>
                after [five] complete years: [one] week for each complete year of continuous employment up to a maximum of [twelve] weeks' notice].
            </li>
        </ol>
        <ol start="9">
            <ol start="2">
                <li>
                    We may at our sole discretion, terminate your employment without notice and make a payment of basic salary in lieu of notice (<strong>Payment in Lieu</strong>). For the avoidance of doubt, the Payment in Lieu shall not include any element in relation to:</li>
            </ol>
        </ol>
        <ol start="3">
            <ol>
                <ol type="a">
                    <li>
                        any bonus or commission payments that might otherwise have been due during the period for which the Payment in Lieu is made;
                    </li>
                    <li>
                        any payment in respect of benefits that you would have been entitled to receive during the period for which the Payment in Lieu is made; and
                    </li>
                    <li>
                        any payment in respect of any holiday entitlement that would have accrued during the period for which the Payment in Lieu is made.
                    </li>
                </ol>
            </ol>
        </ol>
        <ol start="9">
            <ol start="3">
                <li>
                    {{$data['company_info']->name}} may pay any sums due under clause 9.2 in equal monthly instalments until the date on which the notice period referred to in clause 9.1 would have expired, had notice been given.</li>
            </ol>
        </ol>
        <ol start="9">
            <ol start="4">
                <li>
                    Nothing in this Agreement will prevent us from terminating your employment, without notice or payment in lieu of notice, if you commit a serious breach of your obligations as an employee (including for reasons of gross misconduct), or if you cease to be entitled to work in the United Kingdom.</li>
            </ol>
        </ol>
        <ol start="9">
            <ol start="5">
                <li>
                    Once notice to terminate your employment has been given by either party, we may place you on Garden Leave for the whole or any part of the remainder of your notice period. Within this Agreement, Garden Leave means that we have the right to isolate you from our business activities, but retain you as a paid employee, until your notice period has expired. Since you remain {{$data['company_info']->name}}&rsquo;s employee during any period of Garden Leave, you may not work for another person during this period.</li>
            </ol>
        </ol>
        <ol start="9">
            <ol start="6">
                <li>
                    During any period of Garden Leave:
                    <ol>
                        <li>
                            we will be under no-obligation to provide any work to you and may revoke
                            any powers that you hold on {{$data['company_info']->name}}&rsquo;s behalf;
                        </li>
                        <li>
                            we may require you to carry out alternative duties or to only perform such specific duties as are expressly assigned to you, at such location (including your home) as we may decide;
                        </li>
                        <li>
                            you will remain an employee of {{$data['company_info']->name}} and continue to be bound by the terms of this Agreement (including any implied duties of good faith and fidelity);
                        </li>
                        <li>
                            you must ensure that your supervisor or company manager knows where you are and will be and how you can be contacted during each working day (except during any periods taken as holiday in the usual way);
                        </li>
                        <li>
                            we may exclude you from any of our premises, or premises from which we conduct our business; and
                        </li>
                        <li>
                            we may require you not to contact or deal with (or attempt to contact or deal with) any officer, employee, consultant, client, customer, supplier, agent, distributor, shareholder, adviser or other business contact of {{$data['company_info']->name}}.
                        </li>
                    </ol>
                </li>
                <li>
                    If you are placed on Garden Leave, you will continue to be paid any salary or commission already earned and to receive all benefits until the end of the period of notice.</li>
            </ol>
        </ol>
        <ol start="9">
            <ol start="8">
                <li>
                    On termination of your employment, you shall cease to represent yourself as being in any way connected to {{$data['company_info']->name}}.</li>
            </ol>
        </ol>
        <ol start="9">
            <ol start="9">
                <li>
                    If you leave without giving or serving the proper period of notice, we won&rsquo;t pay you for any unworked period of notice. In these circumstances, we are also entitled to make a further deduction from any monies that would otherwise be payable to you, to cover any loss or cost reasonably incurred by the Company, in good faith, due to your failure to properly work your notice (e.g. the cost of recruiting a replacement at short notice). The amount the Company will deduct will be restricted on the following basis:
  
    <ol>
        <li>
            it will not exceed the actual loss suffered by the Company because of your failure
            to properly work your notice, and
        </li>
        <li>
            it will not exceed your daily rate of pay for the days not worked during the notice period.
        </li>
    </ol>
    </li>
    </ol>
    </ol>
    <ol start="10">
        <li>
            <strong>Your obligations on termination of your employment</strong></li>
    </ol>
    <ol start="10">
        <ol>
            <li>
                However, your employment with us is terminated, you will:</li>
        </ol>
    </ol>
    <ol start="11">
        <ol>
            <ol>
                <li>
                    return to us immediately, all Confidential Information and Company Property within your possession or control.
                </li>
            </ol>
        </ol>
    </ol>
    <p lang="en-GB">Please deliver these to your line manager unless we direct you otherwise</p>
    <ol start="12">
        <ol>
            <ol start="2">
                <li>
                    in compliance with our data protection and data retention policies
                    contained within our data protection policy, permanently and comprehensively
                    delete or destroy (as appropriate) all information relation to
                    {{$data['company_info']->name}}, however it is stored, manifested or
                    recorded (including on any magnetic or optical disk, memory, cloud-based
                    storage solution, or other device or system), and any related materials
                    derived from these sources, which are in your possession or control outside
                    {{$data['company_info']->name}}&rsquo;s premises and normal places of work.
                    Please note that the contact details for {{$data['company_info']->name}}&rsquo;s
                    business contacts count as Confidential Information and so you must also delete
                    these from any personal, social or professional networking accounts too.
                </li>
                <li>
                    If we ask you to do so, you agree to provide a signed statement confirming that you have fully complied with your obligations within clause [10.1] above and to include reasonable evidence of this compliance, if we additionally request this.
                </li>
            </ol>
        </ol>
    </ol>
    <ol start="11">
        <li>
            <strong>Restrictions that apply to you once your employment has terminated</strong></li>
    </ol>
    <ol start="10">
        <ol>
            <li>
                The definitions and rules of interpretation set out below apply to this Agreement:
                <ol>
                    <li>
                        Definitions:
                    </li>
                </ol>
            </li>
        </ol>
    </ol>
    <p lang="en-GB"><strong>Restricted Business</strong>: means any aspect of {{$data['company_info']->name}}&rsquo;s business activities with which you were involved to a material extent in the twelve months before your termination date.</p>
    <p lang="en-GB"><strong>Restricted</strong><strong>Customer: </strong>means any business entity or person who, during the twelve months before termination, was one of Name of your business&rsquo;s customer or target customer, with whom you had contact or about whom you became aware or were informed while you were Name of your business&rsquo;s employee.</p>
    <p lang="en-GB"><strong>Restricted Person</strong>: means any individual, (including Name of your business&rsquo;s employees, workers, or any person who was otherwise engaged by Name of your business):who could materially damage Name of your business&rsquo;s business interests if they were to become engaged, in any manner, with any Restricted Business, and with whom you interacted while you were a Name of your business employee in the twelve months before your termination date.</p>
    <p lang="en-GB"><strong>Restricted Partner</strong>: means any business entity or person who, during the twelve months before termination, was one of Name of your business&rsquo;s trading or collaboration partners or was a prospective or target trading or collaboration partner, with whom you had contact or about whom you became aware or were informed while you were Name of your business&rsquo;s employee.</p>
    <p lang="en-GB"><strong>Restricted Supplier: </strong>means any business entity or person who, during the twelve months before termination, was one of Name of your business&rsquo;s suppliers or was a prospective or target supplier, with whom you had contact or about whom you became aware or were informed while you were Name of your business&rsquo;s employee.</p>
    <p lang="en-GB"><strong>Target Customer /Partner/Supplier: </strong>means any business entity or person who, during the twelve months before termination, has been identified by Name of your business as a business entity or person with whom Name of your business intends to engage in sales, partnership or supply discussions.</p>
    <ol start="10">
        <ol>
            <ol start="2">
                <li>Interpretation:</p>
                    <ol type="a">
                        <li>
                            each of the sub-clauses contained in this clause 11 shall be construed 
                            as a separate clause. If for any reason, a sub-clause or other provision 
                            of this Agreement is declared void, unlawful or unenforceable, then that 
                            sub-clause shall be severed from this Agreement without affecting the composition 
                            or validity or enforcement of the other sub-clauses of this Agreement, and
                        </li>
                        <li>
                            the definitions in this clause apply, regardless of the manner in which your employment with us is terminated.
                        </li>
                    </ol>
                </li>
            </ol>
            <li>
                You agree to the following restrictions on the understanding that these are necessary, once you have left our employment, to protect the Confidential Information to which you have access as a {{$data['company_info']->name}} employee. You will therefore not:
                <ol type='a'>
                    <li>
                        for six months after your employment termination date, act in any capacity (including as a founder, owner, director, employee or other worker, agent, consultant/adviser, volunteer, or shareholder), for or with any Restricted Business, whether that Restricted Business is in actual or intended competition with {{$data['company_info']->name}}
                    </li>
                    <li>
                        for six months after your employment termination date, target a Restricted Customer with the intention of enticing them away from {{$data['company_info']->name}} so that you, or someone with whom you are working or otherwise assisting, may provide that Restricted Customer with goods or services that compete with any of {{$data['company_info']->name}}&rsquo;s goods or services
                    </li>
                    <li>
                        for six months after your employment termination date, be involved with a Restricted Partner, in the course of any business activity that is in competition with any Restricted Business
                    </li>
                    <li>
                        for six months after your employment termination date, in the course of any business concern that is in competition with any Restricted Business, target a Restricted Person by any means, with the intention of offering them employment or to otherwise engage their services or assistance
                    </li>
                    <li>
                        hold yourself out as connected in any capacity with {{$data['company_info']->name}} at any point in time following the termination of this Agreement, except that you are permitted to describe yourself as a former {{$data['company_info']->name}} employee, and
                    </li>
                    <li>
                        use any of {{$data['company_info']->name}}&rsquo;s registered or trading names (or any materials relating to them) at any point in time following the termination of this Agreement.
                    </li>
                </ol>
            </li>
            <li>
                These restrictions apply to you whether you are acting directly or indirectly, on your own behalf or on behalf of another person or entity.</li>
        </ol>
    </ol>
    <ol start="10">
        <ol start="3">
            <li>
                We are not obliged to put you on Garden Leave or to grant any request for it by you. Any period of Garden Leave (on which, according to clause [9.3], we may place you prior to the termination of this Agreement), will count towards the above periods of restriction in clauses [11.2](a)-(d), and will therefore reduce them.</li>
        </ol>
    </ol>
    <ol start="10">
        <ol start="4">
            <li>
                The limitations set out in clause [11.2] will not prevent you from holding shares or other securities by way of an investment in another company (including a listed one), provided that those shares and/or securities do not exceed 3% of the total issued share capital of that company.</li>
        </ol>
    </ol>
    <ol start="10">
        <ol start="5">
            <li>
                If at any time during your employment with {{$data['company_info']->name}} and/or before the expiry of the last of the restrictions in clause [11.2], you&rsquo;re offered an opportunity of any description by another business or an individual operating in a business capacity, you will provide the person making this offer with a copy of this clause 11. You also agree to notify your line manager of this offer and the identity of the person who has made it to you, as soon as possible after you accept that offer.</li>
        </ol>
    </ol>
    <ol start="10">
        <ol start="6">
            <li>
                We may request that you provide a written and signed confirmation that you&rsquo;re compliant with your obligations under this clause [11]. We may also request that you provide with reasonable evidence of your compliance and you agree to provide this too.</li>
        </ol>
    </ol>
    <ol start="12">
        <li>
            <strong>Our disciplinary and grievance procedures</strong></li>
    </ol>
    <ol start="12">
        <ol start="1">
        <li> {{$data['company_info']->name}}&rsquo;s disciplinary and grievance policies are available on 
            request to {{$data['director']->full_name}}. Please familiarise yourself with them. While these do not 
            form part of your employment contract, you are expected to comply with them.</li>

            <li>
                If we engage in a disciplinary process with you and you wish to appeal 
                against any disciplinary decision that we reach, please do so by setting 
                out the basis for your appeal in writing and sending it to your line manager.</li>
        </ol>
    </ol>
    <ol start="12">
        <ol start="3">
            <li>
                We are entitled to suspend you on full pay while we conduct any investigation concerning misconduct by you or for as long as is otherwise reasonable while any disciplinary procedure against you remains outstanding.</li>
        </ol>
    </ol>
    <ol start="12">
        <ol start="4">
            <li>
                If you wish to raise a grievance at any stage during your employment with {{$data['company_info']->name}}, you may apply in writing to your line manager or the {{$data['director']->full_name}} in accordance with our grievance procedure.</li>
        </ol>
    </ol>
    <ol start="13">
        <li>
            <strong>Lay-offs and short-term working</strong></li>
    </ol>
    <p lang="en-GB">If disruption occurs to the provision of work or some other event affects the normal operations of the business, {{$data['company_info']->name}} reserves the right to temporarily lay you off work without pay, or to reduce your normal working hours and to reduce your pay accordingly. We will give you as much notice as we reasonably can of any need by us to take such action. When no work is available throughout a day on which you would normally be required to work, {{$data['company_info']->name}} will pay any statutory guarantee payments in force at the time to which you are entitled. This payment is only made when a complete working day is lost.</p>
    <ol start="14">
        <li>
            <strong>Making changes to your terms of employment</strong></li>
    </ol>
    <p lang="en-GB">We can make reasonable changes to any of the terms of this Agreement. If we do so, we will write to you informing you of these changes as soon as possible and always within one month of such change(s).</p>
    <ol start="15">
        <li>
            <strong>Entire Agreement and no reliance on any other factors</strong></li>
    </ol>
    <ol start="10">
        <ol>
            <li>
                This Agreement represents the entire agreed position in relation to your employment with {{$data['company_info']->name}}. It supersedes and extinguishes any other agreements or understandings relating to your employment by us, however they may have been expressed or formed.</li>
        </ol>
    </ol>
    <ol start="10">
        <ol start="2">
            <li>
                You confirm that you have agreed to become a {{$data['company_info']->name}} employee purely on the basis of on the terms contained in this Agreement and that you are not relying on any statement, representation, assurance or warranty (whether made innocently or negligently) that is not set out in this Agreement.</li>
        </ol>
    </ol>
    <ol start="10">
        <ol start="3">
            <li>
                Nothing in this Clause shall limit or exclude any liability for fraud.</li>
        </ol>
    </ol>
    <ol start="16">
        <li>
            <strong>No third-party rights</strong></li>
    </ol>
    <p lang="en-GB">No one other than you and {{$data['company_info']->name}} shall have any right to enforce any terms of this Agreement.</p>
    <ol start="17">
        <li>
            <strong>Governing law and Jurisdiction</strong></li>
    </ol>
    <ol start="10">
        <ol>
            <li>
                This Agreement and any dispute or claim arising out of, or in connection with it, or its subject matter or formation (including non-contractual disputes or claims), shall be governed by and interpreted in accordance with the law of England and Wales.</li>
        </ol>
    </ol>
    <ol start="10">
        <ol start="2">
            <li>
                The courts of England and Wales shall have exclusive jurisdiction to settle any dispute or claim arising out of or in connection with this Agreement or its subject matter or formation (including non-contractual disputes or claims).</li>
        </ol>
    </ol>
    <p lang="en-GB">This Agreement has been entered into on {{$data['agreement_date']}}. It is executed as a Deed.</p>
    
    <h3 lang="en-GB">Employer&rsquo;s signature:</h3>
    <h3 lang="en-GB">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</h3>
    <p lang="en-GB"><strong>{{$data['employment_info']->supervisor}} for and on behalf of {{$data['company_info']->name}}</strong></p>
    <p lang="en-GB"><strong>Employee&rsquo;s signature:</strong></p>
    <p lang="en-GB">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;<strong>.</strong></p>
    <p lang="en-GB" style='font-weight:bold'>{{$data['employee']->full_name}}</p>
    <h1 lang="en-GB" style="page-break-before: always;">Annex 1</h1>
    <div class="my-4" style="padding-bottom:2em">
        {!! $data['job_description'] !!}
    </div>
    <h1 lang="en-GB" style="page-break-before: always;">Annex 2</h1>
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
    <p lang="en-GB" style=""><strong>I {{$data['employee']->full_name}} do hereby confirm 
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