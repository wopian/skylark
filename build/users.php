<!DOCTYPE html>
<html>

<?
  ob_end_flush();

  $user = $_GET['user'];
  $userh = ucfirst($user);
  if (substr($user, -1) == "s") {
    $plural = "'";
  } else {
    $plural = "'s";
  }
  $header = $userh.$plural;

  $url = "http://hummingbird.me/api/v1/users/".$user;
  $json = file_get_contents($url);
  $data = json_decode($json, true);

  ob_start();
  flush();

?>

<head>
  <title><?=$header?> Profile - Hummingbird Tools</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="View <?=$header?> profile.">
  <meta name="keywords" content="Hummingbird,Tool,Tools,Anime,Manga,API,Profile,User,Stats,<?=$user?>">
  <meta name="author" content="James Harris">

  <meta property="og:image" content="<?=$data['avatar']?>" />
  <meta property="og:url" content="http://9.dev.boomcraft.co.uk/<?=$user?>" />
  <meta property="og:title" content="<?=$header?> Profile - Hummingbird Tools" />

  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@hb_tools" />
  <meta name="twitter:title" content="<?=$header?> Profile - Hummingbird Tools" />
  <meta name="twitter:description" content="View <?=$header?> profile." />
  <meta name="twitter:image" content="<?=$data['avatar']?>" />
  <meta name="twitter:url" content="http://9.dev.boomcraft.co.uk/<?=$user?>" />

  <link href="/dist/css/custom.css" rel="stylesheet">
</head>

<?
ob_end_flush();

function secondsToTime($seconds) {
  $seconds = $seconds*60;
  if ($seconds < 3600) {$format = '%i minutes ';}
  elseif ($seconds >= 3600 && $seconds < 86400) {$format = '%h hours and %i minutes ';}
  elseif ($seconds >= 86400 && $seconds < 2592000) {$format = '%d days, %h hours and %i minutes ';}
  elseif ($seconds >= 2592000 && $seconds < 31536000) {$format = '%m months, %d days, %h hours and %i minutes ';}
  elseif ($seconds >= 31536000) {$format = '%y years, %m months, %d days, %h hours and %i minutes ';}
  $dtF = new DateTime("@0");
  $dtT = new DateTime("@$seconds");
  return $dtF->diff($dtT)->format($format);
}

