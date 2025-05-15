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
@include('partials.page_number')

@include('admin.partials.pdf_header',['company_info'=>$data['company_info'],'export'=>true])

    <h2>

        <u>Employee
            Contact Information</u>

    </h2>

    <p><b>Employee Details</b></p>
    <table width="450" cellpadding="2" cellspacing="0">
        <tr>
            <td style="border: 1px solid #000000;">
                Date:

            </td>
            <td style="border: 1px solid #000000;">
                {{$data['date']}}
            </td>
        </tr>
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

                Address:
            </td>
            <td style="border: 1px solid #000000;">

                {{$data['address']}}


            </td>
        </tr>

        <tr>
            <td style="border: 1px solid #000000;">

                Home Phone:
            </td>
            <td style="border: 1px solid #000000;">

                {{$data['contact']}}
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

                E-mail:
            </td>
            <td style="border: 1px solid #000000;">

                {{$data['email']}}
            </td>
        </tr>

    </table>
    <p>
        By signing this form I ({{$data['employee_name']}})
        hereby accept the terms and conditions regarding the employment and
        give {{$data['company_info']->name}} a full consent to hold my information and contact me in the
        future regarding employment related matters.
    </p>
    <p>
        I understand that {{$data['company_info']->name}} would implement an attendance system and
        I will fully comply with the new policies and procedures.
    </p>
        <p>
            <br>
        </p>
    <div style="width:100%;">
        <div style='display:inline-block'>
            <p>Employee Signature: ............................................................ </p>
        </div>
        
    </div>

    <div>
        <h4 style="margin-bottom:4px">Data Protection Notice:</h4>
        <p>{{$data['company_info']->name}} complies with the Data Protection
            Act 2018 (GDPR). Information collected by {{$data['company_info']->name}} will
            only be used for the purposes of dealing with you as an employee,
            an administration of the event. In case of an incident or emergency {{$data['company_info']->name}}
            may disclose the information to the Police, Home office or a relevant organisation.
            {{$data['company_info']->name}} will not use the data or share the data with any third parties for marketing
            or commercial purposes without prior explicit consent.
        </p>
    </div>


    <p>
        {{$data['company_info']->name}}.
        Registered in {{$data['company_info']->registered_in}}, Company Registration No
        {{$data['company_info']->registration_no}}.
    </p>
</body>

</html>