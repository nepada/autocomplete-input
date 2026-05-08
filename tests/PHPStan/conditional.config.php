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

if (InstalledVersions::satisfies(new VersionParser(), 'nette/component-model', '<3.1.4')) {
    $config['parameters']['ignoreErrors'][] = [
        'message' => '#^Method Nepada\\\\AutocompleteInput\\\\AutocompleteInput\\:\\:getPresenter\\(\\) should return Nette\\\\Application\\\\UI\\\\Presenter but returns Nette\\\\ComponentModel\\\\IComponent\\.$#',
        'path' => __DIR__ . '/../../src/AutocompleteInput/AutocompleteInput.php',
        'count' => 1,
    ];
}


if (! InstalledVersions::satisfies(new VersionParser(), 'nette/forms', '<=3.2.8')) {
    $config['parameters']['ignoreErrors'][] = [
        'message' => '~^Parameter \\#2 \\$callback of static method Nette\\\\Forms\\\\Container\\:\\:extensionMethod\\(\\) expects callable\\(Nette\\\\Forms\\\\Container\\)\\: mixed, Closure\\(Nette\\\\Forms\\\\Container, int\\|string, Nette\\\\Utils\\\\Html\\|string\\|null, callable, int\\|null\\=\\)\\: Nepada\\\\AutocompleteInput\\\\AutocompleteInput given\\.$~',
        'path' => __DIR__ . '/../../src/Bridges/AutocompleteInputForms/ExtensionMethodRegistrator.php',
        'count' => 1,
    ];
}

return $config;
