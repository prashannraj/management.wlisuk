<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style>
        body {
            margin: 20px
        }
    </style>
</head>

<body>
    @include('partials.page_number')

    @include('layouts.partials.pdf_header',['company'=>$data['company']])
    <table class="table table-striped table-responsive">
        <tbody>
            <tr>
                <th>Advisor Name:</th>
                <td>
                {{ $data['cpd']->advisor_name }}
                </td>
                <th>Advisor Number:</th>
                <td>{{$data['cpd']->advisor_number}}</td>
            </tr>

            <tr>
                <th>Organisation:</th>
                <td>
                {{ $data['cpd']->organization }}
                </td>
                <th>Organisation Number:</th>
                <td>{{$data['cpd']->organization_number}}</td>
            </tr>

            <tr>
                <th>CPD Period From:</th>
                <td>
                {{ $data['cpd']->period_from_formatted }}
                </td>
                <th>CPD Period To:</th>
                <td>{{$data['cpd']->period_to_formatted}}</td>
            </tr>

        </tbody>
    </table>
    <br><br>
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>Date of completion</th>
                <th>What did you learn?</th>
                <th>Why did you do this learning?</th>
                <th>Did you meet your objectives?</th>
                <th>How will you apply this learning?</th>
            </tr>
        </thead>

        <tbody>
            @foreach($data['cpd']->details as $cpdDetail)
            <tr>
                <td>{{$cpdDetail->date_formatted}}</td>
                <td>{{$cpdDetail->what}}</td>
                <td>{{$cpdDetail->why}}</td>
                <td>{{$cpdDetail->complete_objective}}</td>
                <td>{{$cpdDetail->apply_learning}}</td>


            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>