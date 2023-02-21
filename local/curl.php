<?php
  if( $curl = curl_init() ) {
    curl_setopt($curl, CURLOPT_URL, 'https://new.gipermed.com/local/update_status.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, "a=534&b=YC");
    $out = curl_exec($curl);
    echo $out;
    curl_close($curl);
  }
?>