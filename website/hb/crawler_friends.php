<?php

    $db = new mysqli('localhost', 'bobstudi_humming', 'music195', 'bobstudi_hummingbird');
    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $sql = "SELECT `id`, `name` FROM `users` ORDER BY `id`";
    if(!$result = $db->query($sql)){
        die('There was an error running the query [' . $db->error . ']');
    }
    echo mysqli_num_rows($result);

    $user = 'wopian';
    $url = "https://hummingbird.me/users?followers_of=$user";
    $url2 = "https://hummingbird.me/users?followed_by=$user";
    $json = file_get_contents($url);
    $json2 = file_get_contents($url2);
    $data = json_decode($json, true);
    $data2 = json_decode($json2, true);

    $data = array_merge($data, $data2);

    echo '<pre>';
    print_r($data);
    echo '</pre>';

    /*$name = strtolower($user_name);
    $db = new mysqli('localhost', 'bobstudi_humming', 'music195', 'bobstudi_hummingbird');

    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $sql = "INSERT INTO `users` (`name`) VALUES ('".$name."') ON DUPLICATE KEY UPDATE `name` = '".$name."'";


    if(!$result = $db->query($sql)){
        die('There was an error running the query [' . $db->error . ']');
    }
