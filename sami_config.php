<?php

use Sami\Sami;
use Sami\Parser\Filter\TrueFilter;
use Symfony\Component\Finder\Finder;
use Sami\RemoteRepository\GitHubRemoteRepository;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in($dir = './/app/Blog');

    $sami = new Sami($iterator);

    $sami['title'] = 'Blog Project';
    $sami['build_dir'] = 'storage/app/public/code-docs';
    $sami['cache_dir'] = 'sami_cache';
    $sami['remote_repository'] = new GitHubRemoteRepository('sidis405/laravel-boilerplate-z', './');

    $sami['filter'] = function () {
        return new TrueFilter();
    };

return $sami;
