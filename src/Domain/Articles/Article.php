<?php

declare(strict_types=1);

namespace Src\Domain\Articles;

use DateTimeImmutable;
use Src\Domain\Articles\Enums\ArticleStatus;
use Src\Domain\Articles\Exceptions\ArticleContentRequiredException;

final class Article
{
    public function __construct(
        private string $title,
        private ?string $content,
        private ?string $source_link,
        private string $author,
        private string $featured_image,
        private DateTimeImmutable $received_at,
        private ?DateTimeImmutable $published_at,
        private ArticleStatus $status,
    ) {
        if (is_null($content) && is_null($source_link)) {
            throw new ArticleContentRequiredException();
        }
    }
}
