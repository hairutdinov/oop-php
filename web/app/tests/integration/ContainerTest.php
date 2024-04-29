<?php

namespace AppTest\integration;

use App\Cart;
use App\Container;
use AppTest\unit\MemoryStorage;

class ContainerTest extends \PHPUnit\Framework\TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
        $this->container->set('cart.storage', function (Container $container) {
            return new MemoryStorage();
        });
        $this->container->set('cart.calculator', function (Container $container) {
            return new DummyCost(100);
        });
        parent::setUp();
    }

    public function testGettingCartComponent()
    {
        $this->container->set('cart', function (Container $container) {
            return new Cart(
                $this->container->get('cart.storage'),
                $this->container->get('cart.calculator'),
            );
        });
        $this->assertInstanceOf(MemoryStorage::class, $this->container->get('cart.storage'));
        $this->assertInstanceOf(DummyCost::class, $this->container->get('cart.calculator'));
        $component = $this->container->get('cart');
        $this->assertInstanceOf(Cart::class, $component);
        $this->assertNotSame($component, $this->container->get('cart'));
    }

    public function testGettingSharedCartComponent()
    {
        $this->container->setShared('cart', function (Container $container) {
            return new Cart(
                $this->container->get('cart.storage'),
                $this->container->get('cart.calculator'),
            );
        });
        $this->assertInstanceOf(MemoryStorage::class, $this->container->get('cart.storage'));
        $this->assertInstanceOf(DummyCost::class, $this->container->get('cart.calculator'));
        $component = $this->container->get('cart');
        $this->assertInstanceOf(Cart::class, $component);
        $this->assertSame($component, $this->container->get('cart'));
    }
}