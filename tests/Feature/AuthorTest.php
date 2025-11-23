<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Author;

class AuthorTest extends TestCase
{
    // Esto reinicia la BD en memoria para cada test
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_authors()
    {
        $response = $this->getJson('/api/authors');
        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_create_author()
    {
        // 1. Crear usuario y autenticar
        $user = factory(User::class)->create();
        $token = auth('api')->login($user);

        // 2. Hacer petición POST
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/authors', [
            'first_name' => 'Gabriel',
            'last_name' => 'Garcia Marquez'
        ]);

        // 3. Verificar respuesta
        // Como usamos API Resources, la respuesta viene dentro de "data"
        $response->assertStatus(201)
                 ->assertJson([
                     'data' => [
                         'first_name' => 'Gabriel',
                         'last_name' => 'Garcia Marquez',
                         'full_name' => 'Gabriel Garcia Marquez' // Verificamos el campo calculado
                     ]
                 ]);
    }

    public function test_create_book_updates_author_count()
    {
        // 1. Setup
        $user = factory(User::class)->create();
        $token = auth('api')->login($user);
        $author = Author::create(['first_name' => 'Test', 'last_name' => 'Author']);

        // 2. Acción: Crear libro
        $this->withHeaders(['Authorization' => 'Bearer ' . $token])
             ->postJson('/api/books', [
                 'title' => 'New Book',
                 'description' => 'Test Description',
                 'published_date' => '2023-01-01',
                 'author_id' => $author->id
             ]);

        // 3. Verificar base de datos
        // Nota: En testing, Laravel usa el driver 'sync' para colas por defecto (ver phpunit.xml),
        // así que el Job se ejecuta inmediatamente sin necesitar worker.
        $this->assertDatabaseHas('authors', [
            'id' => $author->id,
            'books_count' => 1
        ]);
    }
}