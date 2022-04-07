<?php

namespace Tests\Feature\Posts;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GetListPostTest extends TestCase
{
    /** @test */
    public function user_can_get_list_posts(){
        
        $postCount = Post::count();

        $resopnse = $this->getJson(route('posts.index'));
        $resopnse->assertStatus(Response::HTTP_OK);
     
        $resopnse->assertJson(fn (AssertableJson $json)=>
            $json->has('data',fn (AssertableJson $json)=>
                $json->has('data')
                ->has('meta', fn (AssertableJson $json)=>
                    $json->where('total', $postCount)
                    ->etc()
                )
                ->has('links')
            )
            ->has('message')
        );
    }
}
