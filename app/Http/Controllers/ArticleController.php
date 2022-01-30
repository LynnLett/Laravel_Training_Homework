<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    public function index(){
        $data= Article::latest()->paginate(5);
        return view('articles.index',['articles'=>$data]);
    }
    public function detail($id){
        $data= Article::find($id);
        return view('articles.detail',['article'=>$data]);
    }
    public function add(){
        $data = [
            [ "id" => 1, "name" => "News" ],
            [ "id" => 2, "name" => "Tech" ],
        ];
        return view('articles.add', ['categories' => $data]);
    }
    public function create(){
        $validator = validator(request()->all(), [
                    'title' => 'required',
                    'body' => 'required',
                    'category_id' => 'required',
                    ]);
            if($validator->fails()) {
            return back()->withErrors($validator);
            }

        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->save();
        return redirect('/articles')->with('info','Article Added');
    }
    public function delete($id){
        $article= Article::find($id);
        $article->delete();
        return redirect('/articles')->with('info','Article Deleted');
    }
    public function update($id){
        $article= Article::find($id);        
        $data = [
            [ "id" => 1, "name" => "News" ],
            [ "id" => 2, "name" => "Tech" ],
        ];
        return view('/articles/update',['article' => $article, 'categories'=>$data]);
    }
    public function recreate($id){
        $validator = validator(request()->all(), [
                    'title' => 'required',
                    'body' => 'required',
                    'category_id' => 'required',
                    ]);
            if($validator->fails()) {
            return back()->withErrors($validator);
            }
        $article= Article::find($id);
        Article::where('id',$id)->update(array(
            'title' => request()->title,
            'body' => request()->body,
            'category_id' => request()->category_id
        ));
        
        return redirect('/articles')->with('info','Article Updated');
    }

}
