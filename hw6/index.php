<?php
    require_once 'php/db_connect.php'; //Used to connnect to the database; Credentials are found here

//--------------------------------------------------Creating the Table in the Database------------------------------------------------------

    $createStmt = 'CREATE TABLE IF NOT EXISTS `BABYNAMES` (' . PHP_EOL
        . '  `id` int(11) NOT NULL AUTO_INCREMENT,' . PHP_EOL
        . '  `name` varchar(50) DEFAULT NULL,' . PHP_EOL
        . '  `gender` varchar(50) DEFAULT NULL,' . PHP_EOL
        . '  `count` int(11) DEFAULT NULL,' . PHP_EOL
        . '  PRIMARY KEY (`id`)' . PHP_EOL
        . ') ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';  //creating a string that will be used to create the 2014 Babynames table

    if($db->query($createStmt)) // Query to create the 2014 Babynames table
    {
    

    } 
    else 
    {
    
    exit(); // Prevents the rest of the file from running

    }

//--------------------------------------------------File Manipulation------------------------------------------------------

    $myfile = fopen("yob2014.txt", "r") or die("Unable to open file!"); //Open the file

    while(!feof($myfile)) //Continue until the end of file
    {   
        $string = fgets($myfile); //One string at a time, place it into a string
    
    
    
        $data = explode(",", $string);  //Explode the string into an array using ',' as a delimiter
        $name = $data[0];               //Set the first item in the array as the name
        $gender = $data[1];             //Set the second item in the array as the gender
        $total = $data[2];              //Set the last item in the array as the total
    
        $insertStmt = 'INSERT INTO `BABYNAMES` (id, name, gender,count)' . PHP_EOL
            . "  SELECT * FROM (SELECT NULL, '$name', '$gender', '$total') AS tmp" . PHP_EOL 
            .  "WHERE NOT EXISTS (SELECT name FROM BABYNAMES WHERE name = '$name');";   //Create a string that will insert the data into the 2014 Babynames table 
    
        if($db->query($insertStmt)) // Query to insert the data into the 2014 Babynames table
        {
        
        } 
        else 
        {

            exit();
        }
    }

    fclose($myfile);    //Close the file

    $db->close();       //Close the connection to the database

?>

<!----------------------------------------------------HTML CODE-------------------------------------------------------->
<!DOCTYPE html>
<html lang="en">
  <head>
      
    <title>Babyname?</title>
      
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
      
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/business-casual.css" />  
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
      
    <script>                    //AJAX script thanks to W3schools.com
        function showHint(str) 
        {
            if (str.length == 0)  
            { 
                document.getElementById("txtHint").innerHTML = "";
                return;
            } 
            else 
            {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function()  
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
                    {
                        document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET", "php/gethint.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>   
  </head>
    
  <body>
    <div class="container" id="home">
      <div class="page-header">
        <h1>What is your Favorite Babyname?</h1>
      </div>
        
        <form class="form-horizontal" method="post" action="php/results.php">                       <!--Main form-->
            <fieldset>
<!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nameinput">Baby Name</label> 
                    <div class="col-md-4 control-label">
                        <input id="nameinput" name="nameinput" type="text" placeholder="Please Enter a Babyname" 
                           autocomplete="off" class="form-control input-md" required="" onkeyup="showHint(this.value)">        <!--Input area for the babyname-->
                        <br>
                        <p>Suggestions: <span id="txtHint"></span></p>                              <!--AJAX Hint Placeholder-->
                    </div>
                </div>

<!-- Multiple Radios -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="radios">Gender</label>               <!--Radios for choosing the Gender-->
                    <div class="col-md-4">
                        <div class="radio">
                            <label for="radios-0">
                                <input type="radio" name="radios" id="radios-0" value="M" checked="checked"> <!--Radio for choosing Male-->
                            Male
                            </label>
                        </div>
                        <div class="radio">
                            <label for="radios-1">
                                <input type="radio" name="radios" id="radios-1" value="F">                  <!--Radio for choosing Female-->
                            Female
                            </label>
	                   </div>
                    </div>
                </div>

<!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="submitbutton"></label>
                    <div class="col-md-4">
                    <button id="submitbutton" name="submit" class="btn btn-inverse">Vote!</button>      <!--Button to Vote!-->
                    </div>
                </div>
            </fieldset>
        </form>
      </div>
    </body>
</html>


