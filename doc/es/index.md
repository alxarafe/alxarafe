# Alxarafe Microframework

**Alxarafe** es un microframework PHP moderno (8.2+) diseñado para el desarrollo rápido de aplicaciones web y APIs RESTful. Se centra en la simplicidad, la modularidad y la convención sobre configuración.

## Características Principales

*   **Arquitectura Modular:** El código se organiza en Módulos (Core y de Usuario) que encapsulan la lógica de negocio.
*   **API First:** Soporte nativo para APIs REST con autenticación JWT integrada.
*   **Enrutamiento Automático:** Sistema de rutas inteligente que mapea URLs a Controladores basándose en convenciones de nombres, sin necesidad de definir archivos de rutas manuales.
*   **Base de Datos Flexible:** Capa de abstracción de base de datos ligera con soporte para migraciones y seeders automáticos.
*   **Configuración Centralizada:** Un único archivo `config.json` gestiona todo el entorno.
*   **Internacionalización (i18n):** Soporte nativo para múltiples idiomas.

### 1. Nuevo proyecto (Recomendado)

La forma más sencilla de empezar es utilizando nuestra plantilla de proyecto:

```bash
composer create-project alxarafe/alxarafe-template miprojecto
```

### 2. Agregar a un proyecto existente

Si quieres incluir Alxarafe como librería en un proyecto ya existente:

```bash
composer require alxarafe/alxarafe
```

2.  Asegúrate de tener la estructura de directorios esperada por el framework (ver sección Arquitectura).

## Requisitos del Sistema

*   PHP >= 8.2
*   Composer
*   Extensiones PHP: `ext-pdo`, `ext-json`, `openssl`

## Estructura de un Proyecto Alxarafe

Un proyecto típico que utiliza Alxarafe sigue esta estructura:

```text
mi-proyecto/
├── config.json          # Configuración global
├── public/              # Document Root del servidor web
│   ├── index.php        # Punto de entrada
│   └── .htaccess        # Reglas de reescritura
├── src/
│   └── Modules/         # Módulos de tu aplicación
│       └── MiModulo/
│           ├── Controller/
│           ├── Model/
│           └── Api/
└── vendor/              # Dependencias (incluyendo Alxarafe)
```

## Primeros Pasos

### 1. Configuración (`config.json`)
Crea un archivo `config.json` en la raíz de tu proyecto. Este archivo define la conexión a la base de datos, rutas y claves de seguridad.

### 2. Crear un Módulo
Crea una carpeta en `src/Modules/` (ej. `src/Modules/HolaMundo`).
Dentro, crea `Controller/HolaMundoController.php`.

### 3. Rutas Automáticas
Alxarafe detectará automáticamente tu controlador.
Si tu módulo es `HolaMundo` y tu controlador `SaludoController`, la ruta podría ser algo como:
`/HolaMundo/Saludo

## Desarrollo y Contribución

Si deseas contribuir al desarrollo del framework o probar cambios localmente sin publicar en Packagist, consulta la [Guía de Contribución](GUIA_CONTRIBUCION.md).

El repositorio incluye una aplicación `skeleton` lista para usar como entorno de desarrollo.`

## Documentación Adicional

*   [Arquitectura y Conceptos Core](arquitectura.md)
*   [Motor de Plantillas](motor-plantillas.md)
*   [Temas](temas.md)
*   [Esquema de Plantillas](esquema_de_plantillas.md)
*   [Guía de Publicación y Versionado](guia_de_publicacion.md)
*   [Guía de Contribución](guia_de_contribucion.md)
*   [Guía de Testing](testing.md)
*   [Desarrollo y Documentación de APIs](desarrollo_de_apis.md)
*   [Análisis de Mejoras](analisis_de_mejoras.md)
*   [Gestor de Menús](gestor_de_menus.md)
*   [Ciclo de Vida del ResourceController](resource_controller_lifecycle.md)
*   [Diagnóstico PHP 8.5](diagnostico_php85.md)
*   [Guía de Módulos](MODULOS.md) (Pendiente)
