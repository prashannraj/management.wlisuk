@extends('layouts.master')

@section('header')
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Edit Web Enquiry</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('rawenquiry.show', $data['row']->id) }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back to view
                    </a>
                    <a href="{{ route('rawenquiry.index') }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back to list
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('main-content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('rawenquiry.update', $data['row']->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")

                    @if(isset($data['row']->form_type) && $data['row']->form_type == 'immigration')
                        @includeIf("enquiryform.forms.immigration", ['row' => $data['row'], 'countries' => $data['countries']])
                    @else
                        @includeIf("enquiryform.forms.general", ['row' => $data['row'], 'countries' => $data['countries']])
                    @endif

                    <div class="form-group">
                        <label for="resendEmail">Resend Email Verification</label>
                        <input type="checkbox" name="resend_email" class="checkbox-control" id="resendEmail">
                    </div>

                    <button class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
<script>
    initiateTinymce('textarea.wysiwyg');
</script>
@endpush
