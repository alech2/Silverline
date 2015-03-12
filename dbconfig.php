<?php

/**
 * @author pokemon_hamster
 * @copyright 2015
 */

class DB_connection {



    public function dbConnect() {
            return new PDO("mysql:host=localhost; dbname=silverline", "root", "309541076");
    }

    public function disconnect() {
        if ($this->con) {
            if (@mysql_close()) {
                $this->con = false;
                return true;
            } else {
                return false;
            }
        }
    }
}

?>