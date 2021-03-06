<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reģistrācija</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

<!-- pievienotie style priekš skata -->
<link rel="stylesheet" href="{{ asset('/css/signin.css') }}">

<body class="text-center">

<form class="form-signin" method="POST" action="{{route ('send.auth.signup')}}" novalidate>
    @csrf
    <img class="mb-4" src="{{asset('images/logo-removebg-preview.png')}}" alt="logo" width="150" height="120">
    <h1 class="h3 mb-3 font-weight-normal">Reģistrēšana</h1>
    <label for="inputName" class="sr-only">Vārds</label>
    <input type="text"  name="name" id="inputName" class="form-control  {{$errors->has('name') ? 'is-invalid' : ''}}  " placeholder="Vārds" value="{{ old('name') ? : ''}}">

    @if($errors->has('name'))
    <span class="help-block text-danger">
        {{$errors->first('name')}}
    </span>
    @endif

    <label for="inputEmail" class="sr-only">E-pasts</label>
    <input type="email"  name="email" id="inputEmail" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" placeholder="Epasta adrese" value="{{ old('email') ? : ''}}">

    @if($errors->has('email'))
        <span class="help-block text-danger">
        {{$errors->first('email')}}
    </span>
    @endif

    <label for="inputPassword" class="sr-only">Parole</label>
    <input type="password" name="password" id="inputPassword" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" placeholder="Parole" value="{{ old('password') ? : ''}}" >

    @if($errors->has('password'))
        <span class="help-block text-danger">
        {{$errors->first('password')}}
    </span>
    @endif

    <label for="inputCode" class="sr-only">Kods</label>
    <input type="text" name="vcode" id="inputNumber" class="form-control {{$errors->has('vcode') ? 'is-invalid' : ''}}" placeholder="Kods" value="{{ old('vcode') ? : '' }}">
    @if($errors->has('vcode'))
        <span class="help-block text-danger">
        {{$errors->first('vcode')}}
    </span>
    @endif
    <br>
    <button type="submit" name="button" class="btn btn-lg btn-primary btn-block" >Izveidot lietotāju</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
</form>
</body>
</html>

