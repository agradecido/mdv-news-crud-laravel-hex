<?php
// file: tests/Feature/ArticleControllerTest.php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;  // Hay que limpiar la DB después de cada test.

    #[Test]
    public function it_validates_required_fields_when_creating_an_article(): void
    {
        // 1. Fase: Intentar enviar datos vacíos a la ruta
        $response = $this->postJson('/api/articles', []);

        // 2. Fase: Asegurar (Assert) que falla con un 422
        $response->assertStatus(422);

        // 3. Verificamos que los errores sean de los campos que nos interesan
        $response->assertJsonValidationErrors(['title', 'content']);
    }

    #[Test]
    public function it_validates_creating_an_article(): void
    {
        $response = $this->postJson('/api/articles', [
            'title' => 'Título del artículo',
            'content' => 'Contenido Lorem impsum del artículo',
            'author' => 'Autor de prueba',
            'featured_image' => null
        ]);

        $response->assertStatus(201);
    }
}
