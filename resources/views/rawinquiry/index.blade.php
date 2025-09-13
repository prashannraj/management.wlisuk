@extends('layouts.master')

@section('header')
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Web Enquiries</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-neutral">Back To Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('main-content')
<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Web Enquiries</h3>
    </div>
    <div class="card-body">

        <!-- Filters -->
        <form method="GET" action="{{ route('rawenquiry.index') }}" class="mb-4 row">
            <div class="col-md-3">
                <input type="text" class="form-control" name="startdate" value="{{ request('startdate') }}" placeholder="Start Date (YYYY-MM-DD)">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="enddate" value="{{ request('enddate') }}" placeholder="End Date (YYYY-MM-DD)">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">-- Filter processed --</option>
                    <option value="processed" {{ request('status')=='processed'?'selected':'' }}>Processed</option>
                    <option value="not_processed" {{ request('status')=='not_processed'?'selected':'' }}>Not Processed</option>
                </select>
            </div>
            <div class="col-md-3 d-flex">
                <button type="submit" class="btn btn-info mr-2">Filter</button>
                <a href="{{ route('rawenquiry.index') }}" class="btn btn-danger">Reset</a>
            </div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>S/N</th>
                        <th>Form Name</th>
                        <th>Full Name</th>
                        <th>Validated</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $index => $row)
                    <tr>
                        <td>{{ $inquiries->firstItem() + $index }}</td>
                        <td>{{ $row->form_name ?? '-' }}</td>
                        <td>{{ $row->full_name }}</td>
                        <td>{{ $row->is_validated }}</td>
                        <td class="d-flex flex-wrap gap-1">
                            <!-- Toggle Status -->
                            <a href="{{ route('rawenquiry.toggle',$row->id) }}" class="btn btn-sm {{ $row->active ? 'btn-info' : 'btn-danger' }}">
                                {{ $row->active ? "Active" : "Inactive" }}
                            </a>

                            <!-- View -->
                            <a href="{{ route('rawenquiry.show',$row->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>

                            <!-- Edit -->
                            <a href="{{ route('rawenquiry.edit',$row->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>

                            <!-- Note Modal Trigger -->
                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#note-modal-{{ $row->id }}">
                                <i class="fa fa-cog"></i>
                            </button>

                            <!-- Delete -->
                            <form action="{{ route('rawenquiry.destroy',$row->id) }}" method="POST" style="display:inline;">
                                @csrf @method('delete')
                                <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>

                    <!-- Note Modal -->
                    <div class="modal fade" id="note-modal-{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="noteModalLabel{{ $row->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Instruction / Discussion:</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('rawenquiry.add-note', $row->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="note">Instruction / Discussion:</label>
                                            <textarea class="form-control" id="note" name="note">{{ $row->additional_details }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="process">Process:</label>
                                            <input type="checkbox" id="process" name="process">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No enquiries found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
          {{ $inquiries->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>


    </div>
</div>

<style>
.modal-sm { max-width: 300px; }
.modal-body { padding: 15px; margin: 10px; }
.d-flex.flex-wrap.gap-1 > * { margin-bottom: 5px; }
</style>

@endsection
