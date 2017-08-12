<?php

/**
 * Container for unit tests for Vevent entity
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
 * Unit tests for Vevent entity
 *
 * @category  Library
 * @package   Lib-objectdesignpattern-immutable
 * @author    Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @copyright 2017 Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @license   MIT ../LICENSE.md
 * @version   GIT: $Id: f627306671268e7a24c3809def44b16abd93065a $ In Development.
 * @link      https://github.com/emeraldinspirations/lib-objectdesignpattern-immutable
 */
class Immutable
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
     * @param object  $ImmutableObject Object to clone and update
     * @param string  $WithFunction    The name of the with... function
     * @param various $Value           The value to set
     *
     * @return object Cloned and updated object
     */
    static function withGeneric(
        $ImmutableObject,
        string $WithFunction,
        $Value
    ) {

        $Return                = clone $ImmutableObject;
        $PropertyName          =
            self::getPropertyFromFunctionName($WithFunction);
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

}
