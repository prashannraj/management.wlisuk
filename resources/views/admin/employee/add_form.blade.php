<!-- Student Contact From Block -->
<div class='modal fade' id="StudentContactDetailAddForm">
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
            <div class="modal-header">
                <h5 class="modal-title" id="">Add Employee Contact Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card">

                <div class="card-body">
                    <div class="contact_details_error"></div>
                    <form action="{{route('employeecontact.store')}}" method="POST">
                        @csrf
                        <input value="{{ $data['employee']->id }}" name="employee_id" type="hidden">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Primary Mobile Code</label>
                                    <select class="form-control" id="country_mobile" name="country_mobile">
                                        <option value="">Select Options</option>
                                        @foreach ($data['country_code'] as $countryCode)
                                        <option value="{{ $countryCode->id }} " {{ (old("country_mobile") == $countryCode->id ? "selected":"") }}>{{ $countryCode->title }}</option>
                                        @endforeach
                                    </select>
                                    {!! isError($errors, 'country_mobile') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Primary Mobile Number</label>
                                    <input type="text" autocomplete="off" class="form-control" name="mobile_number" id="mobile_number" aria-describedby="helpId" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Telephone Number Code</label>
                                    <select class="form-control" id="country_contact" name="country_contact">
                                        <option value="">Select Options</option>
                                        @foreach ($data['country_code'] as $countryCode)
                                        <option value="{{ $countryCode->id }} " {{ (old("country_contact") == $countryCode->id ? "selected":"") }}>{{ $countryCode->title }} ({{ $countryCode->calling_code }})</option>
                                        @endforeach
                                    </select>
                                    {!! isError($errors, 'country_contact') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Telephone Number</label>
                                    <input type="text" autocomplete="off" class="form-control" name="contact_number" id="contact_number1" aria-describedby="helpId" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" autocomplete="off" class="form-control" name="primary_email" id="primary_email" aria-describedby="helpId" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Add</button>
                    </form>
                </div>
            </div>


        </div>
    </div>
</div>
<!-- Address Contact From Block -->
<div class='modal fade' id="AddressContactDetailAddForm">
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
            <div class="modal-header">
                <h5 class="modal-title" id="">Add Address Contact Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card">

                <div class="card-body">
                    <div class="address_details_error"></div>
                    <form action="{{route('employeeaddress.store')}}" method="POST">
                        @csrf
                        <input value="{{ $data['employee']->id }}" name="employee_id" type="hidden">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Country</label>
                                    <select class="form-control" id="iso_countrylist_id" name="iso_countrylist_id">
                                        <option value="">Select Options</option>
                                        @foreach ($data['country_code'] as $countryCode)
                                        <option value="{{ $countryCode->id }} " {{ (old("iso_countrylist_id") == $countryCode->id ? "selected":"") }}>{{ $countryCode->title }}</option>
                                        @endforeach
                                    </select>
                                    {!! isError($errors, 'iso_countrylist_id') !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Post Code</label>
                                    <input type="text" autocomplete="off" class="form-control" name="postal_code" id="postal_code" aria-describedby="helpId" placeholder="">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <textarea name="address" id="address" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary" type="submit">Add</button>
                    </form>
                </div>
            </div>


        </div>

    </div>
</div>
<!-- Emergency Contact From Block -->
<div class='modal fade' id="EmergencyContactDetailAddForm">
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
            <div class="modal-header">
                <h5 class="modal-title" id="">Add Emergency Contact Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card">

                <div class="card-body">
                    <div class="emergency_details_error"></div>
                    <form action="{{route('employeeemergency.store')}}" method="POST">
                        @csrf
                        <input value="{{ $data['employee']->id }}" name="employee_id" type="hidden">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" autocomplete="off" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Relationship</label>
                                    <input type="text" autocomplete="off" class="form-control" name="relationship" id="relationship" aria-describedby="helpId" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Contact Number</label>
                                    <input type="text" autocomplete="off" class="form-control" name="contact_number" id="contact_number" aria-describedby="helpId" placeholder="Enter Contact Number">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" autocomplete="off" class="form-control" name="email" id="email" aria-describedby="helpId" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <textarea name="address" id="" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Add</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>



<div class='modal fade' id="PassportDetailAddForm">
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
            <div class="modal-header">
                <h5 class="modal-title" id="">Add passport detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card">

                <div class="card-body">
                    <div class="emergency_details_error"></div>
                    <form action="{{ route('passportdetail.store') }}" method="POST">
                        @csrf
                        <input value="{{ $data['employee']->id }}" name="employee_id" type="hidden">
                        @include('admin.passport_detail.form',["passport"=>""])
                        <button class="btn btn-primary" type="submit">Add</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>




<div class='modal fade' id="VisaDetailAddForm">
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
            <div class="modal-header">
                <h5 class="modal-title" id="">Add current visa detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card">

                <div class="card-body">
                    <div class="emergency_details_error"></div>
                    <form action="{{ route('visa.store') }}" method="POST">
                        @csrf
                        <input value="{{ $data['employee']->id }}" name="employee_id" type="hidden">
                        @include('admin.visa.form',["visa"=>""])
                        <button class="btn btn-primary" type="submit">Add</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>




<div class='modal fade' id="DocumentAddForm">
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
            <div class="modal-header">
                <h5 class="modal-title" id="">Add new document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card">

                <div class="card-body">
                    <div class="emergency_details_error"></div>
                    <form action="{{ route('employeedocument.store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <input value="{{ $data['employee']->id }}" name="employee_id" type="hidden">
                        @include('admin.employee.document.form',["document"=>""])
                        <button class="btn btn-primary" type="submit">Add</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

