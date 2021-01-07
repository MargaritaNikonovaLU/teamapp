@extends('profile')
@section('database')

    <style>
        .wrapper{
            max-width: 500px;
        }
    </style>



    <link rel="stylesheet" href="{{ asset('/css/userprofile.css') }}">
    @foreach($user as $row)
        @if(auth()->user()->id == $row['id'])
            <h3 align="center">Profils</h3>
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
                                    <div class="col-sm-4 bg-c-lite-green user-profile">
                                        <div class="card-block text-center text-white">
                                            <div class="m-b-25"> <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image"> </div>

                                            <h6 class="f-w-600">Sveiki, {{$row['name']}}!</h6>
                                            @foreach($role as $roles)
                                                @if($row['user_id']===$roles['id'])
                                                    <p>Amats: {{$roles['name']}}</p> <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="card-block">
                                            <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Informācija</h6>
                                            <div class="row">
                                                <form method="POST" action="{{ route('user.editInfo', $row['id'])}}" >
                                                    @csrf
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">Vārds</p>
                                                    <input type="text" value="{{$row['name']}}" placeholder="{{$row['name']}}" name="name" maxlength="100" size="10">
                                                </div>
                                                    <div class="col-sm-6">
                                                        <p class="m-b-10 f-w-600">E-pasts</p>
                                                        <h6 class="text-muted f-w-400">{{$row['email']}}</h6>
                                                        <h7 class="text">Nevar mainīt epastu</h7>
                                                    </div>
                                                <div class="col-sm-6">
                                                    <p class="m-b-10 f-w-600">Kontakta numurs</p>
                                                    <input type="text" value="{{$row['number']}}" placeholder="{{$row['number']}}" name="number" maxlength="100" size="10">
                                                </div>
                                                    <div class="col-sm-6">
                                                        <p class="m-b-10 f-w-600">Adrese</p>
                                                        <input type="text" value="{{$row['address']}}" placeholder="{{$row['address']}}" name="address" maxlength="100" size="10">
                                                    </div>
                                                    <input type="submit" value="Saglabāt">
                                                </form>
                                            </div>
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

                            {{--                <div class="col-xl-4 col-md-6">--}}
                            {{--                  Te japadoma--}}
                            {{--                </div>--}}



                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection


