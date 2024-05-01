<?php
$arr = [1, 2, 3];

reset($arr);

while (!is_null($key = key($arr))) {
    echo $key . ' => ' . current($arr) . PHP_EOL;
    next($arr);
}