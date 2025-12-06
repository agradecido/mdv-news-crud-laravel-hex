<?php
// file: src/Domain/Articles/Enums/Exceptions/ArticleContentRequiredException.php

declare(strict_types=1);

namespace Src\Domain\Articles\Exceptions;

use DomainException;

final class ArticleContentRequiredException extends DomainException
{
    protected $message = 'Either content or source link must be provided for the article.';
}
