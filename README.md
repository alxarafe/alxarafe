# Alxarafe

![PHP Version](https://img.shields.io/badge/PHP-8.5.1-blueviolet?style=flat-square)
![CI](https://github.com/alxarafe/alxarafe/actions/workflows/ci.yml/badge.svg)
![Tests](https://github.com/alxarafe/alxarafe/actions/workflows/tests.yml/badge.svg)
[![Quality Report](https://img.shields.io/badge/quality-report-brightgreen?style=flat-square)](https://alxarafe.github.io/alxarafe/quality/)
![Static Analysis](https://img.shields.io/badge/static%20analysis-PHPStan%20%2B%20Psalm-blue?style=flat-square)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](https://github.com/alxarafe/alxarafe/issues?utf8=✓&q=is%3Aopen%20is%3Aissue)

## LICENSE

Alxarafe is released under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version (GPL-3+).

See the [COPYING](https://github.com/alxarafe/alxarafe/blob/develop/COPYING) file for a full copy of the license.

Other licenses apply for some included dependencies. See [COPYRIGHT](https://github.com/alxarafe/alxarafe/blob/develop/COPYRIGHT) for a full list.

## INSTALLING

### Local development with Docker

Alxarafe includes a complete Docker development environment. To use it:

1. Copy the example environment file:
   ```bash
   cp .env.example .env
   ```
2. Start the containers using the provided script:
   ```bash
   ./bin/docker_start.sh
   ```
3. Run the migrations:
   ```bash
   ./bin/run_migrations.sh
   ```
4. Access the application at [http://localhost:8081](http://localhost:8081).

For more details, see the [Docker documentation](https://alxarafe.github.io/alxarafe/en/docker).

### Manual installation

```bash
composer require alxarafe/alxarafe
```

## DOCUMENTATION

Official documentation is available at: [https://alxarafe.github.io/alxarafe/](https://alxarafe.github.io/alxarafe/)

You can also find the markdown source in the `docs/` directory.

## CONTRIBUTING

This project exists thanks to all the people who contribute.
Please read the instructions on how to contribute (report a bug/error, a feature request, send code, ...)  [[Contributing](https://github.com/alxarafe/alxarafe/blob/develop/.github/CONTRIBUTING.md)]

## CREDITS

alxarafe is the work of many contributors over the years and uses some fine PHP libraries.

See [COPYRIGHT](https://github.com/alxarafe/alxarafe/blob/develop/COPYRIGHT) file.

## NEWS AND SOCIAL NETWORKS

Follow alxarafe project on:

- [GitHub](https://github.com/alxarafe/alxarafe)
