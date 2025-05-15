<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$data['form']->title}}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400&display=swap">
    <link rel="stylesheet" href="{{ asset('assets/css/argon.css')}}" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css" integrity="sha512-TQQ3J4WkE/rwojNFo6OJdyu6G8Xe9z8rMrlF9y7xpFbQfW5g8aSWcygCQ4vqRiJqFsDsE1T6MoAOMJkFXlrI9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #additional_contact_info {
            display: none;
        }
    </style>
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
            <h1 class='display-4 text-center text-underlined'><u>{{$data['form']->title}}</u></h1>
            <form action="{{ $data['form']->form_url }}" method="POST" enctype="multipart/form-data" >
                <input type="hidden" name="form_id" value="{{$data['form']->id}}">
                @csrf
                @includeIf('enquiryform.forms.'.$data['form']->type,['row'=>null])
                <p>
                    <div class="g-recaptcha" data-sitekey="6LeKX5gqAAAAAPwgUlPo9fSCFR9Ljq2sRv6-jo2q"></div>
                </p>
                {!! isError($errors, 'g-recaptcha-response',"Please solve the captcha and try again.") !!}
                <div class="form-group container">
                    <input class="form-check-input" type="checkbox" id="allow" name='allow' value="1" />
                    <label for="allow">
                    I consent {{$data['companyinfo']->name}} to contact me regarding my enquiry and add my details to their mailing list.
I consent {{$data['companyinfo']->name}} to record my Internet Protocol (IP) address upon submission of this enquiry form.
I consent {{$data['companyinfo']->name}} to hold my personal information and IP address on their web server in the UK or in the EEA in compliance with Data Protection Act 2018 (GDPR).</label>

                </div>
                {!! isError($errors, 'allow',"Please tick the consent box above to to comply with Data Protection Act 2018 (GDPR).") !!}

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" style="width: 150px;">Send</button>
                </div>

            </form>
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('#date_of_decision').datepicker({
            format: "dd/mm/yyyy"
        });
        jQuery('#contact_person_address').hide();
        jQuery('#contact_person_address_option').on('change', function(e) {
            e.preventDefault();
            if(jQuery(this).val() == 'yes'){
                jQuery('#contact_person_address').show();
            } else {
                jQuery('#contact_person_address').hide();
            }
        })

        $(document).ready(function () {
            jQuery('#contact_person_address_option').on('change', function(e) {
                var checkedContactPerson = jQuery('#contact_person_address_option option:selected').val();
                if(checkedContactPerson == 'yes') {
                    jQuery('#additional_contact_info').show();
                } else {
                    jQuery('#additional_contact_info').hide();
                }
            });
        });
    </script>
    <script>
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
    'secret' => config('cms.recaptcha_secret_key'),
    'response' => $request->input('g-recaptcha-response'),
    'remoteip' => $request->ip(),
]);

if (!$response->json('success')) {
    return back()->withErrors(['g-recaptcha-response' => 'Captcha verification failed.']);
}

    </script>

</body>

</html>
