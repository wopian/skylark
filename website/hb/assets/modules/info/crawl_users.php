<?php

    # Database connection
    $dbhost     = "localhost";
    $dbname     = "bobstudi_hummingbird";
    $dbuser     = "bobstudi_humming";
    $dbpass     = "music195";
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);

    # Setup default values
    $users = array();

    $sql = "SELECT `name` FROM `users` ORDER BY `crawled` ASC LIMIT 5";
    $q = $conn->query($sql);
    while($r = $q->fetch()) {
        $users[] = $r['name'];
        #print_r($r);
    }
    #print_r($users);

    foreach($users as $usr) {
        $name = $usr;
        echo "$usr --- $name";

        $sql = "UPDATE `users` SET `crawled` + 1 WHERE `name` = :name";
        $q = $conn->prepare($sql);
        $q->execute(array(':name'=>$name));

        $total = 0;
        for ($x=1; $x<=1000; $x++) {
            $url = "https://hummingbird.me/users?followers_of=$user&pages=$x";
            $json = file_get_contents($url);
            $data = json_decode($json, true);

            if (!empty($data['users'][0])) {
                $count = count($data['users'])-1;
                $total .= $count;

                for ($y=0; $y<=$count; $y++) {
                    $names = strtolower($data['users'][$y]['id']);
                    echo $names;
                    $sql = "INSERT INTO `users` (`name`) VALUES (:names) ON DUPLICATE KEY UPDATE `name` = :names";
                    $q = $conn->prepare($sql);
                    $q->execute(array(':names'=>$names));
                }
            } else {
                break;
            }
        }

        echo "Added $total users from $name<br>";
    }
