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
     * @param $value
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

    /**
     * @dataProvider subtractiveLiterals
     * @param $result
     * @param $quotient
     * @param $lower
     * @param $middle
     * @param $upper
     */
    public function testFormatSubtractiveLiteral($result, $quotient, $lower, $middle, $upper)
    {
        $this->assertEquals($result, $this->sut->formatSubtractiveLiteral($quotient, $lower, $middle, $upper));
    }

    public function subtractiveLiterals()
    {
        return [
            ['I', 1, 'I', 'V', 'X'],
            ['II', 2, 'I', 'V', 'X'],
            ['IV', 4, 'I', 'V', 'X'],
            ['V', 5, 'I', 'V', 'X'],
            ['VI', 6, 'I', 'V', 'X'],
            ['VII', 7, 'I', 'V', 'X'],
            ['IX', 9, 'I', 'V', 'X'],
            ['X', 10, 'I', 'V', 'X'],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFormatSubtractiveLiteralFailsForTooLargeQuotient()
    {
        $this->sut->formatSubtractiveLiteral(11, '', '', '');
    }
}