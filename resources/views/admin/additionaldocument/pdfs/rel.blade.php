<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Representation Letter</title>


    <style>
        @php include(public_path('assets/css/argon.css')) @endphp @php include(public_path('assets/css/colors.css')) @endphp @php $export=true;

        @endphp
    </style>

    <style>
        body {
            background: "white";
            font-family: "Open Sans";
            line-height: 1;
        }

        p {
            font-size: 16px;
            color: black;
            line-height: 1;
        }

        .classic-table {
            width: 100%;
            color: #000;
        }

        th,
        tr {
            color: black;
        }
    </style>

</head>

<body>
@include('partials.page_number')


    @include("admin.partials.pdf_header",["company_info"=>$data['company_info']])
    <p>
        Date: @if($data["date"])<b>{{$data['date']}}</b>@endif
    </p>
    
    <p class="western" style="text-align: center;">
       <b> <u>To Whom It May Concern,</u></b>
    </p>

    <p style="margin-bottom: 0.14in">
        This is
        to confirm we are representing the following client regarding their
        immigration matters:
    </p>
    <table width="500" cellpadding="7" cellspacing="0">


        <tr valign="top">
            <td width="240" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p>
                    Client’s
                    Name:

                </p>
            </td>
            <td width="260" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p>
                    {{$data['client']->full_name_with_title}}

                </p>
            </td>
        </tr>
        <tr valign="top">
            <td width="240" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p>
                    Client's
                    Date of birth:
                </p>
            </td>
            <td width="260" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p>
                    {{$data['client']->date_of_birth}}
                </p>
            </td>
        </tr>
        <tr valign="top">
            <td width="240" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p>
                    Client’s
                    Nationality:
                </p>
            </td>
            <td width="260" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p>
                    {{$data['client']->nationality}}
                </p>
            </td>
        </tr>
        <tr valign="top">
            <td width="240" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p>
                    Client’s
                    Passport/ID number:
                </p>
            </td>
            <td width="260" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p>
                    {{$data['passport_number']}}

                </p>
            </td>
        </tr>
        <tr valign="top">
            <td width="240" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p>
                    Application
                    Type:
                </p>
            </td>
            <td width="260" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p>
                    {{$data['application_type']}}

                </p>
            </td>
        </tr>
        <tr valign="top">
            <td width="240" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p>
                    Application
                    Submission Date:
                </p>
            </td>
            <td width="260" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p>
                    {{$data['application']->date_submitted_format("d F Y")}}
                </p>
            </td>
        </tr>
        <tr valign="top">
            <td width="240" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p>
                    Unique
                    Application Number:
                </p>
            </td>
            <td width="260" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p>



                    <b>{{$data['application']->ref}}</b>



                </p>
            </td>
        </tr>
    </table>
    <p style="margin-bottom: 0in; line-height: 100%"><br />

    </p>
    <p style="margin-bottom: 0in; line-height: 100%">
        Our
        records show that the client’s application has been submitted
        online, and documents uploaded to the UKVI through the application
        portal.
    </p>
    <p style="margin-bottom: 0in; line-height: 100%"><br />

    </p>
    <p style="margin-bottom: 0.14in">

        <b>{{$data['client_name']}}</b>
        remains lawfully in the United Kingdom under the same terms and
        conditions of {{$data['client']->gender=='Male'?'his':'her'}} last grant of leave by virtue of Section 3C of the
        Immigration Act 1971 (as amended).

    </p>
    <p style="margin-bottom: 0.14in">
        Immigration
        status checks can be carried out by the employer by visiting the
        following employer checking service link below or calling prevention
        of illegal working on 0300 1235 434.
    </p>
    <p style="margin-bottom: 0.14in"><a href="https://www.gov.uk/employee-immigration-employment-status">https://www.gov.uk/employee-immigration-employment-status</a></p>
    <p style="margin-bottom: 0.14in">
        Please
        use unique application reference number
        (<b>{{$data['application']->ref}}</b>)

        where the reference/Case ID is requested.
    </p>
    <p style="margin-bottom: 0.14in">
        Please
        do not hesitate to contact us at the contact address above to verify
        any of the details included in this letter.
    </p>
    <p style="margin-bottom: 0.14in">
        Yours
        sincerely,
    </p>
    <table>
        <tbody>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <img style="height:auto" src="{{public_path($data['application']->advisor->signature_url)}}" width="120" alt="">
                            </td>

                        </tr>
                        <tr>

                            <td>
                                <p style="line-height: 0.8;margin:0px;padding:0px">{{$data['application']->advisor->name}}</p>
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <p style="line-height: 0.8;margin:0px;padding:0px">{{$data['company_info']->name}}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <img style="height:auto" src="{{public_path($data['company_info']->stamp_url)}}" width="150" alt="">

            </td>
        </tbody>
    </table>

</body>

</html>