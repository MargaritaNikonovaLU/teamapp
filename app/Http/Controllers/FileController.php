<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FileController extends Controller
{
//FileController satur visas funkcijas, kas nepieciešamas priekš loga "Dokumenti" attēlošanai (darbs ar failiem)

/*Funkcija createForm atrod datubāzē tabulā 'files' visus ierakstus un parāda to lietotājam*/
    public function createForm(){
        $file = File::all()->toArray();
        return view('file-upload')
            ->with('file', $file);
    }

/*kad administrator uzspiež uz pogas "Pievienot dokumentu" funkcija pārbauda
ievadītos datus un saglabā to datu bāzē, ja nav kļūdu*/
    public function fileUpload(Request $req){
        $req->validate([
            'file'=>'required',
            'description',
            'name',
            'user_id'
        ]);

        $fileModel = new File;

        if($req->file()) {
            $fileName = $req->file->getClientOriginalName();  //ar iebūvēto funkciju paņēm faila oriģinālo nosaukumu, kad ir pirms ielādes
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public'); //saglabā to speciālaja vietā 'uploads/public' mapē
            $fileModel->file_path = '/storage/' . $filePath; //pievieno to nosaukumu laukā 'file_path'
            $fileModel->user_id = Auth::id(); //'user_id' nepieciešams, lai saglabāt datus par dokumenta pievienotāju (pievienot varēs 3 cilvēki uzņēmumā/direktoram tas ir jāzina)
            $fileModel->name = $req->get('name'); //lietotājs var pievienot failam nosaukumu
            $fileModel->description = $req->get('description'); //un pamatojumu
            $fileModel->subject = $req->get('subject'); // šīs lauks nepieciešams priekš tēmas izvēles.

            $fileModel->save();    // informācija tiek saglabāta datu bāzē un lietotāju atgriež atpakaļ 'Dokuemntu' skatā ar ierakstiem no datu bāzes
            $file = File::all()->toArray();
            return back()
                ->with('success','Dokuments veiksmīgi lejupielādēts.') // attēlojās, ja dokuments tika veiksmīgi pievienots datu bāzē
                ->with('file', $file);

        }
        else redirect()->back()->with('message','Neizdevās pievienot.');  //ja neizdevās pievienot failu
    }

//funkcija izsaucās, kad lietotājs uzspiež uz pogas 'Izdzēst'
    public function deleteFile($id)
    {
        $file = File::find($id);
        $file->delete();
            return redirect()->back()->with('success', 'Fails veiksmīgi izdzēsts.'); //paziņojums, ja dokuments tika izdzēsts

    }




}
