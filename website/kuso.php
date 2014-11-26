<?php

    $uid = 1;

    setcookie('uid', $uid, time() + (86400 * 365));

    $cookie = $_COOKIE['uid'];

    echo "Cookie OK: $cookie.";
    echo "<br>";
    echo "Cookie OK: " . $_COOKIE['uid'] . ".";
