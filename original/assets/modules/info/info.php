<?php

    header("Refresh: 60");

    $user = 'redacted';
    $pass = 'redacted';
    $dbh = new PDO('mysql:host=redacted;dbname=redacted', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

    try {
        foreach($dbh->query('SELECT COUNT(*) FROM `users`') as $row) {
            $users = $row[0];
        }
        foreach($dbh->query('SELECT COUNT(*) FROM `users` WHERE `timestamp` >= unix_timestamp() - 86400') as $row) {
            $recent = $row[0];
        }
        foreach($dbh->query('SELECT COUNT(*) FROM `users` WHERE `timestamp` >= unix_timestamp() - 3600') as $row) {
            $recentHr = $row[0];
        }
        foreach($dbh->query('SELECT COUNT(*) FROM `users` WHERE `crawled` >= 1') as $row) {
            $crawled = $row[0];
        }
        foreach($dbh->query('SELECT COUNT(*) FROM `users` WHERE `crawled` = 0') as $row) {
            $uncrawled = $row[0];
        }

        $history = array();
        //$history[1] = 0;
        foreach($dbh->query('SELECT COUNT(`timestamp`) FROM `users` GROUP BY `timestamp`') as $row) {
            print_r($row);
            $historyA = $row[0]*1000;
            $history[0][] = '['.$historyA.']';
            //$history[1]++;
        }
        print_r($history);

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

    /*$db = new mysqli('redacted', 'redacted', 'redacted', 'redacted');
    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    # SQL pointers
    $sqlUsers = "SELECT COUNT(*) FROM `users`";
    $sqlCrawled = "SELECT COUNT(*) FROM `users` WHERE `crawled` = 1";
    $sqlUncrawled = "SELECT COUNT(*) FROM `users` WHERE `crawled` = 0";

    # Users in database
    if(!$result = $db->query($sqlUsers)){die('There was an error running the query [' . $db->error . ']');} else {
        $users = mysqli_fetch_row($result)[0];
    }

    # Users crawled
    if(!$result = $db->query($sqlCrawled)){die('There was an error running the query [' . $db->error . ']');} else {
        $crawled = mysqli_fetch_row($result)[0];
    }

    # Users crawled
    if(!$result = $db->query($sqlUncrawled)){die('There was an error running the query [' . $db->error . ']');} else {
        $uncrawled = mysqli_fetch_row($result)[0];
    }*/

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
    $crawledPer = round($crawled / $users * 100, 1);
    $uncrawledPer = round($uncrawled / $users * 100, 1);
    $tLeft = seconds2human(($uncrawled/10)*60);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Hummingbird Tools</title>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="NOODP">
    <link href="/assets/css/custom.css" rel="stylesheet">
</head>

<body>

    <div class="navbar navbar-material-teal">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Hummingbird Tools</a>
            </div>
            <div class="navbar-collapse collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/">Home</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">Other Sites <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="//manga.jamesharris.net">Manga</a></li>
                            <li class="divider"></li>
                            <li><a href="//jamesharris.net">Portfolio</a></li>
                            <li><a href="//whatpulse.jamesharris.net">WhatPulse Stats</a></li>
                            <li><a href="//lastfm.jamesharris.net">Lastistics</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Start of content. -->

    <div class="container">

        <div class="page-header">
            <h1>Database, Crawler & Other Info</h1>
        </div>

        <div class="row">

            <div class="col-md-4">
                <div class="panel panel-material-teal text-center">
                    <div class="panel-heading">
                        <p class="btn btn-default disabled">Tracked Users</p>
                    </div>
                    <div class="panel-body">
                        <p class="h2"><?=$users?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-material-teal text-center">
                    <div class="panel-heading">
                        <p class="btn btn-default disabled">Processed Users</p>
                    </div>
                    <div class="panel-body">
                        <p class="h2"><?=$crawled?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-material-teal text-center">
                    <div class="panel-heading">
                        <p class="btn btn-default disabled">Queued Users</p>
                    </div>
                    <div class="panel-body">
                        <p class="h2"><?=$uncrawled?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-material-teal text-center">
                    <div class="panel-heading">
                        <p class="btn btn-default disabled">Queue Processing Time</p>
                    </div>
                    <div class="panel-body">
                        <p class="h2"><?=$tLeft?> remaining</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-material-teal text-center">
                    <div class="panel-heading">
                        <p class="btn btn-default disabled">Processed Today</p>
                    </div>
                    <div class="panel-body">
                        <p class="h2"><?=$recent?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-material-teal text-center">
                    <div class="panel-heading">
                        <p class="btn btn-default disabled">Processed In Last Hour</p>
                    </div>
                    <div class="panel-body">
                        <p class="h2"><?=$recentHr?></p>
                    </div>
                </div>
            </div>

        </div>

        <div id="history" class="col-lg-12"></div>

    </div>

    <img id="dploy" src="//wopian.dploy.io/badge/13023223950720/13284.png" alt="Deployment status from dploy.io">

    <script src='/assets/js/modernizr.min.js'></script>
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="/assets/js/ripples.min.js"></script>
    <script src="/assets/js/material.min.js"></script>

    <script>
        $(document).ready(function() {
            $.material.init();
        });
    </script>

    <script src="/assets/js/highcharts.js"></script>
    <script src="/assets/js/exporting.js"></script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-545296d61bde8abb" async="async"></script>

    <script type="text/javascript">
        $(function () {
            $('#history').highcharts({
                chart: {
                    type: 'spline'
                },
                title: {
                    text: 'Usage History'
                },
                subtitle: {
                    text: 'Amount of crawls over time'
                },
                xAxis: {
                    type: 'datetime',
                    dateTimeLabelFormats: { // don't display the dummy year
                        month: '%e. %b',
                        year: '%b'
                    },
                    title: {
                        text: 'Date'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Amount)'
                    },
                    min: 0
                },
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                    pointFormat: '{point.x:%e. %b}: {point.y:.2f} m'
                },

                series: [{
                    // Define the data points. All series have a dummy year
                    // of 1970/71 in order to be compared on the same x axis. Note
                    // that in JavaScript, months start at 0 for January, 1 for February etc.
                    data: [
                        //[Date.UTC(1970,  9, 27), 0   ],
                        //[Date.UTC(1970, 10, 10), 0.6 ],
                        //[Date.UTC(1970, 10, 18), 0.7 ],
                        //[1417425688*1000, 10],
                        //[1417425388*1000, 1093]
                        <?= implode(",",$history[0]);?>
                    ]
                }]
             });
        });
    </script>
</body>
</html>
