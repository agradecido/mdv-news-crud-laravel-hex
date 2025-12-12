<?php
// file: src/Infrastructure/Articles/EloquentArticleRepository.php

declare(strict_types=1);

namespace Src\Infrastructure\Articles;

use App\Models\Article as EloquentArticle;
use Src\Domain\Articles\Article;
use Src\Domain\Articles\ArticleRepository;
use \Src\Domain\Articles\Enums\ArticleStatus;

final class EloquentArticleRepository implements ArticleRepository
{
    public function save(Article $article): void
    {
        EloquentArticle::updateOrCreate(
            [
                'uuid' => $article->uuid()
            ],
            [
                'title' => $article->title(),
                'content' => $article->content(),
                'author' => $article->author(),
                'received_at' => $article->receivedAt(),
                'featured_image' => $article->featuredImage(),
                'published_at' => $article->publishedAt(),
                'status' => $article->status()->value,
            ]
        );
    }

    public function findByUuid(string $uuid): ?Article
    {
        $record = EloquentArticle::where('uuid', $uuid)->first();

        if ($record === null) {
            return null;
        }

        return new Article(
            $record->uuid,
            $record->title,
            $record->content,
            $record->author,
            new \DateTimeImmutable($record->received_at),
            $record->featured_image,
            $record->published_at ? new \DateTimeImmutable($record->published_at) : null,
            ArticleStatus::from($record->status)
        );
    }
}
