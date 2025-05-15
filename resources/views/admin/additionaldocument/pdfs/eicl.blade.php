<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Immigration visa status letter</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=OPen+Sans">


    <style>
        body {
            font-family: "Open Sans";
            font-size: 16px;
            line-height: 1;
        }

        p {
            
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
@include('partials.page_number')


    <header style='border-bottom:2px solid red'>
        <table class='classic-table'>
            <tbody>
                <tr>
                    <td colspan="3">
                        <table>
                            <tbody>
                                <tr>

                                    <td>
                                        <img src="{{public_path($data['company_info']->logourl)}}" alt="">


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
                                    <td colspan="2"><b>{{$data['company_info']->name}}</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2">{{$data['company_info']->address}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">T: {{$data['company_info']->telephone}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">E: {{$data['company_info']->email}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">W: {{$data['company_info']->website}}</td>
                                </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
            </tbody>
        </table>
    </header>



    <p>Private and Confidential<br>
        {{$data['employee_name']}}
        <br>
        {{$data['address']}}
        <br>
        {{$data['postal_code']}}

    </p>


    <p>Date: <b>{{$data['date']==null? date('d M Y'):$data['date']}}</b></p>
    <br>
    <p>Dear {{$data['employee']->f_name}},</p>
    <br>


    <p style="text-decoration:underline;font-weight:bold;text-align:center">RE: Immigration, Asylum and Nationality Act 2006</p>
    <br><br>
    <p>As part of your continuous employment with {{$data['company_info']->name}} employees are required to provide
         the company with confirmation of their eligibility to work in the UK by providing the 
        relevant original document or documents detailed at the bottom of this letter.</p>

    <p>
    I am now requesting that you provide me with the confirmation of your eligibility to live
     and work in the UK, following a VISA Check by the company being
     returned as ineligible to work in the United Kingdom.
    </p>

    <p>
    In line with the Home Office guidelines you are not entitled to apply for a 
    new permit until at least 28 days before your current permit expires.
     Having reviewed your current permit this does not expire until {{$data['visa']->expiry_date}}.
    </p>

    <p>
    Therefore, you are not entitled to apply for a new residence 
    permit until at least {{$data['visa']->expiry_date_raw->subDays(28)->format(config('constant.date_format'))}}.
    </p>

    <p>
    Due to this you have until {{$data['visa']->expiry_date_raw->subDays(7)->format(config('constant.date_format'))}} to contact me 
        on {{$data['employee']->current_employment_info->supervisor_tel}} to arrange a suitable time to meet with me to provide me 
        with documentation of your eligibility to live and work in the UK.
    </p>

    <p>
    Please be advised that, if the original document or documents referred to below have not been produced by {{$data['visa']->expiry_date}}, 
        we will suspend you on nil pay for failure to provide Eligibility Documents.
    </p>
    <p>
    The list below details documents that would be acceptable to us a proof of your eligibility to live and work in the UK.
    </p>
    <p>
    Copy documentation is not acceptable. The document(s) will then be checked, and
     a copy will be taken and retained on your personnel file.
    </p>
    <p>Required:</p>
    <ol>
        <li>Biometric Residence Permit (BRP)</li>
        <li>Residence Card (Biometric Format)</li>
    </ol>
    <p>Citizen of the United Kingdom and Common Travel Area (including the right of abode)</p>
    <ol type="i">
        <li style="vertical-align: baseline;">UK Passport</li>
        <li>UK Birth and Adoption Certificate</li>
        <li>Certificate of Registration or Naturalisation as a British Citizen</li>
        <li>Right of Abode Certificate</li>
    </ol>
    <ol>
        <li>EU Settlement Scheme confirmation documentation</li>
        <li>Asylum Claimants</li>
        <li>Migrants with a right to work
      
            <ol type='i'>
                <li>Immigration Status Documents</li>
                <li>List of Documents that demonstrate a right to work
               
                    <ol>
                        <li>A passport Vignette that permits employment or indicates that there are no work restrictions</li>
                        <li>An Immigration Status Document (ISD)</li>
                        <li>Further leave to remain application submission confirmation or Home office issued letter with confirmation of receipt of
                             the application with case ID or reference number.</li>
                    </ol>
                </li>
            </ol>
        </li>
    </ol> 

          
    <p>If you have any questions, please contact me on {{$data['letter_signer']->email}}.</p>
    <br>
    <p>Yours sincerely,</p>
    <br>
    <table class=''>
        <tbody>
            <tr>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <img style="height:auto" src="{{public_path($data['letter_signer']->signature_url)}}" width="120" alt="">
                                </td>

                            </tr>
                            <tr>

                                <td>{{$data['letter_signer']->full_name}}</td>

                            </tr>
                            <tr>
                                <td>{{$data['company_info']->name}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <img style="height:auto" src="{{public_path($data['company_info']->stamp_url)}}" width="150" alt="">

                </td>
            </tr>
        </tbody>
    </table>


    <br><br>
    <table style="border:1px">
        <tbody>
            <tr>
                <td width="100%">
                    {{$data['company_info']->name}}. Registered in {{$data['company_info']->registered_in}}, Company Registration No. <b>{{$data['company_info']->registration_no}}</b>
                    , Regulated by {{$data['company_info']->regulated_by}}, Authorisation No. <b>{{$data['company_info']->regulation_no}}</b>.
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>