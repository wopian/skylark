<!DOCTYPE html>
<html>

<?
  ob_end_flush();

  $user = $_GET['user'];
  $userh = ucfirst($user);
  if (substr($user, -1) == "s") {
    $plural = "'";
  } else {
    $plural = "'s";
  }
  $header = $userh.$plural;

  $url = "http://hummingbird.me/api/v1/users/".$user;
  $json = file_get_contents($url);
  $data = json_decode($json, true);

  ob_start();
  flush();

?>

<head>
  <title><?=$header?> Profile - Hummingbird Tools</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="View <?=$header?> profile.">
  <meta name="keywords" content="Hummingbird,Tool,Tools,Anime,Manga,API,Profile,User,Stats,<?=$user?>">
  <meta name="author" content="James Harris">

  <meta property="og:image" content="<?=$data['avatar']?>" />
  <meta property="og:url" content="http://9.dev.boomcraft.co.uk/<?=$user?>" />
  <meta property="og:title" content="<?=$header?> Profile - Hummingbird Tools" />

  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@hb_tools" />
  <meta name="twitter:title" content="<?=$header?> Profile - Hummingbird Tools" />
  <meta name="twitter:description" content="View <?=$header?> profile." />
  <meta name="twitter:image" content="<?=$data['avatar']?>" />
  <meta name="twitter:url" content="http://9.dev.boomcraft.co.uk/<?=$user?>" />

  <link href="/dist/css/custom.css" rel="stylesheet">
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
          <li><a rel="prerender" href="/">Home</a></li>
          <li class="active"><a href="/<?=$user?>">Info</a></li>
          <li><a rel="prerender" href="/<?=$user?>/library">Library</a></li>
          <li><a rel="prerender" href="/<?=$user?>/">Cover Images</a></li>
          <li><a rel="prerender" href="//hummingbird.me/users/<?=$user?>">Hummingbird</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="" class="dropdown-toggle" data-toggle="dropdown">Other Sites <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a rel="prerender" href="//manga.jamesharris.net">Manga</a></li>
              <li class="divider"></li>
              <li><a rel="prerender" href="//jamesharris.net">Portfolio</a></li>
              <li><a rel="prerender" href="//whatpulse.jamesharris.net">WhatPulse Stats</a></li>
              <li><a rel="prerender" href="//lastfm.jamesharris.net">Lastistics</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="cover cover-loading">
    <div class="spinner">
      <div class="double-bounce1"></div>
      <!--<div class="double-bounce2"></div>-->
    </div>
  </div>

  <div id="container">
    <!--<div id="cover loading" style="background-image: url('https://s3.amazonaws.com/f.cl.ly/items/062K3X2O2724291l0X0y/cover-default.png')">-->
  </div>


  <a id="dploy" href="http://dploy.io"><img src="https://wopian.dploy.io/badge/13023223950720/13284.png" alt="Deployment status from dploy.io"></a>

  <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

  <script src="/dist/js/ripples.min.js"></script>
  <script src="/dist/js/material.min.js"></script>

  <script>
    $(document).ready(function start(){
      $.get('/dist/templates/users.php?user=<?=$user?>',null,function(result) {
        setTimeout(function(){
          $(".cover-loading").fadeOut('slow').remove();
        }, 100);
        setTimeout(function(){
          $("#container").hide().html(result).fadeIn('slow');
        }, 500);
      },'html');
    });
  </script>

  <script>
    $(document).ready(function() {
      $.material.init();
    });
  </script>

  <script src="/dist/js/highcharts.js"></script>
  <script src="/dist/js/exporting.js"></script>

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
                        //color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
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
                          //color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
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
                          //color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
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
                          //color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
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

  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-545296d61bde8abb" async="async"></script>

</body>

</html>
