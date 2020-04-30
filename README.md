Autocomplete text input
=======================

[![Build Status](https://travis-ci.org/nepada/autocomplete-input.svg?branch=master)](https://travis-ci.org/nepada/autocomplete-input)
[![Coverage Status](https://coveralls.io/repos/github/nepada/autocomplete-input/badge.svg?branch=master)](https://coveralls.io/github/nepada/autocomplete-input?branch=master)
[![Downloads this Month](https://img.shields.io/packagist/dm/nepada/autocomplete-input.svg)](https://packagist.org/packages/nepada/autocomplete-input)
[![Latest stable](https://img.shields.io/packagist/v/nepada/autocomplete-input.svg)](https://packagist.org/packages/nepada/autocomplete-input)


Installation
------------

Via Composer:

```sh
$ composer require nepada/autocomplete-input
```

### Option A: install form container extension method via DI extension

```yaml
extensions:
    - Nepada\Bridges\AutocompleteInputDI\AutocompleteInputExtension
```

It will register extension method `addAutocomplete($name, $label, callable $dataSource): AutocompleteInput` to `Nette\Forms\Container`.


### Option B: use trait in your base form/container class

You can also use `AutocompleteInputMixin` trait in your base form/container class to add method `addAutocomplete($name, $label, callable $dataSource): AutocompleteInput`.

Example:

```php

trait FormControls
{

    use Nepada\Bridges\AutocompleteInputForms\AutocompleteInputMixin;

    public function addContainer($name)
    {
        $control = new Container;
        $control->setCurrentGroup($this->getCurrentGroup());
        if ($this->currentGroup !== null) {
            $this->currentGroup->add($control);
        }
        return $this[$name] = $control;
    }

}

class Container extends Nette\Forms\Container
{

    use FormControls;

}

class Form extends Nette\Forms\Form
{

    use FormControls;

}

``` 


Usage
-----

`AutocompleteInput` is a standard text input from Nette enhanced with the autocomplete feature. The input exposes URL to retrieve the entries matching a specified query - you need to pass data source callback when creating the input:

```php
$autocompleteInput = $form->addAutocomplete('foo', 'Foo', function (string $query) {
    // return entries matching the query
});
$autocompleteInput->setAutocompleteMinLength(3); // set minimum input length to trigger autocomplete
```


### Client side

The backend form control is not tightly coupled to any specific client side implementation. The rendered input contains data attributes with all the necessary settings: 
```html
<input type="text" name="foo"
    data-autocomplete-query-placeholder="__QUERY_PLACEHOLDER__"
    data-autocomplete-url="/some-url/?do=form-foo-autocomplete&form-foo-query=__QUERY_PLACEHOLDER__"
    data-autocomplete-min-length="3"
>
<!--
    data-autocomplete-min-length is optional
-->
```

If you do not want to roll out your own client side solution, try [@nepada/autocomplete-input](https://yarnpkg.com/package/@nepada/autocomplete-input) npm package.
