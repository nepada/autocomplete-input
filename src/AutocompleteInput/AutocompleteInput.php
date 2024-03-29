<?php
declare(strict_types = 1);

namespace Nepada\AutocompleteInput;

use Nette\Application\UI\BadSignalException;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\SignalReceiver;
use Nette\Forms\Controls\TextInput;
use Nette\Utils\Html;

class AutocompleteInput extends TextInput implements SignalReceiver
{

    private const AUTOCOMPLETE_SIGNAL = 'autocomplete';
    private const QUERY_PLACEHOLDER = '__QUERY_PLACEHOLDER__';
    private const QUERY_PARAMETER = 'query';

    /**
     * @var callable
     */
    private $dataSource;

    public function __construct(Html|string|null $label, callable $dataSource, ?int $maxLength = null)
    {
        parent::__construct($label, $maxLength);
        $this->dataSource = $dataSource;
        $this->setHtmlAttribute('data-autocomplete-query-placeholder', self::QUERY_PLACEHOLDER);
        $this->monitor(
            Presenter::class,
            function (Presenter $presenter): void {
                $uidPrefix = $this->getUniqueId() . self::NAME_SEPARATOR;
                $signal = $uidPrefix . self::AUTOCOMPLETE_SIGNAL . '!';
                $arguments = [$uidPrefix . self::QUERY_PARAMETER => self::QUERY_PLACEHOLDER];
                $autocompleteUrl = $presenter->link($signal, $arguments);
                $this->setHtmlAttribute('data-autocomplete-url', $autocompleteUrl);
            },
        );
    }

    public function setAutocompleteMinLength(int $minLength): void
    {
        $this->setHtmlAttribute('data-autocomplete-min-length', $minLength);
    }

    /**
     * @throws BadSignalException
     */
    public function signalReceived(string $signal): void
    {
        if ($signal !== self::AUTOCOMPLETE_SIGNAL) {
            $class = static::class;
            throw new BadSignalException("Missing handler for signal '$signal' in $class.");
        }

        $presenter = $this->getPresenter();

        $query = $presenter->popGlobalParameters($this->getUniqueId())[self::QUERY_PARAMETER] ?? null;
        if ($query === null) {
            $class = static::class;
            throw new BadSignalException("Missing query parameter for '$signal' in $class.");
        }

        $data = call_user_func($this->dataSource, $query);
        $presenter->sendJson($data);
    }

    private function getPresenter(): Presenter
    {
        $presenter = $this->lookup(Presenter::class, true);
        assert($presenter instanceof Presenter);
        return $presenter;
    }

    private function getUniqueId(): string
    {
        return $this->lookupPath(Presenter::class, true);
    }

}
