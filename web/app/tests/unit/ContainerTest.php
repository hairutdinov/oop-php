<?php

namespace AppTest\unit;

use App\Container;
use Exception;
use stdClass;

class ContainerTest extends \PHPUnit\Framework\TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
        parent::setUp();
    }

    public function testGettingUnknownComponentThrowsException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Неизвестный компонент: test');
        $this->container->get('test');
    }

    public function testGettingComponent()
    {
        $this->container->set('test', function (Container $container) {
            return new StdClass();
        });
        $firstInstance = $this->container->get('test');
        $this->assertInstanceOf(StdClass::class, $firstInstance);
        $secondInstance = $this->container->get('test');
        $this->assertNotSame($firstInstance, $secondInstance);
    }

    public function testGettingSharedComponent()
    {
        $this->container->setShared('test', function (Container $container) {
            return new StdClass();
        });
        $component = $this->container->get('test');
        $this->assertInstanceOf(StdClass::class, $component);
        $this->assertSame($component, $this->container->get('test'));
    }
}