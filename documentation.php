<?php

/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

// php sami.phar update documentation.php

use Sami\Parser\Filter\TrueFilter;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Sami\Sami;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in($dir = 'src');

$versions = GitVersionCollection::create($dir)
    ->add('master', 'master branch');

$sam = new Sami(
    $iterator,
    [
        'theme' => 'default',
        'versions' => $versions,
        'title' => 'alxarafe',
        'build_dir' => __DIR__ . '/docs/',
        'cache_dir' => __DIR__ . '/cache/docs/',
        'remote_repository' => new GitHubRemoteRepository('alxarafe/alxarafe', ''),
        'default_opened_level' => 2,
    ]
);
// document all methods and properties
$sam['filter'] = function() {
    return new TrueFilter();
};

return $sam;