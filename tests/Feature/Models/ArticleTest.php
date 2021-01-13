<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Article;
use App\User;


class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function count_first_user_articles()
    {
        // Add new user
        $user = factory(User::class)->create();
        $allUsers = User::all();
        $this->assertCount(1, $allUsers);

        $addArticles = factory(Article::class)->create(['user_id'=>$user->id]);
        $getArticles = Article::where('user_id', $user->id)->get();
        $this->assertEquals($addArticles->title, $getArticles->first()->title);

    }
}
