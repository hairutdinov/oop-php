<?php

namespace App;

enum PlayerState: int
{
    case ON = 1;
    case OFF = 0;
    case PLAY = 2;
    case STOP = 3;
}