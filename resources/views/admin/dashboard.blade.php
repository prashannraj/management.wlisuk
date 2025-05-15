@extends('layouts.master')
@section('header')
<!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6>
    
        </div>
      
      </div>
      <!-- Card stats -->
    </div>
  </div>
</div>
@endsection
@section('main-content')
<div class="row">

  <div class="col-xl-6">
    <div class="card">
      <div class="card-header bg-transparent">
        <div class="row align-items-center">
          <div class="col">
            <h6 class="text-uppercase text-muted ls-1 mb-1">Enquiry</h6>
            <h5 class="h3 mb-0">Total enquiries</h5>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="chart">
          <canvas id="enquiry-bars" class="chart-canvas"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-6">
    <div class="card">
      <div class="card-header bg-transparent">
        <div class="row align-items-center">
          <div class="col">
            <h6 class="text-uppercase text-muted ls-1 mb-1">Applications</h6>
            <h5 class="h3 mb-0">Total applications</h5>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="chart">
          <canvas id="application-pie" class="chart-canvas"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-6">
    <div class="card">
      <div class="card-header bg-transparent">
        <div class="row align-items-center">
          <div class="col">
            <h6 class="text-uppercase text-muted ls-1 mb-1">Visa expiry</h6>
            <h5 class="h3 mb-0"><a href='https://management.wlisuk.com/report/clients'>Total visa expiries</a></h5>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="chart">
          <canvas id="visa-pie" class="chart-canvas"></canvas>
        </div>
      </div>
    </div>
  </div>


  <div class="col-xl-6">
    <div class="card">
      <div class="card-header bg-transparent">
        <div class="row align-items-center">
          <div class="col">
            <h6 class="text-uppercase text-muted ls-1 mb-1">Immigration Application Status</h6>
            <h5 class="h3 mb-0">Total file closed</h5>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="chart">
          <canvas id="file-pie" class="chart-canvas"></canvas>
        </div>
      </div>
    </div>
  </div>


  <div class="col-xl-6">
    <div class="card">
      <div class="card-header bg-transparent">
        <div class="row align-items-center">
          <div class="col">
            <h6 class="text-uppercase text-muted ls-1 mb-1">Outstanding invoice balance</h6>
            <h5 class="h3 mb-0">Invoice balance</h5>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="chart">
            <table class="table table-responsive">
              <thead>
                <tr><th>S/N</th>
                <th>Balance</th>
                <th>No. of Invoices</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody>
                @php $i=1; @endphp
                @foreach($data['invoiceDataLabels'] as $key=>$d)
                  <tr>
                    <td>{{$i++}}</td>
                    <td>
                      {{$key}}
                    </td>
                    <td>
                      {{$d}}
                    </td>
                    <td>
                      <a target="_blank" href="{{route('report.invoice',['balance'=>$key])}}">
                        <i class="fa fa-file"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          <!-- <canvas id="invoice-chart" class="chart-canvas"></canvas> -->
        </div>
      </div>
    </div>
  </div>


</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/vendor/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('assets/vendor/chart.js/dist/Chart.extension.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>

<script>
  function generateChart($data, $location, $type) {
    var $chart = $($location);


    //
    // Methods
    //

    // Init chart
    function initChart($chart) {

      // Create chart
      var ordersChart = new Chart($chart, {
        type: $type,
        data: $data,
        plugins: {
          colorschemes: {
            scheme: 'brewer.Paired12'
          }
        }
      });

      // Save to jQuery object
      $chart.data('chart', ordersChart);
    }


    // Init chart
    if ($chart.length) {
      initChart($chart);
    }
  };
</script>


<script>
  var enquiryData = {
    labels: ['Last 30 days', 'Last 3 months', 'Last 6 months', 'Last 1 year'],
    datasets: [{
      label: 'Enquiries',
      data: {!!json_encode($data['enquiry_data']->all(),false)!!}
    }]
  };
  var applicationData = {
    labels: ['Immigration', 'Admission'],
    datasets: [{
      label: 'Active applications',
      data: {!!json_encode($data['application_data']->all(),false)!!}
    }]
  };

  var visaData = {
    labels: ['6 months', '3 months', '1 month', '1 week', 'today'],
    datasets: [{
      label: 'Active applications',
      data: {!!json_encode($data['visa_data']->all(),false)!!}
    }]
  };

  var fileData = {
    labels: {!! json_encode($data['fileLabels'],false) !!},
    datasets: [{
      label:"Immigration Application status",
      data: {!! json_encode($data['fileData'],false) !!}
    }]
  };

  var invoiceData = {
    labels: {!! json_encode(array_keys($data['invoiceDataLabels']),false) !!},
    datasets: [{
      label:"Outstanding invoice balances",
      data: {!! json_encode(array_values($data['invoiceDataLabels']),false) !!}
    }]
  };
</script>
<script>
  

  var enquiryChart = generateChart(enquiryData, "#enquiry-bars", "doughnut");
  var applicationChart = generateChart(applicationData, "#application-pie", "pie");
  var visaChart = generateChart(visaData, "#visa-pie", "pie");
  var fileChart = generateChart(fileData, "#file-pie", "horizontalBar");

  var invoiceChart = generateChart(invoiceData, "#invoice-chart", "doughnut");

</script>
@endpush