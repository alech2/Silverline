<?php

include_once('dbconfig.php');

class User {

    private $db;

    public function __construct() {
        $Connection = new DB_connection();
        $this->db = $Connection->dbConnect();
    }

    public function Login($name, $pass) {
        if (isset($name) && isset($pass)) {
            $st = $this->db->prepare("SELECT * FROM users WHERE username= ? AND password= ?");
            $st->bindParam(1, $name);
            $st->bindParam(2, $pass);
            $st->execute();

            if ($st->rowCount() == 1) {
                echo "User Verified";
            } else {
                echo "Access Denied";
            }

        } else {
            echo "Set Pass And UserName";
        }

    }
}

?>