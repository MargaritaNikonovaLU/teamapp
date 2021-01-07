<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    //attēlo visus lietotājus, kuriem var nosūtīt ziņu, izņēmot pašu sevi (lai nevarētu pašam sev nosūtīt ziņu)
    public function selectUsers()
    {
        //pārbauda, lai būtu visi lietotāji, izņēmot sevi
        $users = User::where('id', '!=', Auth::id())->get();
        $message = Message::all()->toArray();
// šīs te ir nepieciešams, lai attēlot, cik daudz ir neizlasīto ziņu (tas tiek pārbaudīts 'chat.blade.php')
        return view('chat')->with('users',$users)->with('message',$message);

    }




    public function getMessage($user_id)
        // saņemt visus izvēlētajam lietotājam nosūtītos ziņojumus
    {
        $my_id = Auth::id();
                             // to ziņojumu saņemšana, kas ir no = Auth :: id () un uz = user_id VAI no = user_id un uz = Auth :: id ();
        $messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('from', $my_id)->where('to', $user_id);  //atsūtītas ziņas
        })->orWhere(function ($query) use ($user_id, $my_id) {
            $query->where('from', $user_id)->where('to', $my_id)->update(array('is_read' => 1));})->get();   //saņemtās ziņas
                     /*ja tomēr ir  no = user_id un uz = Auth :: id ()
                         (kas nozīmē, ka tas ir ziņas, kas saņēmtas no cita lietotāja, nevis no manis nosūtītas)
                        tad lauks 'is_read' šai ziņai mainās uz 1, kas tālāk nozīmēs, ka tā ir izlasīta*/

        return view('index')->with('messages', $messages);
        //atgriež lietotājam blakus logu, kur parādās visas ziņas (gan atsūtītas, gan saņemtās)
    }


    //sūtot ziņojumu, tas tiek saglabāta datu bāzē
    public function sendMessage(Request $request){

        $to = $request->receiver_id;   //receiver_id tiek ņemts tas lietotājs uz kuru mēs uzspiežam no saraksta
        $message=$request->message;  //tas ir teksts, kuru gribam nosūtīt

        $data = new Message([
            'from' => Auth::id(),
            'message' => $message,
            'to' => $to,
            'is_read' => 0,  //automātiski jaunā ziņa skaitās neizlasīta
        ]);
        $data->save();  //ziņa tiek saglabāta datu bāzē
    }
}
