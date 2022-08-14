<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardPostCreateTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testUserCreatePostValidationNotOkRedirectBackWithErrors()
    {
        $this->actingAs($this->user)
             ->from(route('dashboard.post.create'))
             ->post(route('dashboard.post.store'), [
                 'user_id'          => $this->user->id,
                 'title'            => '',
                 'description'      => '',
                 'publication_date' => now()->format('Y-m-d'),
             ])
             ->assertRedirect(route('dashboard.post.create'))
             ->assertInvalid(['title', 'description', 'publication_date']);
    }

    public function testUserCreatePostValidationOkRedirectToIndex()
    {
        $post = [
            'user_id'          => $this->user->id,
            'title'            => 'Test title',
            'description'      => 'Test description',
            'publication_date' => now()->format('Y-m-d\TH:i'),
        ];

        $this->actingAs($this->user)
             ->from(route('dashboard.post.create'))
             ->post(route('dashboard.post.store'), $post)
             ->assertRedirect(route('dashboard.post.index'));

        $this->assertDatabaseHas('posts', $post);
    }
}
