<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function userProfileCart(){
        $user = User::all()->toArray();
        $role = Role::all()->toArray();
        return view('useProfile')->with('user',$user)->with('role',$role);
    }

    public function userProfileCart2(){
        $user = User::all()->toArray();
        $role = Role::all()->toArray();
        return view('editUserInfo')->with('user',$user)->with('role',$role);
    }

    public function userProfileById($id){

        $user = User::find($id);
        $role = Role::all()->toArray();
        $myID = Auth::user();
        if($myID=== $user) {    //ja auth lietotājs uzspiež uz save, viņam atvēras viņa profila lappaspuse
            return redirect('userprofile');
        }
        else {
            return view('darbiniekiProfiles', compact('user', 'id'))->with('role', $role);
        }

    }



    public function updateUserInfo(Request $request, $id)
    {
        $this->validate($request,[
            'name',
            'number',
            'address',
            ]);
        $user=User::find($id);
        $user->name=$request->get('name');
        $user->address=$request->get('address');
        $user->number=$request->get('number');
        $user->save();
        $user = User::all()->toArray();
        $role = Role::all()->toArray();
        return redirect(route('userprofile'))->with('message', 'Lietotāja dati atjaunoti.')->with('user',$user)->with('role',$role);
    }


}
