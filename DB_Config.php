<?php
 class DB_Config //Stores the configurations to connect to the DB

    {

        static $confArray;

        public static function read($name)

        {

            return self::$confArray[$name];

        }

        public static function write($name, $value)

        {

            self::$confArray[$name] = $value;

        }

    }

    

    // Initialize the DB configurations for DB connection

    DB_Config::write('db.host', 'localhost');

    DB_Config::write('db.port', '');

    DB_Config::write('db.basename', 'silverline_db');

    DB_Config::write('db.user', 'root');

    DB_Config::write('db.password', '');



    class DB_Connection //Creates DB connection - singleton 

    {

        public $db_conn; // db connection

        private static $instance; // instance of connection

    

        private function __construct()

        {

            // create data base name from config

            $db_conf = 'mysql:host=' . DB_Config::read('db.host') .

                   ';dbname=' . DB_Config::read('db.basename') .

                   ';port=' . DB_Config::read('db.port') .

                   ';connect_timeout=15';

            // getting DB user from config                

            $user = DB_Config::read('db.user');

            // getting DB password from config                

            $password = DB_Config::read('db.password');

            //create connection

            

            $this->db_conn = new PDO($db_conf, $user, $password);

            $this->db_conn->exec("SET NAMES 'hebrew'"); //Need in order to query hebrew text

        }

    

        public static function getInstance()

        {

            if (!isset(self::$instance))

            {

                $object = __CLASS__;

                self::$instance = new $object;

            }

            return self::$instance;

        }

    }

    

    //Check if username or password exists and return user_id if exists else return -1 

    function ifUserExist($new_username,$new_password)

    {

     //$new_username=md5($new_username);

     $new_password=md5($new_password);

     $q = 'SELECT user_id FROM users WHERE user_name = ? OR password = ?';

        try {

            $db_connect = DB_Connection::getInstance();

            $stmt = $db_connect->db_conn->prepare($q);

            $param=array($new_username,$new_password);

            if ($stmt->execute($param))

            {

                $res = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($res['user_id']>0)       

                    return $res['user_id'];

                else

                    return -1;

            }

        }

        catch(PDOException $e) {

                // need to add any error handler

        }   

    }
?>