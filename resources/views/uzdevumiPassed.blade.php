@extends('profile')
@section('database')
    <!-- Modal -->
    <form class="task_form" method="POST" action="{{route('taskAdd')}}" novalidate>
        @csrf
        <div id="add_project" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header login-header">
                        <button type="button" class="close" data-dismiss="modal"></button>
                        <h4 class="modal-title">Pievienot jauno uzdevumu</h4>
                    </div>
                    <div class="modal-body">
                        <input type="text" placeholder="Uzdevuma nosaukums" name="title">
                        <form>
                            <select name="user_id">
                                <option value="1">Visi darbinieki</option>
                                <option value="2"></option>
                                <option value="3"></option>
                                <option value="4"></option>
                                <option value="5"></option>
                                <option value="6"></option>
                            </select>
                        </form>
                        <input type="date" placeholder="Izpildes termiņš" name="expiredDate">
                        <textarea type ="text" name="description" placeholder="Uzdevuma formulējums"></textarea>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="cancel" data-dismiss="modal">Aizvērt</button>
                        <button type="submit" class="add-project" >Saglabāt</button>

                    </div>
                </div>


            </div>
        </div>
    </form>
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
                        <th >Uzdevuma formulējums</th>
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
                        @if($row['status']===1)
                            <tr>
                                <td>{{$rowNumber}}</td>
                                <td>{{$row['title']}}</td>
                                <td style="width: 5px"> {{$row['description']}}</td>
                                <td> {{$row['expiredDate']}}</td>
                                @foreach($role as $roles)
                                    @if($roles['id']==$row['user_id'])
                                        <td>{{$roles['name']}} </td>
                                        @else HO
                                    @endif

                                @endforeach
                                @if(auth()->user()->is_admin == 0)
                                    <td>
                                        <form method="POST" class="activate_form" action="{{ route('task.approve', $row['id'])}}">
                                            @csrf
                                            @if($row['status'] ==0)
                                                <button type ="submit" class="btn btn-warning">
                                                    Izpildīts
                                                </button>
                                            @else <p style="color:green">Izpildīts</p>
                                            @endif
                                        </form>
                                    </td>
                                @endif
                                <td>
                                    @if(!empty($row['comment']))
                                        {{$row['comment']}}
                                    @else
                                        Nebija komentāru.
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <form method="POST" class="delete_form" action="{{ route('task.delete', $row['id'])}}">
                                            @csrf
                                            <input type="hidden" name="delete" value="IZDZĒST"/>
                                            <button type ="submit" class="btn btn-danger">
                                                Izdzēst
                                            </button>
                                        </form>
                                    </div>
                                </td>

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
