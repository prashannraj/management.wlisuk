{!! Form::open(['route' => ['cpdDetails.destroy', $cpdDetail->id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('cpdDetails.show', $cpdDetail->id) }}" class='btn btn-default btn-sm'>
        <i class="fa fa-eye"></i>
    </a>
    <a href="#edit_detail_modal" data-toggle="modal" data-id="{{$cpdDetail->id}}" class='btn btn-default btn-sm'>
        <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-sm',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
