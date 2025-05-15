<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Third party consent</title>


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


    <p class='' style="color:#4f81bd;">

        <u><b>Consent
                for the {{$data['company_info']->name}}
                to hold and process third party information</b></u>

    </p>

    <p class="western" style="margin-bottom: 0.14in">
        <u><b>Client's
                Details:</b></u>
    </p>
    <table style="width:100%" cellpadding="7" cellspacing="0">
        <tbody>
            <tr style="width: 100%;" valign="top">
                <td width="162" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p class="western">
                        Full Name:
                    </p>
                </td>
                <td style="width:250;border: 1px solid #000000; padding: 0in 0.08in">
                    <p class="western" align="justify">
                        {{$data['client_name']}}

                    </p>
                </td>
            </tr>
            <tr style="width: 100%;" valign="top">
                <td width="162" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p class="western">
                        Date of birth:
                    </p>
                </td>
                <td style="width:250;border: 1px solid #000000; padding: 0in 0.08in">
                    <p class="western" align="justify">
                        {{$data['client']->dob}}

                    </p>
                </td>
            </tr>
            <tr style="width: 100%;" valign="top">
                <td width="162" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p class="western" align="justify">
                        National of:
                    </p>
                </td>
                <td style="width:250;border: 1px solid #000000; padding: 0in 0.08in">
                    <p class="western" align="justify">
                        {{$data['client']->nationality}}

                    </p>
                </td>
            </tr>
            <tr style="width: 100%;" valign="top">
                <td width="162" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p class="western" align="justify">
                        Applicant’s Current
                        Address
                    </p>
                </td>
                <td style="width:250;border: 1px solid #000000; padding: 0in 0.08in">
                    <p class="western" align="justify">
                        {{$data['address']}}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <p style="margin-bottom: 0in; line-height: 100%"><br />

    </p>
    <ol>
        <li>
            <p style="margin-bottom: 0in; line-height: 100%">



                If
                any information or documentation showing ownership provided to us is
                in the joint names of the client and another person (or persons),
                the joint owner should sign the following declaration.



            </p>
        <li>
            <p style="margin-bottom: 0in; line-height: 100%">



                If
                any documents provided to the {{$data['company_info']->name}} or its advisor is
                named and addressed to another person (or persons), the owner of the
                document should sign the following declaration.



            </p>
    </ol>

    <p style="margin-bottom: 0in; line-height: 100%">



        The
        above-named person (‘the client’) has given the {{$data['company_info']->name}}
        information or documentation and agreed that the {{$data['company_info']->name}}
        can store or process that such information or documentation or pass
        it on to the relevant authority regarding the case (i.e. Home Office,
        visa authorities or other relevant authorities) to verify
        authenticity and in support of their application.



    </p>
    <p style="margin-bottom: 0in; line-height: 100%"><br />

    </p>
    <p style="margin-bottom: 0in; line-height: 100%">



        I
        am a joint owner or a supporting party with the client of some or all
        of that information or documentation.



    </p>
    <p style="margin-bottom: 0in; line-height: 100%"><br />

    </p>
    <p style="margin-bottom: 0in; line-height: 100%">



        I
        understand that information about the client may also reveal
        information about me.



    </p>
    <p style="margin-bottom: 0in; line-height: 100%"><br />

    </p>
    <p style="margin-bottom: 0in; line-height: 100%">



        I
        agree to the provider of the information or documentation giving the
        relevant data (including personal data) that it holds about me.



    </p>
    <p style="margin-bottom: 0in; line-height: 100%"><br />

    </p>
    <p style="margin-bottom: 0in; line-height: 100%">



        I
        understand that this only covers data about me in my capacity as
        joint owner/sponsor or guarantor of the relevant information with the
        client (and not about any other information it may hold about me
        either in my capacity as an individual or jointly together with a
        third party) and is limited to:



    </p>
    <ul>
        <li>
            <p style="margin-bottom: 0.03in; line-height: 100%">



                such
                relevant data as is necessary to confirm that the information or
                documentation that the client has supplied is genuine and correct;



            </p>
        <li>
            <p style="margin-bottom: 0.03in; line-height: 100%">



                if
                that information or documentation is not correct, relevant data
                relating to any irregularities, inaccuracies or discrepancies in the
                information or documentation that the applicant has provided,
                including as to the correct information that the provider of the
                information holds.



            </p>
    </ul>
    <p style="margin-bottom: 0in; line-height: 100%"><br />

    </p>
    <p style="margin-bottom: 0in; line-height: 100%">



        I
        understand that this information or documentation may be used to make
        a decision on the client’s application and for related purposes.



    </p>
    <p style="margin-bottom: 0in; line-height: 100%"><br />

    </p>
    <table width="100%" cellpadding="7" cellspacing="0">


        <tr style="width: 100%;" valign="top">
            <td width="140" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p style="margin-bottom: 0in;text-align: right;margin-right:30px">

                



                        Name
                        and address of joint owner:

<br/>
                </p>
                <br>
           
            </td>
            <td width="162" style="border: 1px solid #000000; padding: 0in 0.08in">


                <p style="margin-bottom: 0in">

                <b>{{$data['joint_name']}}</b>, {{$data['joint_address']}}

                </p>

            </td>
        </tr>
        <tr style="width: 100%;" valign="top">
            <td width="140" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p style="text-align: right;margin-right:30px">

                    Signature:

                </p>
            </td>
            <td width="162" style="border: 1px solid #000000; padding: 0in 0.08in">

                <p style="margin-bottom: 0in"><br />

                </p>

            </td>
        </tr>
        <tr style="width: 100%;" valign="top">
            <td width="140" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p style="text-align: right;margin-right:30px"> 



                    Date:



                </p>
            </td>
            <td width="162" style="border: 1px solid #000000; padding: 0in 0.08in">
                <p style="margin-bottom: 0in">
                    @if($data["date"])
                    <b>{{$data['date']}}</b>


                    @endif
                </p>
                <p><br />

                </p>
            </td>
        </tr>
    </table>
  

</body>

</html>