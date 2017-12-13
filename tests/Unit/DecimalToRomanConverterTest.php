<?php
/**
 * @copyright 2017
 * @author Stefan "eFrane" Graupner <stefan.graupner@gmail.com>
 */

namespace Tests\Unit;

use EFrane\BaseX\DecimalToRomanConverter;
use Tests\TestCase;

class DecimalToRomanConverterTest extends TestCase
{
    /**
     * @var DecimalToRomanConverter
     */
    protected $sut = null;

    public function setUp()
    {
        $this->sut = new DecimalToRomanConverter();
    }

    /**
     * @dataProvider valid
     */
    public function testConvertValid($input, $output)
    {
        $this->assertEquals($output, $this->sut->convert($input));
    }

    public function valid()
    {
        return [
            [1, 'I'],
            [2, 'II'],
            [4, 'IV'],
            [9, 'IX'],
            [10, 'X'],
            [12, 'XII'],
            [7, 'VII'],
            [55, 'LV'],
            [155, 'CLV'],
            [2017, 'MMXVII'],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider invalid
     */
    public function testConvertInvalid($value)
    {
        $this->sut->convert($value);
    }

    public function invalid()
    {
        return [
            [2.5],
            ['xlvii'],
            [false],
        ];
    }
}