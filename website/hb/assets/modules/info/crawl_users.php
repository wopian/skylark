<?php

    # Database connection
    $dbhost     = "localhost";
    $dbname     = "bobstudi_hummingbird";
    $dbuser     = "bobstudi_humming";
    $dbpass     = "music195";
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass,array(PDO::ATTR_PERSISTENT => true));

    # Setup default values
    $users = array();

    $sql = "SELECT `name` FROM `users` ORDER BY `crawled` ASC LIMIT 5";
    $q = $conn->query($sql);
    while($r = $q->fetch()) {
        $users[] = $r['name']
        #print_r($r);
    }
    print_r($users);

    foreach($users as $usr) {
        $name = $usr['name'];

        $sql = "UPDATE `users`
                SET `crawled` + 1
                WHERE `name` = :name";
        $q = $conn->prepare($sql);
        $q->execute(array(':name'=>$name));

        $total = 0;
        for ($x=1, $x<=1000; $x++) {
            $url = "https://hummingbird.me/users?followers_of=$user&pages=$x";
            $json = file_get_contents($url);
            $data = json_decode($json, true);

            if (!empty($data['users'][0])) {
                $count = count($data['users'])-1;
                $total .= $count;

                for ($y=0; $y<=$count; $y++) {
                    $names = strtolower($data['users'][$y]['id']);
                    $sql = "INSERT INTO `users` (`name`)
                            VALUES (:name)
                            ON DUPLICATE KEY UPDATE `name` = :name";
                    $q = $conn->prepare($sql);
                    $q->execute(array(':name'=>$names));
                }
            } else {
                break;
            }
        }

        echo "Added $total users from $name<br>";
    }

/*
    try {

        #foreach($dbh->query('SELECT `id`, `name`, `crawled` FROM `users` ORDER BY `crawled` ASC LIMIT 1') as $row) {
        #    $user = $row[0];
        #}
        foreach($dbh->query('UPDATE `users` SET `crawled` = 1 WHERE `name` = $user') as $row) {
        }
        foreach($dbh->query('SELECT COUNT(*) FROM `users` WHERE `crawled` = 0') as $row) {
            $uncrawled = $row[0];
        }
        #echo '<pre>';
        #foreach($dbh->query('SELECT * from `users`') as $row) {
        #    print_r($row);
        #}
        $dbh = null;
        echo '</pre>';
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    $total = 0;
    for ($x=1; $x<=1000; $x++) {
        $url = "https://hummingbird.me/users?followers_of=$user&page=$x";
        $json = file_get_contents($url);
        $data = json_decode($json, true);

        if (!empty($data['users'][0])) {
            $count = count($data['users'])-1;
            $total = $total + $count;

            for ($y=0; $y<=$count; $y++) {
                $name = strtolower($data['users'][$y]['id']);
                try {
                $dbh->query('INSERT INTO `users` (`name`) VALUES (`$name`) ON DUPLICATE KEY UPDATE `name` = `$name`') as $row) {
                } catch (PDOException $e) {
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                }
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
