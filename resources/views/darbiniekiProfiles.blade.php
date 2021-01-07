@extends('profile')
@section('database')

    <style>
        .wrapper{
            max-width: 500px;
        }
    </style>



    <link rel="stylesheet" href="{{ asset('/css/userprofile.css') }}">

            <h3 align="center">Darbinieka profils</h3>
            <div class="wrapper">

                @if (Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                @endif


                <br />


                <div class="page-content page-container" id="page-content">
                    <div class="padding">
                        <div class="row container d-flex justify-content-center">
                            <div class="col-xl-4 col-md-6">
                                <div class="card user-card-full">
                                    @if(auth()->user()->is_admin==1)
                                    <div class="col-sm-4 bg-c-lite-green user-profile">
                                        @else
                                            <div class="col-sm-4 bg-c-lite-blue user-profile">
                                            @endif
                                        <div class="card-block text-center text-white">
                                            <div class="m-b-25"> <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image"> </div>

                                            <h6 class="f-w-600">Sveiki, {{$user->name}}!</h6>
                                            @foreach($role as $roles)
                                                @if($user->user_id ===$roles['id'])
                                                    <p>Amats: {{$roles['name']}}</p> <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="card-block">
                                            <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Informācija</h6>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">Vārds</p>
                                                    <h6 class="text-muted f-w-400">{{$user->name}}</h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">E-pasts</p>
                                                    <h6 class="text-muted f-w-400">{{$user->email}}</h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">Kontakta numurs</p>
                                                    <h6 class="text-muted f-w-400">{{$user->number}}</h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">Adrese</p>
                                                    <h6 class="text-muted f-w-400">{{$user->address}}</h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">Reģistrācijas datums</p>
                                                    <h6 class="text-muted f-w-400">{{$user->created_at}}</h6>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">Statuss</p>
                                                    @if($user['approvestatus'] ==0)
                                                        <button  class="btn btn-danger">
                                                            Neaktīvs
                                                        </button>
                                                    @else
                                                        <button class="btn btn-success">
                                                            Aktīvs
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
{{--                                            <a href="{{route('edit.UserInfo')}}" class="btn btn-light" >Rediģēt informāciju</a>--}}
                                            {{--                                    <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Projects</h6>--}}
                                            {{--                                    <div class="row">--}}
                                            {{--                                        <div class="col-sm-6">--}}
                                            {{--                                            <p class="m-b-10 f-w-600">Pēdējo reizi </p>--}}
                                            {{--                                            <h6 class="text-muted f-w-400">Sam Disuja</h6>--}}
                                            {{--                                        </div>--}}
                                            {{--                                        <div class="col-sm-6">--}}
                                            {{--                                            <p class="m-b-10 f-w-600">Most Viewed</p>--}}
                                            {{--                                            <h6 class="text-muted f-w-400">Dinoter husainm</h6>--}}
                                            {{--                                        </div>--}}
                                            {{--                                    </div>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="col-xl-4 col-md-4">
                    <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Pēdējo reizi sistēmā</h6>
                    <div class="col-sm-6">
                        <h6 class="text-muted f-w-400">{{$user->rememberTime}}</h6>
                    </div>
                </div>



                        </div>
                    </div>
                </div>
            </div>

@endsection



