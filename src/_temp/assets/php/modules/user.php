<!--<div class="cover" style="background-image: url('<?= $userCover ?>')"></div>-->
<div class="cover lazy" data-original="<?= $userCover ?>"></div>
<div class="user">
  <!--<div class="user-avatar" style="background-image: url('<?= $userAvatar ?>')"></div>-->
  <div class="user-avatar lazy" data-original="<?= $userAvatar ?>"></div>
  <p class="user-name"><?= $user ?></p>
  <div class="user-update">
    <!--<button href="#">Update Profile</button>-->
  </div>
</div>
<p class="user-bio"><?= $userBio ?></p>
<div class="user-details">
  <p>General Info</p>
</div>
    
<?
  print_r($user . $userPlural . ' Details:');
  //echo '<br><br>Cover: ' . $userCover;
  //echo '<br><br>Avatar: ' . $userAvatar;
  //echo '<br><br>Bio: ' . $userBio;
  echo '<br><br>Waifu: ' . $userWaifu;
  echo '<br><br>Location: ' . $userLocation;
  echo '<br><br>Time: ' . $userTime;
  echo '<br><br>Human Time: ' . humanSeconds($userTime);
?>
