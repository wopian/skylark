<?php
$username = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['user']);
$usernamePlural = (substr($username, -1) == 's' ? '\'' : '\'s';

print_r($username . $usernamePlural);

?>
