<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="col-lg-12">
    <div class="card-wrapper">
        <!-- Form controls -->
        <div class="card">
            <!-- Card body -->
            <div class="card-body">

                <div class='row'>



                    <div class='col-md-12'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="surname">
                                Title: </label>
                            <div class="col-9">
                                <input id="title" type="text" class="form-control" name="title" placeholder="Name" value="{{ old('title',optional($data['template'])->title) }}">
                                {!! isError($errors, 'title') !!}
                            </div>

                        </div>
                    </div>


                    <div class='col-md-12'>
                        <div class="form-group">
                            <label class="col-form-label form-control-label" for="content">
                                Content: </label>
                            <div class="">
                                <textarea id="content" type="text" class="form-control wysiwyg" name="content">{{ old('content',optional($data['template'])->content) }}</textarea>
                                {!! isError($errors, 'content') !!}
                            </div>
                        </div>
                    </div>
















                </div>



                <button class='btn btn-sm btn-outline-primary' name='action' value="preview" formtarget="_blank">Preview</button>
            </div>
        </div>
    </div>


</div>


@push("scripts")
{{-- <script src="{{asset('assets/js/tinymce/tinymce.min.js')}}"></script>

<script>
    initiateTinymce('textarea.wysiwyg');
</script> --}}

<script src="{{asset('assets/js/tinymce/tinymce.min.js')}}"></script>

<script>
    tinymce.init({
    selector: 'textarea.wysiwyg',
    height: 300,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code'
    ],
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    images_upload_url: '{{ route('upload.image') }}', // Set the upload URL
    automatic_uploads: true,
    file_picker_types: 'image',
    file_picker_callback: function (callback, value, meta) {
        if (meta.filetype === 'image') {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function () {
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = function () {
                    // Call the callback to insert the image
                    callback(reader.result, { alt: file.name });
                };
                reader.readAsDataURL(file);
            };
            input.click();
        }
    },
});
</script>


@endpush
