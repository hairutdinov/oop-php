<?php

namespace AppTest\unit;

use App\iterator\PhoneCollection;
use App\iterator\PhoneCollection2;

class PhoneCollectionTest extends \PHPUnit\Framework\TestCase
{
    public function testIteratingPhoneCollection()
    {
        $phones = ['79991020301', '79991020302', '79991020303'];
        $phoneCollection = new PhoneCollection($phones);
        $k = 0;
        foreach ($phoneCollection as $phone) {
            $this->assertEquals($phone, $phones[$k]);
            $k++;
        }
    }

    public function testIteratingPhoneCollection2()
    {
        $phones = ['79991020301', '79991020302', '79991020303'];
        $phoneCollection = new PhoneCollection2($phones);
        $k = 0;
        foreach ($phoneCollection as $phone) {
            $this->assertEquals($phone, $phones[$k]);
            $k++;
        }
    }
}