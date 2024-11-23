<?php

// example of debugging an iteration that uses a constant

const WELCOME = "Welcome to demo iteration number ";
$sample = "";

toIterate();

function toIterate() {
    for ($i = 0; $i < 10; $i++) {
        xdebug_break();
        $sample = WELCOME . $i . "!<br>";
        echo $sample;
    }
}
