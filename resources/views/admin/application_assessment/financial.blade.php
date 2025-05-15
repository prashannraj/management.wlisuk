@extends('layouts.master')



@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Showing financial assessment status of {{$data['row']->name}}</h6>
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

        <div class="container">
            <div class="card">

                <div class="card-header">
                    Financial Assessment
                </div>


                <div class="card-body">
                    {!! showErrors($errors) !!}

                    <div class="row">
                        <div class="col-12">
                            <h3 class="text-primary">Income details</h3>
                            <a href="#add_employment_info" data-toggle="modal" class="btn btn-primary">Add employment detail</a>

                            <div class="list-group mt-2">
                                @foreach($data['row']->employment_details as $details)
                                <div class="list-group-item">

                                    <h3 class="text-primary"><a data-toggle="collapse" href="#employment_{{$details->id}}"><u>
                                                ( @if($details->sponsor_name) {{$details->sponsor_name}} @else applicant @endif )</u></a>

                                        {{$details->company_name}}



                                        <form action="{{route('employment_detail.destroy',$details->id)}}" method="POST" class="form-inline float-right">
                                            @csrf
                                            @method('delete')
                                            <span class="smaller mx-2">{{$details->status}}</span>
                                            <a href="{{route('employment_detail.show',$details->id)}}" class="btn btn-sm btn-primary">Edit <i class="fa fa-edit"></i></a>
                                            <button @if($details->payslips()->count() != 0) disabled title="Can only delete empty employment" @endif class="btn-sm btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>

                                    </h3>

                                    <div id='employment_{{$details->id}}' class='collapse @if(request()->clicked == $details->id) show @endif '>
                                        <a href="#add_slip" data-toggle="modal" data-id="{{$details->id}}" class="btn btn-sm btn-primary mb-2">Add payslip</a>
                                        <a href="#import_excel" data-toggle="modal" data-id="{{$details->id}}" class="btn btn-sm btn-primary mb-2">Import from Excel</a>

                                        <table class="table table-striped table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Gross Pay</th>
                                                    <th>Net Pay</th>
                                                    <th>Proof Sent</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($details->payslips()->orderBy("date","desc")->get() as $payslip)
                                                <tr>
                                                    <td>{{$payslip->date_formatted}}</td>
                                                    <td>{{$payslip->gross_pay}}</td>
                                                    <td>{{$payslip->net_pay}}</td>
                                                    <td><a href="{{route('applicantpayslip.toggle',$payslip->id)}}" class="btn btn-sm {{$payslip->proof_class}}">
                                                            {{$payslip->proof_sent}}
                                                        </a></td>
                                                    <td>
                                                        <form method="POST" action="{{route('applicantpayslip.destroy',$payslip->id)}}">
                                                            @csrf
                                                            @method("delete")
                                                            <a href="{{route('applicantpayslip.edit',$payslip->id)}}" class="btn btn-sm btn-primary">Edit <i class="fa fa-edit"></i></a>

                                                            <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                    </td>




                                                </tr>
                                                @endforeach
                                            </tbody>

                                            <tfoot>
                                                @if($details->calculation_type == "6 months")
                                                <tr>
                                                    <th>Total Gross Pay (6 months)</th>
                                                    <th>{{$details->currency->title}} {{$details->total}}</th>
                                                </tr>
                                                <tr>
                                                    <th>Total Gross Pay (12 months)</th>
                                                    <th>{{$details->currency->title}} {{$details->total*2}}</th>
                                                </tr>
                                                @else
                                                <tr>
                                                    <th>Total Gross Pay (12 months)</th>
                                                    <th>{{$details->currency->title}} {{$details->total}}</th>
                                                </tr>
                                                @endif
                                            </tfoot>

                                        </table>


                                    </div>
                                </div>

                                @endforeach
                            </div>

                        </div>

                        <div class="col-12">
                            <h3 class="text-primary mt-4">Saving details</h3>
                            <a href="#add_saving" data-id="{{$data['row']->id}}" data-toggle="modal" class="btn btn-primary">Add saving detail</a>

                            @if($data['row']->saving_infos()->count()>0)
                            <table class=" table mt-2 table-responsive table-striped">
                                <thead>
                                    <tr>
                                        <th>Details</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['row']->saving_infos as $info)
                                    <tr>
                                        <td>
                                            ( @if($info->sponsor_name) {{$info->sponsor_name}} @else Applicant @endif )

                                            Savings at {{$info->account_name}} {{$info->bank_name}}, {{$info->country_name}}


                                        </td>
                                        <td>
                                            {{$info->currency->title}} {{$info->closing_balance}}
                                        </td>
                                        <td>

                                            <form action="{{route('applicantsavinginfo.destroy',$info->id)}}" method="POST" class="form-inline">
                                                @csrf
                                                @method('delete')
                                                <a href="{{route('applicantsavinginfo.edit',$info->id)}}" class="btn btn-sm btn-primary">Edit <i class="fa fa-edit"></i></a>

                                                <button class="btn-sm btn btn-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>


                        <div class="col-12">

                            <h3 class="text-primary">
                                <a href="#generate_document" data-toggle="collapse">Generate Document</a>


                            </h3>

                            <div class="bordered collapse" id="generate_document">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="{{route('financial_assessment.generate',$data['row']->id)}}" method="post">
                                            @csrf
                                            <h2>Document type</h2>
                                            <div class="form-check-inline ">
                                                <input type="radio" class='form-check-input' name="document_type" value="salary_only" id="">

                                                <label for="">Salary only
                                                </label>
                                            </div>
                                            <div class="form-check-inline ">
                                                <input type="radio" class='form-check-input' name="document_type" value="salary_saving" id="">

                                                <label for="">Salary+Saving
                                                </label>
                                            </div>
                                            <div class="form-check-inline ">
                                                <input type="radio" class='form-check-input' name="document_type" value="saving_only" id="">

                                                <label for="">Saving only
                                                </label>
                                            </div>
                                            {!! isError($errors,'document_type',"You need to select the document type")!!}


                                            <div class="form-group ">
                                                <label for="minimum_salary">Minimum salary requirement</label>
                                                <input type="text" value="{{array_key_exists('minimum_salary',$data['parameters'])?$data['parameters']['minimum_salary']:''}}" name='minimum_salary' class="form-control">
                                            </div>

                                            <div class="form-group ">
                                                <label for="advisor_id">Advisor</label>
                                                <select name="advisor_id" id="" class="form-control">
                                                    <option value="">Select advisor</option>
                                                    @foreach($data['advisors'] as $advisor)
                                                        <option {{(array_key_exists('advisor_id',$data['parameters'])? $data['parameters']['advisor_id'] : '') == $advisor->id ?"selected":""  }} value="{{$advisor->id}}">{{$advisor->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>






                                            <div class="d-flex align-items-end">
                                                <button type="submit" class='btn btn-primary' name='action' value="fad">Send</button>
                                                <button name="action" value="pdf_fad" class="btn btn-warning">Download</button>
                                                <button name="action" formtarget="_blank" value="preview_fad" target="_blank" class="btn btn-warning">Preview</button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal" id="add_employment_info">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('employment_detail.store',$data['row']->id)}}" method="POST">
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add employment detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <input type="hidden" name="contact_id" value="">
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Sponsor name (if it is of sponsor)</label>
                        <select name="" data-toggle="populate" data-target="#b_sponsor_name" id="" class="form-control mb-2">
                            <option value="">It is applicant's detail</option>
                            @foreach($data['employment_sponsors'] as $sponsor)
                            <option {{$sponsor->sponsor_name==$data['row']->sponsor_name?"selected":""}} value="{{$sponsor->sponsor_name}}">{{$sponsor->sponsor_name}}</option>
                            @endforeach
                        </select>

                        <input placeholder="Leave empty if applicant's detail" type="text" id="b_sponsor_name" name='sponsor_name' class="form-control" value="{{old('sponsor_name',$data['row']->sponsor_name)}}">
                        {!! isError($errors, 'client_address') !!}

                    </div>


                    <div class="form-group">
                        <label for="">Company name:</label>
                        <input required type="text" name="company_name" value="{{old('company_name')}}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Employment start date:</label>
                        <input required type="text" name="start_date" value="{{old('start_date')}}" class="form-control datepicker2">
                    </div>

                    <div class="form-group">
                        <label for="">Employment end date:</label>
                        <input type="text" name="end_date" value="{{old('end_date')}}" id="end_date" class="form-control datepicker2">
                        <label for="ongoing">Ongoing</label>
                        <input type="checkbox" name="ongoing" id="ongoing">
                    </div>

                    <div class="form-group">
                        <label for="">Position:</label>
                        <input required type="text" value="{{old('position')}}" name="position" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Currency</label>
                        <select required name="currency_id" id="" class="form-control">
                            <option value="">Select an option</option>
                            @foreach($data['currencies'] as $currency)
                            <option value="{{$currency->id}}">{{$currency->title}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Currency rate</label>
                        <input type="text" name='currency_rate' value="{{old('currency_rate',1)}}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Calculation type</label>
                        <select required name="calculation_type" id="" class="form-control">
                            <option value="">Select an option</option>
                            @foreach(["6 months","12 months"] as $currency)
                            <option value="{{$currency}}">{{$currency}}</option>
                            @endforeach
                        </select>
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




<div class="modal" id="add_slip">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('applicantpayslip.store',$data['row']->id)}}" method="POST">
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add slip</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <input type="hidden" name="contact_id" value="">
                <!-- Modal body -->
                <div class="modal-body">

                    <input type="hidden" name="employment_info_id" id="employment_info_id" value="">
                    <div class="form-group">
                        <label for="">Date:</label>
                        <input required type="text" name="date" value="{{old('date')}}" class="form-control datepicker2">
                    </div>

                    <div class="form-group">
                        <label for="">Paid into bank date:</label>
                        <input required type="text" name="bank_date" value="{{old('bank_date')}}" class="form-control datepicker2">
                    </div>


                    <div class="form-group">
                        <label for="">Gross pay:</label>
                        <input required type="text" value="{{old('gross_pay')}}" name="gross_pay" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Net pay:</label>
                        <input required type="text" value="{{old('net_pay')}}" name="net_pay" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Proof sent:</label>
                        <select required name="proof_sent" id="" class="form-control">
                            <option value="">Select an option</option>
                            @foreach(["Yes","No"] as $currency)
                            <option value="{{$currency}}">{{$currency}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Note:</label>
                        <input type="text" value="{{old('note')}}" name="note" class="form-control">
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

<div class="modal" id="import_excel">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('applicantpayslip.import',$data['row']->id)}}" enctype="multipart/form-data" method="POST">
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add slip from excel file</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <input type="hidden" name="contact_id" value="">
                <!-- Modal body -->
                <div class="modal-body">

                    <input type="hidden" name="employment_info_id" id="employment_info_id" value="">
                    <div class="form-group">
                        <input type="file" name="file" id="" class='file-control'>
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


