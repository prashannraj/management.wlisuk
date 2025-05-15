<p class="No_20_Spacing"><span>Dear {{$data['enquiry']->full_name_with_title}},</span>@foreach($addedNames as $key => $name)
    {{ $name }}
    @if($key < count($addedNames) - 2)
        ,
    @elseif($key == count($addedNames) - 2)
        &
    @endif
@endforeach
</p>
<br>
<p>
    Thank you for your instructions. Please find attached a client care
    letter which needs signing.
</p>
<p>Instruction:</p>
<ol>
    <li>Please write your full name, sign and date the client care
        letter.</li>
    <li>Please write your full name, sign and date the General Data
        Protection regulation consent. </li>
</ol>
<p>Further information/documents required are also enclosed.</p>
<br><br>

Yours sincerely<br><br><br>
Admin Department<br>
{{$data['company_info']->name}}<br>
{{$data['company_info']->address}}
<br>
T: {{$data['company_info']->telephone}}
<br>
<tr>
    E: {{$data['company_info']->email}}
    <br>
<tr>
    W: {{$data['company_info']->website}}
    <br>
