<?php
header("Content-Type: text/text");

$key = "befd7918ae80d68cfe03530e453ceb587a053144";
$uploadhost = "https://i.wopian.me/";
$redirect = "http://i.wopian.me/denied";

#Comment this next line if you want Robots to index this site.
#if ($_SERVER["REQUEST_URI"] == "/robot.txt") { die("User-agent: *\nDisallow: /"); }

if (isset($_POST['key'])) {
    if ($_POST['key'] == $key) {
        $target = getcwd() . "/" . basename($_FILES['file']['name']);
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
            $hash = hash('crc32b', $target);
            rename(getcwd() . "/" . basename($_FILES['file']['name']), getcwd() . "/" . $hash . "." . end(explode(".", $_FILES['file']["name"])));
            echo $uploadhost . $hash . "." . end(explode(".", $_FILES['file']["name"]));
        } else {
            echo "Sorry, there was a problem uploading your file.";
        }
    } else {
        header('Location: '.$redirect);
    }
} else {
    header('Location: '.$redirect);
}
