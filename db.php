<?php 


$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "";
$db['db_name'] = "noon";





foreach($db as $key => $value) {

    define(strtoupper($key), $value);
}

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASS,DB_NAME);

    if (!$dbc) {

        echo "<br>we are NOT connected<br>";

        }



        function confirm($result = ''){
          global $dbc;
          if(!$result){
          die("die " . mysqli_error($dbc));
  
      }
    }




?>