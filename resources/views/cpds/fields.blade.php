<!-- Advisor Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('advisor_id', 'Advisor') !!}
    {!! Form::select('advisor_id', $data['advisors'],null, ['class' => 'form-control','placeholder'=>"Select an option",'data-toggle'=>'populate','data-target'=>'#advisor_name']) !!}
</div>

<!-- Advisor Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('advisor_number', 'Advisor Number:') !!}
    {!! Form::text('advisor_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Advisor Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('advisor_name', 'Advisor Name:') !!}
    {!! Form::text('advisor_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Organization Field -->
<div class="form-group col-sm-6">
    {!! Form::label('organization', 'Organisation:') !!}
    {!! Form::text('organization', $data['company']->name, ['class' => 'form-control']) !!}
</div>

<!-- Organization Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('organization_number', 'Organisation Number:') !!}
    {!! Form::text('organization_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Period From Field -->
<div class="form-group col-sm-6">
    {!! Form::label('period_from', 'Period From:') !!}
    {!! Form::text('period_from', null, ['class' => 'form-control','id'=>'period_from']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#period_from').datepicker({
            format: '{{config("constant.cpd_date_format_javascript")}}',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Period To Field -->
<div class="form-group col-sm-6">
    {!! Form::label('period_to', 'Period To:') !!}
    {!! Form::text('period_to', null, ['class' => 'form-control','id'=>'period_to']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#period_to').datepicker({
            format: '{{config("constant.cpd_date_format_javascript")}}',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', getStatuses(), null, ['class' => 'form-control custom-select']) !!}
</div>
