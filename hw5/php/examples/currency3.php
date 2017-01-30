<?php
function currencyConverter($currency_from,$currency_to,$currency_input){
    
    
    $amount = urlencode($currency_input);
    $from_Currency = urlencode($currency_from);
    $to_Currency = urlencode($currency_to);
    $get = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency");
    $get = explode("<span class=bld>",$get);
    $get = explode("</span>",$get[1]);  
    $currency_output = preg_replace("/[^0-9\.]/", null, $get[0]);
    
    /*
    $yql_base_url = "http://query.yahooapis.com/v1/public/yql";
    $yql_query = 'select * from yahoo.finance.xchange where pair in ("'.$currency_from.$currency_to.'")';
    $yql_query_url = $yql_base_url . "?q=" . urlencode($yql_query);
    $yql_query_url .= "&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys";
    echo $yql_query_url;
    echo "<br>";
    $yql_session = curl_init($yql_query_url);
    curl_setopt($yql_session, CURLOPT_RETURNTRANSFER,true);
    $yqlexec = curl_exec($yql_session);
    $yql_json =  json_decode($yqlexec,true);
    $currency_output = (float) $currency_input*$yql_json['query']['results']['rate']['Rate'];
    */

    return $currency_output;
}

 $currency_input = 2;
 //currency codes : http://en.wikipedia.org/wiki/ISO_4217
 $currency_from = "USD";
 $currency_to = "INR";
 $currency = currencyConverter($currency_from,$currency_to,$currency_input);

 echo $currency_input.' '.$currency_from.' = '.$currency.' '.$currency_to;

?>

