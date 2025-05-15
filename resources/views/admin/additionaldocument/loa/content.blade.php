
    <p align="justify" class='mt-4' style="margin-bottom: 0.14in;margin-top:10px">
        I, <b>{{$data['client_name']}}</b> do hereby instruct <b>{{$data['company_info']->name}}</b> of
        <b>{{$data['company_info']->address}}</b> to act and represent me in respect of my Immigration matter.
    </p>
    <p align="justify" style="margin-bottom: 0.14in">
        My personal details are given below:
    </p>
    <table style="width:1000px;margin-right:auto;margin-left:auto" cellpadding="7" cellspacing="0">


        <tbody>
            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        Full Name:
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['client_name']}}</b>
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        D.O.B:
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['client']->dob}}</b>
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        National of:
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['client']->nationality}}</b>

                    </p>
                </td>
            </tr>
            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        Applicant Current Address
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['address']}}</b>

                    </p>
                </td>
            </tr>
            <tr valign="top">
                <td width="132" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        Parental address (child
                        applicant)
                    </p>
                </td>
                <td width="100%" style="border: 1px solid #000000; padding: 0in 0.08in">
                    <p>
                        <b>{{$data['parental_address']}}</b>

                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <p align="justify" style="margin-bottom: 0.14in"><br />
        <br />

    </p>
    <p align="justify" style="margin-bottom: 0.14in">
        I further authorise {{$data['company_info']->name}} to communicate with my previous
        representatives, IAC, Home office and Data Protection Unit to obtain all necessary information, records and
        documentary evidence.
    </p>
