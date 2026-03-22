# Alxarafe Microframework – Referencia Técnica

**Alxarafe** es un microframework PHP 8.2+ diseñado para el desarrollo rápido de aplicaciones web modulares y APIs RESTful. Proporciona una capa delgada y con opinión sobre componentes estándar de la industria (Illuminate ORM, Blade, Symfony Translation) siguiendo estrictamente la filosofía de **Convención sobre Configuración**.

## Principios de Diseño

| Principio | Descripción |
|---|---|
| **Convención sobre Configuración** | Controladores, modelos, migraciones y plantillas se descubren automáticamente escaneando namespaces PSR-4. No hay archivos de rutas que mantener. |
| **Modular por Defecto** | Cada funcionalidad se empaqueta como un Módulo (`CoreModules\` o `Modules\`), cada uno con sus propios Controllers, Models, Migrations, Seeders y Templates. |
| **Reutilizar, No Reinventar** | Capa de datos = Illuminate/Eloquent. Plantillas = Blade. Traducciones = Symfony/Translation. Autenticación = JWT (Firebase PHP-JWT). |
| **Metadatos vía Atributos** | Los Atributos PHP 8 (`#[Menu]`, `#[ApiRoute]`, `#[RequireRole]`, `#[ModuleInfo]`) definen declarativamente rutas, permisos y metadatos de módulos. |
| **Arquitectura de Componentes** | Los formularios UI se ensamblan programáticamente a partir de componentes Field, Container y Filter — no HTML codificado a mano. |

## Requisitos del Sistema

- PHP ≥ 8.2
- Composer
- Extensiones requeridas: `ext-pdo`, `ext-json`, `ext-openssl`
- Base de datos: MySQL 5.7+ / MariaDB 10.3+ o PostgreSQL 12+

## Inicio Rápido

### Nuevo Proyecto (Recomendado)

```bash
composer create-project alxarafe/alxarafe-template mi-app
cd mi-app
cp .env.example .env
# Editar .env con las credenciales de base de datos
php bin/run_migrations.sh
```

### Agregar a un Proyecto Existente

```bash
composer require alxarafe/alxarafe
```

Luego crear la estructura de directorios esperada (ver [Arquitectura](arquitectura.md)).

### Desarrollo con Docker

```bash
cp .env.example .env
./bin/docker_start.sh
./bin/run_migrations.sh
# Acceder en http://localhost:8081
```

## Estructura del Proyecto

```text
mi-proyecto/
├── config/
│   └── config.json          # Configuración global (BD, seguridad, idioma)
├── public/                  # Document Root del servidor web
│   ├── index.php            # Punto de entrada → Dispatcher::run()
│   └── .htaccess            # Reglas de reescritura URL
├── Modules/                 # Módulos de aplicación (namespace Modules\)
│   └── MiModulo/
│       ├── Controller/      # *Controller.php → Rutas web
│       ├── Model/           # Modelos Eloquent
│       ├── Api/             # *Controller.php → Rutas API
│       ├── Migrations/      # Migraciones de base de datos
│       ├── Seeders/         # Seeders de datos
│       └── Templates/       # Vistas Blade
├── templates/               # Plantillas Blade compartidas y layouts
├── themes/                  # Sobrescrituras de temas
└── vendor/                  # Dependencias (incluye alxarafe/alxarafe)
    └── alxarafe/alxarafe/
        └── src/
            ├── Core/        # Kernel del framework (namespace Alxarafe\)
            └── Modules/     # Módulos core (namespace CoreModules\)
```

## Índice de Documentación

### Fundamentos

| Documento | Descripción |
|---|---|
| [Arquitectura y Estructura de Directorios](arquitectura.md) | Namespaces PSR-4, responsabilidad de directorios, grafo de dependencias |
| [Ciclo de Vida de una Petición](ciclo_de_vida.md) | Flujo completo desde `index.php` hasta la respuesta HTTP |

### Referencia de API

| Documento | Descripción |
|---|---|
| [Atributos](classes/core/attribute/index.md) | `#[ApiRoute]`, `#[Menu]`, `#[ModuleInfo]`, `#[RequireModule]`, `#[RequirePermission]`, `#[RequireRole]` |
| [Controladores](classes/core/base/controller/index.md) | Jerarquía `GenericController` → `ViewController` → `Controller` → `ResourceController` |
| [Modelos y Traits](classes/core/base/model/index.md) | `Model`, `DtoTrait`, `HasAuditLog` |
| [Config y Base de Datos](classes/core/base/index.md) | `Config`, `Database`, `Seeder`, `Template`, `BladeContainer` |
| [Campos de Componentes](classes/core/component/fields/index.md) | 15 tipos de campos para generación de formularios |
| [Contenedores de Componentes](classes/core/component/container/index.md) | `Panel`, `Tab`, `TabGroup`, `Row`, `Separator`, `HtmlContent` |
| [Filtros de Componentes](classes/core/component/filter/index.md) | `TextFilter`, `SelectFilter`, `DateRangeFilter`, etc. |
| [Workflow de Componentes](classes/core/component/workflow/index.md) | `StatusWorkflow`, `StatusTransition` |
| [Capa Lib](classes/core/lib/index.md) | `Auth`, `Functions`, `Messages`, `Router`, `Routes`, `Trans` |
| [Capa de Servicios](classes/core/service/index.md) | `HookService`, `EmailService`, `PdfService`, servicios API, Markdown |
| [Capa de Herramientas](classes/core/tools/index.md) | `Dispatcher`, `Debug`, `ModuleManager`, `DependencyResolver` |

### Guías

| Documento | Descripción |
|---|---|
| [Referencia del Módulo Admin](admin_module.md) | Módulo Admin integrado: auth, usuarios, roles, permisos, config, migraciones |
| [Uso Avanzado](uso_avanzado.md) | Crear módulos, hooks, campos personalizados, temas, JWT, i18n |
| [Motor de Plantillas](motor-plantillas.md) | Integración Blade y descubrimiento de plantillas |
| [Esquema de Plantillas](esquema_de_plantillas.md) | Estructura de vistas basada en componentes |
| [Pestañas Extensibles](pestanas_extensibles.md) | Sistema de pestañas condicionales y dinámicas |
| [Arquitectura de Temas](frontend/arquitectura_temas.md) | Pipeline de assets y sobrescrituras de temas |
| [Sistema de Temas](frontend/sistema_de_temas.md) | Instalación y personalización de temas |
| [Gestor de Menús](gestor_de_menus.md) | Sistema de menús basado en atributos |
| [Ciclo de Vida del ResourceController](resource_controller_lifecycle.md) | Ciclo CRUD en detalle |
| [Desarrollo de APIs](desarrollo_de_apis.md) | APIs REST con autenticación JWT |
| [Guía de Testing](testing.md) | Configuración de PHPUnit, PHPStan, Psalm |
| [Docker](docker.md) | Entorno de desarrollo Docker |
| [Guía de Publicación](guia_de_publicacion.md) | Versionado y publicación en Packagist |
| [Guía de Contribución](guia_de_contribucion.md) | Cómo contribuir al proyecto |

## Licencia

Alxarafe se distribuye bajo la **GNU General Public License v3.0+** (GPL-3.0-or-later).
