<?php

/**
 * @author pokemon_hamster
 * @copyright 2015
 */

include_once('dbconfig.php');

class CRUD {

    public function __construct() {
        $db = new DB_connection();
    }

    private $result = array();

    private function tableExists($table) {
        $tablesInDb = @mysql_query('SHOW TABLES FROM ' . $this->db_name . ' LIKE "' . $table .
            '"');
        if ($tablesInDb) {
            if (mysql_num_rows($tablesInDb) == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     *  This function simply checks the database to see if the required table already exists. 
     *  If it does it will return true and if not, it will return false.
     */
    public function select($table, $rows = '*', $where = null, $order = null) {
        $q = 'SELECT ' . $rows . ' FROM ' . $table;
        if ($where != null) $q .= ' WHERE ' . $where;
        if ($order != null) $q .= ' ORDER BY ' . $order;
        if ($this->tableExists($table)) {
            $query = @mysql_query($q);
            if ($query) {
                $this->numResults = mysql_num_rows($query);
                for ($i = 0; $i < $this->numResults; $i++) {
                    $r = mysql_fetch_array($query);
                    $key = array_keys($r);
                    for ($x = 0; $x < count($key); $x++) {
                        // Sanitizes keys so only alphavalues are allowed
                        if (!is_int($key[$x])) {
                            if (mysql_num_rows($query) > 1) $this->result[$i][$key[$x]] = $r[$key[$x]];
                            else
                                if (mysql_num_rows($query) < 1) $this->result = null;
                                else  $this->result[$key[$x]] = $r[$key[$x]];
                        }
                    }
                }
                return true;
            } else {
                return false;
            }
        } else  return false;
    }
}

?>