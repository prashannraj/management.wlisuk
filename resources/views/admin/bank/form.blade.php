
<div class="col-lg-12">
    <div class="card-wrapper">
        <!-- Form controls -->
        <div class="card">
            <!-- Card body -->
            <div class="card-body">

                <div class='row'>

                <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="country">Country </label>
                            <div class="col-9">
                                <select name="iso_countrylist_id" class='form-control' value="{{old('iso_countrylist_id',optional($data['bank'])->iso_countrylist_id)}}" id="">
                                    <option value="">Select country</option>
                                    @foreach($data['countries'] as $country)

                                    <option {{old('iso_countrylist_id',optional($data['bank'])->iso_countrylist_id) == $country->id ?"selected":"" }} value="{{$country->id}}">{{$country->title}}</option>

                                    @endforeach
                                </select>

                                {!! isError($errors, 'iso_countrylist_id') !!}
                            </div>
                        </div>
                    </div>

                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="surname">
                                Bank Name: </label>
                            <div class="col-9">
                                <input id="title" type="text" class="form-control" name="title" placeholder="Name" value="{{ old('title',optional($data['bank'])->title) }}">
                                {!! isError($errors, 'title') !!}
                            </div>

                        </div>
                    </div>


                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="account_name">
                                Account Name: </label>
                            <div class="col-9">
                                <input id="account_name" type="text" class="form-control" name="account_name" placeholder="Name" value="{{ old('account_name',optional($data['bank'])->account_name) }}">
                                {!! isError($errors, 'account_name') !!}
                            </div>

                        </div>
                    </div>


                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="sort_code">
                                Sort Code: </label>
                            <div class="col-9">
                                <input id="sort_code" type="text" class="form-control" name="sort_code" placeholder="Sort Code" value="{{ old('sort_code',optional($data['bank'])->sort_code) }}">
                                {!! isError($errors, 'sort_code') !!}
                            </div>

                        </div>
                    </div>




                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="account_number">
                                Account Number: </label>
                            <div class="col-9">
                                <input id="account_number" type="text" class="form-control" name="account_number" placeholder="Account Number" value="{{ old('account_number',optional($data['bank'])->account_number) }}">
                                {!! isError($errors, 'account_number') !!}
                            </div>

                        </div>
                    </div>


                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="swift_code_bic">
                                Swift Code BIC: </label>
                            <div class="col-9">
                                <input id="swift_code_bic" type="text" class="form-control" name="swift_code_bic" placeholder="Swift Code BIC" value="{{ old('swift_code_bic',optional($data['bank'])->swift_code_bic) }}">
                                {!! isError($errors, 'swift_code_bic') !!}
                            </div>

                        </div>
                    </div>


                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="iban">
                                IBAN: </label>
                            <div class="col-9">
                                <input id="iban" type="text" class="form-control" name="iban" placeholder="IBAN" value="{{ old('iban',optional($data['bank'])->iban) }}">
                                {!! isError($errors, 'iban') !!}
                            </div>

                        </div>
                    </div>


                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="branch_address">
                                Branch Address: </label>
                            <div class="col-9">
                                <input id="branch_address" type="text" class="form-control" name="branch_address" placeholder="branch_address" value="{{ old('branch_address',optional($data['bank'])->branch_address) }}">
                                {!! isError($errors, 'branch_address') !!}
                            </div>

                        </div>
                    </div>

                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="account_ref">
                               Account Ref: </label>
                            <div class="col-9">
                                <input id="account_ref" type="text" class="form-control" name="account_ref" placeholder="account_ref" value="{{ old('account_ref',optional($data['bank'])->account_ref) }}">
                                {!! isError($errors, 'account_ref') !!}
                            </div>

                        </div>
                    </div>



                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="status">Status </label>
                            <div class="col-9">
                                <select name="status" class='form-control' value="{{old('status',optional($data['bank'])->status)}}" id="">
                                    <option value="">Select status of this bank</option>
                                    @foreach(array("active","inactive") as $country)

                                    <option {{old('status',optional($data['bank'])->status) == $country ?"selected":"" }} value="{{$country}}">{{ucfirst($country)}}</option>

                                    @endforeach
                                </select>

                                {!! isError($errors, 'status') !!}
                            </div>
                        </div>
                    </div>



                 







                  




                </div>




            </div>
        </div>
    </div>


</div>