ob_start();
flush();
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
          <li><a href="/">Home</a></li>
          <li class="active"><a href="/users/<?=$user?>">Info</a></li>
          <li><a href="/users/<?=$user?>/library">Library</a></li>
          <li><a href="/users/<?=$user?>/cover">Cover Images</a></li>
          <li><a href="https://hummingbird.me/users/<?=$user?>">Hummingbird</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">Other Sites <b class="caret"></b></a>
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

  <div id="cover" style="background-image: url('<?=$data['cover_image']?>')">
    <div>
      <img src="<?=$data['avatar']?>">
    </div>
  </div>

  <div class="container">

    <div class="page-header">
      <div class="col-lg-6 col-md-6 col-sm-6">
        <h1><?=$userh?></h1>
        <p class="lead"><?=$data['bio']?></p>
      </div>

      <?if(strlen($data['waifu']) > 0) {
        echo '<div class="col-lg-6 col-md-6 col-sm-6 text-right">
                <p class="h1">'.$data['waifu'].'</p>
                <p class="lead">'.$data['waifu_or_husbando'].'<p>
              </div>';
      }?>

      <!--</div>-->

      <div class="clearfix visible-lg-block visible-md-block visible-sm-block"></div>

      <div class="col-lg-6 col-md-6 col-sm-6">
        <p class="h1">Location</p>
        <p class="lead"><?=$data['location']?></p>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-6 text-right">
        <p class="h1">Watched</p>
        <p class="lead"><?=secondsToTime($data['life_spent_on_anime'])?> of anime</p>
      </div>

      <div class="col-lg-12 col-md-12 col-sm-12">
        <p class="h1">Recent Anime</p>
      </div>

    </div>

      <div class="row">

        <?
          ob_end_flush();

          $url = "http://hummingbird.me/library_entries?user_id=".$user."&recent=true";
          $json = file_get_contents($url);
          $recent = json_decode($json, true);

          for ($x=0; $x<=3; $x++) {
            if (strlen($recent['anime'][$x]['id']) != null){
            if ($x==3) { //#4
              $hidden = ' hidden-md hidden-sm';
            } else {
              $hidden = '';
            }
            $cover = $recent['anime'][$x]['poster_image'];
            $uri = $recent['anime'][$x]['id'];
            $title = $recent['anime'][$x]['canonical_title'];
            $episodes = $recent['anime'][$x]['episode_count'];
            $watched = $recent['library_entries'][$x]['episodes_watched'];
            $status = $recent['library_entries'][$x]['status'];
            $last = (time()-strtotime($recent['library_entries'][$x]['last_watched']));
            if($last<60){$last=$last." seconds";}
            elseif($last<3600){$last = round($last/60,0)." minutes";}
            elseif($last<86400){$last=round($last/60/60,0)." hours";}
            elseif($last<2629740){$last=round($last/60/60/24,0)." days";}
            elseif($last<31556900){$last=round($last/60/60/24/7/4,0)." months";}
            elseif($last>31556900){$last=round($last/60/60/24/7/4/12,0)." years";}
            if($episodes==0){$episodes='∞';}
            $title=(strlen($title)>30)?substr($title,0,27).'&hellip;':$title;

            switch ($status) {
              case 'Currently Watching':
                $status = 'Watched '.$watched.' of '.$episodes.' episodes.';
                break;
              case 'Completed':
                $status = 'Completed.';
                break;
              case 'Plan to Watch':
                $status = 'Plans to watch.';
                break;
              case 'On Hold':
                $status = 'On hold.';
                break;
              case 'Dropped':
                $status = 'Dropped after '.$watched.' episodes.';
                break;
            }
            }

            echo '<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6'.$hidden.'">
                    <div class="thumbnail card-image">
                      <a href="'.$uri.'"><img src="'.$cover.'" alt="'.$title.'"></a>
                      <div class="caption">
                        <h4>'.$title.'</h4>
                        <p>'.$status.'</p>
                        <p>'.$last.' ago.</p>
                      </div>
                    </div>
                  </div>';
          }

          ob_start();
          flush();
        ?>

      </div>

      <?
      ob_end_flush();

      $url = "http://hummingbird.me/library_entries?user_id=".$user;
      $json = file_get_contents($url);
      $genre = json_decode($json, true);
      $count = count($genre['anime'])-1;
      //echo $count;

      //Get individual
      for ($x=0; $x<=$count; $x++) {
        if ($genre['library_entries'][$x]['status'] == 'Completed') {
          $genres = $genre['anime'][$x]['genres'];
          $genres = implode(',', $genres);
          $genres = str_replace(' ', '-', $genres);
          $total_c = $total_c.$genres.' ';
          $total = $total.$genres.' ';
        }
        if ($genre['library_entries'][$x]['status'] == 'Currently Watching') {
          $genres = $genre['anime'][$x]['genres'];
          $genres = implode(',', $genres);
          $genres = str_replace(' ', '-', $genres);
          $total_cw = $total_cw.$genres.' ';
          $total = $total.$genres.' ';
        }
        if ($genre['library_entries'][$x]['status'] == 'Plan to Watch') {
          $genres = $genre['anime'][$x]['genres'];
          $genres = implode(',', $genres);
          $genres = str_replace(' ', '-', $genres);
          $total_ptw = $total_ptw.$genres.' ';
          $total = $total.$genres.' ';
        }
        if ($genre['library_entries'][$x]['status'] == 'On Hold') {
          $genres = $genre['anime'][$x]['genres'];
          $genres = implode(',', $genres);
          $genres = str_replace(' ', '-', $genres);
          $total_oh = $total_oh.$genres.' ';
          $total = $total.$genres.' ';
        }
        if ($genre['library_entries'][$x]['status'] == 'Dropped') {
          $genres = $genre['anime'][$x]['genres'];
          $genres = implode(',', $genres);
          $genres = str_replace(' ', '-', $genres);
          $total_d = $total_d.$genres.' ';
          $total = $total.$genres.' ';
        }
      }

      //Cut off point
      $cut = 14;

      //OVERVIEW
      // Grabs data generated from above
      $result = array_count_values(str_word_count($total, 1));
      // Reverses the order of array: Highest => Lowest
      arsort($result);
      // Splits off first 15 instances
      $first = array_slice($result, 0, $cut);
      // Cycles through each instance
      foreach ($first as $key => $row) {
        // Replaces safety character with space
        $key = str_replace('-', ' ', $key);
        // Formats each instance for graph
        $overview = $overview . '["'.$key.'", '.$row.'], ';
      }
      // Splits off rest of array
      $second = array_slice($result, $cut);
      $other = 0;
      foreach ($second as $key => $row) {
        // Adds each instance's value together
        $other = $other + $row;
      }
      // Adds 'other' instance to main blob
      $overview = $overview . '["Other", '.$other.']';

      //COMPLETED
      $result = array_count_values(str_word_count($total_c, 1));
      arsort($result);
      $first = array_slice($result, 0, $cut);
      foreach ($first as $key => $row) {
        $key = str_replace('-', ' ', $key);
        $completed = $completed . '["'.$key.'", '.$row.'], ';
      }
      $second = array_slice($result, $cut);
      $other = 0;
      foreach ($second as $key => $row) {
        $other = $other + $row;
      }
      $completed = $completed . '["Other", '.$other.']';

      //CURRENTLY WATCHING
      $result = array_count_values(str_word_count($total_cw, 1));
      arsort($result);
      $first = array_slice($result, 0, $cut);
      foreach ($first as $key => $row) {
        $key = str_replace('-', ' ', $key);
        $currently = $currently . '["'.$key.'", '.$row.'], ';
      }
      $second = array_slice($result, $cut);
      $other = 0;
      foreach ($second as $key => $row) {
        $other = $other + $row;
      }
      $currently = $currently . '["Other", '.$other.']';

      //PLAN TO WATCH
      $result = array_count_values(str_word_count($total_ptw, 1));
      arsort($result);
      $first = array_slice($result, 0, $cut);
      foreach ($first as $key => $row) {
        $key = str_replace('-', ' ', $key);
        $plan = $plan . '["'.$key.'", '.$row.'], ';
      }
      $second = array_slice($result, $cut);
      $other = 0;
      foreach ($second as $key => $row) {
        $other = $other + $row;
      }
      $plan = $plan . '["Other", '.$other.']';

      function pieColour() {
        $colours = [ "607d8b", "e91e63", "03a9f4", "3f51b5", "ff5722", "ffc107", "9c27b0", "00bcd4", "795548", "009688", "e51c23", "9e9e9e", "ff9800", "259b24", "ffeb3b", "cddc39", "8bc34a", "5677fc", "673ab7" ];
        shuffle($colours);
        $colour = '';
        foreach ($colours as $row) {
          $colour = $colour.'"#'.$row.'", ';
        }
        $colour = substr($colour, 0, -2);
        return $colour;
      }

      ob_start();
      flush();
      ?>

      <div class="col-lg-6 no-gutter">
        <div class="col-lg-12">
          <p class="h1">Genre Overview</p>
        </div>
        <div id="overview" class="col-lg-12" style="height: 400px"></div>
      </div>

      <div class="col-lg-6 no-gutter">
        <div class="col-lg-12">
          <p class="h1">Completed Anime</p>
        </div>
        <div id="completed" class="col-lg-12" style="height: 400px"></div>
      </div>

      <div class="col-lg-6 no-gutter">
        <div class="col-lg-12">
          <p class="h1">Currently Watching Anime</p>
        </div>
        <div id="currently" class="col-lg-12" style="height: 400px"></div>
      </div>

      <div class="col-lg-6 no-gutter">
        <div class="col-lg-12">
          <p class="h1">Plan to Watch Anime</p>
        </div>
        <div id="plan" class="col-lg-12" style="height: 400px"></div>
      </div>

      <div id="test">Test</div>

    </div>

  </div>

  <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

  <script src="/dist/js/ripples.min.js"></script>
  <script src="/dist/js/material.min.js"></script>

  <script>
    $(document).ready(function start(){
      $.get('/dist/templates/users.php',null,function(result) {
        //$("#test>.loading-indicator").bind("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function(){
        $("#test"), function(){
          $("#test").hide();
        };
        setTimeout(function(){
          $("#test").html(result);
        }, 1000);
      },'html');
    };
  </script>

  <script>
    $(document).ready(function() {
      $.material.init();
    });
  </script>

  <script src="/dist/js/highcharts.js"></script>
  <script src="/dist/js/exporting.js"></script>

  <script type="text/javascript">
$(function () {
  $('#overview').highcharts({
      colors: [ <?=pieColour()?> ],
      credits: {
          enabled: false
      },
      chart: {
          backgroundColor: 'transparent',
          plotBackgroundColor: null,
          plotBorderWidth: 0,//null,
          plotShadow: false
      },
      title: {
          text: ''
      },
      tooltip: {
          pointFormat: '{series.name}: <b>{point.y:.0f}</b> ({point.percentage:.1f} %)'
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  format: '{point.name}: {point.y:.0f}',
                  style: {
                        //color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        color: 'black'
                  }
              },
          }
      },
      series: [{
          type: 'pie',
          name: 'Amount',
          data: [
              <?=$overview?>
          ],
      }]
    });
    $('#completed').highcharts({
        colors: [ <?=pieColour()?> ],
        credits: {
            enabled: false
        },
        chart: {
            backgroundColor: 'transparent',
            plotBackgroundColor: null,
            plotBorderWidth: 0,//null,
            plotShadow: false
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y:.0f}</b> ({point.percentage:.1f} %)'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.y:.0f}',
                    style: {
                          //color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                          color: 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Amount',
            data: [
                <?=$completed?>
            ],
        }]
    });
    $('#currently').highcharts({
        colors: [ <?=pieColour()?> ],
        credits: {
            enabled: false
        },
        chart: {
            backgroundColor: 'transparent',
            plotBackgroundColor: null,
            plotBorderWidth: 0,//null,
            plotShadow: false
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y:.0f}</b> ({point.percentage:.1f} %)'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.y:.0f}',
                    style: {
                          //color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                          color: 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Amount',
            data: [
                <?=$currently?>
            ],
        }]
    });
    $('#plan').highcharts({
        colors: [ <?=pieColour()?> ],
        credits: {
            enabled: false
        },
        chart: {
            backgroundColor: 'transparent',
            plotBackgroundColor: null,
            plotBorderWidth: 0,//null,
            plotShadow: false
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y:.0f}</b> ({point.percentage:.1f} %)'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.y:.0f}',
                    style: {
                          //color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                          color: 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Amount',
            data: [
                <?=$plan?>
            ],
        }]
    });
});
  </script>

  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-545296d61bde8abb" async="async"></script>

</body>

</html>
