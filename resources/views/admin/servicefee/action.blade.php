@php
$editUrl = route('servicefee.edit',$id);
$viewUrl = route('servicefee.show', $id);
$deleteUrl = route('servicefee.destroy',$id);
$btn =' <a href="'. $viewUrl .'" class="edit btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>'.

' <a href="'. $editUrl .'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i></a>';
@endphp
{!!$btn!!}
<a href="#" data-toggle="modal" data-target="#delete_servicefee" data-id="{{$id}}" class="edit btn btn-warning btn-sm"><i class="fas fa-trash"></i></a>