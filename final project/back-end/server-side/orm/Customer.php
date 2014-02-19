<?php

define("DB_HOST", "classroom.cs.unc.edu"); // classroom.cs.unc.edu
define("DB_USER", "fanl"); // kmp
define("DB_PASSWORD", "liuliushumeng"); // comp426
define("DB_DB", "fanldb"); //kmpdb

date_default_timezone_set('America/New_York');

class Customer
{
    private $customer_id;
    private $username;
    private $password;

    private function __construct($customer_id, $username, $password) {
        $this->customer_id = $customer_id;
        $this->username = $username;
        $this->password = $password;
    }

    public static function findByUsernameAndPassword($username, $password) {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);

        $result = $mysqli->query("select * from CUSTOMER where username = '" . $username . "' and password = '" . $password . "'");

        if ($result) {
            if ($result->num_rows == 0) {
                return null;
            }

            $customer_info = $result->fetch_array();

            return new Customer(intval($customer_info['customer_id']),
                $customer_info['username'],
                $customer_info['password']
            );
        }
        return null;
    }

    public function getJSON() {

        $json_obj = array('customer_id' => $this->customer_id,
            'username' => $this->username,
            'password' => $this->password
        );
        return json_encode($json_obj);
    }

}