<?php

namespace Tests\Unit\Application;

use PHPUnit\Framework\TestCase;
use Src\Application\Articles\CreateArticle; // El caso de uso que aún no existe
use Src\Domain\Articles\Article;
use Src\Domain\Articles\ArticleRepository;
use Src\Domain\Articles\Enums\ArticleStatus;

class CreateArticleTest extends TestCase
{
    public function test_it_creates_and_persists_an_article()
    {
        // 1. Arrange (Preparamos los dobles de prueba)
        // Mockeamos el repositorio porque no queremos ir a la DB real todavía
        $repository = $this->createMock(ArticleRepository::class);

        // Esperamos que el método save sea llamado una vez con una instancia de Article
        $repository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Article::class));

        // Instanciamos el Caso de Uso inyectando el repositorio
        $useCase = new CreateArticle($repository);

        // 2. Act (Ejecutamos)
        $response = $useCase->execute(
            title: 'Título del artículo',
            content: 'Contenido del artículo...',
            author: 'Juan Pérez',
            featured_image: null
        );

        // 3. Assert (Verificamos)
        // Aquí podríamos devolver el Artículo creado o un DTO, depende de tu preferencia.
        $this->assertInstanceOf(Article::class, $response);
        $this->assertEquals('Título del artículo', $response->title());
        $this->assertNull($response->featuredImage());
    }
}