<!-- Topnav -->
<nav class="navbar navbar-top navbar-expand navbar-dark bg-wlis border-bottom">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Search form -->
      <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
        <div class="form-group mb-0">
          <div class="input-group input-group-alternative input-group-merge">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input class="form-control" placeholder="Search" type="text">
          </div>
        </div>
        <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </form>
      <!-- Navbar links -->
      <ul class="navbar-nav align-items-center  ml-md-auto ">
        <li class="nav-item d-xl-none">
          <!-- Sidenav toggler -->
          <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </li>
        <li class="nav-item d-sm-none">
          <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
            <i class="ni ni-zoom-split-in"></i>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ni ni-bell-55"></i>
            <span class="badge badge-light">{{auth()->user()->unreadNotifications->count()}}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
            <!-- Dropdown header -->
            <div class="px-3 py-3">
              <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">{{auth()->user()->unreadNotifications->count()}}</strong> unread notifications.<a href="{{route('notification.index')}}" class="ml-4 text-center text-primary font-weight-bold py-3 text-underline">View all</a></h6>
            </div>
            <!-- List group -->
            <div class="list-group list-group-flush" style='height: 400px;
    overflow-y: scroll;'>
              @foreach(auth()->user()->unreadNotifications->slice(0,6) as $notification)
              <div class='list-group-item  {{$notification->read_at??'unread'}}'>
              <a href="{{route('notification.show',$notification->id)}}" class=" list-group-item-action">
                <div class="row align-items-center">

                  <div class="col ml-2">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h4 class="mb-0 text-sm">{{$notification->data['title']}}</h4>
                      </div>
                      <div class="text-right text-muted">
                        <small>.</small>
                      </div>
					<div>
<div>


</div>
					</div>
                    </div>
                    <p class="text-sm mb-0">{{$notification->data['message']}} </p>

                  </div>
                  </div>


              </a>
              <button onclick="window.location.href='{{route('delete.notification',$notification->id)}}';" class="float-right btn btn-warning btn-sm"><i class="fa fa-trash"></i></button>
              </div>
              @endforeach

            <!-- View all -->
            <a href="{{route('notification.index')}}" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a>
          </div>
        </li>

      </ul>
      <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
        <li class="nav-item dropdown">
          <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <link rel="icon" type="image/png" href="{{ asset('assets/img/brand/favicon.png') }}">
              </span>
              <div class="media-body  ml-2  d-none d-lg-block">
                <span class="mb-0 text-sm  font-weight-bold">Admin</span>
              </div>
            </div>
          </a>
          <div class="dropdown-menu  dropdown-menu-right ">
            <div class="dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome!</h6>
            </div>
            <a href="#!" class="dropdown-item">
              <i class="ni ni-single-02"></i>
              <span>My profile</span>
            </a>
            <!--
            <a href="#!" class="dropdown-item">
              <i class="ni ni-settings-gear-65"></i>
              <span>Settings</span>
            </a> -->
            <div class="dropdown-divider"></div>


            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
  .unread{
    background-color: #0000001a;
  }
</style>
