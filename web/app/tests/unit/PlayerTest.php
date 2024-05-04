<?php

namespace AppTest\unit;

use App\Disk;
use App\Player;
use App\PlayerState;
use App\Track;
use App\TriggerEvent;

class PlayerTest extends \PHPUnit\Framework\TestCase
{
    public function testInitializing()
    {
        $player = new Player();
        $this->assertEquals(PlayerState::OFF, $player->getState());
        $this->assertNull($player->getCurrentTrack());
        $this->assertEquals(5, $player->getVolume());
    }

    public function testPlayerOn()
    {
        $player = new Player();
        $player->on();
        $this->assertEquals(PlayerState::ON, $player->getState());
    }

    public function testPlayerOnThrowsExceptionWhileAlreadyOn()
    {
        $player = new Player();
        $player->on();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Плеер уже включен');
        $player->on();
    }

    public function testPlayerOff()
    {
        $player = new Player();
        $player->on();
        $player->off();
        $this->assertEquals(PlayerState::OFF, $player->getState());
    }

    public function testPlayerOffThrowsExceptionWhileAlreadyOff()
    {
        $player = new Player();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Плеер уже выключен');
        $player->off();
    }

    public function testInsertDisk()
    {
        $tracks = [];
        foreach (range(0, 4) as $i) {
            $tracks[] = new Track('Petr Petrov', 'Song #' . $i);
        }
        $disk = new Disk($tracks);
        $player = new Player();
        $player->on();
        $player->insertDisk($disk);
        $this->assertNull($player->getCurrentTrack());
        $player->play();
        $this->assertEquals(PlayerState::PLAY, $player->getState());
        $this->assertEquals($tracks[0], $player->getCurrentTrack());
    }

    public function testInsertDiskThrowsPlayerIsOffException()
    {
        $tracks = [];
        foreach (range(0, 4) as $i) {
            $tracks[] = new Track('Petr Petrov', 'Song #' . $i);
        }
        $disk = new Disk($tracks);
        $player = new Player();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Включите плеер');
        $player->insertDisk($disk);
    }
    
    public function testPlay()
    {
        $tracks = [];
        foreach (range(0, 4) as $i) {
            $tracks[] = new Track('Petr Petrov', 'Song #' . $i);
        }
        $disk = new Disk($tracks);
        $player = new Player();
        $player->on();
        $player->insertDisk($disk);
        $player->play();
        $this->assertEquals(PlayerState::PLAY, $player->getState());
        $this->assertEquals($tracks[0], $player->getCurrentTrack());
    }

    public function testPlayThrowsDiskNotInsertedException()
    {
        $player = new Player();
        $player->on();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Вставьте диск');
        $player->play();
    }

    public function testStop()
    {
        $disk = new Disk([new Track('Petr Petrov', 'Song')]);
        $player = new Player();
        $player->on();
        $player->insertDisk($disk);
        $player->play();
        $player->stop();
        $this->assertEquals(PlayerState::STOP, $player->getState());
    }

