<?php
declare(strict_types = 1);

namespace NepadaTests\Bridges\AutocompleteInputDI;

use Nepada\AutocompleteInput\AutocompleteInput;
use NepadaTests\TestCase;
use Nette;
use Nette\Forms\Form;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';


/**
 * @testCase
 */
class AutocompleteInputExtensionTest extends TestCase
{

    protected function setUp(): void
    {
        $configurator = new Nette\Configurator();
        $configurator->setTempDirectory(TEMP_DIR);
        $configurator->setDebugMode(true);
        $configurator->addConfig(__DIR__ . '/fixtures/config.neon');
        $configurator->createContainer();
    }

    public function testAutocomplete(): void
    {
        $form = new Form();
        /** @var AutocompleteInput $input */
        $input = $form->addAutocomplete('test', 'Autocomplete', fn (string $query): array => []);
        Assert::type(AutocompleteInput::class, $input);
        Assert::same('Autocomplete', $input->caption);
        Assert::same($input, $form['test']);
    }

}


(new AutocompleteInputExtensionTest())->run();
