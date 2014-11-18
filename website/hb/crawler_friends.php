<?php

    $db = new mysqli('localhost', 'bobstudi_humming', 'music195', 'bobstudi_hummingbird');
    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $sql = "SELECT `id`, `name` FROM `users` ORDER BY `id`";
    if(!$result = $db->query($sql)){
        die('There was an error running the query [' . $db->error . ']');
    }
    $rows = mysqli_num_rows($result);

    $user = 'wopian';

    $url = "https://hummingbird.me/users?followers_of=$user&page=1";
    $json = file_get_contents($url);
    $data = json_decode($json, true);

    $count = count($data['users'])-1;
    echo "Rows: $rows <br>Users: $count";

    echo '<pre>';
    print_r($data);
    echo '</pre>';


    for ($x=0; $x<=$count; $x++) {
        echo $data['users'][$x]['id'];
    }

    /*foreach($data['users'] as $key => $value) {
        echo($value);
    }

    /* $sql = "REPLACE INTO `users` SET `name` = '".$name."'";
        if(!$result = $db->query($sql)){
            die('There was an error running the query [' . $db->error . ']');
        } */


    /*$name = strtolower($user_name);
    $db = new mysqli('localhost', 'bobstudi_humming', 'music195', 'bobstudi_hummingbird');

    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $sql = "INSERT INTO `users` (`name`) VALUES ('".$name."') ON DUPLICATE KEY UPDATE `name` = '".$name."'";


    if(!$result = $db->query($sql)){
        die('There was an error running the query [' . $db->error . ']');
    }
