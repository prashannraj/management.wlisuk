<input value="{{ $data['basic_info']->id }}" name="basic_info_id" type="hidden">
<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Country Applying</label>
            <select class="form-control" id="iso_countrylist_id" name="iso_countrylist_id">
                <option value="">Select Options</option>
                @foreach ($data['countries'] as $countryCode)
                <option value="{{ $countryCode->id }}" {{ (old("iso_countrylist_id",optional($data['application'])->iso_countrylist_id) == $countryCode->id ? "selected":"") }}>{{ $countryCode->title }}</option>
                @endforeach
            </select>
            {!! isError($errors, 'iso_countrylist_id') !!}
        </div>
    </div>


    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Institute</label>
            <select class="form-control" id="partner_id" name="partner_id">
                <option value="">Select Options</option>
                @foreach ($data['partners'] as $partner)
                <option value="{{ $partner->id }}" {{ old("partner_id",optional($data['application'])->partner_id) == $partner->id ? "selected":"" }}>{{ $partner->institution_name }}</option>
                @endforeach
            </select>
            {!! isError($errors, 'partner_id') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Application Method</label>
            <select class="form-control" id="application_method" name="application_method">
                <option value="">Select Options</option>
                <option value="online" {{ old('application_method',optional($data['application'])->application_method) == 'online' ? 'selected' : ''  }}>Online</option>
                <option value="paper" {{ old('application_method',optional($data['application'])->application_method) == 'paper' ? 'selected' : ''  }}>Paper</option>
                <option value="email" {{ old('application_method',optional($data['application'])->application_method) == 'email' ? 'selected' : ''  }}>Email</option>
            </select>
            {!! isError($errors, 'application_method') !!}
        </div>
    </div>




</div>
<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Course name</label>
            <input autocomplete="off" class="form-control" name="course_name" id="course_name" placeholder="Course Name" value="{{old('course_name',optional($data['application'])->course_name)}}">
            {!! isError($errors, 'course_name') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Course start date</label>
            <input autocomplete="off" class="form-control" name="course_start" id="course_start" placeholder="Course Start" value="{{ old('course_start',optional($data['application'])->course_start) }}">
            {!! isError($errors, 'ref') !!}
        </div>
    </div>


    {{-- <div class="col-lg-6">
        <div class="form-group">
            <label for="">Application Ref</label>
            <input autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Application Ref" value="{{ $data['row']->ref }}">
    {!! isError($errors, 'ref') !!}
</div>
</div>

<div class="col-lg-6">
    <div class="form-group">
        <label for="">Advisor</label>
        <select class="form-control" name="advisor_id">
            <option value="">Select advisor</option>
            @foreach($data['advisors'] as $advisor)

            <option {{$data['row']->advisor_id == $advisor->id ? "selected":""}} value="{{$advisor->id}}">{{$advisor->name}}</option>

            @endforeach
        </select>
        {!! isError($errors, 'advisor_id') !!}
    </div>
</div> -}}



{{--<div class="col-lg-6">
        <div class="form-group">
            <label for="date">Date Submitted</label>
            <input type="date" class="form-control" value="{{$data['row']->date_submitted}}" name="date_submitted" id="date">
{!! isError($errors, 'date_submitted') !!}
</div>
</div> --}}

@if($data['application']->id == null)
<div class="col-lg-6">
    <div class="form-group">
        <label for="">Document</label>
        <input type="file" class="form-control" name="document" id="documents">
        {!! isError($errors, 'document') !!}
    </div>
</div>

@endif


<div class="col-lg-6">
    <div class="form-group">
        <label for="">Remarks</label>
        <textarea autocomplete="off" class="form-control" name="remarks" id="remarks" placeholder="Remarks">{{ old('remarks',optional($data['application'])->remarks) }}</textarea>
        {!! isError($errors, 'remarks') !!}
    </div>
</div>
</div>


@push("scripts")

<script>
    $(document).ready(function(){
    $('#iso_countrylist_id').on('change', function (){
        $.getJSON('{{route("ajax.partner.index")}}', {iso_countrylist_id: $(this).val()}, function(data){
            var options = '<option value="">Select Options</option>';
            for (var x = 0; x < data.length; x++) {
                options += '<option value="' + data[x]['id'] + '">' + data[x]['institution_name'] + '</option>';
            }
            $('#partner_id').html(options);
        });
    });
    $('#iso_countrylist_id').change();
});
</script>


@endpush