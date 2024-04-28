<?php

namespace AppTest;

use App\Cart;
use App\CartItem;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    protected function tearDown(): void
    {
        $cart = new Cart();
        $cart->clear();
    }

    public function testCreatingInstance()
    {
        $cart = new Cart();
        $this->assertEquals([], $cart->getItems());
        $this->assertCount(0, $cart->getItems());
    }

    public function testGettingItems()
    {
        $cart = new Cart();
        $cart->add(1, 2, 100);
        $cart->add(2, 3, 100);
        $this->assertCount(2, $cart->getItems());
        $this->assertEquals(200, $cart->getItems()[1]->getCost());
        $this->assertEquals(300, $cart->getItems()[2]->getCost());
    }

    public function testAddingItem()
    {
        $cart = new Cart();
        $cart->add(1, 2, 100);
        $this->assertEquals(200, $cart->getItems()[1]->getCost());
        $this->assertCount(1, $cart->getItems());
        $cart->add(1, 3, 100);
        $this->assertEquals(500, $cart->getItems()[1]->getCost());
        $this->assertCount(1, $cart->getItems());
    }

    public function testRemovingItem()
    {
        $cart = new Cart();
        $cart->add(1, 2, 100);
        $cart->add(2, 3, 100);
        $cart->remove(1);
        $this->assertEquals(300, $cart->getItems()[2]->getCost());
        $this->assertCount(1, $cart->getItems());
    }

    public function testClearingCart()
    {
        $cart = new Cart();
        $cart->add(1, 2, 100);
        $cart->add(2, 3, 100);
        $cart->clear();
        $this->assertEquals([], $cart->getItems());
        $this->assertCount(0, $cart->getItems());
    }

    public function testGetCost()
    {
        $cart = new Cart();
        $cart->add(1, 2, 100);
        $cart->add(2, 3, 100);
        $this->assertEquals(500, $cart->getCost());
    }
}