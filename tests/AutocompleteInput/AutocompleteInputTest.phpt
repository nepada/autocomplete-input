<?php
declare(strict_types = 1);

namespace NepadaTests\AutocompleteInput;

use Nepada;
use NepadaTests\AutocompleteInput\Fixtures\TestPresenter;
use NepadaTests\TestCase;
use Nette\Application;
use Nette\Http\IRequest;
use Nette\Http\Request;
use Nette\Http\UrlScript;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


/**
 * @testCase
 */
class AutocompleteInputTest extends TestCase
{

    private const AUTOCOMPLETE_URL = '/?do=form-foo-autocomplete&form-foo-query=__QUERY_PLACEHOLDER__&action=default&presenter=Test';

    public function testRendering(): void
    {
        $presenter = TestPresenter::create();
        /** @var Nepada\AutocompleteInput\AutocompleteInput $autocompleteInput */
        $autocompleteInput = $presenter['form']['foo'];

        $autocompleteInput->setDefaultValue('bar');

        Assert::same(
            sprintf('<input type="text" name="foo" data-autocomplete-query-placeholder="__QUERY_PLACEHOLDER__" data-autocomplete-url="%s" id="frm-form-foo" value="bar">', str_replace('&', '&amp;', self::AUTOCOMPLETE_URL)),
            (string) $autocompleteInput->getControl(),
        );
    }

    public function testMinLengthSetting(): void
    {
        $presenter = TestPresenter::create();
        /** @var Nepada\AutocompleteInput\AutocompleteInput $autocompleteInput */
        $autocompleteInput = $presenter['form']['foo'];

        $autocompleteInput->setAutocompleteMinLength(42);

        Assert::same(
            sprintf('<input type="text" name="foo" data-autocomplete-query-placeholder="__QUERY_PLACEHOLDER__" data-autocomplete-url="%s" data-autocomplete-min-length="42" id="frm-form-foo">', str_replace('&', '&amp;', self::AUTOCOMPLETE_URL)),
            (string) $autocompleteInput->getControl(),
        );
    }

    public function testAutocompleteSignal(): void
    {
        $presenter = $this->runTestPresenter(str_replace('__QUERY_PLACEHOLDER__', 'someQuery', self::AUTOCOMPLETE_URL));

        /** @var Application\Responses\JsonResponse $response */
        $response = $presenter->response;
        Assert::type(Application\Responses\JsonResponse::class, $response);
        Assert::same(['Query: someQuery', 'Lorem ipsum'], $response->getPayload());
    }

    public function testMissingQueryInAutocompleteSignal(): void
    {
        Assert::exception(
            function (): void {
                $this->runTestPresenter('/?do=form-foo-autocomplete&action=default&presenter=Test');
            },
            Application\UI\BadSignalException::class,
        );
    }

    public function testInvalidSignal(): void
    {
        Assert::exception(
            function (): void {
                $this->runTestPresenter('/?do=form-foo-invalid&action=default&presenter=Test');
            },
            Application\UI\BadSignalException::class,
        );
    }

    private function runTestPresenter(string $url): TestPresenter
    {
        $url = new UrlScript($url);
        $httpRequest = new Request($url);
        $presenter = TestPresenter::create($httpRequest);

        $request = new Application\Request('Test', IRequest::GET, $url->getQueryParameters());
        try {
            $presenter->run($request);
        } catch (Application\AbortException $exception) {
            // noop
        }

        return $presenter;
    }

}


(new AutocompleteInputTest())->run();
