@extends('layouts.master')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Send Email</h6>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('main-content')



<div>
    @foreach ($errors->all() as $error)
    <p class='alert alert-warning'>{{ $error }}</p>
    @endforeach
</div>



<div class="card" id="enquirycare_form">
    <div class="card-header">
        <h4 class='text-primary'>Send essential documents</h4>
    </div>

    <div class="card-body">
        <form action="{{route('massemail.send')}}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">

                <div class='col-md-8'>
                    <div class="form-group row">
                        <label class="col-4 col-form-label form-control-label" for="mobile">Select clients </label>
                        <div class="col-8">
                            <select placeholder="Type here to select" name='receiver' class='form-control clientautocomplete' value=""></select>

                          
                            {!! isError($errors, '') !!}
                        </div>
                       
                    </div>
                    <p id="text_linked" class='text-warning' style="display:none">
                    </p>
                    <button style="display:none" class='btn btn-sm btn-danger' id="btn_unlink">Unlink</button>


                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Subject</label>
                        <input type="text" name='subject' class="form-control">
                    </div>
                    <div class="form-group">
                        <label for=""> Content</label>
                        <div class="form-inline">
                            <select name="" id="" class="form-control">
                                <option value="0">Load from template</option>
                                @foreach($data['templates'] as $template)
                                <option value="{{$template->id}}">{{$template->title}}</option>
                                @endforeach
                            </select>
                            <button data-target="content" class="template-load btn-small btn-primary mx-2">Load</button>
                            <span class="loading"></span>
                        </div>
                        <p class="text-small">Loading the template will overwrite the existing content. Click <atarget="_blank" href="{{route('template.index')}}">here</a> to manage templates</p>
                        <textarea name="content" id='content' class="form-control wysiwyg">{{old('content')}}</textarea>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Select sender</label>
                        <select name="sender_id" id="" class="form-control">
                            <option value="">Please make a choice</option>
                            @foreach($data['senders'] as $sender)
                                <option value="{{$sender->id}}">{{$sender->email}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="col-md-6">
                    <h4>Send email</h4>

                    <div class="documents-list">
                        <label for="">Attach from company documents</label>
                    </div>
                    <button class="btn-sm btn-primary" id="addDocumentField">
                        <i class="fa fa-plus"></i>
                    </button>


                    <div class="">

                        <div class="form-inline">
                            <div class="attachment-list">
                                <label for="">Attachments (If any)</label>
                                <input type="file" name='attachments[]' class="form-control">
                            </div>
                            <button class="btn-sm btn-primary" id="addField">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="button-group">
                        <input type="submit" name="action" value="Email" class="btn btn-primary float-right">

                    </div>
                </div>




            </div>








        </form>
    </div>
</div>







@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css">

<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>




<script>
    function ajaxSearchTemplate($id, $loading, $target) {

        $loading.html("loading");
        $loading.show();
        var url = "/template/" + $id;
        // alert(url);
        $.ajax({
            type: "GET",
            url: url,
            success: function(data) {
                // alert(data); // show response from the php script.

                console.log(data);
                if (data.hasOwnProperty("content")) {
                    $loading.html("loaded...");

                    tinyMCE.get($target).setContent(data.content)
                } else {
                    $loading.html("");
                }

            },
            done: function() {

                // alert("done");
            }
        });
    }

    $('.clientautocomplete').autoComplete({
        minLength: 1,
        resolverSettings: {
            url: '{{url("/ajax/clients")}}'
        },
        events: {
            searchPost: function(data) {
                var da = [];
                data.map(function(e) {
                    da.push({
                        id: e.id,
                        value: e.id,
                        text: e.full_name + " - " + e.email_address + "("+e.id+")",
                        address: e.address,
                        addresses: e.addresses
                    });
                })
                return da;
            }
        },

    });

    var tagApi = $('.tm-input').tagsManager(
            {prefilled:"{{old('receivers')}}",
            hiddenTagListName:"receivers"}
    );

    $('.clientautocomplete').on('autocomplete.select', function(evt, item) {
        
        tagApi.tagsManager("pushTag", item.id);
    })
</script>
<script>
    $('.datepicker2').datepicker({
        format: "{{ config('constant.date_format_javascript') }}",
    });


    $('.status').on('change', function(evt) {
        var $this = $(evt.currentTarget);
        if ($this.val() == 2) {
            $this.parent().parent().find('.followup').show();
        } else {
            $this.parent().parent().find('.followup').hide();
        }
    })

    $('#delete_log').on('show.bs.modal', function(evt) {
        var button = $(evt.relatedTarget);
        var modal = $(evt.currentTarget);
        var id = button.data('docid');

        modal.find('#doc_id').val(id);
    });

    $('#edit_log').on('show.bs.modal', function(evt) {
        var button = $(evt.relatedTarget);
        if (button.html() === undefined || button.hasClass('datepicker2')) {
            return;
        }


        var modal = $(evt.currentTarget);
        var id = button.data('docid');
        var note = button.data('note');
        var status = button.data('status');
        var followup_date = button.data('followup_date');

        modal.find('#activity_id').val(id);
        modal.find('#note').val(note);
        modal.find('#status').val(status);
        modal.find('#status').change();

        modal.find('#followup_date').val(followup_date);




    });


    $(".template-load").on('click', function(e) {
        e.preventDefault();
        $loading = $(this).siblings(".loading")
        var x = $(this).siblings("select").val();
        // alert($(this).data('target'));
        var target = $(this).data("target");
        ajaxSearchTemplate(x, $loading, target);
    })
</script>


<script>

</script>
<script src="{{asset('assets/js/tinymce/tinymce.min.js')}}"></script>

<script>
    initiateTinymce('textarea.wysiwyg');
</script>


<script>
    function addField(e) {
        e.preventDefault();
        var field = '<input type="file" name="attachments[]" class="form-control">';
        $(".attachment-list").append(field);
    }

    $("#addField").on('click', addField);


    function addDocumentField(e) {
        e.preventDefault();
        var field = '<select name="documents[]" class="form-control">' +
            '<option>Select an option</option>' +
            '@foreach($data["documents"] as $doc) <option value="{{$doc->id}}">{{$doc->name}}</option>  @endforeach' +
            '</select>';
        $(".documents-list").append(field);

    }

    $("#addDocumentField").on('click', addDocumentField);
</script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('.typeahead').select2({
        ajax: {
            url: '/ajax/clients',
            dataType: 'json',
            processResults: function(data) {
                var da = {};
                da.results = [];
                data.map(function(e) {
                    da.results.push({
                        id: e.id,
                        text: e.full_name + " - " + e.email_address,
                    });
                })
                console.log(da);

                return da;
            }
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
        }
    });

    // jQuery(".typeahead").typeahead({

    //     display: 'text',

    //     source: function(query, process) {

    //         return $.get('/ajax/clients', {
    //             q: query
    //         }, function(data) {
    //             var da = [];
    //             data.map(function(e) {
    //                 da.push({
    //                     id: e.id,
    //                     text: e.full_name + " - " + e.email_address,
    //                 });
    //             })
    //             console.log(da);

    //             return process(da);

    //         });

    //     },

    //     afterSelect: function(item) {

    //         tagApi.tagsManager("pushTag", item);

    //     }

    // });
</script>
@endpush