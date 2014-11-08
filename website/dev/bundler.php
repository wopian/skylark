<?php
    $page = $_GET['page'];

    switch ($page) {
        case "user":
            $user = $_GET['user'];
            $ajaxData = 'user='. $user .'&page=user';
            break;
        case "library":
            $user = $_GET['user'];
            $status = $_GET['status'];
            $ajaxData = 'user='. $user .'&status='. $status .'page=library';
            break;
        case "compare":
            $user = $_GET['user'];
            $user2 = $_GET['user2'];
            $ajaxData = 'user='. $user .'&user2='. $user2 .'page=compare';
            break;
    }
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="/assets/css/main.css" rel="stylesheet">
</head>

<body>

    <div id="content">
    </div>

    <svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
        <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
    </svg>

    <img id="dploy" src="https://wopian.dploy.io/badge/13023223950720/13284.png" alt="Deployment status from dploy.io">

    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <script>
        $('.spinner').show();

        var post_data = "<?=$ajaxData?>";
        $.ajax({
            url: '/assets/modules/processor.php',
            type: 'POST',
            data: post_data,
            dataType: 'html',
            success: function(data) {
                $('.content').html(data);
                //Moved the hide event so it waits to run until the prior event completes
                //It hide the spinner immediately, without waiting, until I moved it here
                $('.spinner').hide();
            },
            error: function() {
                alert("Something went wrong!");
            }
        });
    </script>

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
