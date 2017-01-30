<?php
    require_once 'db_connect.php'; //Used to connnect to the database; Credentials are found here

    $connection = new mysqli($hn, $un, $pw, $db);

    if ($connection->connect_error) 
    {
        die($connection->connect_error);
    }

//----------------------------------Selecting from the Database--------------------------------------------------

    $query= 'SELECT USER_USERNAME FROM `WALL`';   //Creating a string that will select data from the 2014 Babynames table

    $suggestions=$connection->query($query);   //Query to select data from the 2014 Babynames table

    if(!$suggestions)
    {
        die('failed suggestions');
    }

//----------------------------------Populating the array from the Database--------------------------------------------------


    while ($row=mysqli_fetch_array($suggestions)) //loop until the end of the array that was fetched from the database
    {
    
    $sarray[]=$row['USER_USERNAME'];       //Place each name from the database into an array
        
    }

//----------------------------------Search for Hints--------------------------------------------------

    
    $q = $_REQUEST["q"];    // get the q parameter from URL

    $hint = "";

     
    if ($q !== "") // lookup all hints from array if $q is different from ""
    {
        $len=strlen($q);        //Figure out length of the string
        
        foreach($sarray as $username) //Loop that will go through the whole array until the end has been reached
        {
            if (stristr($q, substr($username, 0, $len))) //Will check the string and the name from the array and see if they start with the same letters
            {
                
               if ($q === $username) //first hint
                {
                    //$hint = $username;
                    echo $hint === "" ? "Username Taken!" : $hint;
                   break;
                } 
                else 
               {
                    {
                        //echo $hint=== "" ? "Username Available!" : $hint;
                        break;
                        //$hint .= ", $username"; //Concatenate the hints
                    }
                }
            }
        }
    }


    //echo $hint === "" ? "Username Available!" : $hint; // Output "no suggestion" if no hint was found or output correct values 


?>