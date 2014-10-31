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

      //OVERVIEW
      $result = array_count_values(str_word_count($total, 1));
      arsort($result);
      $result = array_slice($result, 0, 15); // Limiter
      $count = count($result)-1;
      //print "<pre>";
      //print_r($result);
      //print "</pre>";
      foreach ($result as $key => $row) {
        $key = str_replace('-', ' ', $key);
        $overview = $overview . '["'.$key.'", '.$row.'], ';
      }
      $overview = substr($overview, 0, -2);
      $overview_max = reset($result);
      //print "<pre>";
      //print_r($overview_list);
      //print "</pre>";

      //COMPLETED
      $result = array_count_values(str_word_count($total_c, 1));
      arsort($result);
      $result = array_slice($result, 0, 15); // Limiter
      $count = count($result)-1;
      foreach ($result as $key => $row) {
        $key = str_replace('-', ' ', $key);
        $completed = $completed . '["'.$key.'", '.$row.'], ';
      }
      $completed = substr($completed, 0, -2);
      $completed_max = reset($result);

      //CURRENTLY WATCHING
      $result = array_count_values(str_word_count($total_cw, 1));
      arsort($result);
      $result = array_slice($result, 0, 15); // Limiter
      $count = count($result)-1;
      foreach ($result as $key => $row) {
        $key = str_replace('-', ' ', $key);
        $currently = $currently . '["'.$key.'", '.$row.'], ';
      }
      $currently = substr($currently, 0, -2);
      $currently_max = reset($result);

      //PLAN TO WATCH
      $result = array_count_values(str_word_count($total_ptw, 1));
      arsort($result);
      $result = array_slice($result, 0, 15); // Limiter
      $count = count($result)-1;
      foreach ($result as $key => $row) {
        $key = str_replace('-', ' ', $key);
        $plan = $plan . '["'.$key.'", '.$row.'], ';
      }
      $plan = substr($plan, 0, -2);
      $plan_max = reset($result);

      ob_start();
      flush();
      ?>

      <div class="col-lg-6">
        <div class="col-lg-12">
          <p class="h1">Genre Overview <small class="h6"><span class="label label-danger">Test</span></small></p>
        </div>
        <div id="overview_pie" class="col-lg-12" style="height: 400px"></div>
      </div>
      <div class="col-lg-6">
        <div class="col-lg-12">
          <p class="h1">Completed Anime <small class="h6"><span class="label label-danger">Test</span></small></p>
        </div>
        <div id="completed_pie" class="col-lg-12" style="height: 400px"></div>
      </div>

      <div class="col-lg-12">
        <p class="h1">Genre Overview</p>
      </div>

      <div id="overview" class="col-lg-12" style="height: 400px"></div>

      <div class="col-lg-12">
        <p class="h1">Completed Genres</p>
      </div>

      <div id="completed" class="col-lg-12" style="height: 400px"></div>

      <div class="col-lg-12">
        <p class="h1">Currently Watching Genres</p>
      </div>

      <div id="currently" class="col-lg-12" style="height: 400px"></div>

      <div class="col-lg-12">
        <p class="h1">Plan To Watch Genres</p>
      </div>

      <div id="plan" class="col-lg-12" style="height: 400px"></div>

    </div>

  </div>

  <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

  <script src="/dist/js/ripples.min.js"></script>
  <script src="/dist/js/material.min.js"></script>

  <script>
    $(document).ready(function() {
      $.material.init();
    });
  </script>

  <script src="/dist/js/highcharts.js"></script>
  <script src="/dist/js/exporting.js"></script>

  <script type="text/javascript">
