@php

if(!isset($disabled)) $disabled = "";

@endphp
<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Year</label>
            <select autocomplete="off" class="form-control" name="year" id="year" placeholder="Document year" value="{{ old('year',optional($document)->year) }}">
                <option value="">Select year</option>
                @foreach(getYears() as $year)
                <option {{$data['row']->year == $year?"selected":""}} value="{{$year}}">{{$year}}</option>
                @endforeach
            </select>
            {!! isError($errors, 'year') !!}
        </div>
    </div>
@php
$engmonths = ["","January","February","March","April","May","June","July","August","September","October","November","December"];
@endphp
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Month</label>
            <select autocomplete="off" class="form-control" name="month" id="month" placeholder="Month" value="{{ old('month',optional($document)->month) }}">
                <option value="">Select month</option>
                @foreach(range(1,12) as $month) 
                <option {{$data['row']->month == $month?"selected":""}} value="{{$month}}">{{$engmonths[$month]}}</option>
                    @endforeach
            </select>
            {!! isError($errors, 'month') !!}
        </div>
    </div>


    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Document</label>
            <input type="file" class="form-control" name="document" id="document">
            {!! isError($errors, 'document') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Note</label>
            <textarea autocomplete="off" class="form-control" name="note" id="note" placeholder="Notes">{{ old('note',optional($document)->note) }}</textarea>
            {!! isError($errors, 'note') !!}
        </div>
    </div>
    <div class="col-lg-6">
        @if((optional($document))->document)
        <div class="form-group">
            <label for="">View File</label>
            <a href="{{ optional($document)->file_url }}" class="form-control" style="border: 0;">
                <i class="{{ optional($document)->file_type }} fa-3x"></i>
            </a>
        </div>
        @endif
    </div>
</div>