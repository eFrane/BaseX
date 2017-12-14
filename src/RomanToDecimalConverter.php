<?php
/**
 * @copyright 2017
 * @author Stefan "eFrane" Graupner <stefan.graupner@gmail.com>
 * @license MIT
 */

namespace EFrane\BaseX;


class RomanToDecimalConverter implements ConverterInterface
{
    const ALLOWED_NEXT = [
        'M' => ['M', 'D', 'C', 'L', 'X', 'V', 'I'],
        'D' => ['C'],
        'C' => ['M', 'D', 'C', 'L', 'X', 'V', 'I'],
        'L' => ['X'],
        'X' => ['C', 'L', 'X', 'V', 'I'],
        'V' => ['I'],
        'I' => ['X', 'V', 'I']
    ];

    const SUBTRACTIVE_DIGITS = ['C', 'X', 'I'];

    const LOOKAHEAD_DIGITS = [
        'C' => ['D', 'M'],
        'X' => ['L', 'C'],
        'I' => ['V', 'X'],
    ];

    public function convert($digits)
    {
        if (!is_string($digits)) {
            throw new \InvalidArgumentException('Did you mean to use DecimalToRomanConverter?');
        }

        $digits = strtoupper($digits);
        $convertedValue = 0;

        $numDigits = strlen($digits);
        for ($i = 0; $i < $numDigits; $i++) {
            $digit = $digits[$i];

            if (!in_array($digit, explode(';', 'I;V;X;L;C;D;M'))) {
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
            if (in_array($digit, self::SUBTRACTIVE_DIGITS) &&
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