<?php
// file: tests/Unit/Domain/ArticleTest.php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use Src\Domain\Articles\Article;
use Src\Domain\Articles\Enums\ArticleStatus;
use DateTimeImmutable;

class ArticleTest extends TestCase
{
    public function test_it_creates_article_with_content(): void
    {
        // Arrange: Preparamos los datos del artículo
        $uuid = 'test-uuid-1234';
        $title = 'Mi primer artículo sobre DDD';
        $content = 'Este es el contenido completo del artículo sobre Domain-Driven Design.';
        $author = 'Juan Pérez';
        $featuredImage = 'https://example.com/ddd-article.jpg';
        $receivedAt = new DateTimeImmutable('2025-12-06 10:00:00');
        $status = ArticleStatus::DRAFT;

        // Act: Creamos el artículo
        $article = new Article(
            uuid: $uuid,
            title: $title,
            content: $content,
            author: $author,
            featured_image: $featuredImage,
            received_at: $receivedAt,
            published_at: null,
            status: $status,
        );

        // Assert: Verificamos que todos los getters devuelven los valores correctos
        $this->assertSame($title, $article->title());
        $this->assertSame($content, $article->content());
        $this->assertSame($author, $article->author());
        $this->assertSame($featuredImage, $article->featuredImage());
        $this->assertSame($receivedAt, $article->receivedAt());
        $this->assertNull($article->publishedAt());
        $this->assertSame($status, $article->status());
    }
}
