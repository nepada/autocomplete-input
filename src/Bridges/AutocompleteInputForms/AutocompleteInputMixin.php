<?php
declare(strict_types = 1);

namespace Nepada\Bridges\AutocompleteInputForms;

use Nepada\AutocompleteInput\AutocompleteInput;
use Nette\Utils\Html;

trait AutocompleteInputMixin
{

    /**
     * @param string|int $name
     * @param string|Html|null $label
     * @param callable $dataSource
     * @param int|null $maxLength
     * @return AutocompleteInput
     */
    public function addAutocomplete($name, $label, callable $dataSource, ?int $maxLength = null): AutocompleteInput
    {
        return $this[$name] = new AutocompleteInput($label, $dataSource, $maxLength);
    }

}
