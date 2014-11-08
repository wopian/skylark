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
