<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->exclude('vendor');

return (new Config())
    ->setRules([
        '@PSR12' => true,
        'strict_param' => true,
    ])
    ->setFinder($finder);
