<?php
if (isset($_GET["host"])) {
    $host = $_GET["host"];

    $url = "https://check-host.net/check-ping?host={$host}&node=ir3.node.check-host.net&node=ir4.node.check-host.net&node=ir1.node.check-host.net";

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ["Accept: application/json"],
    ]);
  
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "cURL error: " . curl_error($ch);
    } else {
        $request_id = json_decode($response, true)["request_id"];
        sleep(3);
        $new_url = "https://check-host.net/check-result/{$request_id}";
        $new_response = file_get_contents($new_url);
        $decoded_response = json_decode($new_response, true);

        $Pings = [
            "Tehran" => 0,
            "Tabriz" => 0,
            "Shiraz" => 0,
        ];

        if (!empty($decoded_response["ir1.node.check-host.net"])) {
            $count = 0;
            foreach ($decoded_response["ir1.node.check-host.net"][0] as $value) {
                if ($value[0] == "OK") {
                    $count++;
                    $Pings["Tehran"] += $value[1];
                }
            }
            $Pings["Tehran"] = (@$Pings["Tehran"] / $count) * 1000;
        }

        if (!empty($decoded_response["ir3.node.check-host.net"])) {
            $count = 0;
            foreach ($decoded_response["ir3.node.check-host.net"][0] as $value) {
                if ($value[0] == "OK") {
                    $count++;
                    $Pings["Shiraz"] += $value[1];
                }
            }
            $Pings["Shiraz"] = (@$Pings["Shiraz"] / $count) * 1000;
        }

        if (!empty($decoded_response["ir4.node.check-host.net"])) {
            $count = 0;
            foreach ($decoded_response["ir4.node.check-host.net"][0] as $value) {
                if ($value[0] == "OK") {
                    $count++;
                    $Pings["Tabriz"] += $value[1];
                }
            }
            $Pings["Tabriz"] = (@$Pings["Tabriz"] / $count) * 1000;
        }

        $json_pings = json_encode($Pings, JSON_PRETTY_PRINT);

        echo $json_pings;
    }

    curl_close($ch);
} else {
    echo "Please provide a host and retry!";
}
