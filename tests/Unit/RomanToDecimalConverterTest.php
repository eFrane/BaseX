<?php
/**
 * @copyright 2017
 * @author Stefan "eFrane" Graupner <stefan.graupner@gmail.com>
 */

namespace Tests\Unit;

use EFrane\BaseX\RomanToDecimalConverter;
use Tests\TestCase;

class RomanToDecimalConverterTest extends TestCase
{
    /**
     * @var RomanToDecimalConverter
     */
    protected $sut = null;

    public function setUp()
    {
        $this->sut = new RomanToDecimalConverter();
    }

    /**
     * @dataProvider valid
     * @param $input
     * @param $output
     */
    public function testConvertValid($input, $output)
    {
        $this->assertEquals($output, $this->sut->convert($input));
    }

    public function valid()
    {
        return [
            ['I', 1],
            ['II', 2],
            ['IV', 4],
            ['IX', 9],
            ['X', 10],
            ['XII', 12],
            ['VII', 7],
            ['CLV', 155],
            ['MMXVII', 2017],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider invalid
     * @param $value
     */
    public function testConvertInvalid($value)
    {
        $this->sut->convert($value);
    }

    public function invalid()
    {
        return [
            [1],
            [false],
            [true],
            [2.5],
            ['Xabc'],
            ['VIM'],
        ];
    }
}