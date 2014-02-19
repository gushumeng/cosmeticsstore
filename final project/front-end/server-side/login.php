<?php

require_once('Customer.php');

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
        print("Customer not found while login.");
        exit();
    }

    $customer = Customer::findByUsernameAndPassword($username, $password);

    if ($customer == null ) {
        header("HTTP/1.0 404 Not Found");
        print("Customer not found while login.");
        exit();
    }

    header("Content-type: application/json");
    print($customer->getJSON());
    exit();
}