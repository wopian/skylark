<?php
    if ($_POST['type'] == 'info' && !empty($_POST['infoUser'])) {
        $user = $_POST['infoUser'];
        header("Location: //hb.wopian.me/$user");
    }

    if ($_POST['type'] == 'library' && !empty($_POST['libraryUser'])) {
        $user = $_POST['libraryUser'];
        $status = '/' . $_POST['libraryStatus'];
        if ($status == '/') { $status = ''; }
        header("Location: //hb.wopian.me/$user/library$status");
    }
    if ($_POST['type'] == 'compare' && (!empty($_POST['compareUser']) || !empty($_POST['compareUser2']))) {
        $user = $_POST['compareUser'];
        $user2 = $_POST['compareUser2'];
        header("Location: //fuzetsu.github.io/hummingbird-user-compare/?user1=$user&user2=$user2&type=anime");
    }
?>

<!DOCTYPE html>
<html lang="en-us">

<head>
  <title>Hummingbird Tools</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Hummingbird Tools hosts a variety of tools and stats for Hummingbird.">
  <meta name="keywords" content="Hummingbird,Tool,Tools,Anime,Manga,API,User Stats,Library,User Library,Cover,Cover Images">
  <meta name="author" content="James Harris">
  <meta name="robots" content="NOODP">

  <meta property="og:image" content="//hb.wopian.me/assets/images/avatar_teal.png" />
  <meta property="og:url" content="hb.wopian.me" />
  <meta property="og:title" content="Hummingbird Tools" />

  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@hb_tools" />
  <meta name="twitter:title" content="Hummingbird Tools" />
  <meta name="twitter:description" content="A variety of tools and stats for Hummingbird." />
  <meta name="twitter:image" content="//hb.wopian.me/assets/images/twitter_teal.png" />
  <meta name="twitter:url" content="//hb.wopian.me" />

  <link href="/assets/css/custom.css" rel="stylesheet">
