<p>This is to confirm {{$data['employee']->title}}. {{$data['employee']->full_name}}, D.O.B {{$data['employee']->dob_formatted}}
        is employed at {{$data['company_info']->name}} and holds a {{$data['type']}} position with the company.
    </p>
 
    <p>Please find below the details on record:</p>
    <table class='classic-table particular' border="1" style='border-collapse: collapse;'>
        <tbody>
            <tr>
                <td width="123">
                    <b>Employee's Name:</b>
                </td>
                <td>
                    {{$data['employee']->full_name}}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Employee's Address</b>
                </td>
                <td>
                    {{$data['address']}}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Job Type:</b>
                </td>
                <td>
                    {{$data['employment_info']->job_title}} ({{$data['employment_info']->region}})
                </td>
            </tr>



            <tr>
                <td>
                   <b>PAY Rate:</b>
                </td>
                <td>
                    {{$data['employment_info']->salary .'/'. $data['employment_info']->salary_arrangement}}
                </td>
            </tr>


            <tr>
                <td>
                    <b>Weekly hour of work:</b>
                </td>
                <td>
                {{$data['employment_info']->working_hours .' '. $data['employment_info']->working_time}}                </td>
            </tr>



            <tr>
                <td>
                   <b>Employment type:</b>
                </td>
                <td>
                {{$data['employment_info']->type }}                
            </td>
            </tr>

            <tr>
                <td>
                    <b>Employment start date:</b>
                </td>
                <td>
                {{$data['employment_info']->start_date_formatted }}                
            </td>
            </tr>

            <tr>
                <td>
                    <b>NI Number:</b>
                </td>
                <td>
                {{$data['employment_info']->ni_number }}                
            </td>
            </tr>

        </tbody>
    </table>
    <br>
    <p>
    If you require further information, please do not hesitate to contact me at the above 
    contact number or the employee’s manager/supervisor 
    {{$data['employment_info']->supervisor}} either by email {{$data['employment_info']->supervisor_email}} or 
        phone {{$data['employment_info']->supervisor_tel}}.
    </p>
    <br>