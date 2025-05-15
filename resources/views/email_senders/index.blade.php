@extends('layouts.master')
@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Email Senders</h6>
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
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <a class="btn btn-primary float-right" href="{{ route('emailSenders.create') }}">
                    Add New
                </a>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">

    @include('flash::message')

    <div class="clearfix"></div>

    <div class="card">
        <div class="card-body">
            @include('email_senders.table')

            <div class="card-footer clearfix float-right">
                <div class="float-right">
                    @include('adminlte-templates::common.paginate', ['records' => $emailSenders])
                </div>
            </div>
        </div>

    </div>

    <div class="card mt-2">
        <div class="card-body">
            <p>Following provision has been done in the system regarding emails.</p>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Purpose</th>
                    </tr>

                </thead>
                <tbody>
                    <tr>
                        <td>
                            1
                        </td>
                        <td>
                            Accounts
                        </td>
                    </tr>

                    <tr>
                        <td>
                            2
                        </td>
                        <td>
                            Applications
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            3
                        </td>
                        <td>
                            Admin
                        </td>
                    </tr>

                    <tr>
                        <td>
                            4
                        </td>
                        <td>
                            Enquiries
                        </td>
                    </tr>

                    <tr>
                        <td>
                            5
                        </td>
                        <td>
                            Info (i.e. info@companyname.com)
                        </td>
                    </tr>

                    <tr>
                        <td>
                            6
                        </td>
                        <td>
                            Administrator Name (i.e. janedoe@companyname.com)
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection