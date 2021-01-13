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
                        <label>Atbildīgais:</label>
                        <select name="user_id">
                            <option value="1">Darbinieks</option>
                            <option value="2">Zāles pārzinis</option>
                            <option value="3">Šefpavārs</option>
                            <option value="4">Direktors</option>
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
                        border: 2px solid #008CBA;
                        position: absolute; right: 0;
                    }

                    .button2:hover {
                        background-color: #008CBA;
                        color: white;
                    }
                </style>
                <form method="get" action="{{route('task.passed')}}">
                    @csrf
                <button type="submit" class="button2" name="button2">Izpildītie uzdevumi</button>
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
                    @if(auth()->user()->is_admin == 0)
                    <th>Statuss</th>
                    @endif
                    <th>Komentārs direktoram</th>
                    @if(auth()->user()->is_admin == 0)
                        <th></th>
                        <th></th>
                    @endif
                </tr>
                <?php $rowNumber = 1 ?>
                @foreach($task as $row)
{{--                    lietotājam ir attēloti tikai viņam uzdotie uzdevumi--}}
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
                        @if((auth()->user()->is_admin == 0) OR ($row['user_id'] !== 1) )
                        <td>
                            <form method="POST" class="activate_form" action="{{ route('task.approve', $row['id'])}}">
                                @csrf
                                @if($row['status'] ==0)
                                <button type ="submit" class="btn btn-danger">
                                   Nav izpildīts
                                </button>
                                    @else <p style="color:green">IZPILDīTS</p>
                                @endif
                            </form>
                        </td>
                        @endif
                        <td>
                            @if(!empty($row['comment']))
                                {{$row['comment']}}
                            @else
                                <form method="POST" action="{{ route('task.addComment', $row['id'])}}" >
                                @csrf
                                <input type="text" placeholder="Maks.100 simboli" name="comment" maxlength="100" size="20">
                                <input type="submit" value="Saglabāt">
                            </form>
                           @endif
                        </td>
                            @if(auth()->user()->is_admin == 0)
                        <td>
                                <form method="POST" action="{{ route('editTask', $row['id'])}}">
                                    @csrf
                                    <button type ="submit" class="btn btn-warning">Mainīt</button>
                                </form>
                        </td>
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
                        Pašlaik nav neizpildīto uzdevumu.
                    @endif
                </div>
        </div>
    </div>
@endsection
