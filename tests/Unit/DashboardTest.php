<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{

    use RefreshDatabase;

    public function test_that_dashboard_is_inaccessible_to_unauthorized_users(): void
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_post_deletion()
    {
        $user = User::find(1);
        $post = Post::factory()->create();
        $this->actingAs($user);
        $response = $this->delete(route('delete', $post->id));
        $response->assertStatus(200);
        $this->assertSoftDeleted('posts', ['id' => $post->id]);
        $this->assertEquals($user->id, $post->refresh()->deleted_by);
    }

    public function test_that_dashboard_returns_posts()
    {
        $user = User::find(1);
        Post::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $this->assertGreaterThan(0, Post::count());
    }
}
