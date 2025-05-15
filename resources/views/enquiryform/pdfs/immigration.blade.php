<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Verified</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=OPen+Sans">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>



    <style>
        body {
            font-family: "Open Sans";
            font-size: 16px;
            line-height: 1;
        }

        p {
            margin-top: 4px;
            margin-bottom: 4px;
            text-align: justify;
            line-height: 1;

        }
    </style>


    <style>
        .classic-table {
            width: 100%;
            color: #000;

        }

        th,
        tr {
            color: #000;
        }

        .table-bordered td {
            border-color: #000;
        }

        .table-bordered th {
            border-color: #000;
        }

        .particular td {
            padding: 6px
        }
    </style>
</head>

<body>


    <header style='border-bottom:2px solid red'>
        <table class='classic-table'>
            <tbody>
                <tr>
                    <td colspan="3">
                        <table>
                            <tbody>
                                <tr>

                                    <td>
                                        <img src="{{public_path($data['companyinfo']->logourl)}}" alt="">


                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="100%">
                    </td>
                    <td width="350px">
                        <table>
                            <tbody>
                                <tr>
                                    <td colspan="2"><b>{{$data['companyinfo']->name}}</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2">{{$data['companyinfo']->address}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">T: {{$data['companyinfo']->telephone}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">E: {{$data['companyinfo']->email}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">W: {{$data['companyinfo']->website}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>


                </tr>
            </tbody>
        </table>
    </header>



    <br>
    <br>
    <div style="display: flex; justify-content: space-between;">
        <p style="text-decoration:underline;font-weight:bold;text-align:center">Enquiry/Initial Attendance Form</p>
        <h2 style="text-align:right; color:rgb(76, 76, 76)">{{ $data['processed'] ? "ENQ{$data['enquiry']->id}" : 'Not Processed' }}</h2>
      </div>

    <br>
    {{-- <table class='classic-table particular' border="1" style='border-collapse: collapse;'>
        <tbody>
            <tr>
                <td>
                    Form Type:
                </td>
                <td>
                    {{$data['row']->form->name}}
                </td>
            </tr>
            <tr>
                <td>
                    Full Name:
                </td>
                <td>
                    {{$data['row']->title.". ".$data['row']->full_name}}
                </td>
            </tr>
            <tr>
                <td>
                    Email:
                </td>
                <td>
                    {{$data['row']->email}}
                </td>
            </tr>
            <tr>
                <td>
                    Tel/Mobile:
                </td>
                <td>
                    {{$data['row']->contact_number}}
                </td>
            </tr>

            <tr>
                <td>
                    Enquirer's Address:
                </td>
                <td>
                    {{$data['row']->full_address}}
                </td>
            </tr>

            <tr>
                <td>
                    Enquirer's Nationality:
                </td>
                <td>
                    {{$data['row']->nationality_country}}
                </td>
            </tr>

            <tr>
                <td>
                    Email Verification:
                </td>
                <td>
                    {{$data['row']->validated_status}}
                </td>
            </tr>
            <tr><td>Post Reference/Ho Ref:</td><td>{{$data['row']->ho_ref}}</td></tr>
            <tr><td>How was the decision received?</td><td>{{$data['row']->method_decision_received}}</td></tr>
            <tr><td>Do you have a UK Sponsor?</td><td>{{$data['row']->has_uk_sponsor}}</td></tr>
            <tr><td>Sponsor Name:</td><td>{{$data['row']->(sponsor_name)??''}}</td></tr>
            <tr><td>Relationship with Sponsor:</td><td>{{($data['row']->sponsor_relationship)??''}}</td></tr>
            <tr><td>Sponsor's Contact Email (if any):</td><td>{{($data['row']->sponsor_email)??''}}</td></tr>
            <tr><td>UK Sponsor Mobile/Contact:</td><td>{{($data['row']->sponsor_phone)??''}}</td></tr>
            <tr><td>Sponsor's Address:</td><td>{{($data['row']->sponsor_address)??''}}</td></tr>
            <tr><td>Sponsor City:</td><td>{{($data['row']->sponsor_city)??''}}</td></tr>
            <tr><td>UK preferred contact person, if different to the sponsor:</td><td>{{($data['row']->sponsor_preferred)??''}}</td></tr>
            <tr><td>UK preferred contact person's Email:</td><td>{{($data['row']->sponsor_preEmail)??''}}</td></tr>
            <tr><td>Application prepared by (Name/contact):</td><td>{{($data['row']->preparedby)??''}}</td></tr>
            <tr><td>Visa Application type:</td><td>{{($data['row']->visa)??''}}</td></tr>
            <tr><td>Their Contact details (Email/Telephone)::</td><td>{{($data['row']->appellant_email)??''}}</td></tr>
            <tr><td>Would you like to authorise additional contact who you wish to authorise to discuss your appeal matter?</td><td>{{($data['row']->authorise)}}</td></tr>
            <tr><td>Their Contact details (Email/Telephone)::</td><td>{{($data['row']->authorise_name)??''}}</td></tr>
        </tbody>
    </table> --}}
    {{-- class="table table-bordered table-striped" --}}
    <table class='classic-table particular' border="1" style='border-collapse: collapse;'>
        <thead>
            <tr>
                <th style="background-color: #2460a9; padding: 8px;"colspan="2" class="table-info">{{$data['row']->form->name}}</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <th style="background-color: #D4E1F8;" colspan="2" class="table-info">Refusal details:</th>
            </tr>
            <tr>
                <td>Refusal letter date (DD/MM/YYYY):</td>
                <td>{{ date('d/m/Y', strtotime($data['row']->refusalLetterDate)) }}</td>

            </tr>
            <tr>
                <td>Refusal received date (DD/MM/YYYY):</td>
                <td>{{ date('d/m/Y', strtotime($data['row']->refusalReceived)) }}</td>

            </tr>
            <tr>
                <td>Did you apply in the UK or outside the UK?</td>
                <td>{{$data['row']->applicationLocation}}</td>
            </tr>
            <tr>
                <td>Visa application (UAN/GWF Number):</td>
                <td>{{$data['row']->uan}}</td>
            </tr>
            <tr>
                <td>Post Reference/HO Ref:</td>
                <td>{{$data['row']->ho_ref}}</td>
            </tr>
            <tr>
                <td>How was the decision received? Post/Email/in-person:</td>
                <td>{{$data['row']->method_decision_received}}</td>
            </tr>
            <tr>
                <th style="background-color: #D4E1F8;" colspan="2" class="table-info">Appellant details:</th>
            </tr>
            <tr>
                <td>Title:</td>
                <td>
                    @if($data['row']->title == 'other')
                        {{ $data['row']->other_text }}
                    @else
                        {{ $data['row']->title }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Full Name:</td>
                <td>{{$data['row']->full_name}}</td>
            </tr>
            <tr>
                <td>Date of Birth (DD/MM/YYYY):</td>
                <td>{{ date('d/m/Y', strtotime($data['row']->birthDate)) }}</td>

            </tr>
            <tr>
                <td>National of:</td>
                <td>{{$data['row']->nationality_country}}</td>
            </tr>
            <tr>
                <th style="background-color: #D4E1F8;"colspan="2" class="table-info">Appellant contact details:</th>
            </tr>
           {{-- <tr>
                <td>Mobile Country Code:</td>
                <td>{{$data['row']->country_id}}</td>
            </tr>--}}
            <tr>
                <td>Mobile number:</td>
              <td>{{$data['row']->contact_number}}</td>
            </tr>
            <tr>
                <td>Appellants Email:</td>
                <td>{{$data['row']->email}}</td>
            </tr>
            <tr>
                <td>
                    Email Verification:
                </td>
                <td>
                    {{$data['row']->validated_status}}
                </td>
            </tr>
            <tr>
                <td>Appellants Country:</td>
                <td>{{ ucfirst($data['countries']->find($data['row']->appellant_nation)->title) }}</td>
            </tr>
            <tr>
                <td>Appellants address:</td>
                <td>{{$data['row']->appellant_address}}</td>
            </tr>
            <tr>
                <th style="background-color: #D4E1F8;"colspan="2" class="table-info">Sponsor details:</th>
            </tr>
            <tr>
                <td colspan="2">"Sponsor is someone who you are applying to join or remain in the UK e.g. Father, Mother, Sibling or a relative"</td>
            </tr>

            <tr>
                <td>Sponsor's Name:</td>
                <td>{{$data['row']->sponsor_name}}</td>
            </tr>
            <tr>
                <td>Relationship with sponsor</td>
                <td>{{$data['row']->sponsor_relationship}}</td>
            </tr>
            <tr>
                <td>Sponsor's address:</td>
                <td>{{$data['row']->sponsor_address}}</td>
            </tr>
            <tr>
                <td>Sponsor's contact Email (If any):</td>
                <td>{{$data['row']->sponsor_email}}</td>
            </tr>
            <tr>
                <td>UK Sponsor Mobile/Contact:</td>
                <td>{{$data['row']->sponsor_phone}}</td>
            </tr>
            <tr>
                <td>UK preferred contact person, if different to the sponsor:</td>
                <td>{{$data['row']->sponsor_preferred}}</td>
            </tr>
            <tr>
                <td>UK preferred contact person's Mobile number:</td>
                <td>{{$data['row']->name}}</td>
            </tr>
            <tr>
                <td>UK preferred contact person's Email:</td>
                <td>{{$data['row']->sponsor_preEmail}}</td>
            </tr>
            <tr>
                <th style="background-color: #D4E1F8;"colspan="2" class="table-info">Tell us who prepared your application?</th>
            </tr>
            <tr>
                <td>Application prepared by (Name/contact):</td>
                <td>{{$data['row']->preparedby}}</td>
            </tr>
            <tr>
                <td>Application visa category:</td>
                <td>{{$data['row']->visa}}</td>
            </tr>
            <tr>
                <td>Their Contact details (Email/Telephone):</td>
                <td>{{$data['row']->prepared_email}}</td>
            </tr>
            <tr>
                <th style="background-color: #D4E1F8;"colspan="2" class="table-info">Authorise additional contact:</th>
            </tr>
            <tr>
                <td colspan="2">Would you like to authorise additional contact who you wish to authorise to discuss your appeal matter?</td>
            </tr>
            <tr>
                <td>Please provide their Name's, contact phone</td>
                <td>{{$data['row']->authorise_name}}</td>
            </tr>
        </tbody>
    </table>

    <br>
    <br>
    <p style="text-decoration:underline;font-weight:bold;text-align:left">Enquiry/Instruction/Discussion</p>

    <br>
    <br>
    <div style="border:0.8px solid black;padding:20px">
          {{$data['row']->notes}}
    </div>
    <br>
    <div class="form-group">
        <input class="form-check-input" type="checkbox" id="allow" name='allow' checked value="1" />
        <label for="allow">
        I consent {{$data['companyinfo']->name}} to contact me regarding my enquiry and add my details to their mailing list.
I consent {{$data['companyinfo']->name}} to record my Internet Protocol (IP) address upon submission of this enquiry form.
I consent {{$data['companyinfo']->name}} to hold my personal information and IP address on their web server in the UK or in the EEA in compliance with Data Protection Act 2018 (GDPR).
        </label>

    </div>
    <p>Consent message above ticked: <b>{{$data['row']->created_at_formatted}}</b></p>

    <p>Consentee's Name: <b>{{$data['row']->full_name}}</b></p>
</body>
</html>
