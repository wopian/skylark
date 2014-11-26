<?

    if (!isset($_COOKIE['uid'])) {
        $uid = (isset($_POST["userid"])) ? $_POST["userid"] : 0;
    } else {
        $uid = (isset($_COOKIE['uid'])) ? $_COOKIE['uid'] : 0;
    }

    echo $uid;

    if ($uid) {
        $mysqli = new mysqli("localhost","user","password","dbname");

        if ($mysqli->connect_errno) {
            printf("Connect failed: %s\n", $mysqli->connect_error);
            exit();
        }

        if ($query = $mysqli->query("SELECT username, avatar, rank FROM players WHERE id='".$uid."';")) {
            if (!$query) {
                throw new Exception("Database Error [{$mysqli->errno}] {$mysqli->error}");
                $mysqli->close();
                exit();
            }

            while ($res = $query->fetch_assoc()){
                $_SESSION['loggedUsr'] = $uid;
                $_SESSION['username'] = $res['username'];
                $_SESSION['urank'] = $res['rank'];
                $_SESSION['uavatar'] = "http://10.201.41.64" + $res['avatar'];
                echo "Session ok: ".$_SESSION['loggedUsr']." ".$_SESSION['username']." ".$_SESSION['urank']." ".$_SESSION['uavatar'].".<br>";
                echo $uid;
                setcookie("uid",$uid,time() + (86400*365));
                echo "Cookie ok: ".$_COOKIE['uid'].".";
            }

            $mysqli->close();
        }
    } else {
        echo "not ok";
    }
