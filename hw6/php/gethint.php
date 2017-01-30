<?php
    require_once 'db_connect.php'; //Used to connnect to the database; Credentials are found here

//----------------------------------Selecting from the Database--------------------------------------------------

    $selectStmt = 'SELECT name FROM `BABYNAMES`' . PHP_EOL
    .   'ORDER BY `count` DESC;';   //Creating a string that will select data from the 2014 Babynames table

    $suggestions=$db->query($selectStmt);   //Query to select data from the 2014 Babynames table

    if(!$suggestions)
    {
        die('failed suggestions');
    }

//----------------------------------Populating the array from the Database--------------------------------------------------


    while ($row=mysqli_fetch_array($suggestions)) //loop until the end of the array that was fetched from the database
    {
    
    $sarray[]=$row['name'];       //Place each name from the database into an array
        
    }

//----------------------------------Search for Hints--------------------------------------------------

    
    $q = $_REQUEST["q"];    // get the q parameter from URL

    $hint = "";

     
    if ($q !== "") // lookup all hints from array if $q is different from ""
    {
        $q = strtolower($q);    //Sanitize the string from the input
        $len=strlen($q);        //Figure out length of the string
        $x=1;                   //Arbitrary variable
        foreach($sarray as $name) //Loop that will go thorugh the whole array until the end has been reached
        {
            if (stristr($q, substr($name, 0, $len))) //Will check the string and the name from the array and see if they start with the same letters
            {
                if ($hint === "") //first hint
                {
                    $hint = $name;
                } 
                else 
                {
                    if($x < 5)  //List only 5 Suggestions
                    {
                        $hint .= ", $name"; //Concatenate the hints
                        $x++;
                    }
                }
            }
        }
    }


echo $hint === "" ? "no suggestion" : $hint; // Output "no suggestion" if no hint was found or output correct values 


?>