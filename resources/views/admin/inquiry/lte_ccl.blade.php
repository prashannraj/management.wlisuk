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
                        <h6 class="h2 text-white d-inline-block mb-0">Send client care letter for {{ $data['enquiry']->full_name }}
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
            <h4 class='text-primary'>Generate Client Care Letter</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('enquiry.lteccl', $data['enquiry']->id) }}" enctype="multipart/form-data"
                method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Full Name:</label>
                            <input type="text" name="full_name_with_title" id="full_name_with_title" class="form-control"
                                value="{{ $data['lteccl']->full_name_with_title ?? $data['enquiry']->full_name_with_title }}">
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
                            <input type="text" name="date" id="date" class="form-control datepicker2" value="{{ old('date', \Carbon\Carbon::parse(optional($data['lteccl'])->date)->format('d/m/Y')) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Discussion Date</label>
                            <input type="text" class="form-control datepicker2" name='discussion_date'
                            value="{{ old('discussion_date', optional($data['lteccl'])->discussion_date ? \Carbon\Carbon::parse($data['lteccl']->discussion_date)->format('d/m/Y') : '') }}" placeholder="dd/mm/yyyy">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Visa Application Submitted Date</label>
                            <input type="text" class="form-control datepicker2" name='visa_application_submitted'
                            value="{{ old('visa_application_submitted', optional($data['lteccl'])->visa_application_submitted ? \Carbon\Carbon::parse($data['lteccl']->visa_application_submitted)->format('d/m/Y') : '') }}" placeholder="dd/mm/yyyy">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Select Advisor</label>
                            <select name="advisor_id" class="form-control">
                                <option value="">Select an advisor</option>
                                @foreach ($data['advisors'] as $advisor)
                                    <option
                                        {{ old('advisor_id', optional($data['lteccl'])->advisor_id) == $advisor->id ? 'selected' : '' }}
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
                                        {{ old('bank_id', optional($data['lteccl'])->bank_id) == $bank->id ? 'selected' : '' }}
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
                                        {{ old('agreed_fee_currency_id', optional($data['lteccl'])->agreed_fee_currency_id) == $currency->id ? 'selected' : '' }}
                                        value="{{ $currency->id }}">{{ $currency->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Visa Type</label>
                            <input type="text"
                                value="{{ old('visa_type', optional($data['lteccl'])->visa_type) }}"
                                class="form-control" name='visa_type'>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Agreed Fee</label>
                            <input type="text"
                                value="{{ old('agreed_fee', optional($data['lteccl'])->agreed_fee) }}"
                                class="form-control" name='agreed_fee'>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Tribunal Fee</label>
                            <input type="text"
                                value="{{ old('tribunal_fee', optional($data['lteccl'])->tribunal_fee) }}"
                                class="form-control" name='tribunal_fee'>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Vat</label>
                            <input type="text"
                                value="{{ old('vat', optional($data['lteccl'])->vat) }}"
                                class="form-control" name='vat'>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Travel Fee</label>
                            <input type="text"
                                value="{{ old('travel_fee', optional($data['lteccl'])->travel_fee) }}"
                                class="form-control" name='travel_fee'>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">FtT Re-appearance Fee</label>
                            <input type="text"
                                value="{{ old('reappear_fee', optional($data['lteccl'])->reappear_fee) }}"
                                class="form-control" name='reappear_fee'>
                        </div>
                    </div>

                    <div class="col-md-12"> <!-- Full width for new textarea -->
                        <div class="form-group">
                            <label for="additional_notes">Discussion/Notes:</label>
                            <textarea id="c" name="additional_notes" class='form-control wysiwyg' rows='3'
                                placeholder="Enter any additional notes here...">{{ old('additional_notes', optional($data['lteccl'])->additional_notes) }}</textarea>
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
                                <p>Thank you for instructing <strong>{{ $data['company_info']->name ?? 'Default text here' }}</strong> We are a regulated by <strong>{{ $data['company_info']->regulated_by }}</strong>. We are authorised to provide immigration advice and services in the categories of <strong>{{ $data['advisor']->category ?? 'Default category here' }}</strong>. Our registration number is <strong>{{ $data['company_info']->regulation_no }}</strong>.</p>

                                <p>Thank you for your instructions. Thank you for instructing me to act on your behalf about your immigration matter.</p>

                                <h3 style="text-decoration: underline;">Who is dealing with your case?</h3>
                                <p>My name is <strong>{{ $data['advisor']->name ?? 'Default name here' }}</strong> and I will be handling your case. I am authorised to provide immigration advice and services at <strong>{{ $data['advisor']->level ?? 'Default name here' }}</strong> in the categories of <strong>{{ $data['advisor']->category ?? 'Default category here' }}</strong>.</p>

                                <h3 style="text-decoration: underline;">Key details about your case:</h3>
                                @php
                                    use Carbon\Carbon;

                                    $appealDeadline = null;
                                    if (!empty($data['rawInquiry']->refusalreceivedDate)) {
                                        $refusalDate = Carbon::parse($data['rawInquiry']->refusalreceivedDate);
                                        $appealDeadline = $refusalDate->addDays(28)->format('d F Y'); // Adding 28 days and formatting the date
                                    }
                                @endphp
                                <ul>
                                    <li>Visa application submitted: <strong>{{ \Carbon\Carbon::parse($data['lteccl']->visa_application_submitted)->format('d F Y') ?? 'Default date' }}</strong></li>
                                    <li>Application type: <strong>{{$data['rawInquiry']->form_type ?? ""}}</strong></li>
                                    <li>Refusal letter date (DD/MM/YYYY): <strong>{{ \Carbon\Carbon::parse($data['rawInquiry']->refusalLetterDate)->format('d F Y') ?? ""}}</strong></li>
                                    <li>Refusal received date (DD/MM/YYYY):<strong> {{ \Carbon\Carbon::parse($data['rawInquiry']->refusalreceivedDate)->format('d F Y') ?? ""}}</strong></li>
                                    <li>Where was the application made:<strong> {{$data['rawInquiry']->applicationLocation ?? ""}}</strong></li>
                                    <li>Visa application (UAN/GWF Number):<strong> {{$data['rawInquiry']->uan ?? ""}}</strong></li>
                                    <li>Post Reference/HO Ref:<strong> {{$data['rawInquiry']->ho_ref ?? ""}}</strong></li>
                                    <li>How was the decision received:<strong> {{$data['rawInquiry']->method_decision_received ?? ""}}</strong></li>
                                    <li>Sponsors Name (if applicable):<strong> {{$data['rawInquiry']->sponsor_name ?? ""}}</strong></li>
                                    <li>Relationship with the sponsor: <strong>{{$data['rawInquiry']->sponsor_relationship ?? ""}}</strong></li>
                                    <li>Appeal deadline: <strong>{{ \Carbon\Carbon::parse( $appealDeadline)->format('d F Y') ?? 'N/A' }}</strong></li>
                                </ul>

                                <h3 style="text-decoration: underline;">INSTRUCTIONS/DISCUSSIONS</h3>
                                <p>I write further to our discussion on the (<strong>{{ \Carbon\Carbon::parse($data['lteccl']->discussion_date)->format('d F Y') ?? 'Default discussion date'}}</strong>) when you instructed me to act for you in connection with your Entry clearance application and its refusal.</p>
                                <p>{{$data['lteccl']->additional_notes ?? 'Default discussion notes'}}</p>
                                <h3 style="text-decoration: underline;">Reason for the refusal:</h3>
                                <p>I read to you the reason for refusal given to you by the Home Office and explained to you what they mean in a simple term.</p>

                                <h3 style="text-decoration: underline;">Advice Given:</h3>
                                <ul>
                                    <li>I advised you that you must submit the appeal before the deadline (<strong>{{ $appealDeadline ?? 'N/A' }}</strong>) as advised above.</li>
                                    <li>I advised you that your application was refused as home office claims you do not meet the immigration rules and the above reasons for refusal.</li>
                                    <li>I advised to you that we can bring the appeal to the first-tier tribunal under section 82(1)(b) of the Nationality Immigration and Asylum Act 2002 ("the 2002 Act") (as amended), against the decision of the Respondent (Home Office) to refuse a human rights claim.</li>
                                    <li>I also advised you that the appeal can be brought to the first-tier tribunal on the basis of the only ground available under section 84(2) of the 2002 Act (as amended), namely that the decision is unlawful under section 6 of the Human Rights Act 1998.</li>
                                    <li>I also advised you that the appeal can be brought to the first-tier tribunal on the basis the decision is unlawful under section 6(1) of the Human Rights Act 1998 because it creates a real risk of a breach of the following articles of the European Convention on Human Rights:</li>
                                    <ul>
                                        <li>Article 8 (family life) Article 8(1) family life - “real”, “effective” or “committed” support</li>
                                    </ul>
                                    <li><b>I also advised you that your appeal is also based on the historic injustice your father faced and the grant of delayed settlement.</b></li>
                                    <li><b>I also advised you that the success of the matter is not guaranteed and is influenced by many factors which I will explain below.</b></li>
                                </ul>

                                <p>We will assist in preparing the appeal against the decision. Once the appeal is submitted with the grounds, we will receive direction to prepare for court hearing. We will reach out to the Sponsor, Appellants or any Witnesses in support of this appeal matter.</p>

                                <p>You and your sponsor and additional corroborating witnesses will be invited to provide a detailed statement and all evidence relating to your family life with your sponsor. This evidence can include:</p>
                                <ul>
                                    <li><b>Travel records</b> shown in your passport.</li>
                                    <li><b>Telephone records</b>, such as calling cards, text messages, or messages from smartphone applications like Viber, WhatsApp, or Messenger.</li>
                                    <li><b>Evidence of financial and emotional support</b> from your sponsor or other family members, which can include:</li>
                                    <ul>
                                        <li>Bank statements showing pension withdrawals in your location, especially if you are authorised to withdraw such funds.</li>
                                        <li>Money transfer receipts (e.g. Ria Financial Services, Taptap Send, WorldRemit, Remitly, Crosspay, IME, Western Union, MoneyGram, etc.) proving that your sponsor or family members have been sending you money since they moved to the UK or when the support began.</li>
                                        <li>Proof that either your parents/sponsor or you are claiming a family life with support you, or you support them.</li>
                                    </ul>
                                </ul>

                                <p>Additional documents requested during the casework process can be sent to us via email or posted to the address provided below.</p>

                                <h3 style="text-decoration: underline;">Termination of Instructions</h3>
                                <p><b>You may end your instructions to us at any time, but this must be done in writing. If we stop working on your matter, whether you terminate our instructions or for other reasons outlined below, we have the right to retain all your documents and papers until any outstanding charges and expenses are fully paid.</b></p>

                                <p><b>There may be situations where you believe we should stop acting for you, such as losing confidence in how we are handling your case. Similarly, we may choose to stop acting for you, but only for valid reasons. Examples include failure to pay an interim bill or to make a payment requested on account.</b></p>

                                <p><b>If we decide to stop working on your case, we will provide reasonable notice. If we stop acting for you because of unpaid bills or payments on account of costs or expenses, and your matter involves litigation, we may apply to the court to formally withdraw as your legal representatives. After this, you would proceed as a "litigant in person."</b></p>

                                <h3 style="text-decoration: underline;">The work I will carry out</h3>
                                <p>The work I will be undertaking on your behalf includes the following steps:</p>
                                <ol>
                                    <li>Submitting an appeal to the First Tier Tribunal to challenge the decision to refuse your UK visa application.</li>
                                    <li>Reviewing your documents and planning the appeal process.</li>
                                    <li>Drafting witness statements that detail what your witnesses intend to say. Either I or my caseworker, under my supervision, will prepare these statements, and I will review and finalise them.</li>
                                    <li>Compiling an electronic (PDF) bundle of relevant documents for submission to the Tribunal. My caseworker will assemble this bundle, and I will check it.</li>
                                    <li>Drafting a skeleton argument—a document that outlines our case's key facts and legal arguments. This will either be prepared by expert counsel we will instruct or by the counsel you request, if they are available.</li>
                                    <li>Submitting the appellant's bundle and skeleton argument in accordance with the Tribunal's directions.</li>
                                    <li>Reviewing any response from the other side with you and counsel. If needed, I will address their concerns and submit supplementary evidence.</li>
                                </ol>

                                <p>Finally, I will:</p>
                                <ul>
                                    <li>Prepare for the appeal hearing and arrange for counsel to represent you in court and present the arguments.</li>
                                </ul>

                                <h3 style="text-decoration: underline;">Timeline for the Work</h3>
                                <ol>
                                    <li>Within 21 days of receiving this signed agreement and the agreed payment, I will review your documents and provide a plan for the case to my caseworker, if applicable.</li>
                                    <li>Once I have the necessary documents, either my caseworker or I will interview the witnesses and draft their statements.</li>
                                    <li>After completing the draft witness statements and collecting all necessary evidence, I will review the documents and oversee the preparation of the PDF bundle. This will be done promptly and in time to meet any Tribunal deadlines.</li>
                                    <li>Once the bundle is complete, it will be sent to counsel for preparation of the skeleton argument. If for any reason I am unable to complete any of the above steps (for example, due to missing documents), I will inform you and advise how we can request more time from the Tribunal.</li>
                                </ol>

                                <h3 style="text-decoration: underline;">Respondent's Role in the Appeal</h3>
                                <p>The respondent in your appeal will be the Entry Clearance Officer or Home Office Presenting Officer. This person represents the Secretary of State for the Home Department (the Home Office). Their role is to argue that your appeal should be dismissed.</p>

                                <p>After submitting the documents (the bundle and skeleton argument), the respondent may raise new issues. You might also provide new documents that introduce fresh challenges. If a new document or issue arises, I will address it. If the new issues are straightforward, counsel will handle them during the hearing. If the issues are complex and could jeopardise the appeal, I will advise you and outline any additional work needed, such as drafting a new witness statement or writing a supplementary legal explanation. You can then decide whether you wish to proceed with this additional work, which would involve an extra fee.</p>

                                <h3 style="text-decoration: underline;">Additional Work</h3>
                                <p>If further work is required, a new agreement will be issued. While I will handle all current work personally, I may not be able to accept instructions for future work due to other professional commitments. I will inform you of my availability as soon as possible.</p>

                                <h3 style="text-decoration: underline;">OPENING TIMES</h3>
                                <p>We are based at <strong>{{ $data['company_info']->address ?? 'Default text here' }}</strong>. The normal hours of work are from 10 am to 5 pm Monday to Friday. We are completely <strong>remote and online service</strong>. If you are unable to access technology or post, please inform us. We may need to ask you to seek local litigator. Zoom appointments can be arranged within and outside these hours when essential for your interest. My emergency number is <strong>{{ $data['advisor']->contact ?? 'Default contact here' }}</strong>. Please only use in an urgent situation.</p>

                                <h3 style="text-decoration: underline;">COST</h3>
                                <p><b>Legal costs: We estimate initially costs in the region of £<strong>{{$data['lteccl']->agreed_fee ?? 'Default agreed fee'}}</strong> plus VAT (if applicable), tribunal fee of £<strong>{{$data['lteccl']->tribunal_fee ?? 'Default tribunal fee'}}</strong> per applicant and disbursements. (VAT applicable only to in country applications).</b></p>

                                <p><b><u>Our charges may vary according to the nature of your case. If further work is required in addition to the initial instructions, then additional costs will be added as incurred.</u></b></p>

                                <p>“VAT” means value added tax – a sales tax. If you live in the UK or have leave in the UK, I have to add <strong>{{$data['lteccl']->vat ?? 'Default vat'}}</strong> % by law.</p>

                                <h3 style="text-decoration: underline;">Payment terms:</h3>
                                <p>Payment in full on engagement or as agreed prior to completion of work prior to the application being sent or as advised by the advisor (instruction will be sent). Payments The invoice is to be paid in advance into our business bank account (clients account if applicable) below on signing this client care and prior to the evidence being sent. An invoice will be raised on completion of the instruction and on receipt of the payment.</p>
                                <h3 style="text-decoration: underline;">Payment:</h3>
                                <p>The invoice is to be paid in advance into our business bank account (clients account if applicable) below on signing this client care and prior to the evidence being sent. An invoice will be raised on completion of the instruction and on receipt of the payment.</p>
                                @if ($data['bank'])
                                <div>
                                    {!! $data['bank']->formattedDetails() !!}
                                </div>
                                @else
                                <p>No bank information available.</p>
                                @endif
                                <p>Payment reference: <strong>ENQ{{$data['enquiry']->id}}</strong></p>

                                <p><u>Please note that this <b>does not</b> include a Tribunal fee, the postal cost for the return of the documents.</u></p>
                                <p><u><b>We charge</b> for the work carried out on the case irrespective of the outcome. We do not operate on a “no win no fee basis”.</u></p>
                                <p><b>The fee is a single fee which covers the following work:</b></p>

                                <h3 style="text-decoration: underline;">Preparation:</h3>
                                <p>Planning the appeal, interviewing witnesses, drafting the witness statements, checking them and preparing the PDF bundle. You and I agree I will not start work until you have paid the fee.</p>

                                <h3 style="text-decoration: underline;">Appeal work:</h3>
                                <p>Preparing the skeleton argument or sending it to the counsel for the skeleton argument, booking a counsel to appear at the hearing. You and I agree that we will not start work until I have the witness statements, and I will not book a counsel, prepare or appear at the hearing unless you have paid the fee.</p>

                                <p>Please note that if the hearing is listed outside of London or outside where the counsel/advisor is based (and I or the counsel have to travel because the hearing is held face-to-face and not via video) we will need to charge an extra <strong>£{{$data['lteccl']->travel_fee ?? 'Default Travel fee'}} + VAT (if applicable) </strong>to cover hotel and travel. Because we do not yet know where the hearing will be, you do not have to pay this at the moment, but if the hearing is listed outside of London or outside the area where the counsel/advisor lives, I will not be able to attend unless you pay the travel expenses in advance.</p>

                                <h3 style="text-decoration: underline;">Hearings</h3>
                                <p>We will inform you of the hearing date once it is provided by the Tribunal. The hearing may take place in person at the Tribunal hearing centre or via video. If it is a video hearing, witnesses must have access to a computer, tablet, or smartphone with a camera and internet connection. If any witnesses are employed, they will need to arrange time off work to attend the hearing, and you should inform them of the date in advance.</p>

                                <p>To communicate with witnesses at court or during a video hearing, we will require assistance from someone who is not a witness to act as an interpreter if any witness does not speak English. You will need to arrange for this interpreter. It can be a relative, family friend, or a professional interpreter. If you need recommendations, we can suggest professional interpreters, but their fees will be your responsibility.</p>

                                <p>Occasionally, a case may not proceed as planned on the scheduled day due to factors like insufficient judges, the judge running out of time, or unforeseen issues such as new documents or witness errors. Cases may start but not finish, or they may be postponed (adjourned) to a later date.</p>

                                <p>During the hearing, situations might arise where a counsel or representative need to decide whether to request or agree to a postponement. If we are unable to contact you in the moment, we will use the counsel’s suggestion and our professional judgment to decide if postponement is necessary to protect your case. Please let us know in advance if you do not want us to make such decisions on your behalf.</p>

                                <p>If the case extends beyond one day, or if I or the appointed counsel attend a hearing that does not proceed as scheduled (whether it does not start or is postponed), there will be a new charge for the hearing, an additional fee of <strong>£{{$data['lteccl']->reappear_fee ?? 'Default ReAppear fee'}}</strong><b>+ VAT (if applicable) </b> each extra day <b>[Note: this is payable to the counsel for the appearance].</b></p>

                                <h3 style="text-decoration: underline;">OUTCOME OF THE MATTER</h3>
                                <p>We will try our best to get a favourable outcome on all matters. However, success is not guaranteed, and the outcome is dependent upon the merit of your case. We do not operate on a “no win no fee basis”.</p>

                                <h3 style="text-decoration: underline;">REPORT ON PROGRESS</h3>
                                <p>We will update you by telephone or in writing with progress on your matter regularly but at least every six weeks and we will always try to keep you informed of any unexpected delays or changes in the character of the work. You may enquire at any day with me about a progress of your case.</p>

                                <h3 style="text-decoration: underline;">HOW LONG IT TAKE TO RESOLVE THE MATTER</h3>
                                <p>The time scale: Due to various circumstances, the time an appeal can take ranges between six months to a year sometimes even more.</p>
                                <p class="font-bold mt-8"> Note: Tribunal are independent, and we have no influence over it to speed the process. An expedition can be requested in a special circumstance only.</p>

                                <h3 style="text-decoration: underline;">EQUALITY AND DIVERSITY</h3>
                                <p>We are committed to promoting equality and diversity in all our dealings with clients, third parties and employees. Please contact us if you would like a copy of our equality and diversity policy.</p>

                                <h3 style="text-decoration: underline;">COMPLAINTS</h3>
                                <p>We are committed to high-quality legal advice and client care. When something goes wrong, we need you to tell us about it. This will help us to maintain and improve our standards.</p>

                                <p>If you are unhappy about any aspect of the service you have received, please contact me on <strong>{{ $data['advisor']->contact ?? 'Default contact here' }}</strong> or <strong>{{ $data['company_info']->email ?? 'Default text here' }}</strong> or by post to our registered address at Complaints, <strong>{{ $data['company_info']->name ?? 'Default text here' }}</strong><strong>{{ $data['company_info']->address ?? 'Default address here' }}</strong>.</p>

                                <h3 style="text-decoration: underline;">Our complaints procedure</h3>
                                <p>If you have a complaint, please contact us with the details. If we have to change any of the timescales set out below, we will let you know.</p>
                                <p>What will happen next?</p>
                                <ol>
                                    <li>Within 2 weeks of receiving your complaint, I will send you a letter acknowledging your complaint and asking you to confirm or explain the details. I may suggest that we meet to clarify any details.</li>
                                    <li>I will then record your complaint in our central register and open a file for your complaint and investigate your complaint. This may involve one or more of the following steps.</li>
                                    <li>I will consider your complaint again. I will then send you my detailed reply or invite you to a meeting to discuss the matter.</li>
                                    <li>Within two days of the meeting I will write to you to confirm what took place and any solutions I have agreed with you. Inappropriate cases, I could offer an apology, a reduction of any bill or a repayment in relation to any payment received.</li>
                                </ol>

                                <p><strong>{{ $data['company_info']->name ?? 'Default text here' }}</strong> intends to resolve any complaint within 6 weeks of receiving it.</p>
                                <p>Please note that alternatively, you can make yours complain directly to the <strong>{{ $data['company_info']->regulated_by }}</strong>, who regulate all Immigration Advisors, by completing the <strong>{{ $data['company_info']->regulated_by }}</strong> complaint’s form. This form is available in a range of languages on the website, www.gov.uk/iaa.</p>

                                <p>You can also make yours complain in writing to the Immigration Advice Authority (IAA), PO Box 567, Dartford, DA1 9XW or by email at <u>info@immigrationadviceauthority.gov.uk.</u> Telephone: 0345 000 0046. Website: www.gov.uk/iaa.</p>

                                <h3 style="text-decoration: underline;">CONFIDENTIALITY</h3>
                                <p>We are under the duty to keep your affairs confidential to our firm and to ensure that our staffs do the same. If we are to release any confidential information which is unauthorised then this can lead to disciplinary action against us. The duty of confidentiality applies to information about your affairs and general information.</p>

                                <p>It is likely that during the course of the work we undertake certain information may have to be disclosed to the third parties, for example, counsels, experts for reports. We will only disclose such information having discussed the matter with you, having obtained your consent to disclose information or where we are under a professional obligation to do so.</p>

                                <h3 style="text-decoration: underline;">INSPECTION OF FILES AND QUALITY STANDARDS</h3>
                                <p><strong>{{ $data['company_info']->regulated_by }}
                                </strong> may need to access your file whilst checking my competence. <strong>{{ $data['company_info']->regulated_by }}</strong> does not require permission to inspect my client files. Please be assured that they will maintain your confidentiality at all times.</p>

                                <h3 style="text-decoration: underline;">TRANSFER OF FILE</h3>
                                <p>If you wish to instruct other Firms to deal with your matter, we will transfer your file to another adviser/solicitor/barrister, but you will still pay our fees. We will always release your file whether you have paid us or not. We may take action in the county courts to recover our fees should you refuse to pay.</p>

                                <h3 style="text-decoration: underline;">INSURANCE COVER</h3>
                                <p>We maintain Professional Indemnity Insurance.</p>

                                <h3 style="text-decoration: underline;">PAPERS HELD BY US AND DOCUMENT CUSTODY</h3>
                                <p>On completion of matters, I will return your original documents to you unless otherwise agreed with you. We will undertake to retain files for at least six years in line with <strong>{{ $data['company_info']->regulated_by }}</strong> Code of Standards. We reserve the right to destroy the files without further reference to you after retaining the files for the period stated above.</p>

                                <h3 style="text-decoration: underline;">ACTION BY YOURSELF</h3>
                                <p>To enable us to provide you with an efficient service, you are committing yourself to ensure that:</p>
                                <ul>
                                    <li>You always keep us updated whenever any of your contact details change. We need to be able to contact you when necessary.</li>
                                    <li>You will provide us with clear, timely and accurate instructions.</li>
                                    <li>You will provide all documentation required to complete the transaction in a timely manner.</li>
                                    <li>You will safeguard and provide any documents which are likely to be required for the matter.</li>
                                    <li>You will update and inform your witnesses of the hearing and the attendance.</li>
                                </ul>

                                <p>To proceed with your Immigration Appeal, you must sign the client care letter and provide your GDPR consent as mentioned at the end of this letter. Please note that we can commence work on your case only upon receipt of these documents.</p>



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

        @if (optional($data['lteccl'])->servicefee_id != null)
            $('.servicefeeautocomplete').autoComplete('set', {
                value: "{{ $data['lteccl']->servicefee_id }}",
                text: "{{ $data['lteccl']->servicefee->name }} - {{ $data['lteccl']->servicefee->category }}"
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
