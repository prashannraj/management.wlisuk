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
                                <input id="category" type="text" class="form-control" name="category" placeholder="Category" value="{{ old('category',optional($data['advisor'])->category) }}">
                                {!! isError($errors, 'category') !!}
                            </div>

                        </div>
                    </div>

                    <div class='col-md-6'>




                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="name">
                                Full Name: </label>
                            <div class="col-9">
                                <input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name',optional($data['advisor'])->name) }}">
                                {!! isError($errors, 'name') !!}
                            </div>

                        </div>
                    </div>

                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="level">
                               Advisor Level: </label>
                            <div class="col-9">
                                <input id="level" type="text" class="form-control" name="level" placeholder="level" value="{{ old('level',optional($data['advisor'])->level) }}">
                                {!! isError($errors, 'level') !!}
                            </div>

                        </div>
                    </div>



                <div class='col-md-6'>
                    <div class="form-group row">
                        <label class="col-3 col-form-label form-control-label" for="email">
                            Email </label>
                        <div class="col-9">
                            <input id="email" type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email',optional($data['advisor'])->email) }}">
                            {!! isError($errors, 'email') !!}
                        </div>

                    </div>
                </div>


                <div class='col-md-6'>
                    <div class="form-group row">
                        <label class="col-3 col-form-label form-control-label" for="contact">
                             Emergency Contact (with country code) </label>
                        <div class="col-9">
                            <input id="contact" type="contact" class="form-control" name="contact" placeholder="Emergency Contact" value="{{ old('contact',optional($data['advisor'])->contact) }}">
                            {!! isError($errors, 'contact') !!}
                        </div>

                    </div>
                </div>


                <div class='col-md-6'>
                    <div class="form-group row">
                        <label class="col-3 col-form-label form-control-label" for="status">
                            Status </label>
                        <div class="col-9">
                            <select name="status" class='form-control' id="status">
                                <option value="">Select status of this advisor</option>
                                <option {{ optional($data['advisor'])->status == 'active'?'selected':'' }} value="active">Active</option>
                                <option {{ optional($data['advisor'])->status == 'inactive'?'selected':'' }} value="inactive">Inactive</option>
                            </select>
                            {!! isError($errors, 'status') !!}
                        </div>

                    </div>
                </div>

                

                <div class='col-md-6'>
                    <div class="form-group row">
                        <label class="col-3 col-form-label form-control-label" for="note">
                            Digital Signature: </label>
                        <div class="col-9">
                            @if($data['advisor']->signature != null)
                            <img class='img img-fluid' width="200px" src="{{  $data['advisor']->signature_url}}" alt="" srcset="">
                            @endif
                            <input id="note" type="file" class="file-control" name="signature">
                            {!! isError($errors, 'signature') !!}
                        </div>

                    </div>
                </div>
















            </div>




        </div>
    </div>
</div>


</div>