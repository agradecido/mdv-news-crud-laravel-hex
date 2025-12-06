<?php
declare(strict_types=1);

namespace Src\Domain\Articles\Enums;

enum ArticleStatus: string {
    case DRAFT = 'draft';
    case AI_EDITED = 'ai_edited';
    case HUMAN_REVIEWED = 'human_reviewed';
    case PUBLISHED = 'published';
}
