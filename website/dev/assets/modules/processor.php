<?php
    $page = $_GET['page'];

    switch ($page) {
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
