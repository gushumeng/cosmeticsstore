<?php

define("DB_HOST", "classroom.cs.unc.edu"); // classroom.cs.unc.edu
define("DB_USER", "fanl"); // kmp
define("DB_PASSWORD", "liuliushumeng"); // comp426
define("DB_DB", "fanldb"); //kmpdb

date_default_timezone_set('America/New_York');

class Administrator
{
    private $a_id;
    private $username;
    private $password;

    private function __construct($a_id, $username, $password) {
        $this->a_id = $a_id;
        $this->username = $username;
        $this->password = $password;
    }

    public static function findByUsernameAndPassword($username, $password) {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);

        $result = $mysqli->query("select * from ADMINISTRATOR where username = '" . $username . "' and password = '" . $password . "'");

        if ($result) {
            if ($result->num_rows == 0) {
                return null;
            }

            $administrator_info = $result->fetch_array();

            return new Administrator(intval($administrator_info['a_id']),
                $administrator_info['username'],
                $administrator_info['password']
            );
        }
        return null;
    }

    public function getJSON() {

        $json_obj = array('a_id' => $this->a_id,
            'username' => $this->username,
            'password' => $this->password
        );
        return json_encode($json_obj);
    }

}