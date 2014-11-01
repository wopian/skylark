<?
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

?>
