<?php
/**
 * @copyright 2017
 * @author Stefan "eFrane" Graupner <stefan.graupner@gmail.com>
 * @license MIT
 */

namespace EFrane\BaseX;

/**
 * RomanToDecimalConverter
 *
 * Convert roman numerals to decimal numbers.
 *
 * @package EFrane\BaseX
 */
class RomanToDecimalConverter implements ConverterInterface
{
    /**
     * Lookup table for allowed next digits of a digit
     *
     * @const array
     */
    const ALLOWED_NEXT = [
        'M' => ['M', 'D', 'C', 'L', 'X', 'V', 'I'], // Note how M contains all other symbols...
        'D' => ['C', 'L', 'X', 'V', 'I'],
        'C' => ['M', 'D', 'C', 'L', 'X', 'V', 'I'],
        'L' => ['X', 'V', 'I'],
        'X' => ['C', 'L', 'X', 'V', 'I'],
        'V' => ['I'],
        'I' => ['X', 'V', 'I']
    ];

    /**
     * Lookup table for when to subtract
     *
     * @const array
     */
    const LOOKAHEAD_DIGITS = [
        'C' => ['D', 'M'],
        'X' => ['L', 'C'],
        'I' => ['V', 'X'],
    ];

    /**
     * Convert a roman numeral into it's decimal form
     *
     * @param $digits
     * @return int
     * @throws \OutOfBoundsException if the resulting int is larger than PHP_INT_MAX
     * @throws \InvalidArgumentException for invalid roman numbers
     */
    public function convert($digits)
    {
        if (!is_string($digits)) {
            throw new \InvalidArgumentException('Invalid roman number');
        }

        $digits = strtoupper($digits);
        $convertedValue = 0;

        $numDigits = strlen($digits);
        for ($i = 0; $i < $numDigits; $i++) {
            $digit = $digits[$i];

            if (!in_array($digit, self::ALLOWED_NEXT['M'])) {
                throw new \InvalidArgumentException('Invalid roman number');
            }

            $nextDigit = null;
            if ($numDigits > $i + 1) {
                $nextDigit = $digits[$i + 1];
            }

            if (!is_null($nextDigit) && !in_array($nextDigit, self::ALLOWED_NEXT[$digit])) {
                throw new \InvalidArgumentException('Invalid roman number');
            }

            $signMultiplicator = 1;
            if (in_array($digit, array_keys(self::LOOKAHEAD_DIGITS)) &&
                !is_null($nextDigit) && in_array($nextDigit, self::LOOKAHEAD_DIGITS[$digit])
            ) {
                $signMultiplicator = -1;
            }

            $valueToAdd = 0;
            switch ($digit) {
                case 'M':
                    $valueToAdd += 1000;
                    break;
                case 'D':
                    $valueToAdd += 500;
                    break;
                case 'C':
                    $valueToAdd += 100;
                    break;
                case 'L':
                    $valueToAdd += 50;
                    break;
                case 'X':
                    $valueToAdd += 10;
                    break;
                case 'V':
                    $valueToAdd += 5;
                    break;
                case 'I':
                    $valueToAdd = 1;
                    break;
            }

            $convertedValue += $valueToAdd * $signMultiplicator;
        }

        return $convertedValue;
    }
}