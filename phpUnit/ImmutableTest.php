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
class ImmutableTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Verify property name returned when with... function name passed
     *
     * @return void
     */
    public function testGetPropertyFromFunctionName()
    {

        $PropertyName = microtime();
        $this->assertEquals(
            $PropertyName,
            Immutable::getPropertyFromFunctionName('with'.$PropertyName),
            'Fails if function doesn\'t exist or returns wrong value'
        );

    }

    /**
     * Verify object cloned and property value changed
     *
     * @return void
     */
    public function testWithGeneric()
    {
        $Key    = 'Key' . str_replace([' ', '.'], ['', ''], microtime());
        $Value1 = 'Value' . microtime();
        $Value2 = 'Value' . microtime();

        $GenericObject       = new \stdclass();
        $GenericObject->$Key = $Value1;

        $GenericClone = Immutable::withGeneric(
            $GenericObject,
            'with'.$Key,
            $Value2
        );

        $this->assertNotSame(
            $GenericObject,
            $GenericClone,
            'Fails if object not cloned'
        );

        $this->assertEquals(
            $Value2,
            $GenericClone->$Key,
            'Fails if property not updated'
        );

    }

    /**
     * Verify objects are cloned recursively
     *
     * @return void
     */
    public function testCloneArrayRecursively()
    {

        $Key = 'Key' . str_replace([' ', '.'], ['', ''], microtime());

        $Object1       = new \stdclass();
        $Value1        = 'Value' . microtime();
        $Object1->$Key = $Value1;

        $Object2       = new \stdclass();
        $Value2        = 'Value' . microtime();
        $Object2->$Key = $Value2;

        $OriginalArray = [
            $Key.'Level1'=>$Object1,
            $Key.'Value1'=>$Value1,
            $Key.'Array'=>[
                $Key.'Level2'=>$Object2,
                $Key.'Value2'=>$Value2,
            ]
        ];

        $ArrayCopy = $OriginalArray;

        Immutable::cloneArrayRecursively($ArrayCopy);

        $this->assertEquals(
            $OriginalArray,
            $ArrayCopy,
            'Fails if array modifies wrong parameters'
        );

        $this->assertNotSame(
            $OriginalArray[$Key.'Level1'],
            $ArrayCopy[$Key.'Level1'],
            'Fails if objects not cloned'
        );

        $this->assertNotSame(
            $OriginalArray[$Key.'Array'][$Key.'Level2'],
            $ArrayCopy[$Key.'Array'][$Key.'Level2'],
            'Fails if cloning isn\'t recursive'
        );

    }

}
