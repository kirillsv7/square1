<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardPostIndexTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testIsAccesibleAndHasNotPosts()
    {
        $this->actingAs($this->user)
             ->get(route('dashboard.post.index'))
             ->assertOk()
             ->assertViewIs('dashboard.post.index')
             ->assertViewHas('posts', function (LengthAwarePaginator $posts) {
                 return $posts->count() == 0;
             })
             ->assertSeeText('Create your first post');
    }

    public function testIsAccesibleAndHasPosts()
    {
        Post::factory()->count(5)->create();

        $this->actingAs($this->user)
             ->get(route('dashboard.post.index'))
             ->assertViewHas('posts', function (LengthAwarePaginator $posts) {
                 return $posts->count() > 0;
             });
    }

    public function testUserSeesOnlyOwnPosts()
    {
        $user2 = User::factory()->create();

        Post::factory([
            'user_id' => $this->user->id,
        ])->count(5)->create();

        Post::factory([
            'user_id' => $user2->id,
        ])->count(5)->create();

        $this->actingAs($this->user)
             ->get(route('dashboard.post.index'))
             ->assertViewHas('posts', function (LengthAwarePaginator $posts) {
                 $postItems = $posts->items();

                 return collect($postItems)->every(function ($item) {
                     return $item->user_id == $this->user->id;
                 });
             });
    }
}
