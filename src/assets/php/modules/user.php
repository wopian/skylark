<?
  #Grab username from URL
  $user = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['user']);

  #Download Hummingbird user profile
  $apiURL  = "https://hummingbird.me/api/v1/users/$user";
  $apiJSON = file_get_contents($apiURL);
  $apiData = json_decode($apiJSON, true);

  #Redirect to index if invalid username
  if (empty($apiData['name'])) {
    switch ($_SERVER['SERVER_NAME']) {
      case 'hb.wopian.me':
        header("Location: https://hb.wopian.me");
        break;
      case 'staging.wopian.me':
        header("Location: https://staging.wopian.me");
        break;
    }
  }

  #Use correct username capitalisation via API
  $user       = $apiData['name'];
  $userPlural = (substr($user, -1) == 's') ? '\'' : '\'s';

  #Extract key information
  $userCover      = $apiData['cover_image'];
  $userAvatar     = $apiData['avatar'];
  $userBio        = $apiData['bio'];
  $userWaifu      = $apiData['waifu'];
  $userWaifuCheck = $apiData['waifu_or_husbando'];
  $userTime       = $apiData['life_spent_on_anime']*60;
  $userLocation   = empty($apiData['location']) ? 'Unknown' : $apiData['location'];

  #Update MySQLi Database

  $db = new mysqli('localhost', 'bobstudi_hibari', 'eSU1Cq@R;s^I$R{Bgq', 'bobstudi_hibari');

  if ($db->connect_errno > 0) {
    die('Unable to connect to the database [' . $db->connect_error . ']');
  }

  $sql = "INSERT INTO `users` (`user`) VALUES ('" . $user . "') ON DUPLICATE KEY UPDATE `user` = '" . $user ."'";

  if(!$result = $db->query($sql)) {
    die('There was an error running the query [' . $db->error . ']');
  }
  #End Update MySQLi Database

  function humanSeconds($ss, $recent = false) {
    $m = (floor(($ss % 3600) / 60) > 0)       ? floor(($ss % 3600) / 60)       . ' minutes' : '';
    $h = (floor(($ss % 86400) / 3600) > 0)    ? floor(($ss % 86400) / 3600)    . ' hours'   : '';
    $d = (floor(($ss % 2592000) / 86400) > 0) ? floor(($ss % 2592000) / 86400) . ' days'    : '';
    $M = (floor($ss / 2592000) > 0)           ? floor($ss / 2592000)           . ' months'  : '';
    $y = (floor($ss / 31557600) > 0)          ? floor($ss / 31557600)          . ' years'   : '';

    if (strlen($m) > 1 && (strlen($h) > 1 || strlen($d) > 1 || strlen($M) > 1)) {
      $and = 'and';
    } else {
      $and = '';
    }

    #If no anime watched fill in with 0 minutes
    if (strlen($m) === '' && strlen($h) === '' && strlen($d) === '' && strlen($M) === '' && strlen($y) === '') {
      $m = '0 minutes';
    }

    if ($recent === false) {
      return "$y $M $d $h $and $m";
    } else {
      if ($y != '')                                                     { return "$y"; }
      elseif ($y == '' && $M != '')                                     { return "$M"; }
      elseif ($y == '' && $M == '' && $d != '')                         { return "$d"; }
      elseif ($y == '' && $M == '' && $d == '' && $h != '')             { return "$h"; }
      elseif ($y == '' && $M == '' && $d == '' && $h == '' && $m != '') { return "$m"; }
    }
  }

  require('../partials/header.php');
  
?>

<section class="content">
  <main>
    <div class="cover" style="background-image: url('<?= $userCover ?>')"></div>
    <div class="user">
      <div class="user-avatar" style="background-image: url('<?= $userAvatar ?>')"></div>
      <p class="user-name"><?= $user ?></p>
      <button class="user-update" href="#">Update Profile</button>
    </div>
    <p class="bio"><?= $userBio ?></p>
    <div class="user-details">
      <p>General Info</p>
    </div>
    
    <?
      print_r($user . $userPlural . ' Details:');
      echo '<br><br>Cover: ' . $userCover;
      echo '<br><br>Avatar: ' . $userAvatar;
      echo '<br><br>Bio: ' . $userBio;
      echo '<br><br>Waifu: ' . $userWaifu;
      echo '<br><br>Location: ' . $userLocation;
      echo '<br><br>Time: ' . $userTime;
      echo '<br><br>Human Time: ' . humanSeconds($userTime);
    ?>
  </main>

  <aside></aside>
  <aside></aside>
</section>

<? require('../partials/footer.php'); ?>
