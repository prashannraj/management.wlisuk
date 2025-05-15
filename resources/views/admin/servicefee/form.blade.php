<div class="col-lg-12">
    <div class="card-wrapper">
        <!-- Form controls -->
        <div class="card">
            <!-- Card body -->
            <div class="card-body">

                <div class='row'>

                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="category">
                                Category: </label>
                            <div class="col-9">
                                <input id="category" type="text" class="form-control" name="category" placeholder="Category" value="{{ old('category',optional($data['servicefee'])->category) }}">
                                {!! isError($errors, 'category') !!}
                            </div>

                        </div>
                    </div>

                    <div class='col-md-6'>




                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="name">
                                Name: </label>
                            <div class="col-9">
                                <input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name',optional($data['servicefee'])->name) }}">
                                {!! isError($errors, 'name') !!}
                            </div>

                        </div>
                    </div>

<div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-3 col-form-label form-control-label" for="currency">Currency </label>
                        <div class="col-9">
                            <select name="iso_currency_id" class='form-control' value="{{old('iso_currency_id',optional($data['servicefee'])->iso_currency_id)}}" id="">
                                <option value="">Select currency</option>
                                @foreach($data['currencies'] as $currency)

                                <option {{old('iso_currency_id',optional($data['servicefee'])->iso_currency_id) == $currency->id ?"selected":"" }} value="{{$currency->id}}">{{$currency->title}}</option>

                                @endforeach
                            </select>

                            {!! isError($errors, 'iso_currency_id') !!}
                        </div>
                    </div>
                </div>

                <div class='col-md-6'>
                    <div class="form-group row">
                        <label class="col-3 col-form-label form-control-label" for="surname">
                            Net Amount </label>
                        <div class="col-9">
                            <input id="net" type="number" class="form-control" name="net" placeholder="Net Amount" value="{{ old('net',optional($data['servicefee'])->net) }}">
                            {!! isError($errors, 'net') !!}
                        </div>

                    </div>
                </div>


                <div class='col-md-6'>
                    <div class="form-group row">
                        <label class="col-3 col-form-label form-control-label" for="surname">
                            VAT(%) </label>
                        <div class="col-9">
                            <input id="vat" type="number" class="form-control" name="vat" placeholder="VAT(%)" value="{{ old('vat',optional($data['servicefee'])->vat) }}">
                            {!! isError($errors, 'vat') !!}
                        </div>

                    </div>
                </div>


                <div class='col-md-6'>
                    <div class="form-group row">
                        <label class="col-3 col-form-label form-control-label" for="note">
                            Note: </label>
                        <div class="col-9">
                            <input id="note" type="text" class="form-control" name="note" placeholder="Note" value="{{ old('note',optional($data['servicefee'])->note) }}">
                            {!! isError($errors, 'note') !!}
                        </div>

                    </div>
                </div>


                <div class='col-md-6'>
                    <div class="form-group row">
                        <label class="col-3 col-form-label form-control-label" for="note">
                            Status: </label>
                        <div class="col-9">
                            <select name="status" id="" class="form-control">
                                <option value="">Select an option</option>
                                <option {{optional($data['servicefee'])->status == 1?"selected":""}} value="1">Active</option>
                                <option {{optional($data['servicefee'])->status == 0?"selected":""}} value="0">Inactive</option>
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