<?php
function currencyConverter($currency_from,$currency_to,$currency_input){
    
    $amount = urlencode($currency_input);
    $from_Currency = urlencode($currency_from);
    $to_Currency = urlencode($currency_to);
    $get = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency");
    $get = explode("<span class=bld>",$get);
    $get = explode("</span>",$get[1]);  
    $currency_output = preg_replace("/[^0-9\.]/", null, $get[0]);

    return $currency_output;
}

$display_result = false;
$currency_from = "USD";
$currency_to = "INR";
$currency_input = 100;

if (isset($_POST['currency_from']))
	$currency_from = $_POST['currency_from'];

if (isset($_POST['currency_to']))
	$currency_to = $_POST['currency_to'];

if (isset($_POST['currency_input']))
	$currency_input = $_POST['currency_input'];
 
$currency = currencyConverter($currency_from,$currency_to,$currency_input);
$display_result = true;

echo <<<_END
<html>
	<head>
		<title>Currency conversion</title>
	</head>
	<body>
	<form method="post" action="currency4.php">
		<label>Enter amount:</label>
		<input type="text" name="currency_input" />
        <label>Select currency (from):</label>
        <select name="currency_from">
            <option value="USD">US Dollar</option>
            <option value="EUR">Euro</option>
            <option value="INR">Indian Rupee</option>
        </select>
        <label>Select currency (to):</label>
        <select name="currency_to">
            <option value="USD">US Dollar</option>
            <option value="EUR">Euro</option>
            <option value="INR">Indian Rupee</option>
        </select>
		<input type="submit" value="Convert!" />
	</form>
	</body>
</html>
_END;

if($display_result) {
    echo $currency_input.' '.$currency_from.' = '.$currency.' '.$currency_to;
}

?>