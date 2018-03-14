<?php
/**
 * @copyright 2017
 * @author Stefan "eFrane" Graupner <stefan.graupner@gmail.com>
 * @license MIT
 */

namespace EFrane\BaseX;

/**
 * BaseX - Quickly convert roman numerals to decimal numbers and back
 *
 * @package EFrane\BaseX
 */
class BaseX
{
    /**
     * Convert a decimal number to it's roman numeral representation
     *
     * @param int $int The decimal number
     * @param int $base Optional: Anything base_convert() understands
     * @return string The roman numeral
     */
    public static function toRoman($int, $base = 10)
    {
        if ($base == 10 && !is_int($int)) {
            throw new \InvalidArgumentException("Expected base {$base} integer");
        }

        if ($base != 10) {
            $int = intval(base_convert($int, $base, 10));
        }

        return (new DecimalToRomanConverter())->convert($int);
    }

    /**
     * Convert a roman numeral to it's decimal number representation
     *
     * @param string $string The roman numeral
     * @param int $base Optional: Anything base_convert() understands
     * @return string|int The decimal number
     */
    public static function toDecimal($string, $base = 10)
    {
        if (!is_string($string)) {
            throw new \InvalidArgumentException('Expected roman number literal');
        }

        $result = (new RomanToDecimalConverter())->convert($string);
        return ($base == 10) ? $result : base_convert($result, 10, $base);
    }
}
