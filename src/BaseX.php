<?php
/**
 * @copyright 2017
 * @author Stefan "eFrane" Graupner <stefan.graupner@gmail.com>
 * @license MIT
 */

namespace EFrane\BaseX;

class BaseX
{
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

    public static function toDecimal($string, $base = 10)
    {
        if (!is_string($string)) {
            throw new \InvalidArgumentException('Expected roman number literal');
        }

        return base_convert((new RomanToDecimalConverter())->convert($string), 10, $base);
    }
}