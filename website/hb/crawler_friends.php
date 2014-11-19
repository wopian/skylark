<?php

    $db = new mysqli('localhost', 'bobstudi_humming', 'music195', 'bobstudi_hummingbird');
    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $sql = "SELECT `id`, `name`, `crawled` FROM `users` ORDER BY `crawled` ASC LIMIT 1";
    if(!$result = $db->query($sql)){
        die('There was an error running the query [' . $db->error . ']');
    }
    #$rows = mysqli_num_rows($result);

    while ($row = mysqli_fetch_row($result)) {
        $user = $row[1];
    }
    #$user = 'wopian';

    $sql = "UPDATE `users` SET `crawled` = 1 WHERE `name` = '".$user."'";
    if(!$result = $db->query($sql)){
        die('There was an error running the query [' . $db->error . ']');
    }

    $total = 0;
    for ($x=1; $x<=20; $x++) {
        $url = "https://hummingbird.me/users?followers_of=$user&page=$x";
        $json = file_get_contents($url);
        $data = json_decode($json, true);

        if (!empty($data['users'][0])) {
            $count = count($data['users'])-1;
            $total = $total + $count;

            for ($y=0; $y<=$count; $y++) {
                $name = strtolower($data['users'][$y]['id']);
                $sql = "INSERT INTO `users` (`name`) VALUES ('".$name."') ON DUPLICATE KEY UPDATE `name` = '".$name."'";
                if(!$result = $db->query($sql)){
                    die('There was an error running the query [' . $db->error . ']');
                }
            }
        } else {
            break;
        }
    }
    echo "Added $total users from $user's followers.";
