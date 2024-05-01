<?php

namespace AppTest\unit;

use App\arrayAccess\PhoneCollection;
use PHPUnit\Framework\TestCase;

class ArrayAccessTest extends TestCase
{
    private PhoneCollection $phoneCollection;

    protected function setUp(): void
    {
        $this->phoneCollection = new PhoneCollection([1, 2, 3]);
    }

    public function testOffsetExistsMethod()
    {
        $this->assertTrue(isset($this->phoneCollection[0]));
        $this->assertFalse(isset($this->phoneCollection[3]));
    }

    public function testOffsetGetMethod()
    {
        $this->assertEquals(1, $this->phoneCollection[0]);
        $this->assertNull($this->phoneCollection[3]);
    }

    public function testOffsetSetMethod()
    {
        $this->phoneCollection[] = 4;
        $this->assertEquals(4, $this->phoneCollection[3]);
        $this->phoneCollection[4] = 5;
        $this->assertEquals(5, $this->phoneCollection[4]);
    }

    public function testOffsetUnsetMethod()
    {
        $this->assertEquals(1, $this->phoneCollection[0]);
        unset($this->phoneCollection[0]);
        $this->assertNull($this->phoneCollection[0]);
        unset($this->phoneCollection[10]);
    }
}