<div class="table-responsive">
    <table class="table" id="emailSenders-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
        <th>Email</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($emailSenders as $emailSender)
            <tr>
                <td>{{ $emailSender->id }}</td>
                <td>{{ $emailSender->name }}</td>
            <td>{{ $emailSender->email }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['emailSenders.destroy', $emailSender->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('emailSenders.show', [$emailSender->id]) }}" class='btn btn-default btn-sm'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('emailSenders.edit', [$emailSender->id]) }}" class='btn btn-default btn-sm'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
