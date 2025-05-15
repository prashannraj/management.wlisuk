@php 
if(!isset($disabled)) $disabled = '';

@endphp

<input type="hidden" {{$disabled}}  name="employee_id" value="{{old('employee_id',$data['row']->employee_id)}}">

<div class="col-md-6">
    <div class="form-group">
        <label for="job_title">Job Title</label>
        <input required {{$disabled}}  name='job_title' value="{{old('job_title',$data['row']->job_title)}}" type="text" class="form-control">
        {!! isError($errors, 'job_title') !!}

    </div>
</div>


<div class="col-md-6">
    <div class="form-group">
        <label for="start_date">Start date</label>
        <input required {{$disabled}}  name='start_date' autocomplete="off" value="{{old('start_date',$data['row']->start_date_formatted)}}" type="text" class="form-control datepicker">
        {!! isError($errors, 'start_date') !!}

    </div>
</div>



<div class="col-md-6">
    <div class="form-group">
        <label for="type">Employment type</label>
        <select {{$disabled}}  name="type" id="" class="form-control">
            <option value="">Select type</option>
            @foreach(getJobTypes() as $jt)
            <option {{old('type',$data['row']->type) == $jt?"selected":""}} value="{{$jt}}">{{ucfirst($jt)}}</option>
            @endforeach
        </select>
        {!! isError($errors, 'type') !!}

    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="working_hours">Working hours</label>
        <input required {{$disabled}}  name='working_hours' value="{{old('working_hours',$data['row']->working_hours)}}" type="text" class="form-control">
        {!! isError($errors, 'working_hours') !!}

    </div>
</div>


<div class="col-md-6">
    <div class="form-group">
        <label for="working_days">Working days</label>
        <input required {{$disabled}}  name='working_days' value="{{old('working_days',$data['row']->working_days)}}" type="text" class="form-control">
        {!! isError($errors, 'working_days') !!}

    </div>
</div>



<div class="col-md-6">
    <div class="form-group">
        <label for="working_time">Working time</label>
        <input required {{$disabled}}  name='working_time' value="{{old('working_time',$data['row']->working_time)}}" type="text" class="form-control">
        {!! isError($errors, 'working_time') !!}

    </div>
</div>


<div class="col-md-6">
    <div class="form-group">
        <label for="salary">Salary</label>
        <input required {{$disabled}}  name='salary' value="{{old('salary',$data['row']->salary)}}" type="text" class="form-control">
        {!! isError($errors, 'salary') !!}

    </div>
</div>



<div class="col-md-6">
    <div class="form-group">
        <label for="salary_arrangement">Salary arrangement</label>
        <input required {{$disabled}}  name='salary_arrangement' value="{{old('salary_arrangement',$data['row']->salary_arrangement)}}" type="text" class="form-control">
        {!! isError($errors, 'salary_arrangement') !!}

    </div>
</div>


<div class="col-md-6">
    <div class="form-group">
        <label for="ni_number">NI number</label>
        <input required {{$disabled}}  name='ni_number' value="{{old('ni_number',$data['row']->ni_number)}}" type="text" class="form-control">
        {!! isError($errors, 'ni_number') !!}

    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="end_date">End Date (optional)</label>
        <input {{$disabled}}  name='end_date' autocomplete="off" value="{{old('end_date',$data['row']->end_date_formatted)}}" type="text" class="form-control datepicker">
        {!! isError($errors, 'end_date') !!}

    </div>
</div>


<div class="col-md-6">
    <div class="form-group">
        <label for="place_of_work">Place of work</label>
        <input {{$disabled}}  name='place_of_work' value="{{old('place_of_work',$data['row']->place_of_work)}}" type="text" class="form-control">
        {!! isError($errors, 'place_of_work') !!}

    </div>
</div>


<div class="col-md-6">
    <div class="form-group">
        <label for="region">Region</label>
        <input required {{$disabled}}  name='region' value="{{old('region',$data['row']->region)}}" type="text" class="form-control">
        {!! isError($errors, 'region') !!}

    </div>
</div>


<div class="col-md-6">
    <div class="form-group">
        <label for="supervisor">Supervisor's name</label>
        <input required {{$disabled}}  name='supervisor' value="{{old('supervisor',$data['row']->supervisor)}}" type="text" class="form-control">
        {!! isError($errors, 'supervisor') !!}

    </div>
</div>



<div class="col-md-6">
    <div class="form-group">
        <label for="supervisor_email">Supervisor's email</label>
        <input required {{$disabled}}  name='supervisor_email' value="{{old('supervisor_email',$data['row']->supervisor_email)}}" type="text" class="form-control">
        {!! isError($errors, 'supervisor_email') !!}

    </div>
</div>


<div class="col-md-6">
    <div class="form-group">
        <label for="supervisor_tel">Supervisor's telephone</label>
        <input required {{$disabled}}  name='supervisor_tel' value="{{old('supervisor_tel',$data['row']->supervisor_tel)}}" type="text" class="form-control">
        {!! isError($errors, 'supervisor_tel') !!}

    </div>
</div>



<div class="col-md-6">
    <div class="form-group">
        <label for="probation_period">Probation period</label>
        <input required {{$disabled}}  name='probation_period' value="{{old('probation_period',$data['row']->probation_period)}}" type="text" class="form-control">
        {!! isError($errors, 'probation_period') !!}

    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="probation_end_date">Probation end date</label>
        <input required {{$disabled}}  name='probation_end_date' autocomplete="off" value="{{old('probation_end_date',$data['row']->probation_end_date_formatted)}}" type="text" class="form-control datepicker">
        {!! isError($errors, 'probation_end_date') !!}

    </div>
</div>


@push('scripts')
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $('.datepicker').datepicker({
        format: "{{ config('constant.date_format_javascript') }}",
    });
</script>
@endpush