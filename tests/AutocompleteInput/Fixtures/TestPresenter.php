<?php
declare(strict_types = 1);

namespace NepadaTests\AutocompleteInput\Fixtures;

use Nepada\AutocompleteInput\AutocompleteInput;
use Nette;
use Nette\Application\Routers\SimpleRouter;
use Nette\Application\UI\Form;

final class TestPresenter extends Nette\Application\UI\Presenter
{

    public ?Nette\Application\Response $response = null;

    public static function create(?Nette\Http\IRequest $httpRequest = null): self
    {
        $presenter = new self();
        $presenter->autoCanonicalize = false;

        $primaryDependencies = [];
        $rc = new \ReflectionMethod($presenter, 'injectPrimary');
        foreach ($rc->getParameters() as $parameter) {
            if ($parameter->isDefaultValueAvailable()) {
                continue;
            }
            $primaryDependencies[$parameter->getName()] = null;
        }
        $primaryDependencies['httpRequest'] = $httpRequest ?? $presenter->createHttpRequest();
        $primaryDependencies['httpResponse'] = $presenter->createHttpResponse();
        $primaryDependencies['router'] = new SimpleRouter();
        $primaryDependencies['presenterFactory'] = new Nette\Application\PresenterFactory();
        $presenter->injectPrimary(...$primaryDependencies);

        $presenter->setParent(null, 'Test');
        $presenter->changeAction('default');

        return $presenter;
    }

    protected function createComponentForm(): Form
    {
        $form = new Form();
        $form['foo'] = new AutocompleteInput('Foo autocomplete', fn (string $query): array => ["Query: $query", 'Lorem ipsum']);

        return $form;
    }

    public function renderDefault(): void
    {
        $this->terminate();
    }

    public function sendResponse(Nette\Application\Response $response): void
    {
        $this->response ??= $response;
        parent::sendResponse($response);
    }

    private function createHttpRequest(): Nette\Http\IRequest
    {
        return new Nette\Http\Request(new Nette\Http\UrlScript('https://example.com'));
    }

    private function createHttpResponse(): Nette\Http\IResponse
    {
        return new Nette\Http\Response();
    }

    public function getAutocompleteInput(): AutocompleteInput
    {
        $input = $this['form']['foo'];
        assert($input instanceof AutocompleteInput);
        return $input;
    }

}
