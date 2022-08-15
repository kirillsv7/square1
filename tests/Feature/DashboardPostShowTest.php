<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardPostShowTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testPublishedOk()
    {
        $createdPost = Post::factory([
            'publication_date' => Carbon::now()->subMinutes(10)->seconds(0),
        ])->create();

        $this->actingAs($this->user)
             ->get(route('dashboard.post.show', $createdPost->id))
             ->assertOk()
             ->assertViewIs('front.post.show')
             ->assertViewHas('post', function (Post $post) use ($createdPost) {
                 return $post->id === $createdPost->id;
             })
             ->assertSeeText($createdPost->title)
             ->assertSeeText($createdPost->description);
    }

    public function testNotYetPublishedOwnOk()
    {
        $createdPost = Post::factory([
            'publication_date' => Carbon::now()->addMinutes(10)->seconds(0),
        ])->create();

        $this->actingAs($this->user)
             ->get(route('dashboard.post.show', $createdPost->id))
             ->assertOk()
             ->assertViewIs('front.post.show')
             ->assertViewHas('post', function (Post $post) use ($createdPost) {
                 return $post->id === $createdPost->id;
             })
             ->assertSeeText('This post is not yet visible.');
    }

    public function testAnotherAuthorsPostNotFound()
    {
        $user2 = User::factory()->create();

        $publishedPost = Post::factory([
            'user_id'          => $user2->id,
            'publication_date' => Carbon::now()->subMinutes(10)->seconds(0),
        ])->create();

        $notYetPublishedPost = Post::factory([
            'user_id'          => $user2->id,
            'publication_date' => Carbon::now()->addMinutes(10)->seconds(0),
        ])->create();

        $this->actingAs($this->user)
             ->get(route('dashboard.post.show', $publishedPost->id))
             ->assertNotFound();

        $this->actingAs($this->user)
             ->get(route('dashboard.post.show', $notYetPublishedPost->id))
             ->assertNotFound();
    }
}
