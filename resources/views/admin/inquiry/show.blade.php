@extends('layouts.master')

@push('styles')
@endpush
@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-6">
          <h6 class="h2 text-white d-inline-block mb-0 pl-4">{{ $data['panel_name'] }}</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('enquiry.list') }}" class="btn btn-sm btn-neutral">
            <i class="fas fa-chevron-left"></i> Back To list</a>
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
      <div class="card-header border-0 pb-0">
        <div class="card-wrapper">
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-striped table-inverse table-responsive">
              <thead>
                <tr>
                  <th>User Detail</th>
                  <th>#</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th>Title</th>
                  <td>{{ $data['enquiry']->title }}</td>
                </tr>
                <tr>
                  <th>Full Name</th>
                  <td>{{ $data['enquiry']->full_name }}</td>
                </tr>
                <tr>
                  <th>Mobile</th>
                  <td>{{ $data['enquiry']->m_code .' '. $data['enquiry']->mobile }}</td>
                </tr>
                <tr>
                  <th>Tel</th>
                  <td>{{ $data['enquiry']->t_code .' '. $data['enquiry']->tel }}</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td>{{ $data['enquiry']->email }}</td>
                </tr>
                <tr>
                  <th>Enquiry Type</th>
                  <td>{!! $data['enquiry']->enquiry_type !!}</td>
                </tr>
                <tr>
                  <th>Referral</th>
                  <td>{{ $data['enquiry']->referral }}</td>
                </tr>
                <tr>
                  <th>Note</th>
                  <td>{{ $data['enquiry']->note }}</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td>Go To Process</td>
                  <td>
                    <a href="{{ route('enquiry.log',$data['enquiry']->id)}}" class="btn btn-info btn-sm">
                      <i class="fas fa-cog"></i>
                    </a>
                  </td>
                </tr>
                <tr>
                	<td>
                		Delete this?
                	</td>
                	<td>
                		<a href="#deleteModal" data-toggle="modal" class='btn btn-error'>Delete</a>
                	</td>
                </tr>
              </tfoot>
            </table>
          </div>

          <div class="col-md-6">
            <h4 class="text-primary font-weight-600">Addresses</h4>
            <ul class="list-group">
              @foreach($data['enquiry']->addresses as $address)
                <li class="list-group-item">
                  {{$address->full_address}}
                </li>
              @endforeach
            </ul>
            <h4 class="text-primary font-weight-600">Report</h4>
            <ul class="list-group">
              @foreach($data['enquiry']->activities as $activity)
              <li class="list-group-item">
                <p><b>Status: </b>{{$activity->status_attr}}</p>
                @if($activity->enquiryFollowUp)
                <p><b>Follow Up: </b>{{$activity->enquiryFollowUp->date}} <b>({{$activity->enquiryFollowUp->date_difference() }})</b>  </p>
                @endif
                <p><b>Date added: </b>{{$activity->created->format(config('constant.date_format'))}} <b>({{$activity->created->diffForHumans()}})</b> </p>
                <div><b>Note:</b><br>
                {{$activity->note}}
              </div>
              </li>

              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--route('enquiry.delete', ['id' => $row->id])-->

<div class="modal" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('enquiry.delete',$data['enquiry']->id)}}" method="POST">
        @method('delete')
        @csrf
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Delete enquiry details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <input type="hidden" name="emergency_id" value="">
        <!-- Modal body -->
        <div class="modal-body">
          <h3>Are you sure you want to delete this enquiry? This can't be undone.</h3>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="submit" value="Yes" class="btn btn-info">
          <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </div>
      </form>

    </div>
  </div>
</div>

@endsection

@push('scripts')
@endpush