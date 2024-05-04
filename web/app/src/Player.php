<?php

namespace App;

class Player
{
    const MIN_VOLUME = 0;
    const MAX_VOLUME = 10;
    const DEFAULT_VOLUME = 5;

    private ?Disk $disk;
    private ?Track $currentTrack = null;
    private int $volume;
    private PlayerState $state;
    private PlayerEventCollection $events;

    public function __construct()
    {
        $this->state = PlayerState::OFF;
        $this->setVolume(self::DEFAULT_VOLUME);
        $this->events = new PlayerEventCollection();
    }

    public function insertDisk(Disk $disk)
    {
        if ($this->state !== PlayerState::ON) {
            throw new \Exception('Включите плеер');
        }

        $this->disk = $disk;

        if (!$this->disk->valid()) {
            throw new \Exception('Диск пустой');
        }

        $this->events->trigger(TriggerEvent::AFTER_DISK_INSERTED, $this);
    }

    public function on()
    {
        if (!$this->isOff()) {
            throw new \Exception('Плеер уже включен');
        }
        $this->state = PlayerState::ON;
    }

    public function off()
    {
        if ($this->isOff()) {
            throw new \Exception('Плеер уже выключен');
        }
        $this->state = PlayerState::OFF;
    }

    public function play()
    {
        if (!$this->diskInserted()) {
            throw new \Exception('Вставьте диск');
        }

        if (empty($this->currentTrack)) {
            $this->currentTrack = $this->disk->current();
        }

        $this->state = PlayerState::PLAY;
        $this->events->trigger(TriggerEvent::ON_PLAY, $this);
    }

    public function stop()
    {
        $this->state = PlayerState::STOP;
    }

    public function next()
    {
        if ($this->state !== PlayerState::PLAY) {
            throw new \Exception('Нажмите Play');
        }

        $this->disk->next();
        if ($this->disk->valid()) {
            $this->events->trigger(TriggerEvent::BEFORE_PLAY_NEXT, $this);
            $this->stop();
            $this->currentTrack = $this->disk->current();
            $this->play();
        } else {
            $this->events->trigger(TriggerEvent::ON_DISK_COMPLETE, $this);
        }
    }

    public function prev()
    {
        if ($this->state !== PlayerState::PLAY) {
            throw new \Exception('Нажмите Play');
        }

        $this->disk->prev();
        if ($this->disk->valid()) {
            $this->stop();
            $this->currentTrack = $this->disk->current();
            $this->play();
        }
    }

    public function setVolume(int $volume)
    {
        if (self::MIN_VOLUME <= $volume && $volume <= self::MAX_VOLUME) {
            $this->volume = $volume;
        }
    }

    public function getVolume(): int
    {
        return $this->volume;
    }

    public function getState(): PlayerState
    {
        return $this->state;
    }

    public function getCurrentTrack(): ?Track
    {
        return $this->currentTrack;
    }

    public function diskInserted(): bool
    {
        return !empty($this->disk);
    }

    public function isOff(): bool
    {
        return $this->state == PlayerState::OFF;
    }

    public function addEvent(TriggerEvent $name, callable $callback): void
    {
        $this->events->add($name, $callback);
    }

    public function removeEvent(TriggerEvent $name, callable $callback): void
    {
        $this->events->remove($name, $callback);
    }
}