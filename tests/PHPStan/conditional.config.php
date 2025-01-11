<?php
declare(strict_types = 1);

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;

$config = ['parameters' => ['ignoreErrors' => []]];

if (InstalledVersions::satisfies(new VersionParser(), 'nette/component-model', '<3.1')) {
    $config['parameters']['ignoreErrors'][] = [
        'message' => '#^Method Nepada\\\\AutocompleteInput\\\\AutocompleteInput\\:\\:getUniqueId\\(\\) should return string but returns string\\|null\\.$#',
        'path' => __DIR__ . '/../../src/AutocompleteInput/AutocompleteInput.php',
        'count' => 1,
    ];
}

return $config;
