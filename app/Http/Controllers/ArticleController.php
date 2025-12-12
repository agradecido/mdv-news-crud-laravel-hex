<?php
// file: app/Http/Controllers/ArticleController.php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Application\Articles\CreateArticle;

final class ArticleController extends Controller
{
    public function __construct(
        private CreateArticle $createArticle
    ) {}

    public function store(Request $request): JsonResponse
    {

        // Validate data
        $validatedData = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'author'  => ['required', 'string'],
            'featured_image' => ['nullable', 'string'],
        ]);

        // 1. Extract data from http request
        $title   = $validatedData['title'];
        $content = $validatedData['content'];
        $author  = $validatedData['author'];
        $image   = $validatedData['featured_image'];

        // 2. Execute UseCase
        $article = $this->createArticle->execute(
            $title,
            $content,
            $author,
            $image
        );

        // 3. Return JSON response (code 201: created)
        // Convert the objeto to array and create a JSON 
        return response()->json([
            'uuid' => $article->uuid(),
            'message' => 'Article created successfully'
        ], 201);
    }
}
