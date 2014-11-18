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

    function loadUsers($user = 'wopian', $n) {
        $url = "https://hummingbird.me/users?followers_of=$user&page=$n";
        $json = file_get_contents($url);
        $followers = json_decode($json, true);

        $url = "https://hummingbird.me/users?followed_by=$user&page=$n";
        $json = file_get_contents($url);
        $following = json_decode($json, true);

        return array_merge($followers, $following);
    }

    $data = array();

    for ($x=1; $x<10; $x++) {
        $data = array_merge($data,loadUsers($x));
    }
    $count = count($data['users'])-1;
    echo "Rows: $rows <br>Users: $count";

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
