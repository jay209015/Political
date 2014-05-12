<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">

    <title>Political Report - An Election report generation tool.</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('css/sticky-footer-navbar.css')}}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('assets')
  </head>

  <body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{url('/', $parameters = array(), $secure = null);}}">Political Report</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <!-- <li class="active"><a href="{{url('/', $parameters = array(), $secure = null);}}">Home</a></li> -->
            @if(Auth::check())
            @else
			<li {{$active == "register"? 'class="active"':''}}><a href="{{url('register', $parameters = array(), $secure = null);}}">Register</a></li>
            <li {{$active == "login"? 'class="active"':''}}><a href="{{url('login', $parameters = array(), $secure = null);}}">Login</a></li>
            @endif
            @if(Auth::check())
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li {{$active == "lookupvoter"? 'class="active"':''}}><a href="{{url('lookupvoter', $parameters = array(), $secure = null);}}">Get information by Voter ID</a></li>
                <li><a href="#">Generate Full Report</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
            @endif
			<li {{$active == "about"? 'class="active"':''}}><a href="{{url('about', $parameters = array(), $secure = null);}}">About</a></li>
            <li {{$active == "contact"? 'class="active"':''}}><a href={{url('contact', $parameters = array(), $secure = null);}}>Contact</a></li>
            @if(Auth::check())
            <li><a href="{{url('logout', $parameters = array(), $secure = null);}}">Logout</a></li>
            @endif
            @if(Auth::check())
            <li><a href="#">Logged in as: {{Auth::user()->email}}</a></li>
            @endif
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        @yield('header')
      </div>
      @if(Session::has('message'))
      <div class="alert alert-success">
          {{Session::get('message')}}
      </div>
      @endif
      @if(Session::has('error'))
      <div class="alert alert-warning">
          {{Session::get('error')}}
      </div>
      @endif
      @yield('content')
    </div>

    <div id="footer">
      <div class="container">
        <p class="text-muted">&copy;2014 PrintPlace.com, LLC, ALL RIGHTS RESERVED</p>
      </div>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
  </body>
</html>