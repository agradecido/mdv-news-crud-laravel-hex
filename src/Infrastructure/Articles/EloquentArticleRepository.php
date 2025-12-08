<?php
// file: src/Infrastructure/Articles/EloquentArticleRepository.php

namespace Src\Infrastructure\Articles;

use App\Models\Article as EloquentModel;
use Src\Domain\Articles\Article;
use Src\Domain\Articles\ArticleRepository;

final class EloquentArticleRepository implements ArticleRepository
{
    public function save(Article $article): void
    {
        // Usamos updateOrCreate para que sirva tanto para Crear como para Editar
        EloquentModel::updateOrCreate(
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
        $record = EloquentModel::where('uuid', $uuid)->first();

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
            \Src\Domain\Articles\Enums\ArticleStatus::from($record->status)
        );
    }
}
