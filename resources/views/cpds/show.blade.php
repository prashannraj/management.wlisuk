@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>CPD Details</h1>
            </div>
            <div class="col-sm-6">
                <a class="btn btn-default float-right" href="{{ route('cpds.index') }}">
                    Back
                </a>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    <div class="card">

        <div class="card-body">

            @include('cpds.show_fields')

        </div>

    </div>


    <div class="card mt-2">
        <div class="card-body">
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>Date of completion</th>
                        <th>What did you learn?</th>
                        <th>Why did you do this learning?</th>
                        <th>Did you meet your objectives?</th>
                        <th>How will you apply this learning?</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($cpd->details as $cpdDetail)
                    <tr>
                        <td>{{$cpdDetail->date_formatted}}</td>
                        <td>{{$cpdDetail->what}}</td>
                        <td>{{$cpdDetail->why}}</td>
                        <td>{{$cpdDetail->complete_objective}}</td>
                        <td>{{$cpdDetail->apply_learning}}</td>
                        <td>
                            @include('cpd_details.actions',['cpdDetail'=>$cpdDetail])
                        </td>

                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan=6>
                            <p>Import from excel sheet</p>
                            <form method="post" action="{{route('cpdDetails.import')}}" enctype="multipart/form-data" class="form-inline">
                                @csrf
                                <input type="hidden" name="cpd_id" value="{{$cpd->id}}">
                                <input type="file" name='file' class="file-control">
                                <button class="btn btn-sm btn-primary">Import</button>
                            </form>
                            <p>Download the sample sheet <a target="_blank" href="{{asset('assets/samples/cpd_details_sample.xlsx')}}">here</a></p>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" data-toggle="modal" data-target="#add_detail_modal">Add details</button>
        </div>
    </div>

    <div class="card mt-2">
        <div class="card-body">
            @if($cpd->pdf)
            <p>{{$cpd->pdf->name}}</p>
            <p>Generated on: {{$cpd->pdf->updated_at->format("d F Y h:i:s a")}}</p>
            <a href="{{route('cpds.show',['cpd'=>$cpd->id,'download'=>'pdf'])}}" class="btn btn-primary">Download</a>
            <a href="{{route('cpds.show',['cpd'=>$cpd->id,'preview'=>'pdf'])}}" target="_blank" class="btn btn-primary">Preview</a>
            @endif
            <a href="{{route('cpds.show',['cpd'=>$cpd->id,'generate'=>'pdf'])}}" onclick="return confirm('Are you sure? This will delete previously generated file.')" class="btn btn-primary">Generate</a>

        </div>
    </div>
</div>
@endsection


@push('modals')

<div class="modal fade" id="add_detail_modal">
    <div class="modal-lg modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{route('cpdDetails.store')}}" method="post">
                    @csrf
                    @include("cpd_details.fields")
                    <input type="hidden" name="cpd_id" value="{{$cpd->id}}">

                    <button class="btn btn-primary">Submit</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_detail_modal">
    <div class="modal-lg modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{route('cpdDetails.update','_')}}" method="post">
                    @method("PUT")
                    @csrf
                    @include("cpd_details.fields")
                    <input type="hidden" name="id" value="">

                    <input type="hidden" name="cpd_id" value="{{$cpd->id}}">

                    <button class="btn btn-primary">Submit</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endpush

@push('scripts')

<script>
    var cpd_details = @json($cpd->details);
</script>

<script>
    $("#edit_detail_modal").on("shown.bs.modal", function(evt) {
        var modal = $(evt.target);
        var button = $(evt.relatedTarget);
        console.log(cpd_details);

        var cpd_detail = cpd_details.find(element => element.id === button.data("id"));
        console.log(cpd_detail);
        if (typeof cpd_detail === "object") {
            Object.keys(cpd_detail).map(function(key, index) {
                var e = cpd_detail[key];

                modal.find(`input[name=${key}]`).val(e);
            });

            modal.find(`input[name=date]`).val(cpd_detail.date_formatted);


        }
    });
</script>

@endpush