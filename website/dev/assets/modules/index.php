<!DOCTYPE html>
<html>

<head>
    <title>Hummingbird Tools</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Hummingbird Tools hosts a variety of tools and stats for Hummingbird.">
    <meta name="keywords" content="Hummingbird,Tool,Tools,Anime,Manga,API,User Stats,Library,User Library,Cover,Cover Images">
    <meta name="author" content="James Harris">

    <meta property="og:image" content="http://9.dev.boomcraft.co.uk/dist/images/avatar_teal.png" />
    <meta property="og:url" content="http://9.dev.boomcraft.co.uk" />
    <meta property="og:title" content="Hummingbird Tools" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@hb_tools" />
    <meta name="twitter:title" content="Hummingbird Tools" />
    <meta name="twitter:description" content="A variety of tools and stats for Hummingbird." />
    <meta name="twitter:image" content="http://9.dev.boomcraft.co.uk/dist/images/twitter_teal.png" />
    <meta name="twitter:url" content="http://9.dev.boomcraft.co.uk" />

    <link href="/assets/css/main.css" rel="stylesheet">
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

    <div class="container" id="main">
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
    </div>

    <svg class="spinner" width="66px" height="66px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
        <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
    </svg>

    <img id="dploy" src="https://wopian.dploy.io/badge/13023223950720/13284.png" alt="Deployment status from dploy.io">

    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <script src="/assets/javascript/ripples.min.js"></script>
    <script src="/assets/javascript/material.min.js"></script>

    <script>
        $(document).ready(function() {
            $.material.init();
        });
    </script>

    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-545296d61bde8abb" async="async"></script>

</body>

</html>
