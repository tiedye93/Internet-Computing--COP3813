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

$currency_from = "";
$currency_to = "";
$currency_input = 1;

if (isset($_POST['currency_from']) && isset($_POST['currency_to']) && isset($_POST['currency_input']))
{
	$currency_from = $_POST['currency_from'];
	$currency_to = $_POST['currency_to'];
	$currency_input = $_POST['currency_input'];
 
    $currency = currencyConverter($currency_from,$currency_to,$currency_input);
    // Populate a specific paragraph or div with result
}

echo <<<_END
<html>
	<head>
		<title>Currency conversion</title>
	</head>
	<body>
	<form method="post" action="currency6.php">
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
        <p>$currency_input $currency_from is equal to $currency $currency_to</p>
	</form>
	</body>
</html>
_END;
?>

