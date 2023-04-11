<?php

function check_host($host)
{
    if (isset($host)) {
        $url =
            "https://check-host.net/check-ping?host=" .
            $host .
            "&node=ir3.node.check-host.net&node=ir4.node.check-host.net&node=ir1.node.check-host.net";

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

            return $request_id;
        }
        curl_close($ch);
    }
}

function check_ping($request_id)
{
    if (isset($request_id)) {
        $url = "https://check-host.net/check-result/" . $request_id;

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
            $decoded_response = json_decode($response, true);

            $Tehran_ping = $Shiraz_ping = $Tabriz_ping = 0;
            $Pings = [];

            if (!empty($decoded_response["ir1.node.check-host.net"])) {
                $count = 0;
                foreach (
                    $decoded_response["ir1.node.check-host.net"][0]
                    as $value
                ) {
                    if (@$value[0] == "OK") {
                        $count++;
                        $Tehran_ping += $value[1];
                    }
                }
              if ($count !== 0){
                 $Tehran_ping = (@$Tehran_ping / $count) * 1000;
              }
               
            }

            if (!empty($decoded_response["ir3.node.check-host.net"])) {
                $count = 0;
                foreach (
                    $decoded_response["ir3.node.check-host.net"][0]
                    as $value
                ) {
                    if (@$value[0] == "OK") {
                        $count++;
                        $Shiraz_ping += $value[1];
                    }
                }
              if ($count !== 0){
                 $Shiraz_ping = (@$Shiraz_ping / $count) * 1000;
              }
               
                
            }

            if (!empty($decoded_response["ir4.node.check-host.net"])) {
                $count = 0;
                foreach (
                    $decoded_response["ir4.node.check-host.net"][0]
                    as $value
                ) {
                    if (@$value[0] == "OK") {
                        $count++;
                        $Tabriz_ping += $value[1];
                    }
                }
              if ($count !== 0){
                 $Tabriz_ping = (@$Tabriz_ping / $count) * 1000;
              }
                
            }

            $Pings = [
                "Tehran" => $Tehran_ping,
                "Tabriz" => $Tabriz_ping,
                "Shiraz" => $Shiraz_ping,
            ];

            $json_pings = json_encode($Pings, JSON_PRETTY_PRINT);

            return $json_pings;
        }

        curl_close($ch);
    } else {
        return "Request ID not found!";
    }
}
function accuracy($accuracy){
    if( $accuracy >= 0 and $accuracy <= 10 and is_numeric($accuracy)){
        sleep($accuracy);
        return ;
    }elseif( $accuracy > 10 and is_numeric($accuracy)){
        sleep(10);
        return ;
    }elseif( $accuracy < 0 and is_numeric($accuracy)){
        sleep(0);
        return ;
    }elseif(!is_numeric($accuracy)){
        exit ("acuuracy should be numeric!");
    }
}
?>
