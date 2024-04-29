<?php

namespace AppTest\integration;

use App\Cart;
use App\Container;
use AppTest\unit\MemoryStorage;
use Exception;

class ContainerTest extends \PHPUnit\Framework\TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
        parent::setUp();
    }

    public function testGettingCartComponent()
    {
        $this->container->set('cart.storage', function (Container $container) {
            return new MemoryStorage();
        });
        $this->container->set('cart.calculator', function (Container $container) {
            return new DummyCost(100);
        });
        $this->container->set('cart', function (Container $container) {
            return new Cart(
                $this->container->get('cart.storage'),
                $this->container->get('cart.calculator'),
            );
        });
        $this->assertInstanceOf(MemoryStorage::class, $this->container->get('cart.storage'));
        $this->assertInstanceOf(DummyCost::class, $this->container->get('cart.calculator'));
        $this->assertInstanceOf(Cart::class, $this->container->get('cart'));
    }
}