[![Scrutinizer logo](https://scrutinizer-ci.com/images/logo.png)](https://scrutinizer-ci.com/g/alxarafe/alxarafe/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alxarafe/alxarafe/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alxarafe/alxarafe/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/alxarafe/alxarafe/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/alxarafe/alxarafe/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/alxarafe/alxarafe/badges/build.png?b=master)](https://scrutinizer-ci.com/g/alxarafe/alxarafe/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/alxarafe/alxarafe/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

[<img align="left" width="35" height="35" src="https://github.com/alxarafe/alxarafe/blob/master/resources/img/TravisCI-Mascot-1.png">](https://travis-ci.org/alxarafe/alxarafe)
[![Build Status](https://travis-ci.org/alxarafe/alxarafe.svg?branch=master)](https://travis-ci.org/alxarafe/alxarafe)

[![codecov](https://codecov.io/gh/alxarafe/alxarafe/branch/master/graph/badge.svg)](https://codecov.io/gh/alxarafe/alxarafe)

[![packagist](https://img.shields.io/packagist/v/alxarafe/alxarafe.svg)](https://packagist.org/packages/alxarafe/alxarafe)
[![Downloads](https://img.shields.io/packagist/dt/alxarafe/alxarafe.svg)](https://packagist.org/packages/alxarafe/alxarafe)

# Alxarafe.

[Alxarafe](https://alxarafe.com) is an application developed in the [Laravel framework](https://laravel.com/), which initially starts from a [Dolibarr project](https://www.dolibarr.es/) fork, maintaining its functionalities and evolving from there.

## Why Alxarafe?

Because Alxarafe will offer multiple features out of the box.
Its modularity, allows to easily change the tools used to provide his functionalities.

## Documentation

https://alxarafe.github.io/alxarafe/

You can test the application using Docker. Switch to the docker path from the app repository:

>cd docker

Copy or rename .env.example to .env.

>cp .env.example .env

Build docker image using:

>docker-compose build --no-cache --force-rm

Afterwards, you can start the image execution with:

>docker-compose up --force-recreate

Once the image has started running, you can run Alxarafe by starting it in your browser

>http://localhost:8090/

## Laravel 10 considerations

### i18n
The language feature (i18n) is not a base feature that comes available, out of the box, in our folder tree after a clean installation of Laravel 10, so, if you want to make the folder available, you must run the command `php artisan lang:publish` in order to create the folder and the base languages files for all languages


### XDebug in Console
export XDEBUG_CONFIG="remote_enable=1 remote_mode=req remote_port=9000 remote_host={{gateway IP}} remote_connect_back=0 idekey=PHPSTORM"
export PHP_IDE_CONFIG="serverName=localhost"
php bin/script.php

## Contributors

[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](https://github.com/alxarafe/alxarafe/issues?utf8=✓&q=is%3Aopen%20is%3Aissue)

If you find ways to improve the code, do it.
Thank you for considering contributing to Alxarafe ERP! The contribution guide can be found in the [Alxarafe documentation](https://alxarafe.com/contribution/).

## Licence

Alxarafe is released under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version (GPL-3+).

See the [COPYING](https://www.gnu.org/licenses/gpl-3.0.html) file for a full copy of the license.

Other licenses apply for some included dependencies. See [COPYRIGHT](https://gitlab.com/alxarafe-prj/alxarafe/-/blob/master/COPYRIGHT) for a full list.