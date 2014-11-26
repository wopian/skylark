<?php

    $uid = 1;

    setcookie('uid',$uid,time()+(86400*365));

    echo "Cookie OK: $_COOKIE['uid'].";
