<? ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <?
    if (isset($user)) {
      print('<title>'.$user.' &horbar; Hibari</title>');
    } else {
      print('<title>Hibari</title>');
    }
  ?>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="/assets/css/a.min.css" rel="stylesheet">
  <link href="//brick.a.ssl.fastly.net/Fira+Sans:300,400,500" rel="stylesheet">

  <!-- Meta Data -->
  <meta name="description" content="Hummingbird Tools hosts a variety of tools and stats for Hummingbird.">
  <meta name="keywords" content="Hummingbird,Tool,Tools,Anime,Manga,API,User Stats,Library,User Library,Cover,Cover Images">
  <meta name="author" content="James Harris">
  <meta name="robots" content="NOODP">

  <!--<meta property="og:image" content="//hb.wopian.me/assets/images/avatar_teal.png" />
  <meta property="og:url" content="hb.wopian.me" />
  <meta property="og:title" content="Hummingbird Tools" />

  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@hb_tools" />
  <meta name="twitter:title" content="Hummingbird Tools" />
  <meta name="twitter:description" content="A variety of tools and stats for Hummingbird." />
  <meta name="twitter:image" content="//hb.wopian.me/assets/images/twitter_teal.png" />
  <meta name="twitter:url" content="//hb.wopian.me" />-->
</head>

<body>

  <header>
    <div>
      <a href="#Explore">Explore</a>
      <a href="#Trends">Trends</a>
      <a href="#Covers">Covers</a>
    </div>

    <a href="/">Hibari</a>

    <div>
      <a href="#Profile">Profile</a>
      <a href="#Anime">Anime</a>
      <a href="#Manga">Manga</a>
    </div>
  </header>
