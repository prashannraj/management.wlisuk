<div class="col-md-4">
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" id="name" autocomplete="off" name='name' value="{{old('name',$data['form']->name)}}" class="form-control">


        {!! isError($errors, 'name') !!}

    </div>


</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="">Title</label>
        <input type="text" id="title" autocomplete="off" name='title' value="{{old('name',$data['form']->title)}}" class="form-control">


        {!! isError($errors, 'title') !!}

    </div>
</div>

<div class='col-md-4'>
    <div class="form-group">
        <label class="form-label form-control-label" for="status">Status </label>
        <div class="">
            <select name="status" class='form-control' value="{{old('status',optional($data['form'])->status)}}" id="">
                <option value="">Select status of this form</option>
                @foreach(array("active","inactive") as $country)

                <option {{old('status',optional($data['form'])->status) == $country ?"selected":"" }} value="{{$country}}">{{ucfirst($country)}}</option>

                @endforeach
            </select>

            {!! isError($errors, 'status') !!}
        </div>
    </div>
</div>


<div class='col-md-4'>
    <div class="form-group">
        <label class="form-label form-control-label" for="type">Type </label>
        <div class="">
            <select name="type" class='form-control' value="{{old('type',optional($data['form'])->type)}}" id="">
                <option value="">Select type of this form</option>
                @foreach(config('constant.enquiry_form_types') as $key=>$country)

                <option {{old('type',optional($data['form'])->type) == $key ?"selected":"" }} value="{{$key}}">{{$country}}</option>

                @endforeach
            </select>

            {!! isError($errors, 'type') !!}
        </div>
    </div>
</div>