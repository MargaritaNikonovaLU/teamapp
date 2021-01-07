<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{


    public function addNews(Request $request)
    {
        $id=Auth::id();
        $task = new News([
            'news_name' => $request->input('news_name'),
            'news_title' => $request->input('news_title'),
            'news_content' => $request->input('news_content'),
            'user_id' => $id,
        ]);
        $task->save();
        return redirect()->back()->with('message', 'Ziņa tika veiksmīgi pievienota');
    }

    public function showNews()
    {
        $news = News::all()->toArray();
        $allNews = News::all();
        $allNewsTopic = $allNews->unique('news_name');
        return view('news')->with('news', $news)->with('allNewsTopic', $allNewsTopic);
    }

    public function showNewsByTopic($id)
    {
        $newName=News::find($id);
        $newName=$newName->news_name;
        $news = News::where('news_name', $newName)->get();
        $allNews = News::all();
        $allNewsTopic = $allNews->unique('news_name');
        return view('news')->with('news', $news)->with('allNewsTopic', $allNewsTopic);
    }

}
