<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthFormRequest;
use App\Http\Requests\UsersFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    //AuthController satur visas funkcijas, kas nepieciešamas reģistrācijai un autentificēšanai sistēmā

    public function getSignup()
    {
        return view('registerlhj'); //attēlo reģistrācijas skatu
    }


    //funkcija saglabā lietotāja reģistrācijas datus, ja nav kļūdas
    public function postSignup(UsersFormRequest $request)
    {
        $user = new User([  //pārbauda visus laukus, lai tie būtu korekti ievadīti vai ievadīti vispār
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'vcode' => $request->input('vcode'), //speciāls lauks, kas pēc tam dod iespēju uzņēmuma direktoram atpazīt 'savējos' darbiniekus. Šo kodu direktors iedot pats.
            'name' => $request->input ('name'),
        ]);
        //lietotājs tiek saglabāts datu bāzē tabulā 'users' un tiek atgriezts uz ielogošanas skatu ar paziņojumu
        $user->save();
        return view('userhome')->with( 'msg','Reģistrācijas dati nosūtīti. Jums jāpagaidā apstiprinājums.'); //paziņojums
    //lietotājam tiek paziņots, ka viņam ir jāpagaida, kamēr direktors aktivēs lietotāju savā profilā.
    }


    //attēlo ielogošanas skatu
    public function getSignin()
    {
        return view('userhome'); //display signin page
    }

    //ielogo lietotāju sistēmā
    public function postSignin(AuthFormRequest $request)
    {
        //ja nav tāda lietotāja (ar ievadīto e-pastu un paroli), tad tā ir kļūda, un par to lietotājs tiek informēts
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return redirect()->back()->with('message', 'Lietotājs ar tādu epastu vai paroli nav reģistrēts.'); //paziņojums par kļūdu
        }

        //ja tāds lietotājs eksistē, tad tālāk pārbauda, vai viņš ir aktivēts (ar direktora palīdzību)
        if (Auth::attempt($request->only(['email', 'password']))) {
            $userStatus = Auth::User()->approvestatus;
            if ($userStatus == '0') {
                //ja lietotājs nav aktivēts, tad viņs tiek paziņots, ka ir jāpagaidā apstiprinājums
                return redirect()->back()->with('message', 'JĀGAIDA REĢISTRĀCIJAS APSTIPRINĀJUMU');
                //ja ir aktīvs, tad lietotāju pārvieto uz viņa 'profila' skatu
            } else return view('profile');
        }

    }


    //kad lietotājs iziet no sistēmas
    public function getLogout() {
        Auth::logout();
        return redirect()->route('auth.signin'); //atgriež viņu ielogošanas skatā

}}
