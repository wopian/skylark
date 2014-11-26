<?

    if (!isset($_COOKIE['uid'])) {
        $uid = (isset($_POST["userid"])) ? "post set" : "post not set";
    } else {
        $uid = (isset($_COOKIE['uid'])) ? "cookie set" : "cookie not set";
    }

    setcookie("uid",$uid,time() + (86400*365), '/');
    $_COOKIE['uid'] = $uid;

    echo "Cookie: ".$_COOKIE['uid'].".<br>";
    echo "Initial: $uid <br>";

git remote add upstream /url/to/original/repo
git fetch upstream
git checkout master
git reset --hard upstream/master
git push origin master --force
