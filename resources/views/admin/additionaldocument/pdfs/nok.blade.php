<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title></title>
    <meta name="generator" content="LibreOffice 6.4.6.2 (Linux)" />
    <meta name="author" content="Rupak Paudyal" />
    <meta name="created" content="2020-04-24T10:03:00" />
    <meta name="changed" content="2020-11-30T19:40:41.260638284" />
    <meta name="AppVersion" content="16.0000" />
    <meta name="DocSecurity" content="0" />
    <meta name="HyperlinksChanged" content="false" />
    <meta name="LinksUpToDate" content="false" />
    <meta name="ScaleCrop" content="false" />
    <meta name="ShareDoc" content="false" />
    <style>
        body {
            background: "white";
            font-family: "Open Sans";
        }

        p {
            font-size: 15px;
            color: black;
        }

        td {
            font-size: 14px;
        }

        .classic-table {
            width: 100%;
            color: #000;
        }

        th,
        tr {
            color: black;
        }

        .ml-4 {
            margin-left: 4em;
        }
    </style>
</head>

<body lang="en-GB" link="#000080" vlink="#800000" dir="ltr">
@include('admin.partials.pdf_header',['company_info'=>$data['company_info'],'export'=>true])

    <h2>

        <u>Employee
            Next of Kin Information</u>

    </h2>
    <p>
        <i>Please
            complete this form as accurately as possible. These details will help
            us should we need to get hold of you or your Next of Kin urgently or
            in an emergency.</i>
    </p>
    <p><b>Employee Details</b></p>
    <table width="450" cellpadding="2" cellspacing="0">

        <tr>
            <td style="border: 1px solid #000000;">
                Employee ID:

            </td>
            <td style="border: 1px solid #000000;">
                {{$data['employee_id']}}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #000000;">

                Employee Full Name:
            </td>
            <td style="border: 1px solid #000000;">

                {{$data['employee']->full_name_with_title}}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #000000;">

                Current Address:
            </td>
            <td style="border: 1px solid #000000;">

                {{$data['address']}}


            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #000000;">

                E-mail:
            </td>
            <td style="border: 1px solid #000000;">

                {{$data['email']}}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #000000;">

                Mobile:
            </td>
            <td style="border: 1px solid #000000;">

                {{$data['mobile']}}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #000000;">

                Tel:
            </td>
            <td style="border: 1px solid #000000;">

                {{$data['contact']}}
            </td>
        </tr>
    </table>
    <p class="western"><b>Next of Kin Details (a close relative or friend)</b></p>
    <table width="450" cellpadding="2" cellspacing="0">


        <tr>
            <td style="border: 1px solid #000000;">

                Full Name:
            </td>
            <td style="border: 1px solid #000000;">

                {{$data['next_of_kin_name']}}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #000000;">

                Relationship:
            </td>
            <td style="border: 1px solid #000000;">

                {{$data['next_of_kin_relationship']}}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #000000;">

                Address:
            </td>
            <td style="border: 1px solid #000000;">
                {{$data['next_of_kin_address']}}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #000000;">

                Phone No 1 (with country code):
            </td>
            <td style="border: 1px solid #000000;">

                {{$data['next_of_kin_contact']}}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #000000;">

                E-mail:
            </td>
            <td style="border: 1px solid #000000;">

                {{$data['next_of_kin_email']}}
            </td>
        </tr>
    </table>
    <p>

        I
        hereby authorise {{$data['company_info']->name}} to hold my data in compliance
        with The Data Protection Act 2018 (GDPR).

    </p>
    <p style="margin-bottom: 0in;">
        I
        ({{$data['employee']->full_name}}), hereby confirm {{$data['next_of_kin_name']}}
        have consented their details to be provided and held by
        {{$data['company_info']->name}} in relation to my employment.
    </p>
    <p style="margin-bottom: 0in;">
        I
        ({{$data['employee']->full_name}}), hereby consent {{$data['company_info']->name}} to contact the
        above next of Kin during emergency or to establish contact if the
        company manager or relevant person(s) were unable to contact me for
        2 working days.
    </p>

    <p style="margin-bottom: 0in;">
        <b>By
            signing below, I {{$data['employee']->full_name}} have agreed to all the above T&amp;C.</b>
    </p>

    <p><br></p>

    <div style="width:100%;">
        <div style="width:30%;display:inline-block">

            <p style='text-align: center;margin-right:5px'>
                <span ><b>{{$data['employee_name']}}</b> </span><br />
                <span style="margin-top:3px;border-top:1px black dashed;padding-top:3px;display:block">Employee Name</span>
            </p>


        </div>

        <div style="width:30%;display:inline-block">
            <p style='text-align: center;'>
                <span style="opacity:0;display:none">Invisible text</span><br />
                <span style="margin-top:3px;border-top:1px black dashed;padding-top:3px;display:block">Signature</span>
            </p>

        </div>
        <div style="width:30%;display:inline-block;margin-left:5px">
            <p style='text-align: center;'>
                <span><b>{{$data['date']}} </b></span><br />
                <span style="margin-top:3px;border-top:1px black dashed;padding-top:3px;display:block">Date</span>

            </p>

        </div>
        <div style="clear:both"></div>
    </div>


    <p>
        {{$data['company_info']->name}}.
        Registered in {{$data['company_info']->registered_in}}, Company Registration No
        {{$data['company_info']->registration_no}}.
    </p>
</body>

</html>