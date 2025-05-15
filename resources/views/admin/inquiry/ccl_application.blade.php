@extends('layouts.master')

@push('styles')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
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
            <form action="{{ route('enquiry.cclapplication', $data['enquiry']->id) }}" enctype="multipart/form-data"
                method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Full Name:</label>
                            <p id="fullNameDisplay">
                                <!-- Display added names or the original full name -->
                                {{ implode(', ', $data['addedNamesInput']) ?? $data['enquiry']->full_name_with_title }}
                            </p>
                            <input type="text" id="nameField" class="form-control"
                                value="{{ implode(', ', $data['addedNamesInput']) ?? $data['enquiry']->full_name_with_title }}">
                            <input type="hidden" id="added_names_input" name="added_names_input"
                                value="{{ json_encode($data['addedNamesInput']) }}">
                            <!-- Ensure this hidden input is present -->
                            <button type="button" id="addNameButton" class="btn btn-primary mt-2">Add Name</button>
                        </div>
                    </div>

                    <!-- Modal for Adding Name -->
                    <div class="modal fade" id="addNameModel" tabindex="-1" aria-labelledby="nameModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="nameModalLabel">Add Name</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" id="newNameInput" class="form-control" placeholder="Enter Name">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="saveNameButton" class="btn btn-primary">Add Name</button>
                                </div>
                            </div>
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
                            <input type="text" class="form-control datepicker2"
                                value="{{ old('date', optional($data['cclapplication'])->date) ?? date('d/m/Y') }}"
                                name='date'>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Select Advisor</label>
                            <select name="advisor_id" class="form-control">
                                <option value="">Select an advisor</option>
                                @foreach ($data['advisors'] as $advisor)
                                    <option
                                        {{ old('advisor_id', optional($data['cclapplication'])->advisor_id) == $advisor->id ? 'selected' : '' }}
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
                                        {{ old('bank_id', optional($data['cclapplication'])->bank_id) == $bank->id ? 'selected' : '' }}
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
                                        {{ old('agreed_fee_currency_id', optional($data['cclapplication'])->agreed_fee_currency_id) == $currency->id ? 'selected' : '' }}
                                        value="{{ $currency->id }}">{{ $currency->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Agreed Fee</label>
                            <input type="text"
                                value="{{ old('agreed_fee', optional($data['cclapplication'])->agreed_fee) }}"
                                class="form-control" name='agreed_fee'>
                        </div>
                    </div>
                    <div class="col-md-12"> <!-- Full width for new textarea -->
                        <div class="form-group">
                            <label for="additional_notes">Additional Notes:</label>
                            <textarea id="additional_notes" name="additional_notes" class='form-control wysiwyg' rows='3'
                                placeholder="Enter any additional notes here...">{{ old('additional_notes', optional($data['cclapplication'])->additional_notes) }}</textarea>
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
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">Thank you for your instructions. We are delighted to have the opportunity to act for you and trust we can bring your instructions to a satisfactory conclusion. </span></p>
                            <p>{!! $data['discussion_content'] !!}</p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>WHO IS DEALING WITH YOUR CASE?</strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">My name is {{ $data['advisor']->name ?? 'Default name here' }} and I will be handling your case. I am authorised to provide immigration advice and services at <strong>{{ $data['advisor']->level ?? 'Default level here' }}</strong> in the categories of <strong>{{ $data['advisor']->category ?? 'Default category here' }}.</strong></span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>INSTRUCTIONS</strong></span> </span></h1>
                            <p>&nbsp;</p>
                            <div> {{ $data['additional_notes'] ?? 'Default additional notes here' }}</div>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">Further documents are requested with this client care letter which can be sent to us either via email or posted at our address below.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">I have also advised the application decisions may take longer, and the published guidelines suggest 3 - 6 months and priority application being decided within 6 weeks from overseas and 24 hours upon biometric enrolment in country which attracts additional charges. </span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">I confirm that based on the information you have provided; we believe that you are eligible to apply for</span> <span style="font-family: 'Courier New', Courier, monospace; font-weight: bold;">{{ $data['servicefee']->category ?? '' }},</span> <span style="font-family: 'Courier New', Courier, monospace; font-weight: bold;">{{ $data['servicefee']->name ?? '' }}</span> <span style="font-family: 'Courier New', Courier, monospace;">application and we can bring the application to a satisfactory conclusion. </span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>OPENING TIMES</strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">We are based at,</span> <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->address ?? 'Default address here' }}. The normal hours of work are from 10 am to 5 pm Monday to Friday.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">Appointments can be arranged outside these hours when essential for your interest. </span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">My emergency number is {{ $data['advisor']->contact ?? 'Default contact here' }}. Please only use in an urgent situation.</span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>COST</strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">Our fee for this matter is <strong>{{ $data['servicefee']->currency->title ?? '' }} {{ $data['servicefee']->total ?? '' }}</strong> per applicant.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">Our agreed fee for this matter is <strong>{{ $data['agreed_fee_currency']->title ?? '' }} {{ $data['agreed_fee'] ?? '' }}</strong>.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">The invoice is to be paid into our business account below on completion of the application form and prior to the application being sent or in advance to our client account if applicable. An invoice will be raised on completion of the instruction and on receipt of the payment.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="center"><span style="font-family: 'Courier New', Courier, monospace;"><strong>
