<?php
    # Grab user field from url and load user stats
    $user = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING);
    $user_url = "https://hummingbird.me/api/v1/users/$user";
    $user_json = file_get_contents($user_url);
    $user_data= json_decode($user_json, true);

    # Redirect to homepage if invalid username given
    if (empty($user_data['name'])) {
        header("Location: //hb.wopian.me");
    }

    # Makes first character uppercase
    $user_name = ucfirst($user_data['name']);

    # Strips trailing 's' from username when last character of username is 's'
    function properize($string) {
        return $string.'\''.($string[strlen($string) - 1] != 's' ? 's' : '');
    }
?>

<!DOCTYPE html>
<html lang="en-us">

<head>
  <title><?=$user_name;?> - Hummingbird Tools</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="View stats and other information about <?=$user_name;?> on Hummingbird. Hummingbird Tools hosts a variety of tools and stats for Hummingbird.">
  <meta name="keywords" content="Hummingbird,Tool,Tools,Anime,Manga,API,Profile,User,Stats,<?=$user_name;?>">
  <meta name="author" content="James Harris">
  <meta name="robots" content="NOODP">

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

  <script src='/assets/js/modernizr.min.js'></script>
  <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

  <script src="/assets/js/ripples.js"></script>
  <script src="/assets/js/material.js"></script>
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

  <!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//stats.wopian.me/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 2]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//stats.wopian.me/piwik.php?idsite=2" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->


</body>

</html>
