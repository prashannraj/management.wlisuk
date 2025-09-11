@extends('layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@section('header')
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-6">
                    <h6 class="h2 text-white d-inline-block mb-0 pl-4">{{ $data['panel_name'] }}</h6>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('enquiry.create') }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-plus-circle"></i> New
                    </a>
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
            <div class="card-header border-0 pb-0">
                <div class="row">
                    @include('admin.inquiry.status')

                    <div class="form-group col-lg-3 col-sm-12">
                        <label for="filterByActivity">Filter Activity</label>
                        <select class="form-control bg-primary text-white" id="filterByActivity" name="activity">
                            <option value="">All Activities</option>
                            <option value="new">New</option>
                            <option value="follow_up">Follow Up</option>
                            <option value="processed">Processed</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-3 col-sm-12">
                        <label for="filterByEnquiryType">Filter Enquiry Type</label>
                        <select class="form-control bg-primary text-white" id="filterByEnquiryType" name="enquiry_type">
                            <option value="">All Types</option>
                            @foreach ($data['enquiry_type'] as $et)
                                <option value="{{ $et->id }}">{{ $et->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-3 col-sm-12">
                        <label for="filterByEnquiryStatus">Filter Status</label>
                        <select class="form-control bg-primary text-white" id="filterByEnquiryStatus" name="enquiry_status">
                            <option value="">All Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="form-group col-1">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-success rounded-circle btn-sm btn-block text-white mt-3" id="btnReset">
                            <i class="fas fa-sync"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive py-4">
                      <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>S.No.</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Enquiry Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['enquiries'] as $enquiry)
                            <tr>
                                <td>{{ ($data['enquiries']->currentPage() - 1) * $data['enquiries']->perPage() + $loop->index + 1 }}</td>
                                <td>{{ $enquiry->first_name }}</td>
                                <td>{{ $enquiry->surname }}</td>
                                <td>{!! $enquiry->enquiry_type !!}</td>
                                <td>
                                    <a href="{{ route('enquiry.show', $enquiry->id) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('enquiry.edit', $enquiry->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('enquiry.delete', $enquiry->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No enquiries found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                      </table>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center">
                        {{ $data['enquiries']->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
$(document).ready(function() {

    function fetchEnquiries() {
        let filters = {
            enquiry_type: $('#filterByEnquiryType').val(),
            activity: $('#filterByActivity').val(),
            status: $('#filterByEnquiryStatus').val()
        };

        $.ajax({
            url: "{{ route('enquiry.data') }}",
            type: "GET",
            data: filters,
            success: function(response) {
                let tbody = '';
                if(response.data.length > 0){
                    response.data.forEach((item, index) => {
                        tbody += `<tr>
                            <td>${index + 1}</td>
                            <td>${item.first_name}</td>
                            <td>${item.surname}</td>
                            <td>${item.enquiry_type}</td>
                            <td>${item.action}</td>
                        </tr>`;
                    });
                } else {
                    tbody = '<tr><td colspan="5" class="text-center">No records found</td></tr>';
                }
                $('#enquiry-tbody').html(tbody);
            },
            error: function(xhr){
                console.error(xhr.responseText);
            }
        });
    }

    // Initial fetch
    fetchEnquiries();

    // Filters
    $('#filterByActivity, #filterByEnquiryType, #filterByEnquiryStatus').on('change', fetchEnquiries);

    // Reset filters
    $('#btnReset').on('click', function() {
        $('#filterByActivity, #filterByEnquiryType, #filterByEnquiryStatus').val('');
        fetchEnquiries();
    });

    // Datepicker
    $('.follow-up-date').datepicker({ format: 'dd-mm-yyyy' });

    // Status modal functions
    function resetFormFields() {
        $('.statusModification').val('');
        $('#status-modification-form').hide();
        $('.follow-up-section').hide();
        $('#form-heading').text('');
        $('#activity-id').val('');
    }

    window.getStatusBox = function(elmnt, id) {
        if(!id) return;
        resetFormFields();
        let target = $(elmnt).data('target');
        let heading = target === '#nextprocess' ? 'Next Process' : 'Update Status';
        let activityType = target === '#nextprocess' ? 1 : 0;
        $('#activity-id').val($(elmnt).data('id'));
        $('#activity-type').val(activityType);
        $('#enquiry-id').val($(elmnt).data('enquirylistid'));
        $('#form-heading').text(heading);
        $("[name='status_note']").val($(elmnt).data('note'));
        $("select.statusModification").val($(elmnt).data('status'));
        $('#status-modification-form').show();
    };

    $('#updateStatus').on('click', function() {
        let data = {
            activityType: $("#activity-type").val(),
            activityId: $("#activity-id").val(),
            statusNote: $("[name='status_note']").val(),
            statusSelection: $("[name='status_modification']").val(),
            followUpDate: $("[name='followUpDate']").val(),
            followUpNote: $("[name='followUpNote']").val(),
            _token: "{{ csrf_token() }}"
        };

        // Validate data
        let errors = {};
        if(!data.activityType) errors.activityType = "Selected type is not applicable";
        if(!data.activityId) errors.activityId = "No selected data for update status";
        if(!data.statusSelection) errors.statusSelection = "Please select the status type";
        if(data.statusSelection == 2 && !data.followUpDate) errors.followUpDate = "Follow up date must be selected";

        if(Object.keys(errors).length > 0){
            let output = '<ul class="alert alert-danger">';
            $.each(errors, function(_, val){ output += '<li>' + val + '</li>'; });
            output += '</ul>';
            $('#errorDiv').html(output);
            return;
        } else {
            $('#errorDiv').html('');
            $.post("{{ route('enquiry.postStatusUpdate') }}", data, function(result) {
                if(result.status){
                    fetchEnquiries();
                    $("#updateStatus").attr("disabled", true);
                }
            });
        }
    });

});
</script>
@endpush
