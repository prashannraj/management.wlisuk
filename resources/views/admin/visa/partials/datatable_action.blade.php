<a class='btn btn-sm {{$row->expiry_email? "btn-warning":"btn-primary"}}' title='{{$row->expiry_email_status }}' data-id="{{$row->visa_id}}" href="#sendEmailModal" data-toggle='modal'>
    <i class="fa fa-envelope"></i>
</a>
<a href="{{route('client.show',$row->basic_info_id)}}" target="_blank" class="btn-sm btn-warning"> <i class="fa fa-cog"></i> </a>