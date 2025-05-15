@extends('layouts.master')
@push('styles')
@yield('third_party_stylesheets')
@endpush
@section('v2_master')
<div class="main-content" id="panel">
    @include('layouts.inc.top-nav')
    <!-- Page content -->
    <div class="container-fluid mt-4">
        @yield('content')
    </div>
</div>

@endsection

@push('scripts')

@include('layouts.partials.notification')

@stack('page_scripts')

@stack('third_party_scripts')

<script>
    $("select[data-toggle='populate']").on('change', function(e, value) {
        var selector = $(this).data("target");
        $(selector).val($(this).find('option:selected').html());
    })
</script>

@endpush