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

    public static function create(?Nette\Http\IRequest $httpRequest = null): TestPresenter
    {
        $presenter = new self();
        $presenter->autoCanonicalize = false;

        $httpRequest ??= $presenter->createHttpRequest();
        $httpResponse = $presenter->createHttpResponse();
        $router = new SimpleRouter();
        $presenter->injectPrimary(null, null, $router, $httpRequest, $httpResponse);

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

}
