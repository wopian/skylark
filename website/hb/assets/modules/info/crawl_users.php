<?php

    $dbu = 'bobstudi_humming';
    $dbp = 'music195';
    $dbh = new PDO('mysql:host=localhost;dbname=bobstudi_hummingbird', $dbp, $dbu, array(PDO::ATTR_PERSISTENT => true));
    
    try {
        foreach($dbh->query('SELECT `id`, `name`, `crawled` FROM `users` ORDER BY `crawled` ASC LIMIT 1') as $row) {
            $user = $row[0];
        }
        "UPDATE `users` SET `crawled` = 1 WHERE `name` = '".$user."'";
        foreach($dbh->query('UPDATE `users` SET `crawled` = 1 WHERE `name` = $user') as $row) {
            $crawled = $row[0];
        }
        foreach($dbh->query('SELECT COUNT(*) FROM `users` WHERE `crawled` = 0') as $row) {
            $uncrawled = $row[0];
        }
        $dbh = null;
        /*echo '<pre>';
        foreach($dbh->query('SELECT * from `users`') as $row) {
            print_r($row);
        }
        $dbh = null;
        echo '</pre>';*/
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
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
    echo "Added $total users from $user's followers.";
