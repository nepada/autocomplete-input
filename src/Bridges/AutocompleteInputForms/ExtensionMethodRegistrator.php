<?php
declare(strict_types = 1);

namespace Nepada\Bridges\AutocompleteInputForms;

use Nepada\AutocompleteInput\AutocompleteInput;
use Nette;
use Nette\Forms\Container;

class ExtensionMethodRegistrator
{

    use Nette\StaticClass;

    public static function register(): void
    {
        Container::extensionMethod(
            'addAutocomplete',
            function (Container $container, $name, $label, callable $dataSource, ?int $maxLength = null): AutocompleteInput {
                $input = new AutocompleteInput($label, $dataSource, $maxLength);
                $container[$name] = $input;

                return $input;
            },
        );
    }

}
