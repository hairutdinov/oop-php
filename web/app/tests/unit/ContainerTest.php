<?php

namespace AppTest\unit;

use App\Container;
use Exception;

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
            return 1;
        });
        $this->assertEquals(1, $this->container->get('test'));
    }
}