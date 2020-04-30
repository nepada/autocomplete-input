<?php
declare(strict_types = 1);

namespace NepadaTests\Bridges\AutocompleteInputForms;

use Nepada\Bridges\AutocompleteInputForms\AutocompleteInputMixin;
use Nette;

class TestForm extends Nette\Forms\Form
{

    use AutocompleteInputMixin;

}
