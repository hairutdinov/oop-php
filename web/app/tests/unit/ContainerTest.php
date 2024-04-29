<?php

namespace AppTest\unit;

use App\calculator\CalculatorInterface;
use App\Cart;
use App\Container;
use App\storage\StorageInterface;
use Exception;
use stdClass;

class A
{
    public function method()
    {
        return 'Class A method';
    }
}

class B
{
    private A $a;

    public function __construct(A $a)
    {
        $this->a = $a;
    }

    public function method()
    {
        return $this->a->method() . PHP_EOL . 'Class B method';
    }
}

class C
{
    private int $n;

    public function __construct(int $n)
    {
        $this->n = $n;
    }

    public function method()
    {
        return 'Class C method returns number: ' . $this->n;
    }
}

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

    public function testGettingComponentWithoutRegisteringIt()
    {
        /** @var A $component */
        $component = $this->container->get(A::class);
        $this->assertInstanceOf(A::class, $component);
        $this->assertEquals('Class A method', $component->method());
    }

    public function testGettingComponentAutoLoadedInConstructor()
    {
        $component = $this->container->get(B::class);
        $this->assertInstanceOf(B::class, $component);
        $this->assertEquals('Class A method' . PHP_EOL . 'Class B method', $component->method());
    }

    public function testGettingComponentById()
    {
        $this->container->set('class.a', A::class);
        $component = $this->container->get('class.a');
        $this->assertInstanceOf(A::class, $component);
        $this->assertEquals('Class A method', $component->method());
    }

    public function testRegisterBuiltInTypeIntAsComponent()
    {
        $this->container->set('int', function (){return 7;});
        $component = $this->container->get(C::class);
        $this->assertInstanceOf(C::class, $component);
        $this->assertEquals('Class C method returns number: 7', $component->method());
    }
}