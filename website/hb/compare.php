<?php
    # Grab user field from url and load user stats
    $user = [filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING), filter_input(INPUT_GET, 'user2', FILTER_SANITIZE_STRING)];
    $user_url = ["https://hummingbird.me/api/v1/users/$user[0]", "https://hummingbird.me/api/v1/users/$user[1]"];
    $user_json = [file_get_contents($user_url[0]), file_get_contents($user_url[1])];
    $user_data = [json_decode($user_json[0], true), json_decode($user_json[1], true)];

    echo "<pre>";
    print_r($user_data);
    echo "</pre>";

    # `User A` has watched 17 days 3 hours and 12 minutes more than `User B`.
    # 18 days 3 hours and 12 minutes                                    1 day
    #
    # `User A` has watched 193 shows, whereas `User B` has watched 8.
    #
    # `User A` and `User B` both share [Action], [Comedy] and [Sci Fi] as
    # their top genres
    #
    # `User A` and `User B` has both watched:
    # [Anime Card 1] [Anime Card 2] [Anime Card 3] {[Anime Card 4]}
    # and {4} others {{{Click to show}}}
    #
    # `User B` rates anime {4.7} on average while `User A` rates {4.2}
    # [Rating Breakdown Card B] [Rating Breakdown Card A]
    #
    # List of anime both watched {{{Limit to 20 shows}}}
    #
    # Give reccomendation based on shared genres. {{{If have time also take into account user rating}}}
    # [User A reccomends] [User B reccomends]

    # Redirect to homepage if invalid username given
    if (empty($user_data[0]['name']) || empty($user_data[1]['name'])) {
        header("Location: //hb.wopian.me");
    }

    # Makes first character uppercase
    $user_name = [ucfirst($user_data[0]['name']), ucfirst($user_data[1]['name'])];

    # Strips trailing 's' from username when last character of username is 's'
    function properize($string) {
        return $string.'\''.($string[strlen($string) - 1] != 's' ? 's' : '');
    }

    # =============================== #
    # === INITIALIZE USER COMPARE === #
    # =============================== #

    function timeWatched($time_userA, $time_userB) {
      abs($time_watched_diff);
      $time_watched_more = [$time_userA, $time_userB];
    }

    $time_watched = [$user_data[0]['life_spent_on_anime'], $user_data[1]['life_spent_on_anime']];
    $time_watched_diff = $time_watched[0] - $time_watched[1];
    $time_watched_more = $time_watched_diff > 0 ? timeWatched($user_data[0]['name'], $user_data[1]['name']) : timeWatched($user_data[1]['name'], $user_data[0]['name']);
    # $time_watched_more = $time_watched_diff > 0 ? $user_data[0]['name'] : $user_data[1]['name']; # Change this to call 2 functions to auto complete the below stuff and perform better.
    # $time_watched_diff = abs($time_watched_diff);

    echo $time_watched_more[0] . " has watched ". $time_watched_diff ." minutes more than ". $time_watched_more[1];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title><?=$user_name[0];?> vs. <?=$user_name[1];?> - Hummingbird Tools</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="View stats and other information about <?=$user_name;?> on Hummingbird. Hummingbird Tools hosts a variety of tools and stats for Hummingbird.">
  <meta name="keywords" content="Hummingbird,Tool,Tools,Anime,Manga,API,Profile,User,Stats,<?=$user_name;?>">
  <meta name="author" content="James Harris">

  <meta property="og:image" content="<?=$user_data['avatar'];?>" />
  <meta property="og:url" content="//hb.wopian.me/<?=$user;?>" />
  <meta property="og:title" content="<?=properize($user_name);?> Profile - Hummingbird Tools" />

  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@hb_tools" />
  <meta name="twitter:title" content="Check out <?=properize($user_name);?> profile on Hummingbird Tools" />
  <meta name="twitter:description" content="View <?=properize($user_name);?> profile." />
  <meta name="twitter:image" content="<?=$user_data['avatar'];?>" />
  <meta name="twitter:url" content="//hb.wopian.me/<?=$user;?>" />

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
          <li><a href="/">Home</a></li>
          <li class="active"><a href="/<?=$user?>">Info</a></li>
          <li><a href="/<?=$user?>/library">Library</a></li>
          <li><a href="/<?=$user?>/">Cover Images</a></li>
          <li><a href="//hummingbird.me/users/<?=$user?>">Hummingbird</a></li>
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

  <svg class="spinner" width="66px" height="66px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
    <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
  </svg>


  <img id="dploy" src="//wopian.dploy.io/badge/13023223950720/13284.png" alt="Deployment status from dploy.io">

  <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

  <script src="/assets/js/ripples.min.js"></script>
  <script src="/assets/js/material.min.js"></script>
  <script src="/assets/js/snackbar.js"></script>

  <script>
    $(document).ready(function start(){
      $.material.init();

      $('.spinner').show();

      $.ajax({
        url: '/assets/modules/users.php?user=<?=$user?>',
        type: 'GET',
        dataType: 'html',
        success: function(data) {
          $('body').append(data);
          $('.spinner').remove();
        },
        error: function() {
            var options =  {
                content: '<i class="mdi-action-report-problem" style="font-size: 40pt; padding-right: 15px"></i>Failed to load user.<br>Refresh to try again.',
                timeout: 0
            }

            $.snackbar(options);
        }
      });
    });
  </script>

  <script src="/assets/js/highcharts.js"></script>
  <script src="/assets/js/exporting.js"></script>

  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-545296d61bde8abb" async="async"></script>

</body>

</html>
