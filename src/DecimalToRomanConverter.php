<?php
/**
 * @copyright 2017
 * @author Stefan "eFrane" Graupner <stefan.graupner@gmail.com>
 * @license MIT
 */

namespace EFrane\BaseX;


class DecimalToRomanConverter implements ConverterInterface
{
    public function convert($int)
    {
        if (!is_int($int)) {
            throw new \InvalidArgumentException('Must provide decimal');
        }

        if ($int < 1) {
            throw new \InvalidArgumentException('Decimal must be greater than 0');
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

    public function formatSubtractiveLiteral($quotient, $lowerLiteral, $middleLiteral, $upperLiteral)
    {
        $formatted = '';

        if ($quotient > 9) {
            throw new \InvalidArgumentException("Quotient for range check cannot exceed 9");
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