@if ($data['bank'])
<div>
                                    {!! $data['bank']->formattedDetails() !!}
                                </div>
@else
<p>No bank information available.</p>
@endif
</strong></span> <span style="font-family: 'Courier New', Courier, monospace;"><strong></strong></span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;"><em><u>Please note that this </u></em></span> <span style="font-family: 'Courier New', Courier, monospace;"><em><u><strong>does not</strong></u></em></span> <span style="font-family: 'Courier New', Courier, monospace;"><em><u> include UKVI Application fee, the postal cost for the return of the documents. </u></em></span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">We charge for the work carried out on the case irrespective of the outcome. We do not operate on a &ldquo;no win no fee basis&rdquo;.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;"><strong>Payment terms: </strong></span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">Payment in full on completion of work prior to the application being sent or as advised by the advisor (instruction will be sent).</span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>FREE HELP AND ASSISTANCE</strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">You should also be aware that firms such as Citizens Advice Bureau and Law Centres could provide you with advice and representation in immigration matters free of charge. If you wish to consult them, their number can be found in the Local Telephone Directory.</span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>OUTCOME OF THE MATTER</strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">We will try our best to get a favourable outcome on all matters. However, success is not guaranteed, and the outcome is dependent upon the merit of your case. We do not operate on a &ldquo;no win no fee basis&rdquo;.</span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>REPORT ON PROGRESS (In country)</strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">We will update you by telephone or in writing with progress on your matter regularly but at least every six weeks and we will always try to keep you informed of any unexpected delays or changes in the character of the work. You may enquire at any time from me about a progress report.</span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>REPORT ON PROGRESS (OUT OF country)</strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">We would expect you to update us by email on receipt of the correspondence or a decision on the application as its usually not communicated to us.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">However, if require us to contact the UKVI we will contact them online and there is a fee standard fee of &pound;30 we charge inclusive of the UKVI approved contractor (SITEL UK Ltd) charges of &pound;5.48. We will only offer a telephone contact in an emergency and charges remains &pound;30 plus the telephone charge (&pound;1.37 per minute) paid on your behalf.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">Alternatively please visit <a href="https://www.gov.uk/contact-ukvi-inside-outside-uk/y/outside-the-uk/english">https://www.gov.uk/contact-ukvi-inside-outside-uk/y/outside-the-uk/english</a> and follow the process.</span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>HOW LONG IT TAKE TO RESOLVE THE MATTER</strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">At this stage, I am unable to give you an exact time in which your matter will be concluded. The time taken varies depending upon your case and the complexity of the matter. </span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">You should be aware that the Home Office and High Commissions decide on cases according to their own time scales and we have no control over this.</span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>EQUALITY AND DIVERSITY </strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">We are committed to promoting equality and diversity in all our dealings with clients, third parties and employees. Please contact us if you would like a copy of our equality and diversity policy.</span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>COMPLAINTS</strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">We are committed to high-quality legal advice and client care. When something goes wrong, we need you to tell us about it. This will help us to maintain and improve our standards. </span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">If you are unhappy about any aspect of the service you have received, please contact me on </span> <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->telephone }}</span> <span style="font-family: 'Courier New', Courier, monospace;"> or </span> <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->email }}</span> <span style="font-family: 'Courier New', Courier, monospace;"> or by post to our office at Complaints, </span> <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->name }},</span> <span style="font-family: 'Courier New', Courier, monospace;"> </span> <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->address }}.</span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>Our complaints procedure</strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">If you have a complaint, please contact us with the details. If we have to change any of the timescales set out below, we will let you know.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><em> <span style="font-family: 'Courier New', Courier, monospace;">What will happen next?</span> </em></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">1. Within 2 weeks of receiving your complaint, I will send you a letter acknowledging your complaint and asking you to confirm or explain the details. I may suggest that we meet to clarify any details.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">2. I will then record your complaint in our central register and open a file for your complaint and investigate your complaint. This may involve one or more of the following steps.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;"> 3. I will consider your complaint again. I will then send you my detailed reply or invite you to a meeting to discuss the matter. </span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">4. Within two days of the meeting I will write to you to confirm what took place and any solutions I have agreed with you. Inappropriate cases, I could offer an apology, a reduction of any bill or a repayment in relation to any payment received.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 0.15in;" align="justify"><span style="font-size: 9pt;"> <span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;">{{ $data['company_info']->name }} intends to resolve any complaint within 6 weeks of receiving it.</span> </span> </span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">Please note that alternatively, you can make yours complain directly to the OISC, who regulate all Immigration Advisors, by completing the OISC complaint&rsquo;s form. This form is available in a range of languages on the website, www.oisc.gov.uk office of any regulated adviser or community advice organisations. You can also make yours complain in writing to the OISC office, 5th Floor, 21 Bloomsbury Street, London WC1B 3HF or by email at info@oisc.gov.uk. </span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">Telephone: 0345 000 0046 Fax: 020 7211 1553 Website: www.oisc.gov.uk </span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>CONFIDENTIALITY</strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">We are under the duty to keep your affairs confidential to our firm and to ensure that our staffs do the same. If we are to release any confidential information which is unauthorised then this can lead to disciplinary action against us. The duty of confidentiality applies to information about your affairs and general information.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">It is likely that during the course of the work we undertake certain information may have to be disclosed to the third parties, for example, experts&rsquo; reports. We will only disclose such information having discussed the matter with you, having obtained your consent to disclose information or where we are under a professional obligation to do so.</span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>INSPECTION OF FILES AND QUALITY STANDARDS</strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">The Office of The Immigration Services Commissioner may need to access your file whilst checking my competence. The OISC does not require permission to inspect my client files. Please be assured that they will maintain your confidentiality at all times.</span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>TRANSFER OF FILE</strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">If you wish to instruct other Firms to deal with your matter, we will transfer your file to another adviser, but you will still pay our fees. We will always release your file whether you have paid us or not. We may take action in the county courts to recover our fees should you refuse to pay.</span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>INSURANCE COVER</strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">We maintain Professional Indemnity Insurance. </span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>PAPERS HELD BY US AND DOCUMENT CUSTODY</strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">On completion of matters, I will return your original documents to you unless otherwise agreed with you. We will undertake to retain files for at least six years in line with Commissioners Code of Standards. We reserve the right to destroy the files without further reference to you after retaining the files for the period stated above.</span></p>
                            <h1><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>ACTION BY YOURSELF </strong></span> </span></h1>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">To enable us to provide you with an efficient service, you are committing yourself to ensure that:</span></p>
                            <ul>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">You always keep us updated whenever any of your contact details change. We need to be able to contact you when necessary. </span></p>
                            </li>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">You will provide us with clear, timely and accurate instructions. </span></p>
                            </li>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">You will provide all documentation required to complete the transaction in a timely manner. </span></p>
                            </li>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">You will safeguard and provide any documents which are likely to be required for the matter. </span></p>
                            </li>
                            </ul>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">Please sign and date one copy of this client care letter in the space provided below and return to us either by post, email or in-person. </span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">Thank you for choosing to come with us. </span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;">If you have any questions, please do not hesitate to let me know and I will be pleased to help.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">Kind regards,</span></p>
                            <p>&nbsp;</p>
                            <table>
                            <tbody>
                            <tr>
                            <td>
                            <table>
                            <tbody>
                            <tr>
                                <td>
                                    @if ($data['advisor'] && $data['advisor']->signature_url)
