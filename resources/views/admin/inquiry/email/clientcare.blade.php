@php
    // Safe initialization
    $addedNames = $addedNames ?? [];
    $enquiry    = $data['enquiry'] ?? null;
    $company    = $data['company_info'] ?? null;
    $advisor    = $data['advisor'] ?? null;
@endphp

<p class="No_20_Spacing">
    <span>Dear {{ optional($enquiry)->full_name_with_title ?? '' }}</span>
    @foreach($addedNames as $key => $name)
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
        Protection regulation consent.</li>
</ol>

<p>Further information/documents required are also enclosed.</p>

<br><br>

Yours sincerely <br><br><br>
Admin Department<br>
{{ optional($company)->name ?? '' }}<br>
{{ optional($company)->address ?? '' }}<br>
T: {{ optional($company)->telephone ?? '' }}<br>
E: {{ optional($company)->email ?? '' }}<br>
W: {{ optional($company)->website ?? '' }}