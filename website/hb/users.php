<?php
    $user = $_GET['user'];
    $userh = ucfirst($user);
    $url = "https://hummingbird.me/api/v1/users/".$user;
    $json = file_get_contents($url);
    $data = json_decode($json, true);

    $username = ucfirst($data['name']);
    $userplural = (substr($username, -1) == "s") ? "'" : "'s";
?>

<!DOCTYPE html>
<html>

<head>
  <title><?=$userplural?> Profile - Hummingbird Tools</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="View <?=$userplural?> profile.">
  <meta name="keywords" content="Hummingbird,Tool,Tools,Anime,Manga,API,Profile,User,Stats,<?=$username?>">
  <meta name="author" content="James Harris">

  <meta property="og:image" content="<?=$data['avatar']?>" />
  <meta property="og:url" content="//9.dev.boomcraft.co.uk/<?=$user?>" />
  <meta property="og:title" content="<?=$header?> Profile - Hummingbird Tools" />

  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@hb_tools" />
  <meta name="twitter:title" content="<?=$userplural?> Profile - Hummingbird Tools" />
  <meta name="twitter:description" content="View <?=$userplural?> profile." />
  <meta name="twitter:image" content="<?=$data['avatar']?>" />
  <meta name="twitter:url" content="//9.dev.boomcraft.co.uk/<?=$user?>" />

  <link href="/dist/css/custom.css" rel="stylesheet">
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
          <li><a rel="prerender" href="/">Home</a></li>
          <li class="active"><a href="/<?=$user?>">Info</a></li>
          <li><a rel="prerender" href="/<?=$user?>/library">Library</a></li>
          <li><a rel="prerender" href="/<?=$user?>/">Cover Images</a></li>
          <li><a rel="prerender" href="//hummingbird.me/users/<?=$user?>">Hummingbird</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="" class="dropdown-toggle" data-toggle="dropdown">Other Sites <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a rel="prerender" href="//manga.jamesharris.net">Manga</a></li>
              <li class="divider"></li>
              <li><a rel="prerender" href="//jamesharris.net">Portfolio</a></li>
              <li><a rel="prerender" href="//whatpulse.jamesharris.net">WhatPulse Stats</a></li>
              <li><a rel="prerender" href="//lastfm.jamesharris.net">Lastistics</a></li>
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

  <script src="/dist/js/ripples.min.js"></script>
  <script src="/dist/js/material.min.js"></script>

  <script>
    $(document).ready(function start(){
      $.material.init();

      /*$.get('/dist/templates/users.php?user=<?=$user?>',null,function(result) {
        $("body").append(result);
        setTimeout(function(){
          $(".spinner").one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(e) {
            $(".spinner").remove();
          });
        }, 400);
      },'html');*/

      $('.spinner').show();

      $.ajax({
        url: '/dist/templates/users.php?user=<?=$user?>',
        type: 'GET',
        dataType: 'html',
        success: function(data) {
          $('body').append(data);
          $('.spinner').remove();
        },
        error: function() {
          alert("Something went wrong!");
        }
      });
    });
  </script>

  <script src="/dist/js/highcharts.js"></script>
  <script src="/dist/js/exporting.js"></script>

  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-545296d61bde8abb" async="async"></script>

  <script src="outdatedBrowser.min.js" async="async"></script>
  <div id="outdated"></div>
  <script>
    $(document).ready(function start(){
      outdatedBrowser({
        bgColor: '#f25648',
        color: '#ffffff',
        lowerThan: 'transform',
        languagePath: 'your_path/outdatedbrowser/lang/en.html'
      })
    })
  </script>

</body>

</html>
