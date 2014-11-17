<?php
    function initialize() {
        # Grab user field from url and load user stats
        $user = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING);
        $user_url = "https://hummingbird.me/api/v1/users/$user";
        $user_json = file_get_contents($user_url);
        $user_data= json_decode($user_json, true);

        if (empty($user_data['name'])) {
            header("Location: //hb.wopian.me");
        }

        $user_name = $user_data['name'];
    }

    # Format username or pluralize. Should only declare 'plural':  format_name('plural');
    function format_name($x = 'full') {

        echo $user_name;

        switch ($x) {
            case 'full':
                return ucfirst($user_name);
                break;
            case 'plural':
                return (substr($user_name, -1) == "s") ? "'" : "'s";
                break;
        }
    }

    initialize();
?>

<!DOCTYPE html>
<html>

<head>
  <title><?=format_name('plural')?> Profile - Hummingbird Tools</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="View <?=format_name('plural')?> profile.">
  <meta name="keywords" content="Hummingbird,Tool,Tools,Anime,Manga,API,Profile,User,Stats,<?=format_name()?>">
  <meta name="author" content="James Harris">

  <meta property="og:image" content="<?=$user_data['avatar']?>" />
  <meta property="og:url" content="//9.dev.boomcraft.co.uk/<?=$user?>" />
  <meta property="og:title" content="<?=format_name('plural')?> Profile - Hummingbird Tools" />

  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@hb_tools" />
  <meta name="twitter:title" content="<?=format_name('plural')?> Profile - Hummingbird Tools" />
  <meta name="twitter:description" content="View <?=format_name('plural')?> profile." />
  <meta name="twitter:image" content="<?=$user_data['avatar']?>" />
  <meta name="twitter:url" content="//9.dev.boomcraft.co.uk/<?=$user?>" />

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

  <script>
    $(document).ready(function start(){
      $.material.init();

      /*$.get('/assets/modules/users.php?user=<?=$user?>',null,function(result) {
        $("body").append(result);
        setTimeout(function(){
          $(".spinner").one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(e) {
            $(".spinner").remove();
          });
        }, 400);
      },'html');*/

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
          alert("Something went wrong!");
        }
      });
    });
  </script>

  <script src="/assets/js/highcharts.js"></script>
  <script src="/assets/js/exporting.js"></script>

  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-545296d61bde8abb" async="async"></script>

  <script src="/assets/js/outdatedbrowser.min.js"></script>
  <div id="outdated">
     <h6>Your browser is out-of-date!</h6>
     <p>Update your browser to view this website correctly. <a id="btnUpdateBrowser" href="http://outdatedbrowser.com/">Update my browser now </a></p>
     <p class="last"><a href="#" id="btnCloseUpdateBrowser" title="Close">&times;</a></p>
  </div>
  <script>
    $( document ).ready(function() {
      outdatedBrowser({
        bgColor: '#f25648',
        color: '#ffffff',
        lowerThan: 'transform',
        languagePath: ''
      })
    })
  </script>

</body>

</html>
