@extends('layouts.master')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">{{ $data['panel_name']}}</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('application.immigration.index') }}" class="btn btn-sm btn-neutral">
            <i class="fas fa-chevron-left"></i> Back to list</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('main-content')
<div class="row">
  <div class="col">
    <div class="card">
      <!-- Card header -->
      <!-- -->
      <div class="card-body">
        <!-- Address Contact From Block -->
        <div id="DocumentAddForm">
          <div class="card">
            <div class="card-header">
              <h4>Edit immigration application
                <a href="{{ route('client.show', $data['row']->basic_info_id) }}" class="btn btn-sm btn-primary float-right"> Back to client</a>
              </h4>
            </div>
            <div class="card-body">
              <div class="document_error"></div>
              <form action="{{ route('client.update.immigration', $data['row']->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input value="{{ $data['row']->basic_info_id }}" name="basic_info_id" type="hidden">
                <div class="row">

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Applicant name</label>
                      <input type="text" class="form-control" value="{{old('student_name',$data['row']->student_name)}}" name="student_name">

                      {!! isError($errors, 'student_name') !!}
                    </div>
                  </div>


                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Country Applying</label>
                      <select class="form-control" id="iso_countrylist_id" name="iso_countrylist_id">
                        <option value="">Select Options</option>
                        @foreach ($data['country_code'] as $countryCode)
                        <option value="{{ $countryCode->id }}" {{ (old("iso_countrylist_id") == $countryCode->id || $data['row']['iso_countrylist_id']==$countryCode->id ? "selected":"") }}>{{ $countryCode->title }}</option>
                        @endforeach
                      </select>
                      {!! isError($errors, 'iso_countrylist_id') !!}
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Application Method</label>
                      <select class="form-control" id="application_method" name="application_method">
                        <option value="">Select Options</option>
                        <option value="online" {{ ($data['row']->application_method == 'online') ? 'selected' : ''  }}>Online</option>
                        <option value="paper" {{ ($data['row']->application_method == 'paper') ? 'selected' : ''  }}>Paper</option>
                        <option value="email" {{ ($data['row']->application_method == 'email') ? 'selected' : ''  }}>Email</option>
                      </select>
                      {!! isError($errors, 'application_method') !!}
                    </div>
                  </div>

                </div>
                <div class="row">



                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Application Ref</label>
                      <input autocomplete="off" class="form-control" name="ref" id="ref" placeholder="Application Ref" value="{{ $data['row']->ref }}">
                      {!! isError($errors, 'ref') !!}
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Advisor</label>
                      <select class="form-control" name="advisor_id">
                        <option value="">Select advisor</option>
                        @foreach($data['advisors'] as $advisor)

                        <option {{$data['row']->advisor_id == $advisor->id ? "selected":""}} value="{{$advisor->id}}">{{$advisor->name}}</option>

                        @endforeach
                      </select>
                      {!! isError($errors, 'advisor_id') !!}
                    </div>
                  </div>



                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="date">Date Submitted</label>
                      <input type="date" class="form-control" value="{{$data['row']->date_submitted}}" name="date_submitted" id="date">
                      {!! isError($errors, 'date_submitted') !!}
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="date">File opening date</label>
                      <input type="text" class="form-control datepicker2" value="{{$data['row']->file_opening_date_formatted}}" name="file_opening_date">
                      {!! isError($errors, 'file_opening_date') !!}
                    </div>
                  </div>

                  <div class="col-lg-6">

                    <div class="form-group">
                      <label for="">Application Detail</label>
                      <textarea autocomplete="off" class="form-control servicefeeautocomplete" name="application_detail" id="application_detail" placeholder="Application detail">{{ $data['row']->application_detail }}</textarea>
                      {!! isError($errors, 'application_detail') !!}
                    </div>
                  </div>


                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Note</label>
                      <textarea autocomplete="off" class="form-control" name="note" id="note" placeholder="Notes">{{ $data['row']->note }}</textarea>
                      {!! isError($errors, 'note') !!}
                    </div>
                  </div>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name='redirect_to_client' class="custom-control-input" id="redirect_to">
                  <label class="custom-control-label" for="redirect_to">Redirect to this client's dashboard</label>
                </div>
                <button class="btn btn-primary float-right" type="submit">Save</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>

<script type="text/javascript">
  $(function() {
    $('#issue_date').datepicker({
      format: 'dd-mm-yyyy'
    });
    $('#expiry_date').datepicker({
      format: 'dd-mm-yyyy'
    });

    $('.datepicker2').datepicker({
      format: '{{config("constant.date_format_javascript")}}'
    });



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
              value: e.name + " - " + e.category,
              text: e.name + " - " + e.category,
            });
          })
          return da;
        }
      },

    });

  });
</script>
@endpush