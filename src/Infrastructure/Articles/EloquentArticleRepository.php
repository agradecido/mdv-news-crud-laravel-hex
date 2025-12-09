<?php
// file: src/Infrastructure/Articles/EloquentArticleRepository.php

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
            ['uuid' => $article->uuid()],
            [
                'title' => $article->title(),
                'content' => $article->content(),
                'author' => $article->author(),
                'featured_image' => $article->featuredImage(),
                'received_at' => $article->receivedAt(),
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
            $record->featured_image,
            new \DateTimeImmutable($record->received_at),
            $record->published_at ? new \DateTimeImmutable($record->published_at) : null,
            ArticleStatus::from($record->status)
        );
    }
}
