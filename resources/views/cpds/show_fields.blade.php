<div class="row">
    <!-- Id Field -->
<div class="col-md-4">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $cpd->id }}</p>
</div>
<!-- Advisor Name Field -->
<div class="col-md-4">
    {!! Form::label('advisor_name', 'Advisor Name:') !!}
    <p>{{ $cpd->advisor_name }}</p>
</div>

<!-- Advisor Number Field -->
<div class="col-md-4">
    {!! Form::label('advisor_number', 'Advisor Number:') !!}
    <p>{{ $cpd->advisor_number }}</p>
</div>


<!-- Organization Field -->
<div class="col-md-4">
    {!! Form::label('organization', 'Organisation:') !!}
    <p>{{ $cpd->organization }}</p>
</div>

<!-- Organization Number Field -->
<div class="col-md-4">
    {!! Form::label('organization_number', 'Organisation Number:') !!}
    <p>{{ $cpd->organization_number }}</p>
</div>

<!-- Period From Field -->
<div class="col-md-4">
    {!! Form::label('period_from_formatted', 'Period From:') !!}
    <p>{{ $cpd->period_from_formatted }}</p>
</div>

<!-- Period To Field -->
<div class="col-md-4">
    {!! Form::label('period_to_formatted', 'Period To:') !!}
    <p>{{ $cpd->period_to_formatted }}</p>
</div>

<!-- Status Field -->
<div class="col-md-4">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $cpd->status }}</p>
</div>

<!-- Updated At Field -->
<div class="col-md-4">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $cpd->updated_at->format("d F Y h:i:s a") }}</p>
</div>


</div>