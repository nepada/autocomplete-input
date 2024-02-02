<?php
declare(strict_types = 1);

namespace Nepada\Bridges\AutocompleteInputForms;

use Nepada\AutocompleteInput\AutocompleteInput;
use Nette;
use Nette\Forms\Container;
use Nette\Utils\Html;

class ExtensionMethodRegistrator
{

    use Nette\StaticClass;

    public static function register(): void
    {
        Container::extensionMethod(
            'addAutocomplete',
            function (Container $container, string|int $name, string|Html|null $label, callable $dataSource, ?int $maxLength = null): AutocompleteInput {
                $input = new AutocompleteInput($label, $dataSource, $maxLength);
                $container[(string) $name] = $input;

                return $input;
            },
        );
    }

}
