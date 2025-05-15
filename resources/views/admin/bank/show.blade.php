@extends('layouts.master')


@section('header')
<!-- Header -->
<div class="header bg-wlis pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">View Bank Details</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('finance.bank.index') }}" class="btn btn-sm btn-neutral">
                        <i class="fas fa-chevron-left"></i> Back To list</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('main-content')

<!-- Passport Details -->
<div class="card" id="documentCard">
    <div class="card-header">
        <h4 class="text-primary font-weight-600">Bank Details
          <a href="{{ route('finance.bank.index') }}" class="btn btn-sm btn-primary float-right"> Back</a>

        </h4>
    </div>
    <div class="card-body">
        <h3>Status</h3>
        <p>{{ucfirst($data['row']->status)}}</p>
        <br>
        <h3>Country</h3>
        <p>{{$data['row']->country->title}}</p>
        <br>
        <h3>Name of the Bank</h3>
        <p>{{$data['row']->title}}</p>
        <br>
        <h3>Branch Address</h3>
        <p>{{$data['row']->branch_address}}</p>
        <br>
        <h3>Account Name</h3>
        <p>{{$data['row']->account_name}}</p>
        <br>
        <h3>Account Number</h3>
        <p>{{$data['row']->account_number}}</p>
		<br>
        <h3>Swift Code BIC</h3>
        <p>{{$data['row']->swift_code_bic ?? "-"}}</p>
		<br>
        <h3>Sort Code</h3>
         <p>{{$data['row']->sort_code ?? "-"}}</p>
		<br>
		<h3>IBAN</h3>
         <p>{{$data['row']->iban ?? "-"}}</p>
        <br>
        <h3>Account Ref</h3>
         <p>{{$data['row']->account_ref ?? "-"}}</p>
		<br>
        <div>
	
	</div>

    </div>
    <div class="card-footer">
    </div>
</div>






<!--View modal-->





@endsection
