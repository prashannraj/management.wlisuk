<h2>Income details</h2>
<input type="hidden" name="application_assessment_id" value="{{$data['row']->id}}">
@if($data['row']->employment_details()->count()==0)
<p>No income details</p>
@endif
@foreach($data['row']->employment_details as $info)
<div class="form-group mx-4">
    <input type="checkbox" {{array_key_exists("income_".$info->id,$data['parameters'])?"selected":"" }} class='form-check-input' name="income_{{$info->id}}" id="">

    <label for="">Include income statement of
        @if($info->sponsor_name)
        (sponsor) {{$info->sponsor_name}} at {{$info->company_name}}
        @else
        (applicant) at {{$info->company_name}}
        @endif
    </label>
</div>
@endforeach
<h2>Saving details</h2>
@if($data['row']->saving_infos()->count()==0)
<p>No saving details</p>
@endif
@foreach($data['row']->saving_infos as $info)
<div class="form-group mx-4">
    <input type="checkbox" {{array_key_exists("saving_".$info->id,$data['parameters'])?"selected":"" }} class="form-check-input" name="saving_{{$info->id}}" id="">

    <label for="">Include saving of
        @if($info->sponsor_name)
        (sponsor) {{$info->sponsor_name}} at {{$info->bank_name}}
        @else
        applicant at {{$info->bank_name}}
        @endif
    </label>
</div>
@endforeach