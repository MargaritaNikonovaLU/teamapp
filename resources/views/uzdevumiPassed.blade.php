@extends('profile')
@section('database')

    <div class="row">
        <div class="col-md-12">
            @if (Session::has('message'))
                <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
            <br />
            <h3 align="center">Uzdevumi</h3>
            <style>
                .button2 {
                    background-color: white;
                    color: black;
                    border: 2px solid orangered;
                    position: absolute; right: 0;
                }
                .button2:hover {
                    background-color: crimson;
                    color: white;
                }</style>
            <form method="get" action="{{route('taskAdd')}}">
                @csrf
                <button type="submit" class="button2" name="button2">Neizpildītie uzdevumi</button>
            </form>
            {{--            Poga priekš uzdevumu pievienošanas--}}
            @if(auth()->user()->is_admin == 0)
                <li class="hidden-xs"><a href="#" class="add-project" data-toggle="modal" data-target="#add_project">Pievienot uzdevumus</a></li>
            @endif
            <br>
            <div class="task_table">
                <table class="table table-hover">
                    <tr>
                        <th>Nr. </th>
                        <th>Nosaukums</th>
                        <th>Uzdevuma formulējums</th>
                        <th>Izpildes termiņš</th>
                        <th>Atbildīgais</th>
                        <th>Statuss</th>
                        <th>Komentārs direktoram</th>
                        @if(auth()->user()->is_admin == 0)
                            <th>Veikt izmaiņas</th>
                        @endif
                    </tr>
                    <?php $rowNumber = 1 ?>
                    @foreach($task as $row)
                        @if( ($row['status'] === 0) AND ((auth()->user()->user_id == $row['user_id']) OR (auth()->user()->is_admin == 0)))
                            <tr>
                                <td>{{$rowNumber}}</td>
                                <td>{{$row['title']}}</td>
                                <td style="width: 5px"> {{$row['description']}}</td>
                                <td> {{$row['expiredDate']}}</td>
                                <td>
                                    @foreach($role as $roles)
                                        @if($row['user_id']===$roles['id'])
                                            {{$roles['name']}}
                                        @endif
                                    @endforeach
                                </td>
                                    <td>
                                            <p style="color:green">Izpildīts</p>
                                    </td>
                                <td>
                                    @if(!empty($row['comment']))
                                        {{$row['comment']}}
                                    @else
                                        Nav komentāru.
                                    @endif
                                </td>
                                @if(auth()->user()->is_admin == 0)
                                <td>
                                    <form method="POST" action="{{ route('task.delete', $row['id'])}}">
                                        @csrf
                                        <button type ="submit"  class="btn btn-danger">Izdzēst</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            <?php $rowNumber++ ?>
                        @endif
                    @endforeach
                </table>
                @if($rowNumber==1)
                    Pašlaik nav izpildīto uzdevumu.
                @endif
            </div>
        </div>
    </div>
@endsection
