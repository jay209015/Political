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
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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
			<li {{$active == "register"? 'class="active"':''}}><a href="{{url('users/register', $parameters = array(), $secure = null);}}">Register</a></li>
            <li {{$active == "login"? 'class="active"':''}}><a href="{{url('users/login', $parameters = array(), $secure = null);}}">Login</a></li>
            @endif
            @if(Auth::check())
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li {{$active == "lookupvoter"? 'class="active"':''}}><a href="{{url('reports/lookup-voter', $parameters = array(), $secure = null);}}">List Information by Voter ID</a></li>
<!--                <li><a href="#">Generate Full Report</a></li>-->
                <li {{$active == "queryvoter"? 'class="active"':''}}><a href="{{url('reports/query', $parameters = array(), $secure = null);}}">Query Voters</a></li>
                <li {{$active == "uniquevotersincounties"? 'class="active"':''}}><a href="{{url('reports/unique-voters-per-county', $parameters = array(), $secure = null);}}">List Information by County Name</a></li>
<!--                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>-->
              </ul>
            </li>
            @endif
            <li {{$active == "calender"? 'class="active"':''}}><a href="{{url('calendar', $parameters = array(), $secure = null);}}">Calendar</a></li>
			<li {{$active == "about"? 'class="active"':''}}><a href="{{url('about', $parameters = array(), $secure = null);}}">About</a></li>
            <li {{$active == "contact"? 'class="active"':''}}><a href={{url('contact', $parameters = array(), $secure = null);}}>Contact</a></li>
            @if(Auth::check())
            <li><a href="{{url('users/logout', $parameters = array(), $secure = null)}}">Logout</a></li>
            @endif
            @if(Auth::check())
            <li><a href="{{url('users/profile', $parameters = array(), $secure = null)}}">Logged in as:{{Auth::user()->email}}</a></li>
            <li>
            <div class="form-group">
                <label  for="state">Select State</label>
                <select name="state" id="state">
                    <option value="Oklahoma" SELECTED>Oklahoma</option>
                    <option value="Texas" <?=''//(($option['id'] == $form['counties']['selected'])? 'SELECTED': '')?>>Texas</option>
                </select>
            </div>
            </li>
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
          <?php
          $queries = DB::getQueryLog();
          $total_queries = count($queries);
          $total_time = 0;
          foreach($queries as $query){
              $total_time += $query['time'];
          }
          ?>
        <p style="float:right" class="text-muted">
            {{$total_queries}} {{Str::plural('query', count($queries))}}
            generated in {{number_format($total_time/100, 2)}} {{Str::plural('second', count($queries))}}
        </p>
        <p class="text-muted">&copy;2014 PrintPlace.com, LLC, ALL RIGHTS RESERVED</p>
      </div>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
  @yield('assets_footer')
  </body>
</html>