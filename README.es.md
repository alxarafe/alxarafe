# Alxarafe

![Versión de PHP](https://img.shields.io/badge/PHP-8.2+-blueviolet?style=flat-square)
![CI](https://github.com/alxarafe/alxarafe/actions/workflows/ci.yml/badge.svg)
![Tests](https://github.com/alxarafe/alxarafe/actions/workflows/tests.yml/badge.svg)
[![Informe de calidad](https://img.shields.io/badge/quality-report-brightgreen?style=flat-square)](https://alxarafe.github.io/alxarafe/quality/)
![Análisis estático](https://img.shields.io/badge/static%20analysis-PHPStan%20%2B%20Psalm-blue?style=flat-square)
[![PRs Bienvenidos](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](https://github.com/alxarafe/alxarafe/issues?utf8=✓&q=is%3Aopen%20is%3Aissue)

## LICENCIA

Alxarafe se distribuye bajo los términos de la Licencia Pública General de GNU, publicada por la Free Software Foundation; ya sea la versión 3 de la Licencia o (a su elección) cualquier versión posterior (GPL-3+).

Consulte el archivo [LICENSE](https://github.com/alxarafe/alxarafe/blob/develop/LICENSE) para obtener una copia completa de la licencia.

Otras licencias aplican para algunas dependencias incluidas. Consulte [COPYRIGHT](https://github.com/alxarafe/alxarafe/blob/develop/COPYRIGHT.md) para obtener la lista completa.

## INSTALACIÓN

### Desarrollo local con Docker

Alxarafe incluye un entorno de desarrollo Docker completo. Para usarlo:

1. Copie el archivo de entorno de ejemplo:
   ```bash
   cp .env.example .env
   ```
2. Inicie los contenedores usando el script proporcionado:
   ```bash
   ./bin/docker_start.sh
   ```
3. Ejecute las migraciones:
   ```bash
   ./bin/run_migrations.sh
   ```
4. Acceda a la aplicación en [http://localhost:8081](http://localhost:8081).

Para más detalles, consulte la [documentación de Docker](https://alxarafe.github.io/alxarafe/es/docker).

### Crear un nuevo proyecto (Recomendado)

La forma más sencilla de iniciar un nuevo proyecto con Alxarafe es usar nuestra plantilla de proyecto:

```bash
composer create-project alxarafe/alxarafe-template mi-app
```

### Añadir a un proyecto existente

Si ya tiene un proyecto y desea incluir Alxarafe, ejecute:

```bash
composer require alxarafe/alxarafe
```

## DOCUMENTACIÓN

La documentación oficial está disponible en: [https://docs.alxarafe.com/es](https://docs.alxarafe.com/es) (versión en inglés: [https://docs.alxarafe.com/en](https://docs.alxarafe.com/en))

También puede encontrar el código fuente en formato Markdown en el directorio `doc/`.

## CONTRIBUIR

Este proyecto existe gracias a todas las personas que contribuyen.
Por favor, lea las instrucciones sobre cómo contribuir (reportar un error, solicitar una funcionalidad, enviar código, ...)  [[Contribuir](https://github.com/alxarafe/alxarafe/blob/develop/CONTRIBUTING.md)]

## CRÉDITOS

Alxarafe es el trabajo de muchos colaboradores a lo largo de los años y utiliza excelentes bibliotecas de PHP.

Consulte el archivo [COPYRIGHT](https://github.com/alxarafe/alxarafe/blob/develop/COPYRIGHT.md).

## NOTICIAS Y REDES SOCIALES

Siga el proyecto Alxarafe en:

- [GitHub](https://github.com/alxarafe/alxarafe)
