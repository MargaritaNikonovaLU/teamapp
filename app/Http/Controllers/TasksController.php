<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Tasks;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function taskAdd(Request $request)
    {
        $task = new Tasks([
            'description' => $request->input('description'),
            'expiredDate' => $request->input('expiredDate'),
            'title' => $request->input('title'),
            'user_id' => $request->input('user_id'),
        ]);
        $task->save();
        return redirect('uzdevumi')->with('message', 'Uzdevums tika veiksmīgi pievienots');


    }

    public function taskShow(){
        $task = Tasks::all()->toArray();
        $role = Role::all()->toArray();
        return view('uzdevumi')->with('task',$task)->with('role',$role);
    }

    public function taskStatus(Request $request, $id){

        $data = Tasks::find($id);

        if($data->status == 0) {
            $data->status=1;
            $data->save();
        }
        return redirect()->back()->with('message','Uzdevums ir izpildīts');


    }

    public function deleteTask($id)
    {

        $task = Tasks::findorfail($id);
        $task->delete();

        return redirect()->back()->with('message', 'Uzdevums tika izdzēst');

    }




    public function editTask($id)
    {
        $task = Tasks::find($id);
        return view('editTask', compact('task','id'));

    }

    public function updateTask(Request $request, $id)
    {
        $this->validate($request,[

            'expiredDate' ,
            'description',
            'title',
            'user_id'
        ]);
        $task=Tasks::find($id);
        $task->expiredDate =  $request->get('expiredDate');
        $task->description =  $request->get('description');
        $task->title =  $request->get('title');
        $task->user_id =  $request->get('user_id');
        $task->save();
        $task = Tasks::all()->toArray();
        $role = Role::all()->toArray();
        return view('uzdevumi')->with('message', 'Uzdevums veiksmīģi koriģēts')->with('task',$task)->with('role',$role);

    }


    public function taskAddComment(Request $request, $id)
    {
        $this->validate($request,[
            'comment']);
        $task=Tasks::find($id);
        $task->comment =  $request->get('comment');
        $task->save();
        $task = Tasks::all()->toArray();
        $role = Role::all()->toArray();
        return redirect()->back()->with('message', 'Komentārs tika veiksmīgi pievienots')->with('task',$task)->with('role',$role);
    }

    public function taskPassed()
    {
        $task = Tasks::all()->toArray();
        $role = Role::all()->toArray();
        return view('uzdevumiPassed')->with('task',$task)->with('role',$role);
    }



}
