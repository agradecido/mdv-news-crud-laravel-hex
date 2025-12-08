<?php
// file: src/Domain/Articles/Article.php

declare(strict_types=1);

namespace Src\Domain\Articles;

use DateTimeImmutable;
use Src\Domain\Articles\Enums\ArticleStatus;

final class Article
{
    public function __construct(
        private string $uuid,
        private string $title,
        private ?string $content,
        private string $author,
        private ?string $featured_image,
        private DateTimeImmutable $received_at,
        private ?DateTimeImmutable $published_at,
        private ArticleStatus $status,
    ) {
    }

    // Named constructor
    public static function create(
        string $uuid,
        string $title,
        ?string $content,
        string $author,
        ?string $featured_image = null
    ): self {
        return new self(
            $uuid,
            $title,
            $content,
            $author,
            $featured_image,
            new DateTimeImmutable(),
            null,
            ArticleStatus::DRAFT
        );
    }

    // Getters públicos para exponer el estado de la entidad de forma controlada
    // Nota: Usamos nombres fluidos sin prefijo 'get' (estilo DDD moderno)

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): ?string
    {
        return $this->content;
    }

    public function author(): string
    {
        return $this->author;
    }

    public function featuredImage(): ?string
    {
        return $this->featured_image;
    }

    public function receivedAt(): DateTimeImmutable
    {
        return $this->received_at;
    }

    public function publishedAt(): ?DateTimeImmutable
    {
        return $this->published_at;
    }

    public function status(): ArticleStatus
    {
        return $this->status;
    }
}
