<?php
include "functions.php";

if (isset($_GET["host"])) {
    $host = $_GET["host"];

    $request_id = check_host($host);

    sleep(3);

    $Pings = check_ping($request_id);

    echo $Pings;
} else {
    echo "Please provide a Host or IP and retry!";
}
?>