<img style="height: auto;" src="{{ asset($data['advisor']->signature_url) }}" alt="" width="120" />
@else
<p>No signature available.</p>
@endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    @if ($data['advisor'] && $data['advisor']->name)
{{ $data['advisor']->name }}
@else
<p>No advisor name available.</p>
@endif
                                </td>
                            </tr>
                            <tr>
                            <td>{{ $data['company_info']->name }}</td>
                            </tr>
                            </tbody>
                            </table>
                            </td>
                            <td><img style="height: auto;" src="{{ public_path($data['company_info']->stamp_url) }}" alt="" width="150" /></td>
                            </tr>
                            </tbody>
                            </table>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;"><u><strong>Application process (in country):</strong></u></span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">We will file an online application on the Access UK website.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">Supporting documents will either be sent to the Home Office or submitted to Sopra Steria an approved UKVI partner and depends on an application type.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">We will offer to upload documents where possible if the client is comfortable providing us with an access to the online portal for submission. </span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;"><u><strong>Application process (overseas):</strong></u></span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">We will file an online application on the Access UK website.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">Please note there will be an online visa application fee and Immigration Health Surcharge (IHS) to pay as part of the application (EU Applicant and ILE/ILR/AF are exempt). </span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">Fees from overseas are either charged in their local currency or in USD.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><a href="https://www.immigration-health-surcharge.service.gov.uk/checker/type"> <span style="font-family: 'Courier New', Courier, monospace; text-align: left;"><span style="background: #ffffff;">Immigration Health Surcharge (IHS) information:</span></span> </a></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">The IHS can only be paid online and cannot be paid at the Visa Application Centre (VAC). E.g. for Appendix FM Entry Clearance visa application for a client based in Hong Kong their IHS fee is charged in HKD and Nepal-based applicants are charged in USD. Applicants are required to pay the IHS in their local currency where available and the precise amount is only known at the time of the application.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">Please note: We have no control or influence over this charge and it is automatically populated for each application.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;"><u><strong>Document submission process:</strong></u></span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">Copies of the documents are submitted to the UKVI through the VFS Global or Teleperformance either online or by visiting the approved centre. </span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">In some instances where online submissions are not possible due to the website being unresponsive or the file sizes being too large; we suggest the sponsor submit documents at the VFS/Teleperformance office, be this in the UK or at the Visa application centre.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">Note: VFS charges &pound;100 in the UK per application. If you would like us to travel and submit it on your behalf, we are happy to offer the service without any additional charge other than the travel cost (to Edinburgh, Manchester or London) and a submission fee. </span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;"><strong>Photocopies:</strong> Colour copies are charged 80p per page and black and white copies are charged 30p per page. Kindly note copy charges are additional to our fees.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;"><u><strong>Where to send supporting documents: </strong></u></span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">Our address is</span> <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->name }},</span> <span style="font-family: 'Courier New', Courier, monospace;"> </span> <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->address }},</span> <span style="font-family: 'Courier New', Courier, monospace;">T:</span> <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->telephone }},</span>E: <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->email }}.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;"><u><strong>Method of communication</strong></u></span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">Due to relocating from London to Durham we have changed the way we communicate and engage with our clients.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;"><strong>1. Telphone</strong></span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">We would contact you to discuss your case at a pre-arranged time that suits you.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;"><strong>2. Documents</strong></span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">We prefer to receive scanned documents (minimum 300 dpi) via email. If this is not convenient, documents can be posted to us with a pre-paid return envelope. Documents posted to the above address will be scanned and returned via the pre-paid envelope provided.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;"><strong>3. Direct Contact</strong></span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">Your representative</span> <span style="font-family: 'Courier New', Courier, monospace;">({{ $data['advisor']->name ?? '' }})</span> <span style="font-family: 'Courier New', Courier, monospace;">can be contacted by WhatsApp, Viber or iMessage on</span> <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['advisor']->contact ?? '' }}</span> <span style="font-family: 'Courier New', Courier, monospace;">however documents sent on these apps</span> <span style="font-family: 'Courier New', Courier, monospace;"><strong>CANNOT</strong></span> <span style="font-family: 'Courier New', Courier, monospace;">be used for official purpose and can only be used for a quick assessment to advise you. </span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">We will delete the files and will NOT use them under any circumstances other than for our internal processes to the purpose of making an immigration application.</span></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><br /><br /></p>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">Client Care Letter agreeing and contractually entering person&rsquo;s name and signature</span></p>
                            <table style="width: 96.2387%;">
                                <tbody>
                                <tr style="width: 100%;">
                                <td style="width: 37%; text-align: center; vertical-align: bottom;">{{ $data['enquiry']->full_name_with_title }}
                                <div style="width: 90%; height: 1px; background-color: black; margin: 4px auto 4px auto;">&nbsp;</div>
                                Your Name</td>
                                <td style="width: 31%; text-align: center; vertical-align: bottom;">
                                <p>&nbsp;</p>
                                <div style="width: 90%; height: 1px; background-color: black; margin: 4px auto 4px auto;">&nbsp;</div>
                                Your Signature</td>
                                <td style="width: 32%; text-align: center; vertical-align: bottom;">
                                <p>&nbsp;</p>
                                <div style="width: 90%; height: 1px; background-color: black; margin: 4px auto 4px auto;">&nbsp;</div>
                                Date</td>
                                </tr>
                                </tbody>
                            </table>
 @php
     $addedNames = is_array($data['addedNamesInput'])
         ? $data['addedNamesInput']
         : json_decode($data['addedNamesInput'], true);
 @endphp

