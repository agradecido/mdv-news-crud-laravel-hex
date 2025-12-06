<?php
// file: tests/Unit/Domain/ArticleTest.php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use Src\Domain\Articles\Article;
use Src\Domain\Articles\Exceptions\ArticleContentRequiredException;
use Src\Domain\Articles\Enums\ArticleStatus;
use DateTimeImmutable;

class ArticleTest extends TestCase
{
    public function test_it_throws_exception_when_content_and_link_are_missing(): void
    {
        $content = null;
        $link = null;

        // 2. Expectativa: Aquí le decimos a PHPUnit que esté atento a un error específico.
        $this->expectException(ArticleContentRequiredException::class);

        // 3. Acción: Intentamos instanciar la clase (esto debería detonar la bomba 💣)
        new Article(
            title: 'Título de prueba',
            content: $content,
            source_link: $link,
            author: 'Autor de prueba',
            featured_image: 'https://example.com/image.jpg',
            received_at: new DateTimeImmutable(), // now.
            published_at: null,
            status: ArticleStatus::DRAFT,

        );
    }
}
