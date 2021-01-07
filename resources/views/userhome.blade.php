<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ielogošana</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper)
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
 -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>


<!-- Custom styles for this template -->

<link rel="stylesheet" href="{{ asset('/css/signin.css') }}">


<body class="text-center">
<div class="container">
<form class="form-signin" method="POST" action="{{route('auth.signin')}}" novalidate>
@csrf
    @if (Session::has('message'))
        <div class="alert alert-danger">{{ Session::get('message') }}</div>
    @endif
   <img class="mb-4" src="{{asset('images/logo-removebg-preview.png')}}" alt="logo" width="150" height="120">
    <h1 class="h3 mb-3 font-weight-normal">Ielogošana</h1>
    <label for="inputEmail" class="sr-only">E-pasts</label>
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address">

    @if($errors->has('email'))
        <span class="help-block text-danger">
        {{$errors->first('email')}}
    </span>
    @endif
    <label for="inputPassword" class="sr-only">Parole</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password">
    @if($errors->has('password'))
        <span class="help-block text-danger">
        {{$errors->first('password')}}
    </span>
    @endif
    <br>
    <button type="submit" name="button_1" class="btn btn-lg btn-primary btn-block" >Ielogoties</button>
</form>
<form class="form-signin" method="GET" action="{{route('auth.signup')}}" novalidate>
    <button type="submit" name="button" class="btn  btn-lg btn-primary btn-block" >Reģistrēties</button>
</form>
</div>
</body>
</html>

