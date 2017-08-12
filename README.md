![emeraldinspirations logo](http://vps56132.vps.ovh.ca/logo.gitHub.png)

# lib-objectdesignpattern-immutable
> An [object design pattern](https://github.com/emeraldinspirations/lib-objectdesignpattern) support class in [emeraldinspiration](https://github.com/emeraldinspirations)'s library.

Functions that are common in immutable objects

## Installing / Getting started

This project has no dependencies, so can be cloned directly from the [git repo](https://github.com/emeraldinspirations/lib-objectdesignpattern-immutable) or required with [Composer](https://getcomposer.org/).

## Require with Composer

```shell
composer require emeraldinspirations/lib-objectdesignpattern-immutable
```

## Example

```php
<?php

use emeraldinspirations\library\objectDesignPattern\immutable\ImmutableTrait;

class ExampleImmutableObject
{
    use ImmutableTrait;

    protected $Property;

    /**
     * Return value of Property
     *
     * @return \stdclass
     */
    public function getProperty() : \stdclass
    {
        return $this->Property;
    }

    /**
     * Create new instance with new Property value
     *
     * @param \stdclass $Property New value
     *
     * @return self
     */
    public function withProperty(\stdclass $Property) : self {
        return self::withGeneric(__FUNCTION__, $Property);
    }

    /**
     * Clone all specified properties are cloned as necessary
     *
     * @return void
     */
    public function __clone()
    {

        // Create an array of references to properties to clone
        $PropertiesToByCloned = [
            &$this->Property,
        //  ^ - IMPORTANT: Be sure to pass by reference
        ];

        ImmutableTrait::cloneArrayRecursively($PropertiesToByCloned);

    }

}
```


## Contributing

If you'd like to contribute, please fork the repository and use a feature branch.

I am also open to feedback about how well I am being compliant with standards and "best practices." I have written software solo for years, and am trying to learn how to work better with others.

## Licensing

The code in this project is licensed under [MIT license](./LICENSE).
