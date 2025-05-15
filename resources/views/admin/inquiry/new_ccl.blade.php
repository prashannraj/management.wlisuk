@extends('layouts.master')

@push('styles')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <style>
        .spacing {
    margin-bottom: 20px; /* Adjust the value as needed */
        }
    </style>
@endpush

@section('header')
    <!-- Header -->
    <div class="header bg-wlis pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Send client care application for {{ $data['enquiry']->full_name }}
                        </h6>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('enquiry.log', $data['enquiry']->id) }}" class="btn btn-sm btn-neutral">
                            <i class="fas fa-chevron-left"></i> Back To Enquiry</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('main-content')
    <div>
        @foreach ($errors->all() as $error)
            <p class='alert alert-warning'>{{ $error }}</p>
        @endforeach
    </div>




    <div class="card" id="clientcare_form">
        <div class="card-header">
            <h4 class='text-primary'>Generate Client Care Application</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('enquiry.newccl', $data['enquiry']->id) }}" enctype="multipart/form-data"
                method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Full Name:</label>
                            <input type="text" name="full_name_with_title" id="full_name_with_title" class="form-control"
                                value="{{ $data['newccl']->full_name_with_title ?? $data['enquiry']->full_name_with_title }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        @php
                            $full_address = optional($data['enquiry']->address)->full_address;
                        @endphp
                        <div class="form-group">
                            <label for="">Full address</label>
                            <p>{{ $full_address }}</p>
                            <textarea name="full_address" class='form-control wysiwyg' rows='3'>
                            {{ nl2br(str_replace(',', "\n", $full_address)) }}
                        </textarea>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Date</label>
                            <input type="text" name="date" id="date" class="form-control datepicker2" value="{{ old('date', \Carbon\Carbon::parse(optional($data['newccl'])->date)->format('d/m/Y')) }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Immigration Application type</label>
                            <input type="text"
                                value="{{ old('application_type', optional($data['newccl'])->application_type) }}"
                                class="form-control" name='application_type'>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Select Advisor</label>
                            <select name="advisor_id" class="form-control">
                                <option value="">Select an advisor</option>
                                @foreach ($data['advisors'] as $advisor)
                                    <option
                                        {{ old('advisor_id', optional($data['newccl'])->advisor_id) == $advisor->id ? 'selected' : '' }}
                                        value="{{ $advisor->id }}">{{ $advisor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Select Service Fee</label>
                            <select placeholder="Type here to quickly fill up client details" name='servicefee_id'
                                class='form-control servicefeeautocomplete'></select>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Select Bank</label>
                            <select name="bank_id" class="form-control">
                                <option value="">Select a bank</option>
                                @foreach ($data['banks'] as $bank)
                                    <option
                                        {{ old('bank_id', optional($data['newccl'])->bank_id) == $bank->id ? 'selected' : '' }}
                                        value="{{ $bank->id }}">{{ $bank->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Agreed Fee Currency</label>
                            <select name="agreed_fee_currency_id" class="form-control">
                                <option value="">Select currency</option>
                                @foreach ($data['currencies'] as $currency)
                                    <option
                                        {{ old('agreed_fee_currency_id', optional($data['newccl'])->agreed_fee_currency_id) == $currency->id ? 'selected' : '' }}
                                        value="{{ $currency->id }}">{{ $currency->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Agreed Fee</label>
                            <input type="text"
                                value="{{ old('agreed_fee', optional($data['newccl'])->agreed_fee) }}"
                                class="form-control" name='agreed_fee'>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Vat</label>
                            <input type="text"
                                value="{{ old('vat', optional($data['newccl'])->vat) }}"
                                class="form-control" name='vat'>
                        </div>
                    </div>


                    <div class="col-md-12"> <!-- Full width for new textarea -->
                        <div class="form-group">
                            <label for="additional_notes">Discussion/Notes:</label>
                            <textarea id="c" name="additional_notes" class='form-control wysiwyg' rows='3'
                                placeholder="Enter any additional notes here...">{{ old('additional_notes', optional($data['newccl'])->additional_notes) }}</textarea>
                        </div>
                    </div>


                    <!-- Load Content Button -->
                    <div class="col-md-12">
                        <button type="button" id="loadBtn" class="btn btn-primary">Click on Save Button to Load Content</button>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Client Care Cover Leter</label>
                            <textarea id="discussion_details" name="discussion_details" class="form-control wysiwyg" rows="10">
                                <p>Thank you for instructing <strong>{{ $data['company_info']->name ?? 'Default text here' }}</strong>. We are a regulated by <strong>{{ $data['company_info']->regulated_by ?? 'Default text here' }}</strong>.  We are authorised to provide immigration advice and services in the categories of <strong>{{ $data['advisor']->category ?? 'Default category here' }}</strong>.  Our registration number is <strong>{{ $data['company_info']->regulation_no }}</strong>. </p>

                                <p>Thank you for instructing me to act on your behalf about your immigration matter. </p>

                                <h3 style="text-decoration: underline;">Who is dealing with your case?</h3>

                                <p>My name is <strong>{{ $data['advisor']->name ?? 'Default name here' }}</strong> and I will be handling your case. I am authorised to provide immigration advice and services at <strong>{{ $data['advisor']->level ?? 'Default name here' }}</strong> in the categories of <strong>{{ $data['advisor']->category ?? 'Default category here' }}</strong>.</p>
                                <h3 style="text-decoration: underline;">Instructions/discussions</h3>
                                <p>{{$data['newccl']->additional_notes ?? 'Default discussion notes'}}</p>
                                <p>Further documents requested in this client care letter, or separately by the advisor, can be sent to us either via email or by post to the address provided below.</p>
                                <p>I have also explained that application decisions are entirely at the discretion of the Home Office. You can find published guidelines for your application type on the gov.uk website. Certain applications may offer priority or super-priority services, which we can recommend at the time of your application. Please note, there are additional fees for these services. These payments must be made directly to the Home Office, either online through the application portal or at the visa application centre, where applicable.</p>
                                <p>Based on the information you have provided, we believe you are eligible to apply for <strong>{{ $data['newccl']->application_type }}</strong> application. We are able to assist and represent you with your application. However, as advised during our discussions, we cannot guarantee a successful outcome.</p>

                                <h3 style="text-decoration: underline;">Termination of instructions</h3>
                                <p><b>You may end your instructions to us at any time, but this must be done in writing. If we stop working on your matter, whether you terminate our instructions or for other reasons outlined below, we have the right to retain all your documents and papers until any outstanding charges and expenses are fully paid.</b></p>

                                <p><b>There may be situations where you believe we should stop acting for you, such as losing confidence in how we are handling your case. Similarly, we may choose to stop acting for you, but only for valid reasons. Examples include failure to pay an interim bill or to make a payment requested on account.</b></p>

                                <p><b>If we decide to stop working on your case, we will provide reasonable notice. If we stop acting for you because of unpaid bills or payments on account of costs or expenses, and your matter involves litigation, we may apply to the court to formally withdraw as your legal representatives. After this, you would proceed as an "applicant in person."</b></p>


                                <h3 style="text-decoration: underline;">Opening times</h3>
                                <p>We are based at <strong>{{ $data['company_info']->address ?? 'Default text here' }}</strong>. The normal hours of work are from 10 am to 5 pm Monday to Friday. We are completely <b style="font-size: 20px;">remote and online service</b>. If you are unable to access technology or post, please inform us. We may need to ask you to seek local representative. Zoom appointments can be arranged within and outside these hours when essential for your interest. </p>
                                <p>My emergency number is <strong>{{ $data['advisor']->contact ?? 'Default contact here' }}</strong>. Please only use in an urgent situation.</p>

                                <h3 style="text-decoration: underline;">Cost</h3>
                                <p>Our <b>agreed fee</b> this matter is <b>£<strong>{{$data['newccl']->agreed_fee ?? 'Default agreed fee'}}</strong> plus VAT (if applicable).</b></p>

                                <p style= 'text-decoration: underline;'><b>Our charges may vary according to the nature of your case.  If further work is required in addition to the initial instructions, then additional costs will be added as incurred. We will tell you and agree before adding any cost, No separate agreement will be issued but on agreement we will issue agreed amount invoice and discussion and agreement will be logged.</b></p>

                                <p>“VAT” means value added tax – a sales tax. If you live in the UK or have leave in the UK, I have to add <strong>{{$data['newccl']->vat ?? 'Default vat'}}</strong> % by law.</p>

                                <h3 style="text-decoration: underline;">Payment terms</h3>
                                <p>Payment in full on engagement or as agreed prior to completion of work prior to the application being sent or as advised by the advisor (instruction will be sent).</p>
                                <h3 style="text-decoration: underline;">Payment</h3>
                                <p>The invoice must be paid in advance into our business bank account (or client account, if applicable) as outlined below. This payment should be made either upon signing this client care letter or once the application is complete, but always before the visa fee is paid online by you or your authorised payer. Payment is also required before we provide the login credentials. An invoice will be issued upon completion of the instruction and receipt of the payment.</p>
                                @if ($data['bank'])
                                <div>
                                    <strong>{!! $data['bank']->formattedDetails() !!}</strong>
                                </div>
                                @else
                                <p>No bank information available.</p>
                                @endif
                                <p>Payment reference:<strong>ENQ{{$data['enquiry']->id}}</strong></p>

                                <p class="italic mt-4"><u>Please note that this <b>does not</b> include the Home Office visa application fee, Immigration Health Surcharge (IHS) fee, postal costs for the return of documents, visa application centre appointment charges, or any other expenses incurred that are not covered under this agreement.</u></p>

                                <p class="italic mt-4"><u><b>We charge</b> for the work carried out on the case irrespective of the outcome. We do not operate on a “no win no fee basis”.</u> </p>
                                <p><b>The fee is a single fee which covers the following work:</b> </p>

                                <h3 style="text-decoration: underline;">Preparation</h3>
                                <p>The process includes planning the application, interviewing the applicant and sponsor for details, drafting witness statements or statements of support, reviewing them, and preparing the online visa application form along with other related forms, such as the Sponsor Undertaking (SU07), Sponsor Declaration or Consent Forms, and any relevant appendix forms required for the specific visa category. </p>
                                <p><b>Please note that I will not provide the completed work to you until the fee has been paid in full.</b></p>
                                <h3 style="text-decoration: underline;">Free help and assistance</h3>
                                <p>You should also be aware that firms such as Citizens Advice Bureau and Law Centres could provide you with advice and representation in immigration matters free of charge. If you wish to consult them, their number can be found in the Local Telephone Directory.</p>

                                <h3 style="text-decoration: underline;">Outcome of the matter</h3>
                                <p>We will try our best to get a favourable outcome on all matters. However, success is not guaranteed, and the outcome is dependent upon the merit of your case. We do not operate on a “no win no fee basis”.</p>

                                <h3 style="text-decoration: underline;">Report on progress (in country)</h3>
                                <p>We will update you by telephone or in writing with progress on your matter regularly but at least every 12 weeks and we will always try to keep you informed of any unexpected delays or changes in the character of the work. You may enquire at any time from me about a progress report.</p>

                                <h3 style="text-decoration: underline;">Report on progress (out of country)</h3>
                                <p>We would expect you to update us by email on receipt of the correspondence or a decision on the application as its usually not communicated to us.</p>
                                <p>However, if require us to contact the UKVI we will contact them online and there is a fee standard fee of £30 we charge inclusive of the UKVI approved contractor. We will only offer a telephone contact in an emergency and charges remains £30 plus the telephone charge (£1.37 per minute) paid on your behalf.</p>
                                <p>Alternatively, please visit https://www.gov.uk/contact-ukvi-inside-outside-uk/y/outside-the-uk/english and follow the process.</p>

                                <h3 style="text-decoration: underline;">How long it take to resolve the matter</h3>
                                <p>The time scale: Due to various circumstances, the time an application decision takes varies.  You can find published guidelines for your application type on the gov.uk website. </p>
                                <p><b>Note: Home Office is independent, and we have no influence over it to speed the process. An expedition can be requested in a special circumstance only.</b></p>

                                <h3 style="text-decoration: underline;">Equality and diversity </h3>
                                <p>We are committed to promoting equality and diversity in all our dealings with clients, third parties and employees. Please contact us if you would like a copy of our equality and diversity policy.</p>

                                <h3 style="text-decoration: underline;">Complaints</h3>
                                <p>We are committed to high-quality legal advice and client care. When something goes wrong, we need you to tell us about it. This will help us to maintain and improve our standards.</p>

                                <p>If you are unhappy about any aspect of the service you have received, please contact me on <strong>{{ $data['advisor']->contact ?? 'Default contact here' }}</strong> or <strong>{{ $data['company_info']->email ?? 'Default text here' }}</strong> or by post to our registered address at Complaints, <strong>{{ $data['company_info']->name ?? 'Default text here' }}</strong>, <strong>{{ $data['company_info']->address ?? 'Default address here' }}</strong>.</p>

                                <h3 style="text-decoration: underline;">Our complaints procedure</h3>
                                <p>If you have a complaint, please contact us with the details. If we have to change any of the timescales set out below, we will let you know.</p>
                                <p>What will happen next?</p>
                                <ol>
                                    <li>Within 2 weeks of receiving your complaint, I will send you a letter acknowledging your complaint and asking you to confirm or explain the details. I may suggest that we meet to clarify any details.</li>
                                    <li>I will then record your complaint in our central register and open a file for your complaint and investigate your complaint. This may involve one or more of the following steps.</li>
                                    <li>I will consider your complaint again. I will then send you my detailed reply or invite you to a meeting to discuss the matter. </li>
                                    <li>Within two days of the meeting I will write to you to confirm what took place and any solutions I have agreed with you. Inappropriate cases, I could offer an apology, a reduction of any bill or a repayment in relation to any payment received.</li>
                                </ol>

                                <p><strong>{{ $data['company_info']->name ?? 'Default text here' }}</strong> intends to resolve any complaint within 6 weeks of receiving it.</p>
                                <p>Please note that alternatively, you can make yours complain directly to the <strong>{{ $data['company_info']->regulated_by }}</strong>, who regulate all Immigration Advisors, by completing the <strong>{{ $data['company_info']->regulated_by }}</strong> complaint’s form. This form is available in a range of languages on the website, www.gov.uk/iaa.</p>

                                <p>You can also make yours complain in writing to the Immigration Advice Authority (IAA), PO Box 567, Dartford, DA1 9XW or by email at info@immigrationadviceauthority.gov.uk. Telephone: 0345 000 0046. Website: www.gov.uk/iaa.</p>

                                <h3 style="text-decoration: underline;">Confidentiality</h3>
                                <p>We are under the duty to keep your affairs confidential to our firm and to ensure that our staffs do the same. If we are to release any confidential information which is unauthorised then this can lead to disciplinary action against us. The duty of confidentiality applies to information about your affairs and general information.</p>

                                <p>It is likely that during the course of the work we undertake certain information may have to be disclosed to the third parties, for example, counsels, experts for reports. We will only disclose such information having discussed the matter with you, having obtained your consent to disclose information or where we are under a professional obligation to do so.</p>

                                <h3 style="text-decoration: underline;">Inspection of files and quality standards</h3>
                                <p><strong>{{ $data['company_info']->regulated_by }}</strong> may need to access your file whilst checking my competence. <strong>{{ $data['company_info']->regulated_by }}</strong> does not require permission to inspect my client files. Please be assured that they will maintain your confidentiality at all times.</p>

                                <h3 style="text-decoration: underline;">Transfer of file</h3>
                                <p>If you wish to instruct other Firms to deal with your matter, we will transfer your file to another adviser/solicitor/barrister, but you will still pay our fees. We will always release your file whether you have paid us or not. We may take action in the county courts to recover our fees should you refuse to pay.</p>

                                <h3 style="text-decoration: underline;">Insurance cover</h3>
                                <p>We maintain Professional Indemnity Insurance.</p>

                                <h3 style="text-decoration: underline;">Papers held by us and document custody</h3>
                                <p>On completion of matters, I will return your original documents to you unless otherwise agreed with you. We will undertake to retain files for at least six years in line with <strong>{{ $data['company_info']->regulated_by }}</strong> Code of Standards. We reserve the right to destroy the files without further reference to you after retaining the files for the period stated above.</p>

                                <h3 style="text-decoration: underline;">Action by yourself</h3>
                                <p>To enable us to provide you with an efficient service, you are committing yourself to ensure that:</p>
                                <ul>
                                    <li>You always keep us updated whenever any of your contact details change. We need to be able to contact you when necessary.</li>
                                    <li>You will provide us with clear, timely and accurate instructions.</li>
                                    <li>You will provide all documentation required to complete the transaction in a timely manner.</li>
                                    <li>You will safeguard and provide any documents which are likely to be required for the matter.</li>
                                    <li>You will update and inform your witnesses of the hearing and the attendance.</li>
                                </ul>

                                <p>To proceed with your Immigration application, you must sign the client care letter and provide your GDPR consent as mentioned at the end of this letter. Please note that we can commence work on your case only upon receipt of these documents.</p>

                                <p>We are committed to assisting you with your Immigration application and look forward to receiving the necessary documents to proceed ahead.</p>
                                <p>Thank you for choosing to come with us. </p>
                                <p>If you have any questions, please do not hesitate to let me know and I will be pleased to help.</p>
                                <p>Kind regards,</p>
                                <table class=''>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <img src="{{ public_path($data['advisor']->signature_url) }}" width="120" alt="">
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
                                                <img src="{{ public_path($data['company_info']->stamp_url)}}" width="120" alt="">

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

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
                                <p><b>Note:</b>providers charge a fee for submissions made in the UK per application. Please visit their website for the most up-to-date fees.</p>
                                <p><b>Photocopies:</b>Colour copies are charged at £1.50 per page, and black-and-white copies are charged at £1 per page (if we have to make it for them). Please note that these copy charges are additional to our fees.<b> We suggest opting for online digital submission to avoid unnecessary costs.</b></p>

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
                                <p>Client’s name (please print): <strong>{{$data['newccl']->full_name_with_title ?? '' }}</strong></p>
                                <p>Client’s signature:</p>
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
                                <p>Client’s name: <strong>{{$data['newccl']->full_name_with_title ?? '' }}</strong></p>
                                <p>Client’s signature:</p>
                                <p>Date (e.g. 1 January 2025):</p>
                            </textarea>
                        </div>
                    </div>
                </div>
                <h4 class="text-primary">Actions</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="shadow px-2 py-3 my-3 border">
                            <h3 class="text-primary">Client Care Application</h3>
                            <button name="action" value="Save" class="btn btn-success">Save</button>
                            <button name="action" formtarget="_blank" value="Preview" class="btn btn-warning">Preview</button>
                            <button name="action" value="Download" class="btn btn-primary">Download</button>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h3 style="text-decoration: underline;">Send Email</h3>
                                <div class="attachment-list">
                                    <label for="">Attachments (if any)</label>
                                    <input type="file" name="attachments[]" class="form-control">
                                </div>
                                <button class="btn-sm btn-primary" id="addField">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <br>
                                <br>
                                <button name="action" value="Email" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
             </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Make sure you include Bootstrap JS and CSS for Modal functionality -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js">
    </script>


    <script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea.wysiwyg',
            height: 300,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ],
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            images_upload_url: '{{ route('upload.image') }}', // Set the upload URL
            automatic_uploads: true,
            file_picker_types: 'image',
            file_picker_callback: function(callback, value, meta) {
                if (meta.filetype === 'image') {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');
                    input.onchange = function() {
                        var file = this.files[0];
                        var reader = new FileReader();
                        reader.onload = function() {
                            // Call the callback to insert the image
                            callback(reader.result, {
                                alt: file.name
                            });
                        };
                        reader.readAsDataURL(file);
                    };
                    input.click();
                }
            },
        });
    </script>

    <script>
        $('.datepicker2').datepicker({
            format: "{{ config('constant.date_format_javascript') }}",
        });


        $('.status').on('change', function(evt) {
            var $this = $(evt.currentTarget);
            if ($this.val() == 2) {
                $this.parent().parent().find('.followup').show();
            } else {
                $this.parent().parent().find('.followup').hide();
            }
        })

        $('#delete_log').on('show.bs.modal', function(evt) {
            var button = $(evt.relatedTarget);
            var modal = $(evt.currentTarget);
            var id = button.data('docid');

            modal.find('#doc_id').val(id);
        });

        $('#edit_log').on('show.bs.modal', function(evt) {
            var button = $(evt.relatedTarget);
            if (button.html() === undefined || button.hasClass('datepicker2')) {
                return;
            }


            var modal = $(evt.currentTarget);
            var id = button.data('docid');
            var note = button.data('note');
            var status = button.data('status');
            var followup_date = button.data('followup_date');

            modal.find('#activity_id').val(id);
            modal.find('#note').val(note);
            modal.find('#status').val(status);
            modal.find('#status').change();

            modal.find('#followup_date').val(followup_date);




        });



        $('.servicefeeautocomplete').autoComplete({
            minLength: 1,
            resolverSettings: {
                url: '{{ route('ajax.servicefee.index') }}'
            },
            events: {
                searchPost: function(data) {
                    var da = [];
                    data.map(function(e) {
                        da.push({
                            id: e.id,
                            value: e.id,
                            text: e.name + " - " + e.category,
                            address: e.address
                        });
                    })
                    return da;
                }
            },

        });

        @if (optional($data['newccl'])->servicefee_id != null)
            $('.servicefeeautocomplete').autoComplete('set', {
                value: "{{ $data['newccl']->servicefee_id }}",
                text: "{{ $data['newccl']->servicefee->name }} - {{ $data['newccl']->servicefee->category }}"
            });
        @endif
    </script>
    <script>
        function addField(e) {
            e.preventDefault();
            var field = '<input type="file" name="attachments[]" class="form-control">';
            $(".attachment-list").append(field);
        }



        $("#addField").on('click', addField);

        function addDocumentField(e) {
            e.preventDefault();
            var field = '<select name="documents[]" class="form-control">' +
                '<option>Select an option</option>' +
                '@foreach ($data['documents'] as $doc) <option value="{{ $doc->id }}">{{ $doc->name }}</option>  @endforeach' +
                '</select>';
            $(".documents-list").append(field);

        }

        $("#addDocumentField").on('click', addDocumentField);
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="path/to/jquery.scrollbar.min.js"></script>

@endpush
