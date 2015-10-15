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
  $userTime       = $apiData['life_spent_on_anime'];
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

  function humanSeconds($minutes) {
    $zero    = new DateTime('@0');
    //Function reports one less day than HB report, so add 1 day (1440 minutes)
    $offset  = new DateTime('@' . ($minutes + 1440) * 60);
    $diff    = $zero->diff($offset);
    return $diff->format('%Y years, %m months, %a days, %h hours, %i minutes of anime');
  }
?>
