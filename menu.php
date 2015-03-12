<?php

include_once('user.php');

if ($_POST['submit']) {
   $name = $_POST['user'];
   $pass = $_POST['pass'];    
   
   
   $object = new User();
   $object->Login($name, $pass);
}
    

?>