    public function testNext()
    {
        $tracks = [];
        foreach (range(0, 1) as $i) {
            $tracks[] = new Track('Petr Petrov', 'Song #' . $i);
        }
        $disk = new Disk($tracks);
        $player = new Player();
        $player->addEvent(TriggerEvent::ON_DISK_COMPLETE, function () {
            echo 'Диск завершен' . PHP_EOL;
        });
        $player->addEvent(TriggerEvent::ON_DISK_COMPLETE, function () {
            echo 'Второе событие диск завершен' . PHP_EOL;
        });
        $player->on();
        $player->insertDisk($disk);
        $player->play();
        $this->assertEquals($tracks[0], $player->getCurrentTrack());
        $player->next();
        $this->assertEquals($tracks[1], $player->getCurrentTrack());
        $this->expectOutputString("Диск завершен
Второе событие диск завершен
Диск завершен
Второе событие диск завершен
");
        $player->next();
        $player->next();
        $this->assertEquals($tracks[1], $player->getCurrentTrack());
    }

    public function testNextThrowsPlayerIsNotPlayingException()
    {
        $player = new Player();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Нажмите Play');
        $player->next();
    }

    public function testPrev()
    {
        $tracks = [];
        foreach (range(0, 4) as $i) {
            $tracks[] = new Track('Petr Petrov', 'Song #' . $i);
        }
        $disk = new Disk($tracks);
        $player = new Player();
        $player->on();
        $player->insertDisk($disk);
        $player->play();
        $player->next();
        $player->next();
        $this->assertEquals($tracks[2], $player->getCurrentTrack());
        $player->prev();
        $this->assertEquals($tracks[1], $player->getCurrentTrack());
        $player->prev();
        $this->assertEquals($tracks[0], $player->getCurrentTrack());
        $player->prev();
        $this->assertEquals($tracks[0], $player->getCurrentTrack());
    }

    public function testPrevThrowsPlayerIsNotPlayingException()
    {
        $player = new Player();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Нажмите Play');
        $player->prev();
    }

    public function testSetVolume()
    {
        $disk = new Disk([new Track('Petr Petrov', 'Song')]);
        $player = new Player();
        $player->on();
        $player->insertDisk($disk);
        $this->assertEquals(5, $player->getVolume());
        $player->setVolume(0);
        $this->assertEquals(0, $player->getVolume());
        $player->setVolume(10);
        $this->assertEquals(10, $player->getVolume());
        $player->setVolume(-1);
        $this->assertEquals(10, $player->getVolume());
        $player->setVolume(11);
        $this->assertEquals(10, $player->getVolume());
    }

    public function testDiskWithNoTracks()
    {
        $disk = new Disk([]);
        $player = new Player();
        $player->on();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Диск пустой');
        $player->insertDisk($disk);
    }

    public function testOnPlayStart()
    {
        $tracks = [];
        foreach (range(0, 2) as $i) {
            $tracks[] = new Track('Petr Petrov', 'Song #' . $i);
        }
        $disk = new Disk($tracks);
        $player = new Player();
        $player->addEvent(TriggerEvent::ON_PLAY, function () {
            echo 'Плеер играет' . PHP_EOL;
        });
        $player->addEvent(TriggerEvent::ON_PLAY, function (Player $player) {
            echo 'Трек: ' . $player->getCurrentTrack() . PHP_EOL;
        });
        $player->on();
        $player->insertDisk($disk);
        $this->expectOutputString('Плеер играет
Трек: Petr Petrov - Song #0
Плеер играет
Трек: Petr Petrov - Song #1
Плеер играет
Трек: Petr Petrov - Song #2
');
        $player->play();
        $player->next();
        $player->next();
    }

    public function testAddingFewEvents()
    {
        $disk = new Disk([new Track('Petr Petrov', 'Song')]);
        $player = new Player();
        $player->addEvent(TriggerEvent::ON_PLAY, function () {
            echo 'Плеер играет' . PHP_EOL;
        });
        $player->addEvent(TriggerEvent::AFTER_DISK_INSERTED, function () {
            echo 'Диск вставлен' . PHP_EOL;
        });
        $player->addEvent(TriggerEvent::ON_DISK_COMPLETE, function () {
            echo 'Диск завершен' . PHP_EOL;
        });
        $player->on();
        $player->insertDisk($disk);
        $this->expectOutputString("Диск вставлен
Плеер играет
Диск завершен
");
        $player->play();
        $player->next();
    }

    public function testRemovingEvent()
    {
        $tracks = [];
        foreach (range(0, 4) as $i) {
            $tracks[] = new Track('Petr Petrov', 'Song #' . $i);
        }
        $disk = new Disk($tracks);
        $player = new Player();
        $onPlayNext = function () {
            echo 'Переключение трека' . PHP_EOL;
        };
        $player->addEvent(TriggerEvent::BEFORE_PLAY_NEXT, $onPlayNext);
        $player->on();
        $player->insertDisk($disk);
        $this->expectOutputString("Переключение трека\n");
        $player->play();
        $player->next();
        $player->removeEvent(TriggerEvent::BEFORE_PLAY_NEXT, $onPlayNext);
        $player->next();
        $player->next();
    }
}