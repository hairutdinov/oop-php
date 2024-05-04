<?php

namespace App;

enum TriggerEvent
{
    case ON_PLAY;
    case ON_DISK_COMPLETE;
    case BEFORE_PLAY_NEXT;
    case AFTER_DISK_INSERTED;
}