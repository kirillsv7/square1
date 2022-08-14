<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostIndexTest extends TestCase
{
    use RefreshDatabase;

    public function testIsAccesibleAndHasNotPosts()
    {
        $this->get(route('post.index'))
             ->assertOk()
             ->assertViewIs('front.post.index')
             ->assertViewHas('posts', function (LengthAwarePaginator $posts) {
                 return $posts->count() == 0;
             })
             ->assertSeeText('Write your first post');
    }

    public function testIsAccesibleAndHasPosts()
    {
        User::factory()->create();

        Post::factory([
            'publication_date' => Carbon::now()->subMinutes(10)->seconds(0),
        ])->count(20)->create();

        $this->get(route('post.index'))
             ->assertViewHas('posts', function (LengthAwarePaginator $posts) {
                 return $posts->count() > 0;
             });
    }

    public function testPagination()
    {
        User::factory()->create();

        Post::factory([
            'publication_date' => Carbon::now()->subMinutes(10)->seconds(0),
        ])->count(20)->create();

        $this->get(route('post.index', ['page' => 2]))
             ->assertOk()
             ->assertViewIs('front.post.index')
             ->assertViewHas('posts', function (LengthAwarePaginator $posts) {
                 return $posts->count() > 0;
             });
    }

    public function testOrderNewestFirst()
    {
        User::factory()->create();

        Post::factory([
            'publication_date' => Carbon::now()->subMinutes(5)->seconds(0),
        ])->create();

        Post::factory([
            'publication_date' => Carbon::now()->subMinutes(10)->seconds(0),
        ])->create();

        $this->get(route('post.index'))
             ->assertViewHas('posts',
                 function (LengthAwarePaginator $posts) {
                     $postItems = $posts->items();

                     return $postItems[0]->publication_date->greaterThan($postItems[1]->publication_date);
                 });
    }

    public function testOrderOldestFirst()
    {
        User::factory()->create();

        Post::factory([
            'publication_date' => Carbon::now()->subMinutes(5)->seconds(0),
        ])->create();

        Post::factory([
            'publication_date' => Carbon::now()->subMinutes(10)->seconds(0),
        ])->create();

        $this->get(route('post.index', ['order' => 1]))
             ->assertViewHas('posts',
                 function (LengthAwarePaginator $posts) {
                     $postItems = $posts->items();

                     return $postItems[0]->publication_date->lessThan($postItems[1]->publication_date);
                 });
    }
}
