<?php
/**
 * @copyright 2017
 * @author Stefan "eFrane" Graupner <stefan.graupner@gmail.com>
 * @license MIT
 */

namespace EFrane\BaseX;

/**
 * Interface ConverterInterface
 * @package EFrane\BaseX
 */
interface ConverterInterface {
    /**
     * @param $value
     * @return mixed
     */
    public function convert($value);
}