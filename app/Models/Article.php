<?php
// file: app/Models/Article.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    // 1. Definimos el nombre de la clave primaria
    protected $primaryKey = 'uuid';

    // 2. Indicamos que el tipo de dato es string (cadena)
    protected $keyType = 'string';

    // 3. Desactivamos el autoincremento (porque los UUIDs no se incrementan)
    public $incrementing = false;

    // También es buena práctica definir qué campos se pueden rellenar masivamente
    protected $fillable = [
        'uuid',
        'title',
        'content',
        'author',
        'featured_image',
        'received_at',
        'published_at',
        'status'
    ];
}
