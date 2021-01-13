<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthFormRequest;
use App\Http\Requests\UsersFormRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
//AuthController satur visas funkcijas, kas nepieciešamas reģistrācijai un autentificēšanai sistēmā

class AuthController extends Controller
{
    public function getSignup()
    {
        return view('registerlhj'); //attēlo reģistrācijas skatu
    }


    //funkcija saglabā lietotāja reģistrācijas datus, ja nav kļūdas
    public function postSignup(UsersFormRequest $request)
    {
        $user = new User([  //pārbauda visus laukus, lai tie būtu korekti ievadīti vai ievadīti vispār
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),  //saglabā paroli šifrētā veidā
            'vcode' => $request->input('vcode'), //speciāls lauks, kas pēc tam dod iespēju uzņēmuma direktoram atpazīt 'savējos' darbiniekus. Šo kodu direktors iedot pats.
            'name' => $request->input ('name'),
        ]);
        //lietotājs tiek saglabāts datu bāzē tabulā 'users' un tiek atgriezts uz ielogošanas skatu ar paziņojumu
        $user->save();
        Session::flash('warning', 'Reģistrācijas dati nosūtīti. Jums jāpagaidā apstiprinājums.');
        return view('userhome'); //paziņojums
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
            Session::flash('message', 'Lietotājs ar tādu epastu vai paroli nav reģistrēts.');
            return view('userhome'); //paziņojums par kļūdu
        }

        //ja tāds lietotājs eksistē, tad tālāk pārbauda, vai viņš ir aktivēts (ar direktora palīdzību)
        else if (Auth::attempt($request->only(['email', 'password']))) {
            $userStatus = Auth::User()->approvestatus;
            if ($userStatus == '0') {
                //ja lietotājs nav aktivēts, tad viņs tiek paziņots, ka ir jāpagaidā apstiprinājums
                Session::flash('warning', 'JĀGAIDA REĢISTRĀCIJAS APSTIPRINĀJUMU');
                return view('userhome');
                //ja ir aktīvs, tad lietotāju pārvieto uz viņa 'profila' skatu
            } else return redirect()->route('userprofile');
        }

    }


    //kad lietotājs iziet no sistēmas, tiek saglabāta pēdējās vizītes laiks un datums ar iebūvētas Carbon funkcijas palīdzības
    public function getLogout() {

        $user = User::find(Auth::id());
        $user->rememberTime = Carbon::now();  //uzstāda laiku, lai pēc tam varētu zināt, kad lietotājs bija online pēdējo reizi
        $user->save();
        Auth::logout();
        return redirect()->route('auth.signin'); //atgriež ielogošanas skatā

}}
