<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        if(request('length')) {
            return datatables()->of(Article::all())
                ->addColumn('action', 'article_action')
                ->addColumn('user_email', function (Article $article) {
                    return $article->user->email;
                })
                ->addIndexColumn()
                ->toJson();
        }
        return view('article');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArticleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ArticleRequest $request)
    {
        Article::updateOrCreate(
            ['id' => $request->id],
            ['title' => $request->title, 'body' => $request->body, 'user_id' => Auth()->user()->id]
        );
        return response()->json(['success'=>'Article '.$request->title.' saved successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Article $article)
    {
        return response()->json($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(['success'=>'Article '.$article->title.' deleted successfully.']);
    }
}
