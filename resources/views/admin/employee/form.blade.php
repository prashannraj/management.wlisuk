<div class="col-lg-6">
    <div class="card-wrapper">
      <!-- Form controls -->
      <div class="card">
        <!-- Card body -->
        <div class="card-body">
          <div class="form-group row">
            <label class="col-3 col-form-label form-control-label" for="title">Title: </label>
            <div class="col-9">
              <select class="form-control" id="title" name="title">
                <option>Select Options</option>
                @foreach ($data['title'] as $t)
                <option value="{{ $t }}" {{ old('title',optional($data['row'])->title) == $t?"selected":""}}>{{ $t }}</option>
                @endforeach
              </select>
              {!! isError($errors, 'title') !!}
            </div>
          </div>
          <div class="form-group row">
            <label class="col-3 col-form-label form-control-label" for="l_name">
              Surname: </label>
            <div class="col-9">
              <input autocomplete="off" type="text" class="form-control" name="l_name" id="l_name" placeholder="Surname" value="{{ old('l_name',optional($data['row'])->l_name) }}">
              {!! isError($errors, 'l_name') !!}
            </div>

          </div>
          <div class="form-group row">
            <label class="col-3 col-form-label form-control-label" for="f_name">
              First Name: </label>
            <div class="col-9">
              <input autocomplete="off" type="text" class="form-control" id="f_name" name="f_name" placeholder="First Name" value="{{ old('f_name',optional($data['row'])->f_name) }}">
              {!! isError($errors, 'f_name') !!}
            </div>
          </div>
          <div class="form-group row">
            <label class="col-3 col-form-label form-control-label" for="m_name">Middle Name: </label>
            <div class="col-9">
              <input autocomplete="off" type="text" class="form-control" id="m_name" name="m_name" placeholder="Middle Name" value="{{ old('m_name',optional($data['row'])->m_name) }}">
              {!! isError($errors, 'm_name') !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card-wrapper">
      <!-- Form controls -->
      <div class="card">
        <!-- Card body -->
        <div class="card-body">
          <div class="form-group row">
            <label class="col-3 col-form-label form-control-label" for="Date of birth">Date of birth: </label>
            <div class="col-9">
              <input autocomplete="off" type="text" class="form-control" id="dob" name="dob" placeholder="Date of birth" value="{{ old('dob',optional($data['row'])->dob_formatted) }}">
              {!! isError($errors, 'dob') !!}
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label" for="note">Gender: </label>
            <div class="col-lg-9">
              <div class="row pl-3">
                <!-- Gender  -->
                <div class="col-lg-4 custom-control custom-radio float-left mt-2">
                  <input name="gender" class="custom-control-input" id="male" type="radio" value="Male" {{ (strtolower(old('gender',optional($data['row'])->gender)) == "male")? 'checked':'' }}>
                  <label class="custom-control-label" for="male">Male</label>
                </div>
                <div class="col-lg-4 custom-control custom-radio mt-2 ">
                  <input name="gender" class="custom-control-input" id="female" type="radio" value="Female" {{ (strtolower(old('gender',optional($data['row'])->gender)) == "female")? 'checked':'' }}>
                  <label class="custom-control-label" for="female">Female</label>
                </div>
                <!-- End of Gender  -->
              </div>
              {!! isError($errors, 'gender') !!}
            </div>
          </div>

          <div class="form-group row">
            <label class="col-lg-3 col-form-label form-control-label" for="status">Status: </label>
            <div class="col-lg-9">
              <div class="row pl-3">
                <!-- Gender  -->
                <div class="col-lg-4 mt-2 custom-control custom-radio">
                  <input name="status" class="custom-control-input" id="active" type="radio" value="Active" {{ (strtolower(old('status',optional($data['row'])->status)) == "active")? 'checked':'' }}>
                  <label class="custom-control-label" for="active">Active</label>
                </div>
                <div class="col-lg-4 mt-2 custom-control custom-radio">
                  <input name="status" class="custom-control-input" id="inactive" type="radio" value="Inactive" {{ (strtolower(old('status',optional($data['row'])->status)) == "inactive")? 'checked':'' }}>
                  <label class="custom-control-label" for="inactive">Inactive</label>
                </div>
                <div class="col-lg-4 mt-2 custom-control custom-radio">
                  <input name="status" class="custom-control-input" id="pending" type="radio" value="Pending" {{ (strtolower(old('status',optional($data['row'])->status)) == "pending")? 'checked':'' }}>
                  <label class="custom-control-label" for="pending">Pending</label>
                </div>
                <!-- End of Gender  -->
              </div>
              {!! isError($errors, 'status') !!}
            </div>

            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Signature</label>
              <div class="col-lg-9">
                @if($data['row']->signature)
                  <img src="{{$data['row']->signature_url}}" alt="" srcset="">
                @endif
                <input type="file" name="signature" class='form-control' id="">
              </div>
            </div>



          </div>


          <!-- <button class="btn btn-icon btn-warning ml-1 float-right" type="reset">
                <span class="btn-inner--icon"><i class="fas fa-sync"></i></span>
                <span class="btn-inner--text">Reset</span>
            </button> -->
        </div>
      </div>


    </div>
  </div>


  @push('scripts')
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>

<script type="text/javascript">
  $('#dob').datepicker({
    format: '{{config("constant.date_format_javascript")}}',
  });
</script>

@endpush
