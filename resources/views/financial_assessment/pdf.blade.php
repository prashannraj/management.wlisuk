<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$data['filename']}}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">


    <style>
        body {
            font-family: "Inconsolata";
            font-size: 18px;
            line-height: 1;
        }

        p {
            margin-top: 4px;
            margin-bottom: 4px;
            text-align: justify;
            line-height: 1.2;

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



    @if($data['row']->employment_details()->count()>0 && $data['parameters']['document_type']!='saving_only')
    <h2>

        Financial Assessment
    </h2>

    @foreach($data['employment_details'] as $emp)

    @if($emp->sponsor_name != null)
    <h3>Evidence of Sponsor's income ({{$emp->sponsor_name}})</h3>
    @else
    <h3>Evidence of applicant's income</h3>
    @endif

    <table class="classic-table particular" border="1" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th>Payslip Date</th>
                <th>Company</th>
                <th>Gross pay ({{$emp->currency->title}})</th>
                <th>Net pay ({{$emp->currency->title}})</th>
                <th>Paid into bank date</th>
                <th>Proof sent</th>
                <th>Note</th>

            </tr>

        </thead>
        <tbody>
            @foreach($emp->payslips()->orderBy("date","desc")->get() as $payslip)
            <tr>
                <td>{{$payslip->date_formatted}}</td>
                <td>{{$emp->company_name}}</td>
                <td>{{$payslip->gross_pay}}</td>
                <td>{{$payslip->net_pay}}</td>
                <td>{{$payslip->bank_date_formatted}}</td>
                <td>{{$payslip->proof_sent}}</td>
                <td>{{$payslip->note}}</td>

            </tr>

            @endforeach
        </tbody>

    </table>

    @if($emp->calculation_type=="6 months")
    <p>Gross total (6 months): <b>{{$emp->currency->title}} {{$emp->total}}</b> @if(!$emp->is_gbp)~ <b>GBP {{$emp->total_in_gbp}}</b>  @endif </p>
    <p>Gross total (12 months): <b>{{$emp->currency->title}} {{$emp->total * 2}}</b> @if(!$emp->is_gbp)~ <b>GBP {{$emp->total_in_gbp  * 2}}</b>  @endif </p>
    @else
    <p>Gross total (12 months): <b>{{$emp->currency->title}} {{$emp->total}}</b> @if(!$emp->is_gbp)~ <b>GBP {{$emp->total_in_gbp}}</b>  @endif  </p>
    @endif


    @endforeach

    <h3><u>Summary</u></h3>
    @php
    $grand_total = 0;
    @endphp
    @foreach($data['employment_details'] as $emp)
    <p>Income from {{$emp->company_name}} (12 months): <b>{{$emp->currency->title}} {{$emp->gross_total}}</b> @if(!$emp->is_gbp)~ <b>GBP {{$emp->gross_total_in_gbp}}</b>  @endif </p>
    @php
    $grand_total+= $emp->gross_total_in_gbp;
    @endphp
    @endforeach
    <p>Total income from all employments (12 months): <b>GBP {{$grand_total}}</b> </p>
    @endif

    @if($data['parameters']['document_type'] == 'salary_saving' || $data['parameters']['document_type'] == 'saving_only')
    @if($data['parameters']['document_type']=='salary_saving')
    <h2>Savings Summary</h2>

    <table border="1" style="border-collapse: collapse;">
        <tbody>
            <tr>

                <td>
                    Salary Required
                </td>
                <td>GBP {{$data['parameters']['minimum_salary']}}</td>
            </tr>
            <tr>
                <td>
                    Shortfall from Salary
                </td>
                <td>GBP {{$data['row']->shortfall($data['parameters']['minimum_salary'])}}</td>

            </tr>
            <tr>
                <td>
                    2.5x of shortfall from salary
                </td>
                <td>GBP {{number_format($data['row']->shortfall($data['parameters']['minimum_salary'])*2.5,2)}}</td>

            </tr>
            <tr>
                <td>Minimum savings per rule</td>
                <td>GBP 16000</td>
            </tr>
            <tr>
            <td>
            Required saving to cover salary shortfall</td>
            <td>
                GBP
            {{ number_format( $data['row']->shortfall($data['parameters']['minimum_salary'])*2.5 + 16000,2) }}
            </td>
            </tr>
           
        </tbody>
    </table>
    @endif
    <h2>Savings available</h2>
    <table border="1" style="border-collapse: collapse;">
        <tbody>
        @foreach($data['saving_infos'] as $saving_info)
            <tr>
                <td>
                    @if($saving_info->sponsor_name!=null)
                    Sponsor's saving account at
                    @else
                    Applicant's saving account at
                    @endif
                    {{$saving_info->bank_name}}

                </td>
                <td>
                    {{$saving_info->currency->title}}
                    {{number_format($saving_info->closing_balance,2)}}
                </td>
               @if(!$saving_info->in_gbp)
               <td>
                    GBP {{number_format($saving_info->closing_balance_in_gbp,2)}}
                </td>
                @else 
                <td> GBP {{number_format($saving_info->closing_balance_in_gbp,2)}} </td>
               @endif
            </tr>
            @endforeach

            <tr>
                <td>Total Combined savings from all
                    account prior to application</td>
                    <td></td>
                <td>
                   <b> GBP {{number_format($data['row']->total_savings,2)}}</b>
                </td>
                
            </tr>
        </tbody>
    </table>

    @foreach($data['row']->saving_infos as $info)
        @if($info->sponsor_name != null)
            <h3>{{$info->sponsor_name}} (Sponsor's Savings Statement Summary)</h3>
        @else
            <h3>Applicant's savings statement summary</h3>
        @endif

        <table border="1" style="border-collapse: collapse;">
            <tr>
                <td>Bank</td>
                <td colspan="2">{{$info->bank_name}}</td>
            
            </tr>
            <tr>
                <td>Account Name</td>
                <td colspan="2">
                    {{$info->account_name}}
                </td>
            </tr>
            <tr>
                <td>Country Held</td>
                <td colspan="2">{{$info->country_name}}</td>
            </tr>
            <tr>
                <td>Account No</td>
                <td colspan="2">{{$info->account_number}}</td>
            </tr>
            <tr>
                <td>Saving start date</td>
                <td colspan="2">
                {{$info->start_date_formatted}}

                </td>
            </tr>

            <tr>
                <td>Closing balance date</td>
                <td colspan="2">
                    {{$info->closing_date_formatted}}
                </td>
            </tr>

            <tr>
                <td>Minimum balance on any given date during the last 6 months</td>
                <td>
                {{$info->currency->title}} {{$info->minimum_balance}}
                </td>
                <td>
                    GBP {{number_format($info->minimum_balance_in_gbp,2)}}
                </td>
            </tr>

            <tr>
                <td>Closing balance</td>
                <td>
                    {{$info->currency->title}} {{$info->closing_balance}}
                </td>
                <td>
                    GBP {{number_format($info->closing_balance_in_gbp,2)}}
                </td>
            </tr>
        </table>

    @endforeach

    @endif





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

</body>

</html>