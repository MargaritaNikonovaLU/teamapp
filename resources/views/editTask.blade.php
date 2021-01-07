@extends('profile')
@section('database')
                <!-- Modal content-->
    <form class="task_form" method="POST" action="{{route('updateTask', $id)}}" novalidate>
                @csrf
                <div class="modal-content">
                    <div class="modal-header login-header">
                        <button type="button" class="close" data-dismiss="modal"></button>
                        <h4 class="modal-title">Mainīt uzdevuma datus</h4>
                    </div>
                    <div class="modal-body">
                        <input type="text" placeholder="{{$task->title}}" name="title" value="{{$task->title}}">
                        <form>
                            <label>Atbildīgais:</label>
                            <select name="user_id" placeholder="{{$task->user_id}}" value="{{$task->user_id}}">
                                <option value="1">Visi darbinieki</option>
                                <option value="2">Zāles pārzinis</option>
                                <option value="3">Šefpavārs</option>
                                <option value="4">Direktors</option>
                            </select>
                        </form>
                        <input type="date" placeholder="{{$task->expiredDate}}" name="expiredDate" value="{{$task->expiredDate}}">
                        <textarea type ="text" name="description" placeholder="{{$task->description}}" value="{{$task->description}}"></textarea>
                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="add-project" >Saglabāt</button>

                    </div>
                </div>



    </form>



@endsection
