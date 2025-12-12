<?php
//file: routes/api.php

declare(strict_types=1);

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::post('/articles', [ArticleController::class, 'store']);
