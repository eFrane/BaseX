<?php
/**
 * @copyright 2018
 * @author Stefan "eFrane" Graupner <stefan.graupner@gmail.com>
 */

namespace EFrane\BaseX;


/**
 * Class InvalidNumberException
 * @package EFrane\BaseX
 */
class InvalidNumberException extends \InvalidArgumentException
{
    /**
     * @param mixed $number
     * @return InvalidNumberException
     */
    public static function invalidRomanNumber($number)
    {
        return new self("Invalid roman number: {$number}.");
    }

    /**
     * @param mixed $number
     * @return InvalidNumberException
     */
    public static function invalidDecimalNumber($number)
    {
        return new self("Invalid decimal number: {$number}.");
    }

    /**
     * @return InvalidNumberException
     */
    public static function negativeDecimalNumber()
    {
        return new self('Decimal must be greater than 0');
    }

    /**
     * @return InvalidNumberException
     */
    public static function quotientRangeCheck()
    {
        return new self('Quotient for range check cannot exceed 10');
    }
}
