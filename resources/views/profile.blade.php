<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Profils</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">



    <!------ Include the above in your HEAD tag ---------->

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('/css/dashboard.css') }}">




<body class="home">
<div class="container-fluid display-table">
    <div class="row display-table-row">
        <div class="col-md-2 col-sm-1 hidden-xs display-table-cell v-align box" id="navigation">
            <div class="logo">
               <img src="{{asset('images/logo-removebg-preview.png')}}" alt="logo" width="100" height="130"  class="hidden-xs hidden-sm">
            </div>
            <div class="navi">
                <ul>
                    <li><a href="{{route('userprofile')}}"><i class="fa fa-home" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Profils</span></a></li>
                    <li><a href="{{('/news')}}"><i class="fa fa-file-text-o" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Jaunumi</span></a></li>

                    @if(auth()->user()->is_admin == 0)
                    <li><a href="{{url('darbinieki')}}"><i class="fa fa-users"></i> <span class="hidden-xs hidden-sm">Darbinieki</span></a></li>
                    @endif
                    <li><a href="{{url('uzdevumi')}}"><i class="fa fa-tasks" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Uzdevumi</span></a></li>
                    <li><a href="{{route('file-upload')}}"><i class="fa fa-download" aria-hidden="true"></i><span class="hidden-xs hidden-sm">Dokumenti</span></a></li>
                <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </ul>
            </div>
        </div>
        <div class="col-md-10 col-sm-11 display-table-cell v-align">
            <div class="row">
                <header>
                    <div class="col-md-12">
                        <div class="header-rightside">
                            <ul class="list-inline header-top pull-right">

                                <li><a href="{{route('chat')}}"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                                        <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <div class="navbar-content">
                                                @auth
                                                    <span>{{ auth()->user()->name }}</span>
                                                <p class="text-muted small">{{ auth()->user()->email }}</p>
                                                @endauth

                                                <div class="divider">
                                                </div>
                                                    <a href="{{route('userprofile')}}" class="btn btn-light">Profils</a>
                                                    <a href="{{route('logout')}}" class="view btn-sm active">Iziet</a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </div>
                    </div>

                </header>
            </div>
            <div class="user-dashboard">
                @yield('database')
            </div>
            </div>
        </div>
    </div>

</body>
</html>
