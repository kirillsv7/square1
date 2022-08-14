<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostShowTest extends TestCase
{
    use RefreshDatabase;

    public function testPublishedOk()
    {
        User::factory()->create();

        $createdPost = Post::factory([
            'publication_date' => Carbon::now()->subMinutes(10)->seconds(0),
        ])->create();

        $this->get(route('post.show', $createdPost->id))
             ->assertOk()
             ->assertViewIs('front.post.show')
             ->assertViewHas('post', function (Post $post) use ($createdPost) {
                 return $post->id === $createdPost->id;
             });
    }

    public function testNotYetPublishedReturnsNotFound()
    {
        User::factory()->create();

        $createdPost = Post::factory([
            'publication_date' => Carbon::now()->addMinutes(10)->seconds(0),
        ])->create();

        $this->get(route('post.show', $createdPost->id))
             ->assertNotFound();
    }

    public function testNotFound()
    {
        $this->get(route('post.show', 1))
             ->assertNotFound();
    }
}
