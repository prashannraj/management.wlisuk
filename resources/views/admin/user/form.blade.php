<div class="col-lg-12">
    <div class="card-wrapper">
        <!-- Form controls -->
        <div class="card">
            <!-- Card body -->
            <div class="card-body">

                <div class='row'>


                    <div class='col-md-6'>

                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="username">
                                Username: </label>
                            <div class="col-9">
                                <input id="username" type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username',optional($data['user'])->username) }}">
                                {!! isError($errors, 'username') !!}
                            </div>

                        </div>
                    </div>




                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="email">
                                Email </label>
                            <div class="col-9">
                                <input id="email" type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email',optional($data['user'])->email) }}">
                                {!! isError($errors, 'email') !!}
                            </div>

                        </div>
                    </div>

                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="department">
                                Department </label>
                            <div class="col-9">
                        <select name="department_id" id="" class="form-control">
                            <option value="">Select department</option>
                            @foreach($data['departments'] as $department)
                                <option {{ optional($data['user'])->department_id == $department->id ? "selected":"" }} value="{{$department->id}}">{{$department->title}}</option>
                            @endforeach

                        </select>
                            </div>
                            {!! isError($errors, 'department_id') !!}

                        </div>
                    </div>


                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="department">
                                Role </label>
                            <div class="col-9">
                        <select name="role_id" id="" class="form-control">
                            <option value="">Select Role</option>
                            @foreach($data['roles'] as $role)
                                <option {{ optional($data['user'])->role_id == $role->id ? "selected":"" }} value="{{$role->id}}">{{$role->title}}</option>
                            @endforeach

                        </select>
                            </div>
                            {!! isError($errors, 'role_id') !!}

                        </div>
                    </div>


                @if($data['user']->password != null)
                <div class="col-md-12">
                    <p>Enter password only if you wish to change them</p>
                </div>
                @endif

                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="password">
                                Password </label>
                            <div class="col-9">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password" value="">
                            </div>
                            {!! isError($errors, 'password') !!}

                        </div>
                    </div>


                    <div class='col-md-6'>
                        <div class="form-group row">
                            <label class="col-3 col-form-label form-control-label" for="password">
                                Confirm Password </label>
                            <div class="col-9">
                                <input id="password" type="password" class="form-control" name="password_confirmation" placeholder="Re enter password" value="">
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


</div>