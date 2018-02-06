<?php
/**
 * @copyright 2017
 * @author Stefan "eFrane" Graupner <stefan.graupner@gmail.com>
 * @license MIT
 */

namespace EFrane\BaseX;


/**
 * DecimalToRomanConverter
 *
 * Convert base 10 decimals to their roman numeral equivalent.
 *
 * @package EFrane\BaseX
 */
class DecimalToRomanConverter implements ConverterInterface
{
    /**
     * Convert a decimal number to a roman number
     *
     * @param $int
     * @return string
     * @throws InvalidNumberException
     */
    public function convert($int)
    {
        if (!is_int($int)) {
            throw InvalidNumberException::invalidDecimalNumber($int);
        }

        if ($int < 1) {
            throw InvalidNumberException::negativeDecimalNumber();
        }

        $number = '';

        if ($int >= 1000) {
            $thousands = floor($int / 1000);
            $number .= str_repeat('M', $thousands);
            $int -= 1000 * $thousands;
        }

        if ($int >= 100) {
            $hundreds = floor($int / 100);
            $number .= $this->formatSubtractiveLiteral($hundreds, 'C', 'D', 'M');
            $int -= 100 * $hundreds;
        }

        if ($int >= 10) {
            $tens = floor($int / 10);
            $number .= $this->formatSubtractiveLiteral($tens, 'X', 'L', 'C');
            $int -= 10 * $tens;
        }

        // ones
        $number .= $this->formatSubtractiveLiteral($int, 'I', 'V', 'X');

        return $number;
    }

    /**
     * Helper method to format a bounded section of a roman number
     *
     * Roman numbers consist of bounded sections which increase
     * logarithmically in size. Each section has markers for
     * it's beginning, middle and end which must be repeated
     * in a specific manner depending on how many tenths of the
     * section are to be written down.
     *
     * @param int $quotient
     * @param string $lowerLiteral
     * @param string $middleLiteral
     * @param string $upperLiteral
     * @return string
     */
    public function formatSubtractiveLiteral($quotient, $lowerLiteral, $middleLiteral, $upperLiteral)
    {
        $formatted = '';

        if ($quotient > 10) {
            throw InvalidNumberException::quotientRangeCheck();
        }

        if ($quotient == 10) {
            $formatted .= $upperLiteral;
        }

        if ($quotient == 9) {
            $formatted .= $lowerLiteral.$upperLiteral;
        }

        if ($quotient >= 5 && $quotient < 9) {
            $gap = $quotient - 5;
            $formatted .= $middleLiteral;
            $formatted .= str_repeat($lowerLiteral, $gap);
        }

        if ($quotient == 4) {
            $formatted .= $lowerLiteral.$middleLiteral;
        }

        if ($quotient < 4) {
            $formatted .= str_repeat($lowerLiteral, $quotient);
        }

        return $formatted;
    }
}