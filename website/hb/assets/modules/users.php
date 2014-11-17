<?php
    # Grab user field from url and load user stats
    $user = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING);
    $user_url = "https://hummingbird.me/api/v1/users/$user";
    $user_json = file_get_contents($user_url);
    $user_data= json_decode($user_json, true);

    # Makes first character uppercase
    $user_name = ucfirst($user_data['name']);
    $user_cover = $user_data['cover_image'];
    $user_avatar = $user_data['avatar'];
    $user_bio = $user_data['bio'];
    $user_location = $user_data['location'];
    $user_waifu = $user_data['waifu'];
    $user_waifuor = $user_data['waifu_or_husbando'];

    # Strips trailing 's' from username when last character of username is 's'
    function properize($string) {
        return $string.'\''.($string[strlen($string) - 1] != 's' ? 's' : '');
    }

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
?>

<div class="cover" style="background-image: url('<?=$user_cover?>')">
    <div>
        <img src="<?=$user_avatar?>">
    </div>
</div>

<div class="container">
    <div class="page-header">

        <div class="col-lg-6 col-md-6 col-sm-6">
            <h1><?=$user_name?></h1>
            <p class="lead"><?=$user_bio?></p>
        </div>

        <?=$user_waifu?>

        <div class="clearfix visible-lg-block visible-md-block visible-sm-block"></div>

        <div class="col-lg-6 col-md-6 col-sm-6">
            <p class="h1">Location</p>
            <p class="lead"><?=$user_location?></p>
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
            $recent_url = "https://hummingbird.me/library_entries?user_id=$user&recent=true";
            $recent_json = file_get_contents($recent_url);
            $recent= json_decode($recent_json, true);

            for ($x = 0; $x < 4; $x++) {

                if (empty($recent['anime'][0]['id'])) {
                    echo "<p class='lead'>$user_name has not watched any anime recently. :(</p>";
                }

                if (isset($recent['anime'][$x]['id']) || !empty($recent['anime'][$x]['id'])) {

                    $hidden = ($x === 3) ? ' hidden-md hidden-sm' : '';

                    $recent_cover = $recent['anime'][$x]['poster_image'];
                    $recent_uri = $recent['anime'][$x]['id'];
                    $recent_title = $recent['anime'][$x]['canonical_title'];
                    $recent_episodes = $recent['anime'][$x]['episode_count'];
                    $recent_watched = $recent['library_entries'][$x]['episodes_watched'];
                    $recent_status = $recent['library_entries'][$x]['status'];
                    $recent_time = time() - (strtotime($recent['library_entries'][$x]['last_watched']));
                    $recent_last = seconds2human($recent_time, true);

                    if ($recent_episodes == 0 || $recent_episodes == null || $recent_episodes == '?') {
                        $recent_episodes = '∞';
                    }

                    $recent_title = (strlen($recent_title)>30) ? substr($recent_title,0,27).'&hellip;' : $recent_title;

                    switch ($recent_status) {
                        case 'Currently Watching':
                            $recent_status = 'Watched '.$recent_watched.' of '.$recent_episodes.' episodes';
                            break;
                        case 'Completed':
                            $recent_status = 'Completed.';
                            break;
                        case 'Plan to Watch':
                            $recent_status = 'Plans to watch.';
                            break;
                        case 'On Hold':
                            $recent_status = 'On hold.';
                            break;
                        case 'Dropped':
                            $recent_status = 'Dropped after '.$recent_watched.' episodes.';
                            break;
                    }

                    echo    '<div class="col-lg-3 col-md-4 col-sm-4 col-xs-6'.$hidden.'">
                                <div class="thumbnail">
                                    <a href="//hummingbird.me/anime/'.$recent_uri.'"><img src="'.$recent_cover.'" alt="'.$recent_title.'"></a>
                                    <div class="caption">
                                        <h4>'.$recent_title.'</h4>
                                        <p>'.$recent_status.'</p>
                                        <p>'.$recent_last.' ago</p>
                                    </div>
                                </div>
                            </div>';
                }
            }
        ?>
    </div>

  <?php
      $url = "https://hummingbird.me/library_entries?user_id=".$user;
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
      if (!empty($result)) {
          echo '<div class="col-lg-6 no-gutter">
                  <div class="col-lg-12">
                    <p class="h1">Genre Overview</p>
                  </div>
                  <div id="overview" class="col-lg-12" style="height: auto; max-width: 570px"></div>
                </div>';
      }

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
      if (!empty($result)) {
          echo '<div class="col-lg-6 no-gutter">
                  <div class="col-lg-12">
                    <p class="h1">Completed Anime</p>
                  </div>
                  <div id="completed" class="col-lg-12" style="height: auto; max-width: 570px"></div>
                </div>';
      }

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
      if (!empty($result)) {
          echo '<div class="col-lg-6 no-gutter">
                  <div class="col-lg-12">
                    <p class="h1">Currently Watching Anime</p>
                  </div>
                  <div id="currently" class="col-lg-12" style="height: auto; max-width: 570px"></div>
                </div>';
      }

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
      if (!empty($result)) {
          echo '<div class="col-lg-6 no-gutter">
                  <div class="col-lg-12">
                    <p class="h1">Plan to Watch Anime</p>
                  </div>
                  <div id="plan" class="col-lg-12" style="height: auto; max-width: 570px"></div>
                </div>';
      }

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
