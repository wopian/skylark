<?php
    $user = $_GET['user'];
    $status = $_GET['status'];
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="/dist/css/main.css" rel="stylesheet">
</head>

<?php

  $status_selector = '<a class="btn btn-default col-xs-9 disabled">'.$active.'</a>
                      <a class="btn btn-default col-xs-3 dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li><a rel="prerender" href="/'.$user.'/library/'.$status1[0].'">'.$status1[1].'</a></li>
                        <li><a rel="prerender" href="/'.$user.'/library/'.$status2[0].'">'.$status2[1].'</a></li>
                        <li><a rel="prerender" href="/'.$user.'/library/'.$status3[0].'">'.$status3[1].'</a></li>
                        <li><a rel="prerender" href="/'.$user.'/library/'.$status4[0].'">'.$status4[1].'</a></li>
                        <li><a rel="prerender" href="/'.$user.'/library/'.$status5[0].'">'.$status5[1].'</a></li>
                      </ul>';

$url = "http://hummingbird.me/api/v1/users/".$user."/library?status=".$status;
$json = file_get_contents($url);
$data = json_decode($json, true);
$count = count($data)-1;
$sort = array();
//print "<pre>";
//print_r($data);
//print "</pre>";
foreach ($data as $key => $row) {
  $sort[$key] = $row['last_watched'];
}
array_multisort($sort, SORT_DESC, $data);
?>

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
          <li><a rel="prerender" href="/<?=$user?>">Info</a></li>
          <li class="active"><a href="/<?=$user?>/library">Library</a></li>
          <li><a rel="prerender" href="/<?=$user?>/cover">Cover Images</a></li>
          <li><a rel="prerender" href="//hummingbird.me/users/<?=$user?>">Hummingbird</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Other Sites <b class="caret"></b></a>
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

  <!-- Start of content. -->

  <div class="container">

    <div class="page-header">
      <div class="col-lg-6 col-md-6 col-sm-6">
        <h1><?=$userplural?> Library</h1>
        <br>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="btn-group pull-right hidden-xs">
          <?=$status_selector?>
        </div>
        <div class="btn-group btn-block pull-right visible-xs-block">
          <?=$status_selector?>
        </div>
        <div class="visible-xs"><br><br><br /></div>
      </div>
    </div>

  </div>
  <div class="container">

    <div class="row">

      <?
      for ($x=0; $x<=$count; $x++) {
      //for ($x=0; $x<=10; $x++) {
        $cover = $data[$x]['anime']['cover_image'];
        $uri = $data[$x]['anime']['url'];
        $title = $data[$x]['anime']['title'];
        $episodes = $data[$x]['anime']['episode_count'];
        $watched = $data[$x]['episodes_watched'];
        $status = $data[$x]['status'];
        $time = time() - (strtotime($data[$x]['last_watched']));
        $last = seconds2human($time, true);

        if($episodes==0){$episodes='∞';}
        //$title=(strlen($title)>30)?substr($title,0,27).'&hellip;':$title;

        switch ($status) {
          case 'currently-watching':
            $status = 'Watched '.$watched.' of '.$episodes.' episodes';
            break;
          case 'completed':
            $status = 'Watched all '.$episodes.' episodes';
            break;
          case 'plan-to-watch':
            $status = 'Plans to watch '.$episodes.' episodes';
            break;
          case 'on-hold':
            $status = 'On hold';
            break;
          case 'dropped':
            $status = 'Dropped after '.$watched.' episodes';
            break;
        }

        echo '<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
          <div class="thumbnail">
            <a href="'.$uri.'"><img src="'.$cover.'" alt="'.$title.'"></a>
            <div class="caption">
              <h4>'.$title.'</h4>
              <p>'.$status.'</p>
              <p>'.$last.' ago</p>
            </div>
          </div>
        </div>';
      }
      ?>

    </div>

  </div>

  <img id="dploy" src="https://wopian.dploy.io/badge/13023223950720/13284.png" alt="Deployment status from dploy.io">

  <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

  <script src="/dist/js/ripples.min.js"></script>
  <script src="/dist/js/material.min.js"></script>

  <script>
    $(document).ready(function() {
      $.material.init();
    });
  </script>

  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-545296d61bde8abb" async="async"></script>

</body>

</html>
