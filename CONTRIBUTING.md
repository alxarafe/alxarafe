Contributing
============

-   [Fork](https://help.github.com/articles/fork-a-repo) the [alxarafe on github](https://github.com/alxarafe/alxarafe)
-   Build and test your changes:
    ```
    composer install && ./vendor/bin/phpunit
    ```
-   Commit and push until you are happy with your contribution
-   [Make a pull request](https://help.github.com/articles/using-pull-requests)
-   Thanks for your contribution!


Releasing
=========

1. Commit all outstanding changes
2. Bump the version in `BugsnagBundle.php`
3. Update the CHANGELOG.md, and README.md if appropriate.
4. Commit, tag push
    ```
    git commit -am v1.x.x
    git tag v1.x.x
    git push origin master v1.x.x
    ```
5. Update the documentation
    ```
    php sami.phar update documentation.php --force
    ```
