@extends("layouts.master")

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
                    <h6 class="h2 text-white d-inline-block mb-0">Notifications/Alert</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back To Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('main-content')
<div class="row">
    <div class="col">
        <!-- Passport Details -->
        <div class="card" id="documentCard">
            <div class="card-header">
                <h3 class="text-primary font-weight-600">Notifications/Alerts

                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div>
                        
                    </div>

                    <table class='table table-hover'> 
                    
                    <thead>
                    <tr>
                    <th>S/N</th>
                    <th>Title</th>
                    <th>Details</th>
                    <th>Created at</th>
                   
                    <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody> 
                        @foreach($data['notifications'] as $i=>$notification)
                            <tr class="{{$notification->read_at??'unread'}}">
                                <td>{{$i+1}}</td>
                                <td>
                                    {{$notification->data['title']}}
                                </td>
                                <td>
                                {{$notification->data['message']}}
                                </td>
                                <td>
                                    {{$notification->created_at->diffForHumans()}}
                                </td>
                                <td>
                                    <button onclick="window.location.href='{{route('notification.show',$notification->id)}}';" class='btn btn-sm btn-info'><i class="fa fa-eye"></i></button>
                                <button onclick="window.location.href='{{route('delete.notification',$notification->id)}}';" class=" btn btn-warning btn-sm"><i class="fa fa-trash"></i></button>

                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
            {{$data['notifications']->links()}}

            </div>
        </div>
    </div>
</div>

@endsection

@push("scripts")
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="/vendor/datatables/buttons.server-side.js"></script>
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $(function() {

      

    });
</script>



@endpush