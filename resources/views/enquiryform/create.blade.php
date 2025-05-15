@extends('layouts.master')



@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Enquiry Form</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="/" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back to dashboard</a>
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
            <!-- Card header -->

            <div class="card-body">


                <form class="" action="{{ route('enquiryform.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="">
                        <div class="">
                            <div class="px-2 py-3 my-3">
                                <div id="spd" class=" mt-2 row">


                                   @include("enquiryform.form")


                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" class='btn btn-primary' name='action' value="apd">Submit</button>
                                    </div>

                                </div>
                            </div>
                        </div>



                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')

<script src="{{asset('assets/js/tinymce/tinymce.min.js')}}"></script>

<script>
    initiateTinymce('textarea.wysiwyg');
</script>
@endpush