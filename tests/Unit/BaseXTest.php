<?php
/**
 * @copyright 2017
 * @author Stefan "eFrane" Graupner <stefan.graupner@gmail.com>
 */

namespace Tests\Unit;

use EFrane\BaseX\BaseX;
use Tests\TestCase;

class BaseXTest extends TestCase
{
    public function testToDecimal()
    {
        $this->assertEquals(1, BaseX::toDecimal('I'));
    }
    
    public function testToRoman()
    {
        $this->assertEquals('I', BaseX::toRoman(1));
        $this->assertEquals('XVI', BaseX::toRoman('10', 16));
    }
}