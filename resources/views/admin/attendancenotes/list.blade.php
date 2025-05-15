<div class="card">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Attendance Notes</h4>
    </div>

    <div class="card-body">
        <table class="table table-border table-striped" id="attendance_noteTable">
            <thead>
                <th>SN</th>
                
                <th>Note type</th>
                <th>Date</th>
                <th>Action</th>
            </thead>
            <tbody class="attendance_note_details">
                @if(count($data['basic_info']->attendance_notes))
                @foreach($data['basic_info']->attendance_notes()->latest()->get() as $index=>$attendance_note)
                <tr>
                    <td> {{ $index + 1}} </td>
                   
                    <td style="white-space: pre-wrap;"> {{ ucfirst($attendance_note->type_string) }} </td>
                    <td>{{$attendance_note->date->format(config('constant.another_date_format'))}}</td>
                    <td>
                        <a @if(isset($data['basic_info'])) href="{{ route('attendancenote.show',$attendance_note->id)}}" @else href="{{ route('attendancenote.show',['attendance_note'=>$attendance_note->id])}}" @endif class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                        <a href="{{ route('attendancenote.edit',$attendance_note->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                        <form class='d-inline-block' action="{{ route('attendancenote.destroy',$attendance_note->id)}}" method="post">

                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>

                        </form>
                    <td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        <a href="{{route('attendancenote.create',$data['basic_info']->id)}}" class="btn btn-primary">Add new</a>

    </div>
</div>