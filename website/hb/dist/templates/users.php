<?php
    $user = $_GET['user'];
    $userh = ucfirst($user);
    $url = "http://hummingbird.me/api/v1/users/".$user;
    $json = file_get_contents($url);
    $data = json_decode($json, true);

    $username = $data['name'];
    $userplural = (substr($username, -1) == "s") ? "'" : "'s";

    function seconds2human($ss, $recent = false) {
        $m = (floor(($ss%3600)/60)>0)?floor(($ss%3600)/60).' minutes':"";
        $h = (floor(($ss % 86400) / 3600)>0)?floor(($ss % 86400) / 3600).' hours':"";
        $d = (floor(($ss % 2592000) / 86400)>0)?floor(($ss % 2592000) / 86400).' days':"";
        $M = (floor($ss / 2592000)>0)?floor($ss / 2592000).' months,':"";
        $y = (floor($ss / 31557600)>0)?floor($ss / 31557600).' years,':"";
        if ( strlen($m) > 1 && ( strlen($h) > 1 || strlen($d) > 1 || strlen($M) > 1 )) {
            $and = 'and';
        } else {
            $and = '';
        }
        if ($recent === false) {
            return "$y $M $d $h $and $m";
        } else {
            if ($y != '') { return "$y"; }
            elseif ($y == '' && $M != '') { return "$M"; }
            elseif ($y == '' && $M == '' && $d != '') { return "$d"; }
            elseif ($y == '' && $M == '' && $d == '' && $h != '') { return "$h"; }
            elseif ($y == '' && $M == '' && $d == '' && $h == '' && $m != '') { return "$m"; }
        }
    }

    $waifu = $data['waifu'];
    $waifuOrhusbando = $data['waifu_or_husbando'];
    if($user == 'doramu'){
        $waifu = '<a class="waifu" href="//hummingbird.me/users/kusoneko">Kusoneko</a>';
        $waifuOrhusbando = 'Husbando';
    } elseif($user == 'kusoneko'){
        $waifu = '<a class="waifu" href="//hummingbird.me/users/doramu">Doramu</a>';
        $waifuOrhusbando = 'Waifu';
    }
?>

<div class="cover" style="background-image: url('<?=$data['cover_image']?>')">
  <div>
    <img src="<?=$data['avatar']?>">
  </div>
</div>

<div class="container">

  <div class="page-header">
    <div class="col-lg-6 col-md-6 col-sm-6">
      <h1><?=$username?></h1>
      <p class="lead"><?=$data['bio']?></p>
    </div>

    <?
        if(strlen($waifu) > 0) {
            echo '<div class="col-lg-6 col-md-6 col-sm-6 text-right">
                    <p class="h1">'.$waifu.'</p>
                    <p class="lead">'.$waifuOrhusbando.'<p>
                  </div>';
        }
    ?>

    <div class="clearfix visible-lg-block visible-md-block visible-sm-block"></div>

    <div class="col-lg-6 col-md-6 col-sm-6">
      <p class="h1">Location</p>
      <p class="lead"><?=$data['location']?></p>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 text-right">
      <p class="h1">Watched</p>
      <p class="lead"><?=seconds2human($data['life_spent_on_anime']*60)?> of anime</p>"
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
      <p class="h1">Recent Anime</p>
    </div>

  </div>

  <div class="row">
    <?php
        $url = "http://hummingbird.me/library_entries?user_id=".$user."&recent=true";
        $json = file_get_contents($url);
        $recent = json_decode($json, true);

        for ($x=0; $x<4; $x++) {
            if (empty($recent['anime'][0]['id'])) {
              echo "$username hasn't watched any anime recently.";
              break;
            }
            if (isset($recent['anime'][$x]['id']) || !empty($recent['anime'][$x]['id'])) {

                $hidden =  ($x === 3) ? ' hidden-md hidden-sm' : '';

                $cover = $recent['anime'][$x]['poster_image'];
                $uri = $recent['anime'][$x]['id'];
                $title = $recent['anime'][$x]['canonical_title'];
                $episodes = $recent['anime'][$x]['episode_count'];
                $watched = $recent['library_entries'][$x]['episodes_watched'];
                $status = $recent['library_entries'][$x]['status'];
                $time = time() - (strtotime($recent['library_entries'][$x]['last_watched']));
                $last = seconds2human($time, true);

                if ($episodes == 0 || $episodes == null || $episodes == '?') {
                    $episodes='∞';
                }

                $title = (strlen($title)>30) ? substr($title,0,27).'&hellip;' : $title;

                switch ($status) {
                    case 'Currently Watching':
                        $status = 'Watched '.$watched.' of '.$episodes.' episodes';
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
                echo '<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6'.$hidden.'">
                        <div class="thumbnail card-image">
                          <a href="http://hummingbird.me/anime/'.$uri.'"><img src="'.$cover.'" alt="'.$title.'"></a>
                          <div class="caption">
                            <h4>'.$title.'</h4>
                            <p>'.$status.'</p>
                            <p>'.$last.' ago</p>
                          </div>
                        </div>
                      </div>';
            }
        }
    ?>
  </div>

  <?php
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
  ?>

  <div class="col-lg-6 no-gutter">
    <div class="col-lg-12">
      <p class="h1">Genre Overview</p>
    </div>
    <div id="overview" class="col-lg-12" style="height: auto; max-width: 570px"></div>
  </div>

  <div class="col-lg-6 no-gutter">
    <div class="col-md-6 col-lg-12">
      <p class="h1">Completed Anime</p>
    </div>
    <div id="completed" class="col-lg-12" style="height: auto; max-width: 570px"></div>
  </div>

  <div class="col-lg-6 no-gutter">
    <div class="col-lg-12">
      <p class="h1">Currently Watching Anime</p>
    </div>
    <div id="currently" class="col-lg-12" style="height: auto; max-width: 570px"></div>
  </div>

  <div class="col-lg-6 no-gutter">
    <div class="col-lg-12">
      <p class="h1">Plan to Watch Anime</p>
    </div>
    <div id="plan" class="col-lg-12" style="height: auto; max-width: 570px"></div>
  </div>

</div>

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
