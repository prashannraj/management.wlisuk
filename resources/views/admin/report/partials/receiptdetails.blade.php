    @foreach($row->receipts as $receipt)
    <span>
        {{$receipt->receipt_no}} {{$receipt->amount_with_currency}}
    </span>
    @endforeach