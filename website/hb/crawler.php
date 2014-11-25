<?php

    $db = new mysqli('localhost', 'bobstudi_humming', 'music195', 'bobstudi_hummingbird');
    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $sql = "SELECT COUNT(*) FROM `users`";
    if(!$result = $db->query($sql)){
        die('There was an error running the query [' . $db->error . ']');
    }

    $a = mysqli_fetch_row($result)[0];

    $sql = "SELECT COUNT(*) FROM `users` WHERE `crawled` = 0";
    if(!$result = $db->query($sql)){
        die('There was an error running the query [' . $db->error . ']');
    }

    $b = mysqli_fetch_row($result)[0];

    echo "$b of $a users processed.";
