@php

if(!isset($disabled)) $disabled = "";

@endphp
<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Document Name</label>
            <input type="text" autocomplete="off" class="form-control" name="name" id="name" placeholder="Document Name" value="{{ old('name',optional($document)->name) }}">
            {!! isError($errors, 'name') !!}
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