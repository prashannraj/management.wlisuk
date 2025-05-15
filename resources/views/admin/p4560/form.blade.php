@php

if(!isset($disabled)) $disabled = "";

@endphp
<div class="row">
<div class="col-lg-6">
        <div class="form-group">
            <label for="">Type</label>
            <select autocomplete="off" class="form-control" name="type" id="type" placeholder="Document type" value="{{ old('type',optional($document)->type) }}">
                <option value="">Select type</option>
                @foreach(["p45","p60"] as $year)
                <option {{$data['row']->type == $year?"selected":""}} value="{{$year}}">{{strtoupper($year)}}</option>
                @endforeach
            </select>
            {!! isError($errors, 'type') !!}
        </div>
    </div>

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