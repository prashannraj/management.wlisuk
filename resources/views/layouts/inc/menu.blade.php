<li class="nav-item">
    <a class="nav-link" href="{{ route('home') }}">
        <i class="ni ni-tv-2 text-primary"></i>
        <span class="nav-link-text">Dashboard</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('enquiry.*') ? 'active' : '' }}" href="#enquiry" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
        <i class="ni ni-mobile-button text-primary"></i>
        <span class="nav-link-text">Enquiry</span>
    </a>
    <div class="collapse {{ request()->routeIs('enquiry.*') ? 'show' : '' }}" id="enquiry">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{ route('enquiry.list') }}" class="nav-link {{ request()->routeIs('enquiry.list') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('enquiry.list') ? 'fas text-orange' : 'fa' }} fa-list"></i>List</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('enquiry.create') }}" class="nav-link {{ request()->routeIs('enquiry.create') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('enquiry.create') ? 'fas text-orange' : 'fa' }} fa-plus"></i>Add New</a>
            </li>
        </ul>
    </div>
</li>


<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('client.*') ? 'active' : '' }}" href="{{route('client.list')}}" role="button" aria-expanded="false" aria-controls="navbar-examples">
        <i class="ni ni-single-02  text-primary"></i>
        <span class="nav-link-text">Clients</span>
    </a>

</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('application.*') ? 'active' : '' }}" href="#application" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
        <i class="ni ni-mobile-button text-primary"></i>
        <span class="nav-link-text">Application</span>
    </a>
    <div class="collapse {{ request()->routeIs('application.*') ? 'show' : '' }}" id="application">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{ route('application.immigration.index') }}" class="nav-link {{ request()->routeIs('application.immigration.index') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('application.immigration.index') ? 'fas text-orange' : 'fa' }} fa-list"></i>Immigration</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('application.admission.index') }}" class="nav-link {{ request()->routeIs('application.admission.index') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('application.admission.index') ? 'fas text-orange' : 'fa' }} fa-graduation-cap"></i>Admission</a>
            </li>
        </ul>
    </div>
</li>


<li class="nav-item">
    <a class="nav-link" href="{{ route('communicationlog.index') }}">
        <i class="fa fa-comment text-primary"></i>
        <span class="nav-link-text">Communication Logs</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('finance.*') ? 'active' : '' }}" href="#" data-toggle='collapse' data-target="#finance">
        <i class="fa fa-wallet text-primary"></i>
        <span class="nav-link-text">Finance</span>
    </a>
    <div class="collapse {{ request()->routeIs('finance.*') ? 'show' : '' }}" id="finance">
        <ul class='nav nav-sm flex-column'>
            <li class='nav-item'>
                <a href="#" class="nav-link {{ request()->routeIs('finance.invoice.*') ? 'active' : '' }}" data-toggle="collapse" data-target='#invoices'>
                    <i class="{{ request()->routeIs('home') ? 'fas text-orange' : 'fa' }} fa-info"></i>Invoices
                </a>
                <div class="collapse {{ request()->routeIs('finance.invoice.*') || request()->routeIs('finance.bank.*') ? 'show' : '' }}" id="invoices">
                    <ul class='nav nav-sm flex-column'>
                        <li class='nav-item'>
                            <a href='{{route('finance.invoice.index')}}' class='nav-link'>
                                <i class="{{ request()->routeIs('finance.invoice.index') ? 'fas text-orange' : 'fa' }} fa-list"></i>List Invoices

                            </a>
                        </li>


                    </ul>
                </div>
            </li>
            <li class='nav-item'>
                <a href="#" class="nav-link {{ request()->routeIs('finance.receipt.*') ? 'active' : '' }}" data-toggle="collapse" data-target='#receipts'>
                    <i class="{{ request()->routeIs('companyinfo.edit') ? 'fas text-orange' : 'far' }} fa-envelope-open"></i>Receipts
                </a>
                <div class="collapse {{ request()->routeIs('finance.receipt.*') ? 'show' : '' }}" id="receipts">
                    <ul class='nav nav-sm flex-column'>
                        <li class='nav-item'>
                            <a href="{{route('finance.receipt.index')}}" class="nav-link {{ request()->routeIs('finance.receipt.index') ? 'active' : '' }}">
                                <i class="{{ request()->routeIs('finance.receipt.index') ? 'fas text-orange' : 'fa' }} fa-list"></i>List Receipts

                            </a>
                        </li>

                        <li class='nav-item'>
                            <a href="{{route('finance.receipt.create')}}" class="nav-link {{ request()->routeIs('finance.receipt.create') ? 'active' : '' }}">
                                <i class="{{ request()->routeIs('companyinfo.edit') ? 'fas text-orange' : 'fa' }} fa-plus"></i>Create Receipt

                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class='nav-item'>
                <a href="#" class="nav-link {{ request()->routeIs('finance.bank.*') ? 'active' : '' }}" data-toggle="collapse" data-target='#banks'>
                    <i class="{{ request()->routeIs('finance.bank.index') ? 'fas text-orange' : 'fa' }} fa-university"></i>Bank Detail
                </a>
                <div class="collapse {{ request()->routeIs('finance.bank.*') ? 'show' : '' }}" id="banks">
                    <ul class='nav nav-sm flex-column'>
                        <li class='nav-item'>
                            <a href="{{route('finance.bank.index')}}" class='nav-link'>
                                <i class="{{ request()->routeIs('finance.bank.index') ? 'fas text-orange' : 'fa' }} fa-list"></i>List Banks

                            </a>
                        </li>
                    </ul>
                </div>
            </li>


        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('employee.index') }}">
        <i class="fa fa-address-book text-primary"></i>
        <span class="nav-link-text">Employee</span>
    </a>
