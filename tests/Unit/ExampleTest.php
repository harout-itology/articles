<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Article;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $order= [];

        $article = new Article;
        $article->title = "Title";
        $article->body = "body";
        $article->user_id = 4;
        $order[] = $article;

        $article2 = new Article;
        $article2->title = "Title2";
        $article2->body = "body2";
        $article2->user_id = 4;
        $order[] = $article2;



        $this->assertEquals('Title', $article->title);
        $this->assertCount(2,$order);
    }
}
