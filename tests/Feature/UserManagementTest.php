<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_users_can_not_see_list_users()
    {
        $response = $this->getJson('/api/users');

        $response->assertStatus(401);
    }

    public function test_logged_in_users_can_see_list_users()
    {
        $users = User::factory()->count(5)->create();
        
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user*/
        $user = $users->first();

        $this->actingAs($user);

        $response = $this->getJson('/api/users');

        // $response->dump();

        $response
            ->assertStatus(200)
            ->assertJsonPath('total', 5);
    }

    public function test_guest_users_can_not_create_users()
    {
        $response = $this->postJson('/api/users', [
            'name' => 'User 1',
            'email' => 'user1@mail.com',
            'password' => '1234',
            'password_confirmation' => '1234'
        ]);

        $response->assertStatus(401);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_guest_users_can_not_see_one_user()
    {
        $users = User::factory()->count(2)->create();

        $response = $this->getJson("/api/users/{$users->last()->id}");

        $response->assertStatus(401);
    }

    public function test_logged_in_users_can_see_one_user()
    {
        $users = User::factory()->count(2)->create();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = $users->first();

        $this->actingAs($user);

        $response = $this->getJson("/api/users/{$users->last()->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => $users->last()->name,
                'email' => $users->last()->email,
                'created_at' => $users->last()->created_at,
            ]);
    }

    public function test_logged_in_users_can_create_users()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/users', [
            'name' => 'User 1',
            'email' => 'user1@mail.com',
            'password' => '1234',
            'password_confirmation' => '1234'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseHas('users', [
            'email' => 'user1@mail.com'
        ]);
    }

    public function test_guest_users_can_not_update_user()
    {
        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            "name" => "Updated name",
            "email" => "updated@mail.com"
        ]);

        $response->assertStatus(401);
        $this->assertDatabaseMissing('users', [
            "name" => "Updated name",
            "email" => "updated@mail.com"
        ]);
    }

    public function test_logged_in_users_can_update_user()
    {
        // $this->withExceptionHandling();

        $users = User::factory()->count(2)->create();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = $users->first();

        $this->actingAs($user);

        $response = $this->putJson("/api/users/{$users->last()->id}", [
            "name" => "Updated name",
            "email" => "updated@mail.com"
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            "name" => "Updated name",
            "email" => "updated@mail.com"
        ]);
    }

    public function test_guest_users_can_not_delete_users()
    {
        $users = User::factory()->count(2)->create();
        $response = $this->deleteJson("/api/users/{$users->last()->id}");

        $response->assertStatus(401);
        $this->assertDatabaseCount('users', 2);
    }

    public function test_logged_in_users_can_delete_users()
    {
        $users = User::factory()->count(2)->create();
        
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = $users->get(0);
        $userDeleted = $users->get(1);

        $this->actingAs($user);

        $response = $this->deleteJson("/api/users/{$userDeleted->id}");

        $response->assertStatus(204);

        $this->assertDatabaseCount('users', 2);
        $this->assertSoftDeleted('users', [
            'id' => $userDeleted->id
        ]);
    }
}