$(function () {
  $('#overview_pie').highcharts({
      colors: [
          "#e51c23", "#e91e63", "#9c27b0", "#673ab7", "#3f51b5", "#5677fc", "#03a9f4", "#00bcd4", "#009688", "#259b24", "#8bc34a", "#cddc39", "#ffeb3b", "#ffc107", "#ff9800", "#ff5722", "#795548", "#9e9e9e", "#607d8b"
      ],
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
                  format: '<b>{point.name}</b>: {point.y:.0f}',
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
              <?=$overview?>
          ],
      }]
    });
    $('#completed_pie').highcharts({
        colors: [
            "#e51c23", "#e91e63", "#9c27b0", "#673ab7", "#3f51b5", "#5677fc", "#03a9f4", "#00bcd4", "#009688", "#259b24", "#8bc34a", "#cddc39", "#ffeb3b", "#ffc107", "#ff9800", "#ff5722", "#795548", "#9e9e9e", "#607d8b"
        ],
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
                    format: '<b>{point.name}</b>: {point.y:.0f}',
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


  $('#overview').highcharts({
      colors: ['#009688'],
      credits: {
          enabled: false
      },
      chart: {
          type: 'column',
          backgroundColor: 'transparent',
      },
      title: {
          text: ''
      },
      xAxis: {
          type: 'category',
          labels: {
              rotation: -45,
              style: {
                  fontSize: '13px',
                  fontFamily: 'Roboto,"Helvetica Neue",Helvetica,Arial,sans-serif'
              }
          },
          lineWidth: 0,
          minorGridLineWidth: 0,
          lineColor: 'transparent',
          minorTickLength: 0,
          tickLength: 0
      },
      yAxis: {
          min: 0,
          max: <?=$overview_max?>,
          lineWidth: 0,
          minorGridLineWidth: 0,
          labels: {
              enabled: false
          },
          gridLineColor: 'transparent',
          title: {
              text: ''
          }
      },
      legend: {
          enabled: false
      },
      tooltip: {
          pointFormat: 'Amount: <b>{point.y:.0f}</b>',
          enabled: false
      },
      series: [{
          name: 'Genres',
          data: [
              <?=$overview?>
          ],
          dataLabels: {
              enabled: true,
              rotation: -90,
              color: '#eee',
              align: 'right',
              x: 4,
              y: 10,
              style: {
                  fontSize: '13px',
                  fontFamily: 'Roboto,"Helvetica Neue",Helvetica,Arial,sans-serif',
              }
          }
      }]
  });
  $('#completed').highcharts({
      colors: ['#009688'],
      credits: {
          enabled: false
      },
      chart: {
          type: 'column',
          backgroundColor: 'transparent',
      },
      title: {
          text: ''
      },
      xAxis: {
          type: 'category',
          labels: {
              rotation: -45,
              style: {
                  fontSize: '13px',
                  fontFamily: 'Roboto,"Helvetica Neue",Helvetica,Arial,sans-serif'
              }
          },
          lineWidth: 0,
          minorGridLineWidth: 0,
          lineColor: 'transparent',
          minorTickLength: 0,
          tickLength: 0
      },
      yAxis: {
          min: 0,
          max: <?=$completed_max?>,
          lineWidth: 0,
          minorGridLineWidth: 0,
          labels: {
              enabled: false
          },
          gridLineColor: 'transparent',
          title: {
              text: ''
          }
      },
      legend: {
          enabled: false
      },
      tooltip: {
          pointFormat: 'Amount: <b>{point.y:.0f}</b>',
          enabled: false
      },
      series: [{
          name: 'Genres',
          data: [
              <?=$completed?>
          ],
          dataLabels: {
              enabled: true,
              rotation: -90,
              color: '#eee',
              align: 'right',
              x: 4,
              y: 10,
              style: {
                  fontSize: '13px',
                  fontFamily: 'Roboto,"Helvetica Neue",Helvetica,Arial,sans-serif',
              }
          }
      }]
  });
  $('#currently').highcharts({
      colors: ['#009688'],
      credits: {
          enabled: false
      },
      chart: {
          type: 'column',
          backgroundColor: 'transparent',
      },
      title: {
          text: ''
      },
      xAxis: {
          type: 'category',
          labels: {
              rotation: -45,
              style: {
                  fontSize: '13px',
                  fontFamily: 'Roboto,"Helvetica Neue",Helvetica,Arial,sans-serif'
              }
          },
          lineWidth: 0,
          minorGridLineWidth: 0,
          lineColor: 'transparent',
          minorTickLength: 0,
          tickLength: 0
      },
      yAxis: {
          min: 0,
          max: <?=$currently_max?>,
          lineWidth: 0,
          minorGridLineWidth: 0,
          labels: {
              enabled: false
          },
          gridLineColor: 'transparent',
          title: {
              text: ''
          }
      },
      legend: {
          enabled: false
      },
      tooltip: {
          pointFormat: 'Amount: <b>{point.y:.0f}</b>',
          enabled: false
      },
      series: [{
          name: 'Genres',
          data: [
              <?=$currently?>
          ],
          dataLabels: {
              enabled: true,
              rotation: -90,
              color: '#eee',
              align: 'right',
              x: 4,
              y: 10,
              style: {
                  fontSize: '13px',
                  fontFamily: 'Roboto,"Helvetica Neue",Helvetica,Arial,sans-serif',
              }
          }
      }]
  });
  $('#plan').highcharts({
      colors: ['#009688'],
      credits: {
          enabled: false
      },
      chart: {
          type: 'column',
          backgroundColor: 'transparent',
      },
      title: {
          text: ''
      },
      xAxis: {
          type: 'category',
          labels: {
              rotation: -45,
              style: {
                  fontSize: '13px',
                  fontFamily: 'Roboto,"Helvetica Neue",Helvetica,Arial,sans-serif'
              }
          },
          lineWidth: 0,
          minorGridLineWidth: 0,
          lineColor: 'transparent',
          minorTickLength: 0,
          tickLength: 0
      },
      yAxis: {
          min: 0,
          max: <?=$plan_max?>,
          lineWidth: 0,
          minorGridLineWidth: 0,
          labels: {
              enabled: false
          },
          gridLineColor: 'transparent',
          title: {
              text: ''
          }
      },
      legend: {
          enabled: false
      },
      tooltip: {
          pointFormat: 'Amount: <b>{point.y:.0f}</b>',
          enabled: false
      },
      series: [{
          name: 'Genres',
          data: [
              <?=$plan?>
          ],
          dataLabels: {
              enabled: true,
              rotation: -90,
              color: '#eee',
              align: 'right',
              x: 4,
              y: 10,
              style: {
                  fontSize: '13px',
                  fontFamily: 'Roboto,"Helvetica Neue",Helvetica,Arial,sans-serif',
              }
          }
      }]
  });
});
  </script>

</body>

</html>
