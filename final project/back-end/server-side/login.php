<?php

require_once('orm/Administrator.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $username = false;
    if (isset($_REQUEST['username'])) {
        $username = trim($_REQUEST['username']);
    }

    $password = false;
    if (isset($_REQUEST['password'])) {
        $password = trim($_REQUEST['password']);
    }

    if ($username == null || $password == null) {
        header("HTTP/1.0 404 Not Found");
        print("Administrator not found while login.");
        exit();
    }

    $administrator = Administrator::findByUsernameAndPassword($username, $password);

    if ($administrator == null ) {
        header("HTTP/1.0 404 Not Found");
        print("administrator not found while login.");
        exit();
    }

    header("Content-type: application/json");
    print($administrator->getJSON());
    exit();
}