<div class="modal" id="add_saving">
    <div class="modal-dialog">
        <div class="modal-content smaller">
            <form action="{{route('applicantsavinginfo.store',$data['row']->id)}}" method="POST">
                @csrf
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add saving detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">

                    <input type="hidden" name="application_assessment_id" id="application_assessment_id" value="">
                    <div class="form-group">
                        <label for="">Sponsor name (if it is of sponsor)</label>
                        <select name="" data-toggle="populate" data-target="#a_sponsor_name" id="" class="form-control mb-2">
                            <option value="">It is applicant's detail</option>
                            @foreach($data['saving_sponsors'] as $sponsor)
                            <option {{$sponsor->sponsor_name==$data['row']->sponsor_name?"selected":""}} value="{{$sponsor->sponsor_name}}">{{$sponsor->sponsor_name}}</option>
                            @endforeach
                        </select>

                        <input placeholder="Leave empty if applicant's detail" type="text" id="a_sponsor_name" name='sponsor_name' class="form-control" value="{{old('sponsor_name',$data['row']->sponsor_name)}}">
                        {!! isError($errors, 'client_address') !!}

                    </div>

                    <div class="form-group">
                        <label for="">Country:</label>
                        <select required name="country_id" id="" class="form-control">
                            <option value="">Select an option</option>
                            @foreach($data['countries'] as $country)
                            <option value="{{$country->id}}">{{$country->title}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Bank name:</label>
                        <input type="text" value="{{old('bank_name')}}" name="bank_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Currency</label>
                        <select required name="currency_id" id="" class="form-control">
                            <option value="">Select an option</option>
                            @foreach($data['currencies'] as $currency)
                            <option value="{{$currency->id}}">{{$currency->title}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Currency rate</label>
                        <input type="text" name='currency_rate' value="{{old('currency_rate',1)}}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Account name:</label>
                        <input type="text" value="{{old('account_name')}}" name="account_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Account number:</label>
                        <input type="text" value="{{old('account_number')}}" name="account_number" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Saving start date:</label>
                        <input required type="text" name="start_date" value="{{old('start_date')}}" class="form-control datepicker2">
                    </div>


                    <div class="form-group">
                        <label for="">Minimum balance on any given date during the last 6 months:</label>
                        <input required type="text" value="{{old('minimum_balance')}}" name="minimum_balance" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Closing balance:</label>
                        <input required type="text" value="{{old('closing_balance')}}" name="closing_balance" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Closing balance date:</label>
                        <input required type="text" name="closing_date" value="{{old('closing_date')}}" class="form-control datepicker2">
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


    $('#import_excel').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)

        var doc_id = button.data('id');
        if (doc_id === undefined) return;
        // alert(doc_id);
        var modal = $(this);
        modal.find('input[name=employment_info_id]').val(doc_id);
    });

    $('#add_slip').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)

        var doc_id = button.data('id');
        if (doc_id === undefined) return;
        // alert(doc_id);
        var modal = $(this);
        modal.find('input[name=employment_info_id]').val(doc_id);
    });

    $('#add_saving').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget)

        var doc_id = button.data('id');
        if (doc_id === undefined) return;
        // alert(doc_id);
        var modal = $(this);
        modal.find('input[name=application_assessment_id]').val(doc_id);
    });
</script>
@endpush