<?

    if (!isset($_COOKIE['uid'])) {
        $uid = (isset($_POST["userid"])) ? $_POST["userid"] : "post";
    } else {
        $uid = (isset($_COOKIE['uid'])) ? $_COOKIE['uid'] : "cookie";
    }

    setcookie("uid",$uid,time() + (86400*365), '/');
    $_COOKIE['uid'] = $uid;

    echo "Cookie: ".$_COOKIE['uid'].".<br>";
    echo "Initial: $uid <br>";
