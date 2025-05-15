<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">


    <link rel="stylesheet" href="{{ asset('assets/css/argon.css')}}" type="text/css">


</head>

<body class='bg-white'>


    <div class="container">



        <header style='border-bottom:2px solid red'>
            <div class="row justify-content-between">
                <div class="col-md-4">
                    <img src="{{$data['companyinfo']->logourl}}" alt="">

                </div>
                <div class="col-md-4">
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
                </div>
            </div>
        </header>

        <main class='mt-4'>
            <p class="alert-primary">
               Thank you for submitting your online enquiry to {{$data['companyinfo']->name}}.</br>
                    Please check your email to verify and activate your enquiry so that we can proceed.</br>
                    NOTE: If you do not see the email, please ensure that you have entered the correct email address. Additionally, check your junk/spam folder for emails from {{$data['companyinfo']->email}}.</br>
                    Once located, open the email and click the verification link provided within.

            </p>
        </main>



        <br><br>
        <table style="border:1px">
            <tbody>
                <tr>
                    <td width="100%">
                        {{$data['companyinfo']->name}}. Registered in {{$data['companyinfo']->registered_in}}, Company Registration No. <b>{{$data['companyinfo']->registration_no}}</b>
                        , Regulated by {{$data['companyinfo']->regulated_by}}, Authorisation No. <b>{{$data['companyinfo']->regulation_no}}</b>.
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <script src="https://www.google.com/recaptcha/api.js"></script>

</body>

</html>