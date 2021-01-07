@extends('profile')
@section('database')
    <div class="row">
        <div class="col-md-12">
            <br />
            <h3 align="center">Darbinieki</h3>
            <br />

{{--            paziņojumi no funkcijām tiek attēloti skata augšējā daļā--}}
            @if (Session::has('message'))
                <div class="alert alert-danger">{{ Session::get('message') }}</div>
            @endif
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif


            <?php $rowNumber = 1 ?>
            <?php $userNotApproved = 0 ?>
            <table class="table table-hover">
                <tr>
                    <th>Nr.</th>
                <th>Vārds</th>
                <th>Verifikācijas kods</th>
                <th>Epasts</th>
                <th>Izdzēst lietotāju</th>
                    <th>Apstiprināšanas statuss</th>
                    <th>Darbinieka loma</th>
                </tr>
                @foreach($user as $row)
                    <tr>
                       <td>{{$rowNumber}}</td>
                        <td><a href="{{route('userProfileById', $row['id'])}}"> {{$row['name']}}</td>
                        <td> {{$row['vcode']}}</td>
                        <td> {{$row['email']}}</td>
                        <td>

                            <form method="POST" class="delete_form" action="{{ route('user.delete', $row['id'])}}">
                                @csrf
                                <input type="hidden" name="delete" value="IZDZĒST" />
                                <button type ="submit" class="btn btn-danger">
                                    IZDZĒST
                                </button>

                            </form>
                         </td>
                        <td>
                            <form method="POST" class="activate_form" action="{{ route('user.approve', $row['id'])}}">
                                @csrf
                                @if($row['approvestatus'] ==0)
                            <button type ="submit" class="btn btn-danger">
                                 Neaktīvs
                            </button>
                                @else
                                <button type ="submit" class="btn btn-success">
                                    Aktīvs
                                </button>
                                @endif
                            </form>
                        </td>

                        <td>
                                <form method="POST" action="{{ route('add.staffname', $row['id'])}}" >
                                    @csrf
                                    <select name="user_id">
                                        @foreach($role as $roles)
                                            @if($row['user_id']===$roles['id'])
                                                <option value="{{$roles['id']}}" selected disabled hidden>{{$roles['name']}}</option>
                                            @endif
                                        @endforeach
                                        <option value="1">Visi darbinieki</option>
                                        <option value="2">Zāles pārzinis</option>
                                        <option value="3">Šefpavārs</option>
                                        <option value="4">Direktors</option>
                                    </select>
                                    <button type ="submit" class="btn btn-warning">Saglabāt</button>
                                </form>
                        </td>

                    </tr>
                    <?php $rowNumber++ ?>
                    @if($row['approvestatus']==0)
                        <?php $userNotApproved++ ?>
                    @endif
                @endforeach
                <p>Nav aktivizēti: {{$userNotApproved}}  lietotāji</p>
                <p>Pavisam reģistrēti: {{$rowNumber-1}}  lietotāji</p>
            </table>

        </div>
    </div>

@endsection


