<?

    if (!isset($_COOKIE['uid'])) {
        $uid = (isset($_POST["userid"])) ? $_POST["userid"] : 0;
    } else {
        $uid = (isset($_COOKIE['uid'])) ? $_COOKIE['uid'] : 0;
    }

    echo "$uid <br>";

    $uid = 1;

    echo "$uid <br>";

    setcookie("uid",$uid,time() + (86400*365));
    echo "Cookie ok: ".$_COOKIE['uid'].".";
