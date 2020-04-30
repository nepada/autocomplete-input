<?php
declare(strict_types = 1);

namespace NepadaTests\Bridges\AutocompleteInputForms;

use Nepada\AutocompleteInput\AutocompleteInput;
use NepadaTests\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';


/**
 * @testCase
 */
class AutocompleteInputMixinTest extends TestCase
{

    public function testMixin(): void
    {
        $form = new TestForm();
        $input = $form->addAutocomplete('test', 'Autocomplete', fn (string $query): array => []);
        Assert::type(AutocompleteInput::class, $input);
        Assert::same('Autocomplete', $input->caption);
        Assert::same($input, $form['test']);
    }

}

(new AutocompleteInputMixinTest())->run();
