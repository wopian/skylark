<?php

    $db = new mysqli('localhost', 'bobstudi_humming', 'music195', 'bobstudi_hummingbird');
    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $users = array();

    $sql = "SELECT `id`, `name`, `crawled` FROM `users` WHERE `crawled` = 0 ORDER BY `name` ASC LIMIT 5";
    if(!$result = $db->query($sql)){
        die('There was an error running the query [' . $db->error . ']');
    }

    $users = array();
    while ($row = mysql_fetch_assoc($result)) {
        $users[] = $row['name'];
    }
    print_r($users);
    /*

    foreach($users as $user) {
        $sql = "UPDATE `users` SET `crawled` = 1 WHERE `name` = '".$user."'";
        if(!$result = $db->query($sql)){
            die('There was an error running the query [' . $db->error . ']');
        }

        $total = 0;
        for ($x=1; $x<=100; $x++) {
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
        echo "Added $total users from $user's followers.<br>";
    }
