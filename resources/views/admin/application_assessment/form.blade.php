<div class="row">
    <div class="form-group col-md-6">
        <label for="">Applicant's name</label>
        @if($data['row']->name == '')
        <input name='name' type="text" class="form-control" value="{{old('name',$data['client']->full_name)}}">
        @else
        <input name='name' type="text" class="form-control" value="{{old('name',$data['row']->name)}}">
        @endif
        {!! isError($errors, 'name') !!}

    </div>

    <div class="form-group col-md-6">
        <label for="">Country applying to</label>
        <select name="applying_to" id="" class="form-control">
            <option value="">Select country</option>
            @foreach($data['countries'] as $country)
            <option {{ old('applying_to',optional($data['row'])->applying_to) == $country->id?"selected":"" }} value="{{$country->id}}">{{$country->title}}</option>
            @endforeach
        </select>
        {!! isError($errors, 'applying_to',"You should mention country applying to.") !!}

    </div>


    <div class="form-group col-md-6">
        <label for="">Country applying from</label>
        <select name="applying_from" id="" class="form-control">
            <option value="">Select country</option>
            @foreach($data['countries'] as $country)
            <option {{ old('applying_from',optional($data['row'])->applying_from) == $country->id?"selected":"" }} value="{{$country->id}}">{{$country->title}}</option>
            @endforeach
        </select>
        {!! isError($errors, 'applying_from',"You should mention country applying from") !!}

    </div>


    <div class="col-md-6">
        <div class="form-group">
            <label for="">Select application detail</label>
            <select placeholder="Type here to quickly fill up application details" name='application_detail_id' class='form-control servicefeeautocomplete'></select>
            {!! isError($errors, 'application_detail_id',"This can not be empty.") !!}

        </div>
    </div>



</div>


@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>

<script>
    $('.servicefeeautocomplete').autoComplete({
        minLength: 1,
        resolverSettings: {
            url: '{{route("ajax.servicefee.index")}}'
        },
        events: {
            searchPost: function(data) {
                var da = [];
                data.map(function(e) {
                    da.push({
                        id: e.id,
                        value: e.id,
                        text: e.name + " - " + e.category,
                        address: e.address
                    });
                })
                return da;
            }
        },

    });

    @if(optional($data['row'])->application_detail != null)
    $('.servicefeeautocomplete').autoComplete('set', {
        value: "{{$data['row']->application_detail_id}}",
        text: "{{$data['row']->application_detail->name}} - {{$data['row']->application_detail->category}}"
    });
    @endif
</script>

@endpush