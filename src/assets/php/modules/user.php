<?
 #Grab user field from URL and preload user info
  $username = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['user']);
  $usernamePlural = (substr($username, -1) == 's') ? '\'' : '\'s';



  require('../partials/header.php'); 
?>

<section class="content">
  <main>
    <?
      print_r($username . $usernamePlural);
    ?>
  </main>

  <aside>Side 1</aside>
  <aside>Side 2</aside>
</section>

<? require('../partials/footer.php'); ?>
