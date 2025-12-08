# 🏗️ Laravel DDD - Sistema de Gestión de Noticias

Este documento rastrea el progreso de la implementación de Arquitectura Hexagonal/DDD en el proyecto. Actúa como memoria del proyecto para retomar el desarrollo con IA.

## 🎓 Manifiesto de Aprendizaje

Este proyecto no es solo un sistema de gestión de noticias; es un **laboratorio de arquitectura de software**.

El objetivo principal es transicionar de "Programador Laravel" a **Arquitecto de Software**, priorizando la calidad, la escalabilidad y el desacoplamiento sobre la velocidad inicial. Estamos adoptando deliberadamente un camino de aprendizaje estricto basado en:

1. **Domain-Driven Design (DDD):** El negocio manda. El framework (Laravel) es un detalle de implementación, no el centro del universo.
2. **Test-Driven Development (TDD):** No escribimos código sin una prueba que falle primero (Red-Green-Refactor). La confianza le gana a la esperanza.
3. **Arquitectura Hexagonal:** Protegemos nuestro núcleo (Dominio) de las herramientas externas (Base de datos, UI, APIs).

*Nota: Aquí se permite la sobreingeniería con fines educativos para entender el "porqué" de cada patrón.*

## 📍 Estado Actual

**Fase:** Construcción del Dominio (Core)
**Enfoque:** Entidad `Article`, Invariantes y TDD (Ciclo Red-Green-Refactor).

---

## 📂 Estructura de Directorios (Hexagonal)

La lógica de negocio se ha movido a `src/`, dejando `app/` solo para la infraestructura de Laravel.

```text
src/
├── Application/       # Casos de uso (Services)
│   └── Articles/
│       └── CreateArticle.php
├── Domain/            # Lógica pura de negocio (Entidades, Enums)
│   └── Articles/
│       ├── Article.php
│       ├── ArticleRepository.php (interface)
│       └── Enums/
│           └── ArticleStatus.php
└── Infrastructure/    # Implementaciones (Repositorios Eloquent, etc.)
```

## 🛠️ Configuración Realizada

1.  **Autoloading:** Se agregó `"Src\\": "src/"` al `composer.json` (PSR-4).
2.  **Testing:** Configurado PHPUnit (`tests/Unit/Domain/ArticleTest.php`) para importar las clases del dominio.

---

## 🧩 Código del Dominio (Snapshot)

### 1. Enum: Estados del Artículo

*Ubicación: `src/Domain/Articles/Enums/ArticleStatus.php`*
```php
<?php
namespace Src\Domain\Articles\Enums;

enum ArticleStatus: string {
    case DRAFT = 'draft';
    case AI_EDITED = 'ai_edited';
    case HUMAN_REVIEWED = 'human_reviewed';
    case PUBLISHED = 'published';
}
```

### 2. Entidad: Article (Raíz del Agregado)

*Ubicación: `src/Domain/Articles/Article.php`*
*Simplificación:* Se eliminó la propiedad `source_link` y la validación asociada para reducir complejidad.

```php
<?php
declare(strict_types=1);

namespace Src\Domain\Articles;

use DateTimeImmutable;
use Src\Domain\Articles\Enums\ArticleStatus;

final class Article
{
    public function __construct(
        private string $title,
        private ?string $content,
        private string $author,
        private ?string $featured_image,
        private DateTimeImmutable $received_at,
        private ?DateTimeImmutable $published_at,
        private ArticleStatus $status,
    ) {
    }
    
    // Named Constructor
    public static function create(
        string $title,
        ?string $content,
        string $author,
        ?string $featured_image = null
    ): self {
        return new self(
            $title,
            $content,
            $author,
            $featured_image,
            new DateTimeImmutable(),
            null,
            ArticleStatus::DRAFT
        );
    }
    
    // Getters públicos implementados (sin prefijo 'get', estilo DDD moderno)
    // title(), content(), author(), featuredImage()
    // receivedAt(), publishedAt(), status()
}
```

### 3. Caso de Uso: CreateArticle

*Ubicación: `src/Application/Articles/CreateArticle.php`*
```php
<?php
namespace Src\Application\Articles;

use Src\Domain\Articles\Article;
use Src\Domain\Articles\ArticleRepository;

final class CreateArticle
{
    public function __construct(private ArticleRepository $repository) {}

    public function execute(
        string $title,
        ?string $content,
        string $author,
        ?string $featured_image = null
    ): Article {
        $article = Article::create($title, $content, $author, $featured_image);
        $this->repository->save($article);
        return $article;
    }
}
```

---

## ✅ Tests Unitarios (TDD)
*Ubicación: `tests/Unit/Domain/ArticleTest.php`*

- [x] **Happy Path:** Crear artículo válido con contenido. (ESTADO: 🟢 PASS)

*Ubicación: `tests/Unit/Application/CreateArticleTest.php`*

- [x] **Integration:** Crear y persistir un artículo a través del caso de uso. (ESTADO: 🟢 PASS)

**Resultado actual:** `3 tests, 13 assertions - ALL PASS ✅`

**Cambios recientes:**
- ✅ Eliminada propiedad `source_link` de la entidad `Article` para simplificar el modelo
- ✅ Eliminada excepción `ArticleContentRequiredException` (ya no necesaria)
- ✅ Actualizado caso de uso `CreateArticle` 
- ✅ Tests actualizados y pasando

---

## 🚀 Siguientes Pasos (Roadmap)

1.  **Completar Comportamiento:** Añadir métodos de comportamiento en `Article` (ej: `publish()`, `edit()`, `review()`).
2.  **Persistencia:** Implementar `ArticleRepository` con Eloquent en la capa de Infraestructura.
3.  **Value Objects:** Considerar extraer `Title`, `Author` como VOs si añaden validaciones.
4.  **API/Controladores:** Exponer casos de uso a través de controladores HTTP (capa de presentación).

## 📝 Comandos Útiles
```bash
# Regenerar mapa de clases
composer dump-autoload -o

# Ejecutar tests del dominio
php artisan test --filter ArticleTest
```