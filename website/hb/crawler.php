<?php

    $db = new mysqli('localhost', 'bobstudi_humming', 'music195', 'bobstudi_hummingbird');
    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    # SQL pointers
    $sqlUsers = "SELECT COUNT(*) FROM `users`";
    $sqlCrawled = "SELECT COUNT(*) FROM `users` WHERE `crawled` = 1";
    $sqlUncrawled = "SELECT COUNT(*) FROM `users` WHERE `crawled` = 0";

    # Users in database
    if(!$result = $db->query($sqlUsers)){
        die('There was an error running the query [' . $db->error . ']');
    } else {
        $a = mysqli_fetch_row($result)[0];
    }

    # Users crawled
    if(!$result = $db->query($sqlCrawled)){
        die('There was an error running the query [' . $db->error . ']');
    } else {
        $b = mysqli_fetch_row($result)[0];
    }

    # Users crawled
    if(!$result = $db->query($sqlUncrawled)){
        die('There was an error running the query [' . $db->error . ']');
    } else {
        $c = mysqli_fetch_row($result)[0];
    }

    function seconds2human($ss, $recent = false) {
        $m = (floor(($ss%3600)/60)>0)?floor(($ss%3600)/60).' minutes':"";
        $h = (floor(($ss % 86400) / 3600)>0)?floor(($ss % 86400) / 3600).' hours':"";
        $d = (floor(($ss % 2592000) / 86400)>0)?floor(($ss % 2592000) / 86400).' days':"";
        $M = (floor($ss / 2592000)>0)?floor($ss / 2592000).' months':"";
        $y = (floor($ss / 31557600)>0)?floor($ss / 31557600).' years':"";
        if (strlen($m) > 1 && (strlen($h) > 1 || strlen($d) > 1 || strlen($M) > 1 )) {
            $and = 'and';
        }   else {
            $and = '';
        }
        # If no anime watched fill in with 0 minutes
        if (strlen($m) == '' && strlen($h) == '' && strlen($d) == '' && strlen($M) == '' && strlen($y) == '') {
            $m = '0 minutes';
        }
        if ($recent === false) {
            return "$y $M $d $h $and $m";
        }   else {
            if ($y != '') { return "$y"; }
            elseif ($y == '' && $M != '') { return "$M"; }
            elseif ($y == '' && $M == '' && $d != '') { return "$d"; }
            elseif ($y == '' && $M == '' && $d == '' && $h != '') { return "$h"; }
            elseif ($y == '' && $M == '' && $d == '' && $h == '' && $m != '') { return "$m"; }
        }
    }

    # Calculations
    $pCrawled = $b / $a * 100;
    $pUncrawled = $c / $a * 100;
    $tLeft = seconds2human($c*60);

    echo "Tracking $a users.\n
        \n
        $b users processed ($pCrawled%). $c waiting to be processed ($pUncrawled%).\n
        \n
        Approx $tLeft remaining to process all users.";
