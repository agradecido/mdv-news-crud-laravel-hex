<?php

declare(strict_types=1);

namespace Src\Application\Articles;

use Src\Domain\Articles\Article;
use Src\Domain\Articles\ArticleRepository;

final class CreateArticle
{
    // We inject the interface, not the concrete implementation (Dependency Injection)
    public function __construct(private ArticleRepository $repository)
    {
    }

    public function execute(
        string $title,
        ?string $content,
        string $author,
        ?string $featured_image = null
    ): Article {

        $article = Article::create(
            $title,
            $content,
            $author,
            $featured_image
        );

        $this->repository->save($article);

        return $article;
    }
}