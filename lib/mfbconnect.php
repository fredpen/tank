<?php

$db_server = 'localhost';

//$db_name = 'bizmaaponline';
//$db_name = 'bizmaap';
$db_name = 'tank_farm';

$db_user = 'root';
$db_password = 'password';



$db_connect = mysqli_connect($db_server, $db_user, $db_password) or trigger_error(mysql_error(),e_user_error);

mysqli_select_db($db_connect,$db_name);

$_SESSION['db_connect'] = $db_connect;
//include_once "ez_results.php";
//include_once "ez_sql.php";
//include_once "common.php";

//$filename = "./licence/license.txt";
//$fp = fopen($filename,"r");
//$fstring = fread($fp, filesize($filename));
//$_SESSION['licensed_to'] = $fstring;
//fclose($fp);




?>