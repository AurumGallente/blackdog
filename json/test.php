<?php
if( $curl = curl_init() ) {
    curl_setopt($curl, CURLOPT_URL, 'http://boonex/json/');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_POST, true);    
    curl_setopt($curl, CURLOPT_POSTFIELDS, file_get_contents('data.json'));
    $out = curl_exec($curl);
    
    if (curl_errno($curl)) {
        print curl_error($curl);
    } else {
        echo '<pre>';
        print_r($out);
        echo '</pre>';        
        curl_close($curl);
    }
  }