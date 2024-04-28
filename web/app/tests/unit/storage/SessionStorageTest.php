<?php

namespace AppTest\storage;

use App\CartItem;
use App\storage\SessionStorage;
use PHPUnit\Framework\TestCase;

class SessionStorageTest extends TestCase
{
    private SessionStorage $storage;
    private string $sessionKey;

    protected function setUp(): void
    {
        $this->sessionKey = 'sessionStorageTest';
        $this->storage = new SessionStorage($this->sessionKey);
    }

    protected function tearDown(): void
    {
        unset($_SESSION[$this->sessionKey]);
    }

    public function testLoadEmptyList()
    {
        $items = $this->storage->load();
        $this->assertCount(0, $items);
    }

    public function testLoad()
    {
        $item1 = new CartItem(1, 2, 300);
        $item2 = new CartItem(2, 1, 100);
        $_SESSION[$this->sessionKey] = serialize([$item1, $item2]);
        $items = $this->storage->load();
        $this->assertCount(2, $items);
        $this->assertEquals(600, $items[1]->getCost());
        $this->assertEquals(100, $items[2]->getCost());
    }

    public function testSave()
    {
        $item1 = new CartItem(1, 2, 300);
        $item2 = new CartItem(2, 1, 100);
        $this->storage->save([$item1, $item2]);
        $items = unserialize($_SESSION[$this->sessionKey]);
        $this->assertCount(2, $items);
        $this->assertEquals(600, $items[0]->getCost());
        $this->assertEquals(100, $items[1]->getCost());
    }
}