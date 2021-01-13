<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    //funkcija, kas pievieno jauno 'ziņu'
    public function addNews(Request $request)
    {
        $id=Auth::id();  // tas ir ziņas pievienotājs
        $task = new News([
            'news_name' => $request->input('news_name'),
            'news_title' => $request->input('news_title'),
            'news_content' => $request->input('news_content'),
            'user_id' => $id,
        ]);
        $task->save();
        return redirect()->back()->with('message', 'Ziņa tika veiksmīgi pievienota');
    }

    //atgriež lietotājam viss ziņas no datu bāzes priekš @foreach skatā 'Jaunumi'
    public function showNews()
    {
        $news = News::all()->toArray();
        $allNews = News::all();
        $allNewsTopic = $allNews->unique('news_name');
        return view('news')->with('news', $news)->with('allNewsTopic', $allNewsTopic);
    }

    //funkcija priekš ziņu attēlošanas pēc konkrētas tēmas
    public function showNewsByTopic($id)
    {
        $newName=News::find($id);
        $newName=$newName->news_name;
        $news = News::where('news_name', $newName)->get();
        $allNews = News::all();
        $allNewsTopic = $allNews->unique('news_name'); //te parādās 'unique', kas atgriež tikai unikālus (kuri neatkartojas) tēmas
        return view('news')->with('news', $news)->with('allNewsTopic', $allNewsTopic);
    }

    //izdzēš ziņu no saraksta
    public function deleteNews($id)
    {
        $news = News::find($id);
        $news->delete();
        return redirect()->route('news');
    }

}
