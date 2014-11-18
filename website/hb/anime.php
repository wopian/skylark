<?php
// Get cURL resource
$id = rand(1,10000);

$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => "https://hummingbird.me/api/v2/anime/$id",
    CURLINFO_HEADER_OUT => 1,
    CURLOPT_HTTPHEADER => ['X-Client-Id: 053d7e4280a956145494'],
    CURLOPT_USERAGENT => 'Hummingbird Tools Indexer'
));
// Send the request & save response to $resp
$results = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);

$json = json_decode($results, true);

#echo "<pre>";
#print_r($json);
#echo "</pre>";

function seconds2human($ss, $recent = false) {
        $m = (floor(($ss%3600)/60)>0)?floor(($ss%3600)/60).' minutes':"";
        $h = (floor(($ss % 86400) / 3600)>0)?floor(($ss % 86400) / 3600).' hours':"";
        $d = (floor(($ss % 2592000) / 86400)>0)?floor(($ss % 2592000) / 86400).' days':"";
        $M = (floor($ss / 2592000)>0)?floor($ss / 2592000).' months':"";
        $y = (floor($ss / 31557600)>0)?floor($ss / 31557600).' years':"";
        if ( strlen($m) > 1 && ( strlen($h) > 1 || strlen($d) > 1 || strlen($M) > 1 )) {
            $and = 'and';
        }   else {
            $and = '';
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

$id = $json['anime']['id'];
$slug = $json['anime']['slug'];

$title_canonical = $json['anime']['titles']['canonical'];
$title_english = $json['anime']['titles']['english'];
$title_romanji = $json['anime']['titles']['romanji'];
$title_japanese = $json['anime']['titles']['japanese'];

$synopsis = $json['anime']['synopsis'];

$airing_start = $json['anime']['started_airing_date'];
$airing_end = $json['anime']['finished_airing_date'];
$airing_duration = seconds2human(strtotime($airing_end) - strtotime($airing_start));

$age = $json['anime']['age_rating'];
$type = $json['anime']['show_type'];
$genres = $json['anime']['genres'];

$episodes = $json['anime']['episode_count'];
$length = $json['anime']['episode_length'];

$rating_community = $json['anime']['community_rating'];
$rating_reviews = $json['anime']['bayesian_rating'];

$poster = $json['anime']['poster_image'];
$cover = $json['anime']['cover_image'];

?>

<!DOCTYPE html>
<html>

<head>
    <title>Hummingbird Tools</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Hummingbird Tools hosts a variety of tools and stats for Hummingbird.">
    <meta name="keywords" content="Hummingbird,Tool,Tools,Anime,Manga,API,User Stats,Library,User Library,Cover,Cover Images">
    <meta name="author" content="James Harris">

    <meta property="og:image" content="//9.dev.boomcraft.co.uk/assets/images/avatar_teal.png" />
    <meta property="og:url" content="//9.dev.boomcraft.co.uk" />
    <meta property="og:title" content="Hummingbird Tools" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@hb_tools" />
    <meta name="twitter:title" content="Hummingbird Tools" />
    <meta name="twitter:description" content="A variety of tools and stats for Hummingbird." />
    <meta name="twitter:image" content="//9.dev.boomcraft.co.uk/assets/images/twitter_teal.png" />
    <meta name="twitter:url" content="//9.dev.boomcraft.co.uk" />

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

    <div class="row">
        <div class='col-lg-3 col-md-4 col-sm-4 col-xs-6'>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        ID: <?=$id?>
                    </div>
                </div>
            </div>

            <div class='col-lg-3 col-md-4 col-sm-4 col-xs-6'>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        Slug: <?=$slug?>
                    </div>
                </div>
            </div>

            <div class='col-lg-3 col-md-4 col-sm-4 col-xs-6'>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        Title: <?=$title_canonical?>
                    </div>
                </div>
            </div>

            <div class='col-lg-3 col-md-4 col-sm-4 col-xs-6'>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        Start: <?=$airing_start?>
                    </div>
                </div>
            </div>

            <div class='col-lg-3 col-md-4 col-sm-4 col-xs-6'>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        End: <?=$airing_end?>
                    </div>
                </div>
            </div>

            <div class='col-lg-3 col-md-4 col-sm-4 col-xs-6'>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        Duration: <?=$airing_duration?>
                    </div>
                </div>
            </div>

            <div class='col-lg-3 col-md-4 col-sm-4 col-xs-6'>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        Type: <?=$type?>
                    </div>
                </div>
            </div>

            <div class='col-lg-3 col-md-4 col-sm-4 col-xs-6'>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        Age Rating: <?=$age?>
                    </div>
                </div>
            </div>

            <div class='col-lg-3 col-md-4 col-sm-4 col-xs-6'>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        Episodes: <?=$episodes?>
                    </div>
                </div>
            </div>

            <div class='col-lg-3 col-md-4 col-sm-4 col-xs-6'>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        Length: <?=$length?>
                    </div>
                </div>
            </div>

            <div class='col-lg-3 col-md-4 col-sm-4 col-xs-6'>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        Rating: <?=$rating_community?> <br> <?=$rating_reviews?>
                    </div>
                </div>
            </div>

            <div class='col-lg-3 col-md-4 col-sm-4 col-xs-6'>
                <div class='panel panel-default'>
                    <div class='panel-body'>
                        Synopsis: <?=$synopsis?>
                    </div>
                </div>
            </div>
    </div>

    </div>


<img id="dploy" src="//wopian.dploy.io/badge/13023223950720/13284.png" alt="Deployment status from dploy.io">

  <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

  <script src="/assets/js/ripples.min.js"></script>
  <script src="/assets/js/material.min.js"></script>

  <script>
    $(document).ready(function() {
        $.material.init();
    });
  </script>

  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-545296d61bde8abb" async="async"></script>

</body>

</html>
