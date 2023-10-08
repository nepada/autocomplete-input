<?php
declare(strict_types = 1);

namespace Nepada\Bridges\AutocompleteInputForms;

use Nepada\AutocompleteInput\AutocompleteInput;
use Nette\Utils\Html;

trait AutocompleteInputMixin
{

    public function addAutocomplete(string|int $name, string|Html|null $label, callable $dataSource, ?int $maxLength = null): AutocompleteInput
    {
        return $this[$name] = new AutocompleteInput($label, $dataSource, $maxLength);
    }

}
