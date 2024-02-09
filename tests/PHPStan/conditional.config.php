<?php
declare(strict_types = 1);

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;

$config = [];

if (InstalledVersions::satisfies(new VersionParser(), 'nette/application', '<3.2')) {
    $config['parameters']['ignoreErrors'][] = [
        'message' => '#^Method Nepada\\\\AutocompleteInput\\\\AutocompleteInput\\:\\:getUniqueId\\(\\) should return string but returns string\\|null\\.$#',
        'path' => '../../src/AutocompleteInput/AutocompleteInput.php',
        'count' => 1,
    ];
}

return $config;
