![emeraldinspirations logo](http://vps56132.vps.ovh.ca/logo.gitHub.png)

# lib-objectdesignpattern-immutable
> An [object design pattern](https://github.com/emeraldinspirations/lib-objectdesignpattern) support class in [emeraldinspiration](https://github.com/emeraldinspirations)'s library.

Functions that are common in immutable objects

# Example

```php
<?php

use emeraldinspirations\library\objectDesignPattern\immutable\Immutable;

class ExampleImmutableObject
{

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
        return Immutable::withGeneric($this, __FUNCTION__, $Property);
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
        ];

        Immutable::cloneArrayRecursively($PropertiesToByCloned);

    }

}
```


# Contributing

If you'd like to contribute, please fork the repository and use a feature branch.

I am also open to feedback about how well I am being compliant with standards and "best practices." I have written software solo for years, and am trying to learn how to work better with others.

# Licensing

The code in this project is licensed under [MIT license](./LICENSE).
