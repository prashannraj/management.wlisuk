<div class="row">
    <!-- Date Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('date', 'Date:') !!}
        {!! Form::text('date', null, ['class' => 'form-control','id'=>'date']) !!}
    </div>

    @push('page_scripts')
    <script type="text/javascript">
        $('#date').datepicker({
            format: '{{config("constant.date_format_javascript")}}',
            useCurrent: true,
            sideBySide: true
        })
    </script>
    @endpush

    <!-- What Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('what', 'What did you learn?:') !!}
        {!! Form::text('what', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Why Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('why', 'Why did you learn this learning?:') !!}
        {!! Form::text('why', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Complete Objective Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('complete_objective', 'Did you meet your objectives?:') !!}
        {!! Form::text('complete_objective', null, ['class' => 'form-control']) !!}
    </div>


    <!-- Apply Learning Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('apply_learning', 'How will you apply this learning?') !!}
        {!! Form::text('apply_learning', null, ['class' => 'form-control']) !!}
    </div>
</div>