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
├── Domain/            # Lógica pura de negocio (Entidades, Enums, Exceptions)
│   └── Articles/
│       ├── Article.php
│       ├── Enums/
│       │   └── ArticleStatus.php
│       └── Exceptions/
│           └── ArticleContentRequiredException.php
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

### 2. Excepción de Dominio
*Ubicación: `src/Domain/Articles/Exceptions/ArticleContentRequiredException.php`*
```php
<?php
namespace Src\Domain\Articles\Exceptions;
use DomainException;

class ArticleContentRequiredException extends DomainException {
    public function __construct() {
        parent::__construct("An article must have either content or a source link.");
    }
}
```

### 3. Entidad: Article (Raíz del Agregado)
*Ubicación: `src/Domain/Articles/Article.php`*
*Regla de Negocio:* Debe tener `content` O `source_link`. Si ambos son null, lanza excepción.
```php
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
        if ($content === null && $source_link === null) {
            throw new ArticleContentRequiredException();
        }
    }
    
    // PENDIENTE: Añadir Getters públicos (title(), content(), etc.)
}
```

---

## ✅ Tests Unitarios (TDD)
*Ubicación: `tests/Unit/Domain/ArticleTest.php`*

- [x] **Sad Path:** Lanzar excepción si falta contenido Y enlace. (ESTADO: 🟢 PASS)
- [ ] **Happy Path:** Crear artículo válido solo con contenido.
- [ ] **Happy Path:** Crear artículo válido solo con enlace.

---

## 🚀 Siguientes Pasos (Roadmap)

1.  **Exponer Datos:** Implementar *Getters* en la entidad `Article`.
2.  **Completar TDD:** Escribir tests para la creación exitosa de artículos.
3.  **Lógica de Negocio:** Añadir métodos de comportamiento (ej: `publish()`).
4.  **Persistencia:** Definir `ArticleRepository` e implementar persistencia en DB.

## 📝 Comandos Útiles
```bash
# Regenerar mapa de clases
composer dump-autoload -o

# Ejecutar tests del dominio
php artisan test --filter ArticleTest
```