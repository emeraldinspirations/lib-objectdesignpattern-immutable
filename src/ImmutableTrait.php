<?php

/**
 * Container for Immutable trait
 *
 * PHP Version 7
 *
 * @category  Library
 * @package   Lib-objectdesignpattern-immutable
 * @author    Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @copyright 2017 Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @license   MIT ../LICENSE.md
 * @link      https://github.com/emeraldinspirations/lib-objectdesignpattern-immutable
 */

namespace emeraldinspirations\library\objectDesignPattern\immutable;

/**
 * Immutable trait
 *
 * @category  Library
 * @package   Lib-objectdesignpattern-immutable
 * @author    Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @copyright 2017 Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @license   MIT ../LICENSE.md
 * @version   GIT: $Id$ In Development.
 * @link      https://github.com/emeraldinspirations/lib-objectdesignpattern-immutable
 */
trait ImmutableTrait
{

    /**
     * Remove "with" from function name, return as property name
     *
     * @param string $WithFunction Function name
     *
     * @return string Property Name
     */
    static function getPropertyFromFunctionName(string $WithFunction) : string
    {
        return substr($WithFunction, 4);
    }

    /**
     * Clone the object and set the value per the with... function name
     *
     * @param string $WithFunction The name of the with... function
     * @param mixed  $Value        The value to set
     *
     * @return object Cloned and updated object
     */
    public function with(
        string $WithFunction,
        $Value
    ) : self {

        $PropertyName
            = self::getPropertyFromFunctionName($WithFunction);

        $Return                = clone $this;
        $Return->$PropertyName = $Value;

        return $Return;
    }

    /**
     * Clone specified properties as neccessary
     *
     * Pass an array of references to the properties in the immutable class
     * that need to be cloned.  If the property is set to an array it will be
     * iterated recursively to verify all objects that are contained are cloned.
     *
     * @param array $Array Array to be cloned
     *
     * @return void
     */
    static function cloneArrayRecursively(array &$Array)
    {

        foreach ($Array as &$Value) {
            if (is_array($Value)) {
                self::cloneArrayRecursively($Value);
            } elseif (is_object($Value)) {
                $Value = clone $Value;
            }
            // If non-object and non-array then no cloning is neccessary
        }

    }

    /**
     * Throw exception if setting property externally is attempted
     *
     * This function does violate the Liskov substitution principle.  However
     * this is neccessary as PHP 7 does not yet have a Read Only object type.
     *
     * @param string $Name  The name of the property to set
     * @param mixed  $Value The value to set the property to
     *
     * @throws \BadFunctionCallException Object is immutable
     *
     * @see https://en.wikipedia.org/wiki/Liskov_substitution_principle
     *        Liskov Substitution Principle
     *
     * @return void
     */
    public function __set(string $Name, $Value)
    {
        throw new \BadFunctionCallException(
            'Unable to set property in immutable object',
            1504012134
        );
    }

    /**
     * Throw exception if unsetting property externally is attempted
     *
     * This function does violate the Liskov substitution principle.  However
     * this is neccessary as PHP 7 does not yet have a Read Only object type.
     *
     * @param string $Name The name of the property to unset
     *
     * @throws \BadFunctionCallException Object is immutable
     *
     * @see https://en.wikipedia.org/wiki/Liskov_substitution_principle
     *        Liskov Substitution Principle
     *
     * @return void
     */
    public function __unset(string $Name)
    {
        throw new \BadFunctionCallException(
            'Unable to unset property in immutable object',
            1504013024
        );
    }

}
