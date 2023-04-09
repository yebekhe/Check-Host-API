<?php
if (isset($_GET['host'])){
    $host = $_GET['host'];
    
    // Set the endpoint URL
    $url = "https://check-host.net/check-ping?host=".$host."&node=ir3.node.check-host.net&node=ir4.node.check-host.net&node=ir1.node.check-host.net";

    // Initialize a new cURL session and set options
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array("Accept: application/json")
    ));

    // Execute the cURL request and get the response
    $response = curl_exec($ch);

    // Check for any errors
    if(curl_errno($ch)) {
        echo "cURL error: " . curl_error($ch);
    } else {
        // Get request id from response
        $request_id = json_decode($response, true)['request_id'];
      
        // Sleep Until response created
        sleep(3);
        // Create new url , fetch and decode it's data
        $new_url = "https://check-host.net/check-result/".$request_id;
        $new_response = file_get_contents($new_url);
        $decoded_response = json_decode($new_response , true);
      
        $Tehran_ping = $Shiraz_ping = $Tabriz_ping = 0 ;
        
        // Checks if the Ping values are available, collects and averages the OK data and converts them to milliseconds
        if(!empty($decoded_response["ir1.node.check-host.net"])){
          $count = 0 ;
    foreach($decoded_response["ir1.node.check-host.net"][0] as $value){
        if($value[0] == "OK"){
            $count ++ ; 
            $Tehran_ping += $value[1];
        }
    }
          $Tehran_ping = ( @$Tehran_ping / $count) * 1000;
        }

      if(!empty($decoded_response["ir3.node.check-host.net"])){
        $count = 0 ;
    foreach($decoded_response["ir3.node.check-host.net"][0] as $value){
        if($value[0] == "OK"){
             $count ++ ; 
             $Shiraz_ping += $value[1];
        }
    }
           $Shiraz_ping = ( @$Shiraz_ping / $count) * 1000;
        }

      if(!empty($decoded_response["ir4.node.check-host.net"])){
        $count = 0 ;
    foreach($decoded_response["ir4.node.check-host.net"][0] as $value){
        if($value[0] == "OK"){
             $count ++ ; 
             $Tabriz_ping += $value[1];
        }
    }
           $Tabriz_ping = ( @$Tabriz_ping / $count) * 1000;
        }


        $Pings = ["Tehran" => $Tehran_ping , "Tabriz" => $Tabriz_ping , "Shiraz" => $Shiraz_ping];

        $json_pings = json_encode($Pings , JSON_PRETTY_PRINT);

         echo $json_pings;
        
    }

    // Close the cURL session
    curl_close($ch);

} else {
    echo "Please provide a host and retry!";
}
?>