</li>


<li class="nav-item">
    <a class="nav-link" href="#" data-toggle="collapse" data-target="#company">
        <i class="fa fa-building text-primary"></i>
        <span class="nav-link-text">Company Details</span>
    </a>

    <div class="collapse {{ request()->routeIs('emailSenders.*')||request()->routeIs('template.*') || request()->routeIs('companyinfo.*') || request()->routeIs('companybranch.*') ||request()->routeIs('companydocument.*') ||request()->routeIs('servicefee.*')||request()->routeIs('advisor.*') ? 'show' : '' }}" id="company">
        <ul class="nav nav-sm flex-column">
            <li class="nav-item">
                <a href="{{ route('companyinfo.edit') }}" class="nav-link {{ request()->routeIs('companyinfo.edit') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('companyinfo.edit') ? 'fas text-orange' : 'far' }} fa-building"></i>Company Info</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('companybranch.index') }}" class="nav-link {{ request()->routeIs('companybranch.index') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('companybranch.index') ? 'fas text-orange' : 'fa' }} fa-briefcase"></i>Branch List</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('companydocument.index') }}" class="nav-link {{ request()->routeIs('companybranch.index') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('companydocument.index') ? 'fas text-orange' : 'far' }} fa-file"></i>Documents List</a>
            </li>

            <li class="nav-item">
                <a href="{{ route('advisor.index') }}" class="nav-link {{ request()->routeIs('advisor.index') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('advisor.index') ? 'fas text-orange' : 'fas' }} fa-user-tie"></i>Advisors List</a>
            </li>

            <li class="nav-item">
                <a href="{{ route('servicefee.index') }}" class="nav-link {{ request()->routeIs('servicefee.index') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('servicefee.index') ? 'fas text-orange' : 'fas' }} fa-comment-dollar"></i>Service Fees</a>
            </li>

            <li class="nav-item">
                <a href="{{ route('template.index') }}" class="nav-link {{ request()->routeIs('template.index') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('template.index') ? 'fas text-orange' : 'fas' }} fa-file"></i>Templates</a>
            </li>

            <li class="nav-item">
                <a href="{{ route('emailSenders.index') }}" class="nav-link {{ request()->routeIs('emailSenders.index') ? 'active' : '' }}">
                    <i class="{{ request()->routeIs('emailSenders.index') ? 'fas text-orange' : 'fas' }} fa-file"></i>Email Senders</a>
            </li>
        </ul>
    </div>
</li>


<li class="nav-item">
    <a class="nav-link" href="{{ route('partner.index') }}">
        <i class="fa fa-building text-primary"></i>
        <span class="nav-link-text">Partners</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ route('serviceprovider.index') }}">
        <i class="fa fa-building text-primary"></i>
        <span class="nav-link-text">Service Providers</span>
    </a>
</li>





