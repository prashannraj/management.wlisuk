<script>
@if(\Session::has('success'))
    $.notify({
        icon: 'far fa-check-circle p-2 fa-1x',
        message: '{{ \Session::get("success") }}',
    },{
        type: 'success',
        placement: {
            from: "bottom",
            align: "right"
        },
    });
    @php
        \Session::forget('success');
    @endphp
@endif

@if(\Session::has('failed'))
    $.notify({
        icon: 'fas fa-info-circle p-2 fa-1x',
        message: '{{ \Session::get("failed") }}',
    },{
        type: 'warning'
    });
    @php
        \Session::forget('failed');
    @endphp
@endif
</script>
