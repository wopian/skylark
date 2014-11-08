<?php
    $page = $_GET['page'];

    switch ($page) {
        case 'index';
            require_once('//dev.hb.wopian.me/assets/modules/index.php');
            break;
        case "user":
            echo "user";
            break;
        case "library":
            echo "library";
            break;
        case "compare":
            echo "compare";
            break;
    }
?>
