<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DarbiniekiController extends Controller
{

    //'DabriniekiController' satur visas fukcijas, kas nepieciešamas priekš skata 'Darbinieki'


    //funkcija izdzēš lietotāju no datu bāzes (tikai administrators un direktors var to izdarīt)
    public function deleteUser($id)
    {
        //ja administrators centās izdzēst pats sevi, viņam padod ziņu, ka to izdarīt nevar
        if (Auth::user()->id == $id) {
            return redirect()->back()->with('message', 'Nevar izdzēst sevi.');
        }
        $user = User::find($id);
        $user->delete();
        return redirect(route('darbinieki'))->with('success', 'Lietotājs veiksmīgi izdzēsts.');
    }

    //funkcija maina lietotaja statusu (Aktīvs vai Neaktīvs).
    //Tikai ja lietotājs ir Aktīvs, viņs var ielogoties sistēmā
    public function userStatus($id){

        $data = User::find($id);
        //ja administrators  cenšas aktivēt vai diaktivēt sevi, viņam padod ziņu, ka to darīt nedrīkst
        if ($data->is_admin === 0) {
            return redirect()->back()->with('message', 'Nevar deaktivēt sevi.');
        }

        //Kad uzspiež uz pogas: ja izvēlētā lietotaja status ir 0 (neaktīvs), tad mainās uz aktīvs un otrādi
        if($data->approvestatus == 0) {
            $data->approvestatus=1;
            $data->save();
            return redirect()->back()->with('success',   'Lietotājs aktivizēts.');
        }
        else {
            $data->approvestatus=0;
            $data->save();
            return redirect()->back()->with('message',   'Lietotājs ir deaktivizēts.');
        }
    }


    //funkcija paredz lietotāja amata (uzņēmuma amata) maiņu un attēlošanu sistēmā
    public function userAdd_user_id(Request $request, $id)
    {
        $this->validate($request,[
            'user_id']);
        $user = User::find($id);
        $userRole=$user->user_id;
        if ($userRole!==$request->user_id){    //ja izvēlās to pašu lomu lietotājam, ta īstenībā nekas nemainās.
            $user->user_id=$request->get('user_id');
        }
        else $user->user_id = $userRole;
        $user->save();
        $user = User::all()->toArray();
        //roles ir konkrēti 4 amata veidi
        $role = Role::all()->toArray();
        return redirect()->back()->with('user', $user)->with('role', $role);
    }


    public function userIndex(){

        $user = User::all()->toArray();
        $role = Role::all()->toArray();
        return view('darbinieki')->with('user', $user)->with('role', $role);
    }
}
