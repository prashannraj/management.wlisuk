<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header d-flex align-items-center">
      <a class="navbar-brand" href="/">
          <img src="{{ companyLogo() }}" alt="Company Logo" class="navbar-brand-img">
       
      </a>
      <div class="ml-auto">
        <!-- Sidenav toggler -->
        <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
          <div class="sidenav-toggler-inner">
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
            <i class="sidenav-toggler-line"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar-inner">
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Nav items -->
        <ul class="navbar-nav">
        @include('layouts.inc.menu')

        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading p-0 text-muted">
          <span class="docs-normal">System Management</span>
        </h6>
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link" href="{{route('user.index')}}">
              <i class="ni ni-spaceship"></i>
              <span class="nav-link-text">Users</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="collapse" data-target="#old">
              <i class="fa fa-building text-primary"></i>
              <span class="nav-link-text">Old Invoices</span>
            </a>

            <div class="collapse {{ request()->routeIs('old.*')  ? 'show' : '' }}" id="old">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a href="{{ route('old.generalinvoice.index') }}" class="nav-link {{ request()->routeIs('old.generalinvoice.index') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('old.generalinvoice.index') ? 'fas text-orange' : 'far' }} fa-building"></i>General Invoices</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('old.immigrationinvoice.index') }}" class="nav-link {{ request()->routeIs('old.immigrationinvoice.index') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('old.immigrationinvoice.index') ? 'fas text-orange' : 'fa' }} fa-briefcase"></i>Immigration Invoices</a>
                </li>
              </ul>
            </div>
          </li>


          <li class="nav-item">
            <a class="nav-link" href="{{route('delete.index')}}">
              <i class="fa fa-building text-primary"></i>
              <span class="nav-link-text">Delete manager</span>
            </a>

          
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="collapse" data-target="#report">
              <i class="fa fa-file text-primary"></i>
              <span class="nav-link-text">Reports</span>
            </a>

            <div class="collapse {{ request()->routeIs('report.*')  ? 'show' : '' }}" id="report">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a href="{{ route('report.invoice') }}" class="nav-link {{ request()->routeIs('report.invoice') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('report.invoice') ? 'fas text-orange' : 'fa' }} fa-info"></i>Invoice Report</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('report.receipt') }}" class="nav-link {{ request()->routeIs('report.receipt') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('report.receipt') ? 'fas text-orange' : 'fa' }} fa-envelope-open"></i>Receipt Report</a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('report.immigration') }}" class="nav-link {{ request()->routeIs('report.immigration') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('report.immigration') ? 'fas text-orange' : 'fa' }} fa-envelope-open"></i>Immigration Report</a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('report.client') }}" class="nav-link {{ request()->routeIs('report.client') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('report.client') ? 'fas text-orange' : 'fa' }} fa-envelope-open"></i>Clients Report</a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('report.visa') }}" class="nav-link {{ request()->routeIs('report.visa') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('report.visa') ? 'fas text-orange' : 'fa' }} fa-envelope-open"></i>Client Visa Expiry Report</a>
                </li>

              </ul>
            </div>
          </li>

          <li class="nav-item">
              <a class="nav-link" href="{{route('enquiryform.index')}}">
                <i class="ni ni-ui-04"></i>
                <span class="nav-link-text">Enquiry Forms</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{route('rawenquiry.index')}}">
                <i class="ni ni-ui-04"></i>
                <span class="nav-link-text">Web Enquiries</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{route('settings')}}">
                <i class="ni ni-ui-04"></i>
                <span class="nav-link-text">Settings</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{route('massemail.send')}}">
                <i class="ni ni-ui-04"></i>
                <span class="nav-link-text">Emails to clients</span>
              </a>
            </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