</head>

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
          <li class="active"><a href="/">Home</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="" class="dropdown-toggle" data-toggle="dropdown">Other Sites <b class="caret"></b></a>
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

  <div class="container">

    <div class="page-header">
      <h1>Hummingbird Tools <small>various tools and stats for <a href="//hummingbird.me">Hummingbird</a></small></h1>
    </div>

    <div class="panel panel-default">
      <div class="panel-body">
        <h2><i class="mdi-social-poll"></i> User Info</h2>
        <p>Something cool here?</p>
        <form class="form-horizontal" method="POST" action="/">
          <fieldset>
            <div class="form-group">
              <label class="control-label col-lg-1">Username</label>
              <div class="col-lg-11">
                <input class="form-control input-lg floating-label" name="infoUser" id="infoUser" placeholder="Enter a Hummingbird username." type="text" required>
              </div>
            </div>

            <div class="form-group">
              <input type="hidden" name="type" value="info">
              <button type="submit" class="btn btn-material-teal btn-lg btn-flat btn-block">View Stats</button>
            </div>
          </fieldset>
        </form>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-body">
        <h2><i class="mdi-maps-local-library"></i> User Library</h2>
        <p>Something cool here?</p>
        <form class="form-horizontal" method="POST" action="/">
          <fieldset>
            <div class="form-group">
              <label class="control-label col-lg-1">Username</label>
              <div class="col-lg-11">
                <input class="form-control input-lg floating-label" name="libraryUser" id="libraryUser" placeholder="Enter a Hummingbird username." type="text" required>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-lg-1">Status</label>
              <div class="col-lg-11">
                <div class="col-lg-4">
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="libraryStatus" id="libraryStatus1" value="" checked="" type="radio">
                      All
                    </label>
                  </div>
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="libraryStatus" id="libraryStatus2" value="plan-to-watch" type="radio">
                      Plan To Watch
                    </label>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="libraryStatus" id="libraryStatus3" value="completed" type="radio">
                      Completed
                    </label>
                  </div>
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="libraryStatus" id="libraryStatus4" value="on-hold" type="radio">
                      On Hold
                    </label>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="libraryStatus" id="libraryStatus5" value="currently-watching" type="radio">
                      Currently Watching
                    </label>
                  </div>
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="libraryStatus" id="libraryStatus6" value="dropped" type="radio">
                      Dropped
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <input type="hidden" name="type" value="library">
              <button type="submit" class="btn btn-material-teal btn-lg btn-flat btn-block">View Library</button>
            </div>
          </fieldset>
        </form>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-body">
        <h2><i class="mdi-social-people"></i> Compare Users</h2>
        <p>Something cool here?</p>
        <form class="form-horizontal" method="POST" action="/">
          <fieldset>
            <div class="form-group">
              <label class="control-label col-lg-1">Username</label>
              <div class="col-lg-11">
                <input class="form-control input-lg floating-label" name="compareUser" id="compareUser" placeholder="Enter a Hummingbird username." type="text" required>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-lg-1">Username</label>
              <div class="col-lg-11">
                <input class="form-control input-lg floating-label" name="compareUser2" id="compareUser2" placeholder="Enter another Hummingbird username." type="text" required>
              </div>
            </div>

            <div class="form-group">
              <input type="hidden" name="type" value="compare">
              <button type="submit" class="btn btn-material-teal btn-lg btn-flat btn-block">Compare Users</button>
            </div>
          </fieldset>
        </form>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-body">
        <h2>Cover Images</h2>
        <p>Something cool here?</p>
        <img class="img-responsive" src="/assets/images/covers/default/normal1.png" alt="Cover image example."><br />

        <form class="form-horizontal">
          <fieldset>
            <div class="form-group">
              <label class="control-label col-lg-1">Username</label>
              <div class="col-lg-11">
                <input class="form-control input-lg floating-label" id="focusedInput" placeholder="Enter a Hummingbird username." type="text">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-lg-1">Amount</label>
              <div class="col-lg-11">
                <div class="col-lg-4">
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="Amount" id="Amount" value="option1" checked="" type="radio">
                      6 Images (1 row of 6)
                    </label>
                  </div>
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="Amount" id="Amount" value="option2" type="radio">
                      24 Images (2 rows of 12)
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-lg-1">Status</label>
              <div class="col-lg-11">
                <div class="col-lg-4">
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="Status" id="Status" value="option1" checked="" type="radio">
                      All
                    </label>
                  </div>
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="Status" id="Status" value="option2" type="radio">
                      Currently Watching
                    </label>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="Status" id="Status" value="option2" type="radio">
                      Favourites
                    </label>
                  </div>
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="Status" id="Status" value="option2" type="radio">
                      Plan To Watch
                    </label>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="Status" id="Status" value="option2" type="radio">
                      Completed
                    </label>
                  </div>
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="Status" id="Status" value="option2" type="radio">
                      On Hold / Dropped
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-lg-1">Style</label>
              <div class="col-lg-11">
                <div class="col-lg-4">
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="Style" id="Style" value="option1" checked="" type="radio">
                      Full Colour
                    </label>
                  </div>
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="Style" id="Style" value="option2" type="radio">
                      Grayscale
                    </label>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="Style" id="Style" value="option2" type="radio">
                      Darkened
                    </label>
                  </div>
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="Style" id="Style" value="option2" type="radio">
                      Darkened Grayscale
                    </label>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="radio radio-material-teal">
                    <label>
                      <input name="Style" id="Style" value="option2" type="radio">
                      Even Darker
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <!--<button type="submit" class="btn btn-default btn-lg btn-flat btn-block withripple">Generate Cover<div class="ripple-wrapper"></div></button>-->
              <button class="btn btn-flat btn-material-teal btn-lg btn-block">Generate Cover</button>
            </div>
          </fieldset>
        </form>
      </div>
    </div>

  </div>

  <img id="dploy" src="//wopian.dploy.io/badge/13023223950720/13284.png" alt="Deployment status from dploy.io">

  <script src='/assets/js/modernizr.min.js'></script>
  <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

  <script src="/assets/js/ripples.js"></script>
  <script src="/assets/js/material.js"></script>

  <script>
  $(document).ready(function() {
    $.material.init();
  });
  function infoUser() {
    username = document.getElementById('infoUser').value;
    /*window.history.replaceState('page2', 'Title', '/user/' + userid);*/
    location.href = '' + username;
  };
  function libraryUser() {
    username = document.getElementById('libraryUser').value;
    /*window.history.replaceState('page2', 'Title', '/user/' + userid);*/
    location.href = '' + username + '/library';
  };
  function compareUser() {
    username = document.getElementById('compareUser').value;
    username2 = document.getElementById('compareUser').value;
    /*window.history.replaceState('page2', 'Title', '/user/' + userid);*/
    location.href = "https://fuzetsu.github.io/hummingbird-user-compare/?user1=" + username + "&user2=" + username2 + "&type=anime";
  };
  </script>

  <!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//stats.wopian.me/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 2]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//stats.wopian.me/piwik.php?idsite=2" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->


</body>

</html>
