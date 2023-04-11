<?php
include "functions.php";

if (isset($_GET["host"])) {
    $host = $_GET["host"];

    $request_id = check_host($host);
    if(isset($_GET['accuracy'])){
        accuracy($_GET['accuracy']);
    }else{
         accuracy(3);
    }

    $Pings = check_ping($request_id);

    echo $Pings;
} else {
    exit("Please provide a Host or IP and retry!");
}
?>
