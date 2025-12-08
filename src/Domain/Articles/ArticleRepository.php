<?php
// file: src/Domain/Articles/ArticleRepository.php

declare(strict_types=1);

namespace Src\Domain\Articles;

interface ArticleRepository
{
    public function save(Article $article): void;

    public function findByUuid(string $uuid): ?Article;
    
}