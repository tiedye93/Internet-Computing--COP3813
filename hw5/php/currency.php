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
$currency_from = "";
$currency_to = "";
$currency_input = 1;

if (isset($_POST['currency_from']) && isset($_POST['currency_to']) && isset($_POST['currency_input']))
{
	$currency_from = $_POST['currency_from'];
	$currency_to = $_POST['currency_to'];
	$currency_input = $_POST['currency_input'];
 
    $currency = currencyConverter($currency_from,$currency_to,$currency_input);
    $display_result = true;
}


echo <<<_END
<html>
    <head>
		<title>Currency Conversion</title>
        
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/business-casual.css" />  
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        
         <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	</head>
    
	<body>   
        
         <div class="header">
        <h1>Currency Converter</h1>
    </div>
        
       <div class="main">
            <p></p>
	       <form class="form-class" method="post" action="currency.php">
                <input type="number" name="currency_input" />
                <p></p>
		      <label>Select currency (from):</label>
                    <select name="currency_from">
                        <option value="USD">US Dollar</option>
                        <option value="BTC">Bitcoin</option>
                        <option value="BYR">Belarusian Ruble</option>
                        <option value="CAD">Canadian Dollar</option>
                        <option value="EUR">Euro</option>
                        <option value="GBP">British Pound</option>
                        <option value="INR">Indian Rupee</option>
                        <option value="KES">Kenyan Shilling</option>
                        <option value="PHP">Philippine Peso</option>
                        <option value="XOF">West African CFA Franc</option>
                    </select>
                <label>Select currency (to):</label>
                    <select name="currency_to">
                        <option value="USD">US Dollar</option>
                        <option value="BTC">Bitcoin</option>
                        <option value="BYR">Belarusian Ruble</option>
                        <option value="CAD">Canadian Dollar</option>
                        <option value="EUR">Euro</option>
                        <option value="GBP">British Pound</option>
                        <option value="INR">Indian Rupee</option>
                        <option value="KES">Kenyan Shilling</option>
                        <option value="PHP">Philippine Peso</option>
                        <option value="XOF">West African CFA Franc</option>
                    </select>
                <p></p>
		  <input type="submit" class="btn" value="Re-Convert!"/>
	       </form>
        </div>
        
      <br>
      <br>
      <br>
        
        <div class="results">
            <p>$currency_input $currency_from is equal to $currency $currency_to</p>
        </div>
	</body>
</html>
_END;

?>

