<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Author;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_authors()
    {
        $response = $this->getJson('/api/authors');
        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_create_author()
    {
        $user = factory(User::class)->create();
        $token = auth('api')->login($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/authors', [
            'first_name' => 'Gabriel',
            'last_name' => 'Garcia Marquez'
        ]);

        $response->assertStatus(201)
                 ->assertJson(['first_name' => 'Gabriel']);
    }

    public function test_create_book_updates_author_count()
    {
        // Setup
        $user = factory(User::class)->create();
        $token = auth('api')->login($user);
        $author = Author::create(['first_name' => 'Test', 'last_name' => 'Author']);

        // Action
        $this->withHeaders(['Authorization' => 'Bearer ' . $token])
             ->postJson('/api/books', [
                 'title' => 'New Book',
                 'published_date' => '2023-01-01',
                 'author_id' => $author->id
             ]);

        // Assert (Assuming Queue is sync for test or manually processed)
        // En test Laravel suele usar sync driver por defecto
        $this->assertDatabaseHas('authors', [
            'id' => $author->id,
            'books_count' => 1
        ]);
    }
}
