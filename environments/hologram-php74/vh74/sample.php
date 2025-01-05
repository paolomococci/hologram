<?php

for ($i = 0; $i < 10; $i++) {
    $show = $i . "<br>";
    echo $show;
    xdebug_break();
}
