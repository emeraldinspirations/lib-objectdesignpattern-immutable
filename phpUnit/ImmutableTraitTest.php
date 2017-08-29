<?php

/**
 * Container for unit tests for Immutable trait
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
 * Unit tests for Immutable trait
 *
 * @category  Library
 * @package   Lib-objectdesignpattern-immutable
 * @author    Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @copyright 2017 Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @license   MIT ../LICENSE.md
 * @version   GIT: $Id$ In Development.
 * @link      https://github.com/emeraldinspirations/lib-objectdesignpattern-immutable
 */
class ImmutableTraitTest extends \PHPUnit_Framework_TestCase
{

    protected $Object;

    /**
     * Run before each test
     *
     * @return void
     */
    public function setUp()
    {

        $this->Object = new class() {
            use ImmutableTrait;

            protected $Property = [];

            /**
             * Return value of Property
             *
             * @return array
             */
            public function getProperty() : array
            {
                return $this->Property;
            }

            /**
             * Return if Property is set
             *
             * @return bool
             */
            public function hasProperty() : bool
            {
                return isset($this->Property);
            }

        };

    }

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
            ImmutableTrait::getPropertyFromFunctionName('with'.$PropertyName),
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

        $Key = 'Key' . microtime();

        $Value2 = 'Value' . microtime();

        $this->Object = $this->Object->with(
            'withProperty',
            [$Key => $Value2]
        );

        $Clone = $this->Object->without(
            'withoutProperty'
        );
        // Fails if function undefined

        $this->assertNotSame(
            $this->Object,
            $Clone,
            'Fails if object not cloned'
        );

        $this->assertFalse(
            $Clone->hasProperty(),
            'Fails if property not updated'
        );

        $this->assertTrue(
            $this->Object->hasProperty(),
            'Fails if old property updated'
        );

    }

    /**
     * Verify object cloned and property value changed
     *
     * @return void
     */
    public function testWithoutGeneric()
    {

        $Key = 'Key';

        $Value2 = 'Value';

        $Clone = $this->Object->with(
            'withProperty',
            [$Key => $Value2]
        );

        $this->assertNotSame(
            $this->Object,
            $Clone,
            'Fails if object not cloned'
        );

        $this->assertEquals(
            [$Key=>$Value2],
            $Clone->getProperty(),
            'Fails if property not updated'
        );

        $this->assertNotEquals(
            [$Key=>$Value2],
            $this->Object->getProperty(),
            'Fails if old property updated'
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

        ImmutableTrait::cloneArrayRecursively($ArrayCopy);

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

    /**
     * Verify __set magic method throws exception
     *
     * @expectedException     \BadFunctionCallException
     * @expectedExceptionCode 1504012134
     *
     * @return void
     */
    public function testSetMagicMethod()
    {
        $this->Object->UndefinedProperty = 'NewValue';
    }

    /**
     * Verify __unset magic method throws exception
     *
     * @expectedException     \BadFunctionCallException
     * @expectedExceptionCode 1504013024
     *
     * @return void
     */
    public function testUnsetMagicMethod()
    {
        unset($this->Object->UndefinedProperty);
    }

}
