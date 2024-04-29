<?php

namespace AppTest\unit;

use App\calculator\SimpleCost;
use App\Cart;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    private Cart $cart;

    protected function setUp(): void
    {
        $this->cart = new Cart(new MemoryStorage(), new SimpleCost());
    }

    public function testCreatingInstance()
    {
        $this->assertEquals([], $this->cart->getItems());
        $this->assertCount(0, $this->cart->getItems());
    }

    public function testGettingItems()
    {
        $this->cart->add(1, 2, 100);
        $this->cart->add(2, 3, 100);
        $this->assertCount(2, $this->cart->getItems());
        $this->assertEquals(200, $this->cart->getItems()[1]->getCost());
        $this->assertEquals(300, $this->cart->getItems()[2]->getCost());
    }

    public function testAddingItem()
    {
        $this->cart->add(1, 2, 100);
        $this->assertEquals(200, $this->cart->getItems()[1]->getCost());
        $this->assertCount(1, $this->cart->getItems());
        $this->cart->add(1, 3, 100);
        $this->assertEquals(500, $this->cart->getItems()[1]->getCost());
        $this->assertCount(1, $this->cart->getItems());
    }

    public function testRemovingItem()
    {
        $this->cart->add(1, 2, 100);
        $this->cart->add(2, 3, 100);
        $this->cart->remove(1);
        $this->assertEquals(300, $this->cart->getItems()[2]->getCost());
        $this->assertCount(1, $this->cart->getItems());
    }

    public function testClearingCart()
    {
        $this->cart->add(1, 2, 100);
        $this->cart->add(2, 3, 100);
        $this->cart->clear();
        $this->assertEquals([], $this->cart->getItems());
        $this->assertCount(0, $this->cart->getItems());
    }

    public function testGetCost()
    {
        $this->cart->add(1, 2, 100);
        $this->cart->add(2, 3, 100);
        $this->assertEquals(500, $this->cart->getCost());
    }
}