@foreach ($addedNames as $name)
<table style="width: 96.2387%; margin-bottom: 20px;">
        <tbody>
            <tr style="width: 100%;">
                <!-- Name Column -->
                <td style="width: 37%; text-align: center; vertical-align: bottom;">
                    {{ $name }}
                    <div style="width: 90%; height: 1px; background-color: black; margin: 4px auto;">&nbsp;</div>
                    Your Name
                </td>

                <!-- Signature Column -->
                <td style="width: 31%; text-align: center; vertical-align: bottom;">
                    <p>&nbsp;</p>
                    <div style="width: 90%; height: 1px; background-color: black; margin: 4px auto;">&nbsp;</div>
                    Your Signature
                </td>

                <!-- Date Column -->
                <td style="width: 32%; text-align: center; vertical-align: bottom;">
                    <p>&nbsp;</p>
                    <div style="width: 90%; height: 1px; background-color: black; margin: 4px auto;">&nbsp;</div>
                    Date
                </td>
            </tr>
        </tbody>
    </table>
@endforeach


                            <h1 style="page-break-before: always; text-align: left;"><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>{{ $data['company_info']->name }}</strong></span> </span> <span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 11pt;"><strong>General Data Protection Regulation Consent &ndash; Terms and Conditions</strong></span> </span></h1>
                            <ol>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;" align="justify"><span style="font-family: 'Courier New', Courier, monospace;"><strong>General Terms and Conditions</strong></span></p>
                            <ol>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">Purpose of the application:</span></p>
                            </li>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->name }}</span> <span style="font-family: 'Courier New', Courier, monospace;"> reserves the right to vary these Terms and Conditions or the Consent at any time. The latest version of the Terms and Conditions apply to all applications and will supersede previous Terms and Conditions unless otherwise stated.</span></p>
                            </li>
                            </ol>
                            </li>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;"><strong>Consent</strong></span></p>
                            <ol>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">I agree to provide </span> <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->name }}</span> <span style="font-family: 'Courier New', Courier, monospace;"> and its advisor(s) with any relevant data (including personal data) required by the Home Office or UK Visa and Immigration for the &lsquo;Purpose of the Application&rsquo; as stated in Paragraph 1.1.</span></p>
                            </li>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">Where any information or documentation relates to someone else or a Third Party, I confirm that I have consulted and have received consent from any Third Party to provide their data (including personal data) to </span> <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->name }}</span> <span style="font-family: 'Courier New', Courier, monospace;"> for the &lsquo;Purpose of the Application&rsquo; as stated in Paragraph 1.1. I understand that information about the applicant may also reveal information about me.</span></p>
                            </li>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">I agree for </span> <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->name }}</span> <span style="font-family: 'Courier New', Courier, monospace;"> and its advisor to pass on the details provided by me to the relevant authority such as the Home Office, visa issuance authority or another relevant institution.</span></p>
                            </li>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">I confirm that the services provided by </span> <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->name }}</span> <span style="font-family: 'Courier New', Courier, monospace;"> are non-refundable and binding on signing of these Terms and Conditions.</span></p>
                            </li>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">I confirm that all the information and documentations that I have currently provided or will provide is genuine and correct to the best of my knowledge.</span></p>
                            </li>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">I understand that </span> <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->name }}</span> <span style="font-family: 'Courier New', Courier, monospace;"> and its advisors may contact me in the future regarding the &lsquo;Purpose of the Application&rsquo; as stated in Paragraph 1.1.</span></p>
                            </li>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">I consent for </span> <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->name }}</span> <span style="font-family: 'Courier New', Courier, monospace;"> to hold my data digitally and in paper form where applicable.</span></p>
                            </li>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">I understand that </span> <span style="font-family: 'Courier New', Courier, monospace;">{{ $data['company_info']->name }}</span> <span style="font-family: 'Courier New', Courier, monospace;"> will store my data online in their server based either in the UK or the EU.</span></p>
                            </li>
                            </ol>
                            </li>
                            </ol>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">By signing below, I agree to all the Terms and Conditions listed above.</span></p>
                        <table style="width: 96.2387%;">
                            <tbody>
                            <tr style="width: 100%;">
                            <td style="width: 37%; text-align: center; vertical-align: bottom;">{{ $data['enquiry']->full_name_with_title }}
                            <div style="width: 90%; height: 1px; background-color: black; margin: 4px auto 4px auto;">&nbsp;</div>
                            Your Name</td>
                            <td style="width: 31%; text-align: center; vertical-align: bottom;">
                            <p>&nbsp;</p>
                            <div style="width: 90%; height: 1px; background-color: black; margin: 4px auto 4px auto;">&nbsp;</div>
                            Your Signature</td>
                            <td style="width: 32%; text-align: center; vertical-align: bottom;">
                            <p>&nbsp;</p>
                            <div style="width: 90%; height: 1px; background-color: black; margin: 4px auto 4px auto;">&nbsp;</div>
                            Date</td>
                            </tr>
                            </tbody>
                        </table>
                    @php
                        $addedNames = is_array($data['addedNamesInput'])
                            ? $data['addedNamesInput']
                            : json_decode($data['addedNamesInput'], true);
                    @endphp

                   @foreach ($addedNames as $name)
                   <table style="width: 96.2387%; margin-bottom: 20px;">
                           <tbody>
                               <tr style="width: 100%;">
                                   <!-- Name Column -->
                                   <td style="width: 37%; text-align: center; vertical-align: bottom;">
                                       {{ $name }}
                                       <div style="width: 90%; height: 1px; background-color: black; margin: 4px auto;">&nbsp;</div>
                                       Your Name
                                   </td>

                                   <!-- Signature Column -->
                                   <td style="width: 31%; text-align: center; vertical-align: bottom;">
                                       <p>&nbsp;</p>
                                       <div style="width: 90%; height: 1px; background-color: black; margin: 4px auto;">&nbsp;</div>
                                       Your Signature
                                   </td>

                                   <!-- Date Column -->
                                   <td style="width: 32%; text-align: center; vertical-align: bottom;">
                                       <p>&nbsp;</p>
                                       <div style="width: 90%; height: 1px; background-color: black; margin: 4px auto;">&nbsp;</div>
                                       Date
                                   </td>
                               </tr>
                           </tbody>
                       </table>
                   @endforeach

                            <p style="margin-bottom: 0.14in; line-height: 120%; page-break-before: always;"><span style="font-family: 'Courier New', Courier, monospace;"> <span style="font-size: 14pt;"><u><strong>Useful Links: </strong></u></span> </span></p>
                            <ol>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><a href="https://assets.publishing.service.gov.uk/government/uploads/system/uploads/attachment_data/file/903098/Approved_Secure_English_Language_Tests_22.7.2020_.pdf"> <span style="font-family: 'Courier New', Courier, monospace;">UKVI APPROVED SECURE ENGLISH LANGUAGE TEST</span> </a></p>
                            </li>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><a href="https://www.gov.uk/government/publications/visa-regulations-revised-table/2020"> <span style="font-family: 'Courier New', Courier, monospace;">Visa application fee</span> </a></p>
                            </li>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><span style="font-family: 'Courier New', Courier, monospace;">UK-Pre departure TB clearance certificate from an <a href="https://www.gov.uk/tb-test-visa/countries-where-you-need-a-tb-test-to-enter-the-uk">approved clinic</a></span> <u> <span style="font-family: 'Courier New', Courier, monospace;"> </span> </u></p>
                            </li>
                            <li>
                            <p style="margin-bottom: 0.14in; line-height: 120%;"><a href="https://www.immigration-health-surcharge.service.gov.uk/checker/type"> <span style="font-family: 'Courier New', Courier, monospace;"><span style="background: #ffffff;">Immigration Health Surcharge (IHS) Fee</span></span> </a> <u> <span style="font-family: 'Courier New', Courier, monospace;"><span style="background: #ffffff;"> </span></span> </u></p>
                            </li>
                            </ol>
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
                                <h3>Send Email</h3>
                                <div class="attachment-list">
                                    <label for="">Attachments (if any)</label>
                                    <input type="file" name="attachments[]" class="form-control">
                                </div>
                                <button class="btn-sm btn-primary" id="addField">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <br>
                                <br>
                                <button name="action" value="loa" class="btn btn-primary">Send</button>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Parse the initial added names (either from the backend or an empty array if not present)
            let addedNames = JSON.parse(document.getElementById('added_names_input').value) || [];

            // Get the default full name from the server-side template
            const defaultFullName = "{{ $data['enquiry']->full_name_with_title }}";

            // DOM elements
            const nameField = document.getElementById('nameField');
            const fullNameDisplay = document.getElementById('fullNameDisplay');
            const addedNamesInput = document.getElementById('added_names_input');
            const newNameInput = document.getElementById('newNameInput');
            const addNameButton = document.getElementById('addNameButton');
            const saveNameButton = document.getElementById('saveNameButton');

            // Show modal on clicking "Add Name" button
            addNameButton.addEventListener('click', function() {
                // Open the modal using Bootstrap's Modal class
                const addNameModel = new bootstrap.Modal(document.getElementById('addNameModel'));
                addNameModel.show();
            });

            // Handle saving the new name
            saveNameButton.addEventListener('click', function() {
                const newName = newNameInput.value.trim();

                // If a name was entered, append it to the list of added names
                if (newName) {
                    addedNames.push(newName);
                    updateNameField(); // Update the name field with the new name list
                    newNameInput.value = ''; // Clear the input field
                    const addNameModel = bootstrap.Modal.getInstance(document.getElementById(
                        'addNameModel'));
                    addNameModel.hide(); // Close the modal
                }
            });

            // Function to update the name field (both the display and the hidden input)
            function updateNameField() {
                let namesToDisplay = [defaultFullName, ...addedNames]; // Start with the default full name

                if (namesToDisplay.length === 2) {
                    // If there is only one added name, display it with "&" separating it from the default name
                    fullNameDisplay.textContent = namesToDisplay.join(' & '); // E.g., "John Doe & Jane Smith"
                    nameField.value = namesToDisplay.join(' & '); // Same for the input field
                } else if (namesToDisplay.length > 2) {
                    // If there are more than two names, join with commas, and use "&" before the last name
                    const formattedNames = namesToDisplay.slice(0, -1).join(', ') + ' & ' + namesToDisplay[
                        namesToDisplay.length - 1];
                    fullNameDisplay.textContent = formattedNames; // E.g., "John Doe, Jane Smith & Alex Johnson"
                    nameField.value = formattedNames;
                } else {
                    // If only the default name is present, show just that
                    fullNameDisplay.textContent = namesToDisplay[0];
                    nameField.value = namesToDisplay[0];
                }

                // Update the hidden input with the current names (converted to JSON format)
                addedNamesInput.value = JSON.stringify(addedNames);
            }

            // Initialize the display with any previously added names
            updateNameField();
        });
    </script>
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

        @if (optional($data['cclapplication'])->servicefee_id != null)
            $('.servicefeeautocomplete').autoComplete('set', {
                value: "{{ $data['cclapplication']->servicefee_id }}",
                text: "{{ $data['cclapplication']->servicefee->name }} - {{ $data['cclapplication']->servicefee->category }}"
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
    <script>
        document.getElementById('saveButton').addEventListener('click', function() {
            const enquiryId = this.getAttribute('data-enquiry-id');

            // Collect form data
            const formData = {
                added_names_input: document.getElementById('added_names_input').value,
                full_address: document.querySelector('textarea[name="full_address"]').value,
                date: document.querySelector('input[name="date"]').value,
                advisor_id: document.querySelector('select[name="advisor_id"]').value,
                servicefee_id: document.querySelector('select[name="servicefee_id"]').value,
                bank_id: document.querySelector('select[name="bank_id"]').value,
                agreed_fee_currency_id: document.querySelector('select[name="agreed_fee_currency_id"]').value,
                agreed_fee: document.querySelector('input[name="agreed_fee"]').value,
                additional_notes: document.querySelector('textarea[name="additional_notes"]').value,

            };

            // Send data to the server using AJAX
            fetch(`/enquiry/cclapplication/${enquiryId}/save`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token
                    },
                    body: JSON.stringify(formData),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Data saved successfully!');
                    } else {
                        alert('Error saving data!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // When the "Load" button is clicked
            $('#loadButton').click(function(e) {
                e.preventDefault();

                // Get the enquiry ID from the data attribute
                var enquiryId = $(this).data('enquiry-id');

                // Show loading animation (if needed)
                $('.loading').show();

                // Make an AJAX GET request to the server to fetch data
                $.ajax({
                    url: '{{ route('load.cclapplication', ':id') }}'.replace(':id', enquiryId),
                    method: 'GET',
                    success: function(response) {
                        // Hide loading animation
                        $('.loading').hide();

                        // Populate the fields with the fetched data
                        $('#additional_notes').val(response.additional_notes);
                        //$('#discussion_details').val(response.discussion_details);
                        $('select[name="advisor_id"]').val(response.advisor_id);
                        $('select[name="servicefee_id"]').val(response.servicefee_id);
                        $('select[name="bank_id"]').val(response.bank_id);
                        $('select[name="agreed_fee_currency_id"]').val(response
                            .agreed_fee_currency_id);
                        $('input[name="agreed_fee"]').val(response.agreed_fee);

                        // If there are any other fields you need to populate, repeat the process above.
                    },
                    error: function() {
                        // Handle any errors
                        alert('Error loading data.');
                        $('.loading').hide();
                    }
                });
            });
        });
    </script>
    <script src="path/to/jquery.scrollbar.min.js"></script>

@endpush
