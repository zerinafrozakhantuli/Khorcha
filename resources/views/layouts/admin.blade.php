<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel</title>
    <link rel="stylesheet" href="{{asset('contents/admin')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('contents/admin')}}/css/all.min.css">
    <link rel="stylesheet" href="{{asset('contents/admin')}}/css/datatables.min.css">
    <link rel="stylesheet" href="{{asset('contents/admin')}}/css/datepicker.css">
    <link rel="stylesheet" href="{{asset('contents/admin')}}/css/style.css">
  </head>
  <body>
    <header>
        <div class="container-fluid header_part no_print">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-7"></div>
                <div class="col-md-3 top_right_menu text-end">
                    <div class="dropdown">
                      <button class="btn dropdown-toggle top_right_btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <img src="{{asset('contents/admin')}}/images/avatar.png" class="img-fluid">
                          {{Auth::user()->name}}
                      </button>
                      <ul class="dropdown-menu">
<li><a class="dropdown-item" href="#"><i class="fas fa-user-tie"></i> My Profile</a></li>
<li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Manage Account</a></li>
<li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                      </ul>
                    </div>
                </div>
                <div class="clr"></div>
            </div>
        </div>  
    </header>
    <section>
        <div class="container-fluid content_part">
            <div class="row">
                <div class="col-md-2 sidebar_part no_print">
                    <div class="user_part">
                    <img  class="" src="{{asset('contents/admin')}}/images/avatar.png" alt="avatar"/>
                        <h5>{{Auth::user()->name}}</h5>
                        <p><i class="fas fa-circle"></i> Online</p>
                    </div>
                    <div class="menu">
                        <ul>
            <li><a href="{{url('dashboard')}}"><i class="fas fa-home"></i> Dashboard</a></li>
            @if(Auth::user()->role=='1')
            <li><a href="{{url('dashboard/user')}}"><i class="fas fa-user-circle"></i> Users</a></li>
            @endif
            <li><a href="{{url('dashboard/user')}}"><i class="fas fa-cogs"></i>Manage</a>
          <ul>
              <li><a href="#">Basic Information </a></li>
              <li><a href="#">Social Media </a></li>
              <li><a href="#"> Contact Information </a></li>
          </ul>
            </li>
            @if(Auth::user()->role<='2')
         <li><a href="{{url('dashboard/income')}}"><i class="fas fa-wallet"></i> Income </a>
         <ul>
              <li><a href="{{url('dashboard/income')}}">All Income </a></li>
              <li><a href="{{url('dashboard/income/add')}}">Add Income </a></li>
              <li><a href="{{url('dashboard/income/category')}}"> Income Category </a></li>
          </ul>
          </li>
            @endif
            @if(Auth::user()->role<='2')
        <li><a href="{{url('dashboard/expense')}}"><i class="fas fa-coins"></i> Expense</a>
           <ul>
              <li><a href="{{url('dashboard/expense')}}">All Expense </a></li>
              <li><a href="{{url('dashboard/expense/add')}}">Add Expense </a></li>
              <li><a href="{{url('dashboard/expense/category')}}"> Expense Category </a></li>
          </ul>
        </li>
        @endif
        <li><a href="{{url('dashboard/archive')}}"><i class="fas fa-box"></i>Archive </a></li>
        <li><a href="{{url('dashboard/reports')}}"><i class="fas fa-file-alt"></i> Reports</a></li>
        <li><a href="{{url('dashboard/recycle')}}"><i class="fas fa-trash"></i> Recycle Bin</a></li>
        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
          </ul>

<form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
@csrf
</form>
        </div>
                </div>
                <div class="col-md-10 content">
                    <div class="row">
                        <div class="col-md-12 breadcumb_part no_print">
                            <div class="bread">
                                <ul>
                                    <li><a href=""><i class="fas fa-home"></i>Home</a></li>
                                    <li><a href=""><i class="fas fa-angle-double-right"></i>Dashboard</a></li>                             
                                </ul>
                            </div>
                        </div>
                    </div>
                   @yield('content')
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="container-fluid footer_part no_print">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-10 copyright">
            <p>Copyright &copy; 2022 | All rights reserved by Dashboard | Development By <a href="#">Creative System Limited.</a></p>
                </div>
                <div class="clr"></div>
            </div>
        </div>
    </footer>
    <script src="{{asset('contents/admin')}}/js/jquery-3.6.0.min.js"></script>
    <script src="{{asset('contents/admin')}}/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('contents/admin')}}/js/datatables.min.js"></script>
    <script src="{{asset('contents/admin')}}/js/bootstrap-datepicker.js"></script>
    <script src="{{asset('contents/admin')}}/js/custom.js"></script>
  </body>
</html>