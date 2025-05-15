<div class="row">


    <div class="col-md-6">
        <div class="form-group">
            <label for="">Type</label>
            <select name="type" id="type" class="form-control">
                <option value="">Select an option</option>
                @foreach(config('cms.attendance_types') as $key=>$type)
                <option {{$key == old('type',$data['row']->type)?'selected':''}} value="{{$key}}">{{$type}}</option>
                @endforeach

            </select>
                        {!! isError($errors, 'type') !!}

        </div>
    </div>


    <div class="col-md-6">
        <div class="form-group">

            <label for="Date">Date</label>
            <input type="text" autocomplete="false" class="form-control datepicker2" name='date' value='{{old("date",$data["row"]->date_formatted)}}'>
            {!! isError($errors, 'date') !!}

        </div>
    </div>
    <div class="col-md-6">

        <div class="form-group">
            <label for="advisor_id">
                Advisor
            </label>

            <select name="advisor_id" id="" class="form-control">
                <option value="">Select an option</option>
                @foreach($data['advisors'] as $advisor)
                <option {{ old('advisor_id',$data['row']->advisor_id) == $advisor->id ? "selected":"" }} value="{{$advisor->id}}">{{$advisor->name}}</option>
                @endforeach

            </select>

            {!! isError($errors, 'advisor_id') !!}

        </div>

    </div>

    <div class="col-md-12">
        <div id="attendance_only">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="mode">
                            Attendance mode
                        </label>

                        <select name="mode" id="" class="form-control">
                            <option value="">Select an option</option>
                            @foreach(config('cms.attendance_modes') as $key=>$advisor)
                            <option {{ old('mode',$data['row']->mode) == $key ? "selected":"" }} value="{{$key}}">{{$advisor}}</option>
                            @endforeach

                        </select>

                        {!! isError($errors, 'mode') !!}

                    </div>
                </div>


                <div class="col-md-6">

                    <div class="form-group">
                        <label for="duration">Attendance Duration</label>
                        <div class="form-inline">
                        <input type="number" class="form-control w-25 mr-1" name='hours' value='{{old("duration",$data["row"]->hours)}}'>

                            <label for=""> Hours </label>
                        <input type="number" class="form-control w-25 ml-2 mr-1" name='minutes' value='{{old("duration",$data["row"]->minutes)}}'>
                        <label for=""> Minutes </label>

                        </div>
                        {!! isError($errors, 'hours') !!}
                        {!! isError($errors, 'minutes') !!}

                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="file">File (optional, will be overridden)</label>
            <input type="file" name='file' class="form-control">
            {!! isError($errors, 'file') !!}

        </div>
        @if($data['row']->file)
            <a class='btn btn-primary' href="{{$data['row']->file_url}}" target="_blank">View current file</a>
            <br>
        @endif
    </div>

   


    <div class="col-md-12">
        <div class="form-group">
            <label for="duration">Discussion</label>
            <textarea class="form-control wysiwyg" name='details'>{{old("details",$data["row"]->details)}}</textarea>
            {!! isError($errors, 'details') !!}

        </div>
    </div>


</div>


@push('scripts')

<script>
    initiateTinymce('textarea.wysiwyg');

    $('.datepicker2').datepicker({
        format: "{{ config('constant.another_date_format_javascript') }}",
    });

    function attendanceOnly(){
        var c = $("#type").val();
        if(c==="attendance") $("#attendance_only").show();
        else $("#attendance_only").hide();
    }

    $("#type").on('change',function(){
        attendanceOnly();
    });

    $(document).ready(function(){
        attendanceOnly();
    })
</script>

@endpush