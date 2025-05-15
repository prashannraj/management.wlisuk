@extends('layouts.master')



@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Showing application assessment status of {{$data['row']->name}}</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('client.show',['id'=>$data['row']->basic_info_id,'click'=>'applications']) }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back To Dashboard</a>
                    <br>

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
            <div class="card-header">Application assessments</div>

            <div class="card-body">
                <div class="container">

                    <div class="row">
                        <div class="col-md-4">
                            <p>
                                <b>Type: </b> {{ucfirst($data['row']->type)}}
                            </p>
                            <p>
                                <b>Updated at: </b> {{$data['row']->updated_at->format(config('constant.date_format'))}}
                            </p>

                            <p>
                                <b>Country Applying to: </b> {{$data['row']->country_applying_to->title}}
                            </p>
                            <p>
                                <b>Country Applying from: </b> {{$data['row']->country_applying_from->title}}
                            </p>

                            <p>
                                <b>Application Detail: </b> {{$data['row']->application_detail->name}}
                            </p>
                            @if($data['row']->description)
                            <p> <b>Details</b></p>
                            <div>
                                {!! $data['row']->description !!}
                            </div>
                            @endif




                        </div>
                        <div class="col-md-8">
                            <button class="btn btn-primary" data-target="#add_section" data-toggle="modal">Add section</button>
                            @foreach($data['row']->sections as $section)
                            <div class="border p-3 mt-2">
                                <h3 class="text-primary"><a data-toggle="collapse" href="#section_{{$section->id}}"><u class='section_name_{{$section->id}}'>{{$section->name}}</u></a>



                                    <form action="{{route('assessment_section.destroy',$section->id)}}" method="POST" class="form-inline float-right">
                                        @csrf
                                        @method('delete')
                                        <button @if($section->documents()->count() != 0) disabled title="Can only delete empty section" @endif class="btn-sm btn btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>

                                    <form action="{{route('assessment_section.toggle',$section->id)}}" class='form-inline float-right mx-1' method="post">
                                        @csrf
                                        <button class="btn-sm {{$section->status_class}}">{{ $section->status}}</button>
                                    </form>

                                </h3>


                                <div id="section_{{$section->id}}" class='collapse'>
                                    <form action="{{route('assessment_section.update',$section->id)}}" method="POST" class='form-inline ajax_form_section'>
                                        @csrf
                                        <div class="form-group">
                                            <label for="" class='smaller mr-2'>Section name</label>
                                            <input type="text" name="name" value="{{$section->name}}" class="form-control-sm mx-2">
                                            {!! isError($errors, 'name',"You should mention the name.") !!}

                                        </div>

                                        <button class="btn-primary">Update</button>
                                        <span class="loading"></span>
                                    </form>

                                    <div id="accordion_{{$section->id}}" class='text-small'>
                                        <h4 class="text-primary">Files</h4>
                                        <div class="list-group">
                                            @foreach($section->documents as $document)
                                            <div class="list-group-item">

                                                <span>
                                                    <a class="card-link" data-toggle="collapse" href="#document_{{$document->id}}">
                                                        <u>{{$document->name}}</u>
                                                    </a>

                                                </span>
                                                <form action="{{route('application_assessment_file.destroy',$document->id)}}" method="POST" class="form-inline float-right">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn-sm btn btn-danger"><i class="fa fa-trash"></i></button>
                                                </form>

                                                <div style="font-size:smaller" id="document_{{$document->id}}" class="collapse @if(request()->clicked == $document->id) show @endif " data-parent="#accordion_{{$section->id}}">
                                                    <a href="{{$document->url}}" target="_blank">Preview/Download file</a>
                                                    <form action="{{route('application_assessment_file.update',$document->id)}}" method="POST" enctype="multipart/form-data" class='ajax_form'>
                                                        @csrf
                                                        @method('put')
                                                        <div class="form-group">
                                                            <label for="">File name</label>
                                                            <input type="text" name="name" value="{{$document->name}}" class="form-control">
                                                            {!! isError($errors, 'name',"You should mention the name.") !!}

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Description</label>
                                                            <textarea type="text" name="description" class="form-control">{{$document->description}}</textarea>
                                                            {!! isError($errors, 'description',"Description is required.") !!}

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Change document</label>
                                                            <input type="file" name="document" class="file-control form-control">
                                                            {!! isError($errors, 'document',"Document is required.") !!}

                                                        </div>
                                                        <button class="btn-primary">Update</button>
                                                        <span class="loading"></span>
                                                    </form>
                                                </div>
                                            </div>

                                            @endforeach
                                        </div>

                                        <form action="{{route('application_assessment.uploadfiles',$data['row']->id)}}" class="mt-2" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="custom-file-upload">
                                                <label for="">Upload files</label>
                                                <input type="hidden" name="assessment_section_id" value="{{$section->id}}">
                                                <input type="file" multiple name='documents[]' class="custom-file-control form-control">
                                            </div>

                                            <button class="btn btn-primary mt-2">Submit</button>

                                        </form>

                                    </div>

                                </div>

                            </div>
                            @endforeach
                        </div>



                    </div>




                </div>
            </div>

            <div class="card-footer">
                <p><b>Change status</b></p>
                <form action="{{route('application_assessment.updateStatus',$data['row']->id)}}" class='form-inline' method="POST">
                    @csrf
                    <select name="status" id="" class="form-control mx-2">
                        <option {{$data['row']->status == "pending"?"selected":""}} value="pending">Pending</option>
                        <option {{$data['row']->status == "completed"?"selected":""}} value="completed">Completed</option>
                        <option {{$data['row']->status == "cancelled"?"selected":""}} value="cancelled">Cancelled</option>
                    </select>
                    <button class="btn btn-primary">Change status</button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal" id="add_section">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('assessment_section.store',$data['row']->id)}}" method="POST">
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add section</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <input type="hidden" name="contact_id" value="">
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Name:</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="submit" value="Add" class="btn btn-info">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>


@endsection


@push("scripts")
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $('.datepicker2').datepicker({
        format: "{{ config('constant.date_format_javascript') }}",
    });

    $("#ongoing").on("change", function() {
        var checked = $(this).is(":checked");
        if (checked) $("#end_date").hide();
        else $("#end_date").show();
    })

    var x;

    $(".ajax_form").on("submit", function(e) {
        var form = $(this);

        var formData = new FormData(form[0]);

        if (formData.get("document").size != 0) {
            return;
        }

        e.preventDefault();

        var url = form.attr('action');
        var loading = $(this).find(".loading");
        loading.html("loading");
        loading.show();
        var data = form.serialize();

        $.ajax({
            type: "POST",
            url: url,
            data: data, // serializes the form's elements.
            success: function(data) {
                // alert(data); // show response from the php script.
                loading.html("done...");

            },
            done: function() {
                // alert("done");
            }
        });

    });


    $(".ajax_form_section").on("submit", function(e) {
        var form = $(this);

        var formData = new FormData(form[0]);

      

        e.preventDefault();

        var url = form.attr('action');
        var loading = $(this).find(".loading");
        loading.html("loading");
        loading.show();
        var data = form.serialize();

        $.ajax({
            type: "POST",
            url: url,
            data: data, // serializes the form's elements.
            success: function(data) {
                // alert(data); // show response from the php script.
                loading.html("done...");
                console.log(data);
                $(".section_name_"+data.id).html(data.name)
            },
            done: function() {
                // alert("done");

            },
            error:function(){
                loading.html("error : empty details?");

            }
        });

    });
</script>
@endpush