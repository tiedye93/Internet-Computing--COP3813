<?php
    require_once 'db_connect.php'; //Used to connnect to the database; Credentials are found here

//--------------------------------------------------Receiving the data------------------------------------------------------
    $result_name = "";
    $result_gender = "";

    $result_name = $_POST['nameinput']; //recieve the input name from the form
    $result_gender = $_POST['radios'];  //recieve the gender from the form

//--------------------------------------------------Validating the data------------------------------------------------------
    $result_name = strtolower($result_name);  //Alters the string to lowercase letters  
    $result_name = ucfirst($result_name);     //Alters the string to make the first letter uppercase

//--------------------------------------------------Sanitizing the data------------------------------------------------------

    $result_name = preg_replace("/[^a-zA-Z]/" , "" ,  $result_name);    //removes all characters except a-z or A-Z
    
//--------------------------------------------------Male Database Manipulation------------------------------------------------------
    if($result_gender == "M") //if the gender is male
    { 
        $createStmt = 'CREATE TABLE IF NOT EXISTS `MALE_BABYNAMES_TEST` (' . PHP_EOL 
            . '  `id` int(11) NOT NULL AUTO_INCREMENT,' . PHP_EOL
            . '  `name` varchar(50) DEFAULT NULL,' . PHP_EOL
            . '  `total` int(11) DEFAULT NULL,' . PHP_EOL
            . '  PRIMARY KEY (`id`)' . PHP_EOL
            . ') ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';  //creating a string that will be used to create the Male result table

        if($db->query($createStmt)) 
        {
                
        } 
        else 
        {
            exit(); // Prevents the rest of the file from running
        }
        
        
        $insertStmt = 'INSERT INTO `MALE_BABYNAMES_TEST` (id, name,total)' . PHP_EOL    
            . "  SELECT * FROM (SELECT NULL, '$result_name', '0') AS tmp" . PHP_EOL
            .  "WHERE NOT EXISTS (SELECT name FROM MALE_BABYNAMES_TEST WHERE name = '$result_name');";  //creating a string that will insert names into the Male result database
        
    
    
        if($db->query($insertStmt)) 
        {
            
        } 
        else 
        {   
            exit(); // Prevents the rest of the file from running
        }
        
         $updateStmt = 'UPDATE `MALE_BABYNAMES_TEST`' . PHP_EOL 
            . "SET total = total +1" . PHP_EOL
            .  "WHERE name = '$result_name';"; //creating a string that will update names' total number of votes in the Male result table
        
        
        if($db->query($updateStmt))
        {
        
        } 
        else 
        {    
            exit(); // Prevents the rest of the file from running
        }
        
        $selectStmt = 'SELECT name, total FROM `MALE_BABYNAMES_TEST`' . PHP_EOL 
            . "ORDER BY total DESC LIMIT 10;";  // creating a string that will select data from the Male result table
        
            
       $table = $db->query($selectStmt); //Query to select data from the Male result table
        
        if(!$table)
        {
            die('Failed #1');
        }
    }

//--------------------------------------------------Female Database Manipulation------------------------------------------------------
        
    if($result_gender == "F")   //if the gender is female
    {   
        $createStmt = 'CREATE TABLE IF NOT EXISTS `FEMALE_BABYNAMES_TEST` (' . PHP_EOL  
            . '  `id` int(11) NOT NULL AUTO_INCREMENT,' . PHP_EOL
            . '  `name` varchar(50) DEFAULT NULL,' . PHP_EOL
            . '  `total` varchar(50) DEFAULT NULL,' . PHP_EOL
            . '  PRIMARY KEY (`id`)' . PHP_EOL
            . ') ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;'; //creating a string that will be used to create the Female result table

        if($db->query($createStmt)) //Query to create the Female result table
        {
           
        } 
        else 
        {
            exit(); // Prevents the rest of the file from running
        }
        
        
        $insertStmt = 'INSERT INTO `FEMALE_BABYNAMES_TEST` (id, name,total)' . PHP_EOL
            . "  SELECT * FROM (SELECT NULL, '$result_name', '0') AS tmp" . PHP_EOL 
            .  "WHERE NOT EXISTS (SELECT name FROM FEMALE_BABYNAMES_TEST WHERE name = '$result_name');"; //creating a string that will insert names into the Female result database
    
        if($db->query($insertStmt)) //Query to insert names into the Female result table
        {
    
        } 
        else 
        {    
            exit(); // Prevents the rest of the file from running
        }
        
         $updateStmt = 'UPDATE `FEMALE_BABYNAMES_TEST`' . PHP_EOL   
            . "SET total = total +1" . PHP_EOL 
            .  "WHERE name = '$result_name';"; //creating a string that will update names' total number of votes in the Female result table
        
        
        if($db->query($updateStmt)) //Query to update the total number of votes in the Female result table
        {
        
        } 
        else 
        {    
            exit();
        }
        
        $selectStmt = 'SELECT name, total FROM `FEMALE_BABYNAMES_TEST`' . PHP_EOL 
            . "ORDER BY total DESC LIMIT 10;"; // creating a string that will select data from the Female result table
        
            
        $table = $db->query($selectStmt); //Query to select data from the Female result table
        
        if(!$table)
        {
            die('Failed #2');
        }
    }
     
    $db->close();    
    
?>

//--------------------------------------------------HTML CODE------------------------------------------------------

<!DOCTYPE html>
<html lang="en">
    <head>
      
        <title>Tyler Bourque</title>
      
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
      
        <link href="css/bootstrap.min.css" rel="stylesheet">
    
        <link rel="stylesheet" href="../css/business-casual.css" />  
    
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    
      
  </head>
    <body>
        
        <table style="width:100%">      //Male Result Table
            <tr>
                <th>Rank</th>
                <th> Male Names</th>
                <th>Votes</th>
            </tr>
            
            <?php
            
                if(!$table)
                {
                    die('Failed #3 ');
                }
            
                            
                for($rank = 0; $rank<= 10 ; $rank++)
                    {       
                            echo "</tr>";
                                echo "<td>" . $rank . "</td>";               
        
                        while($row = mysqli_fetch_array($table))
                        {
                    
                                echo "<td>" . $row[name] . "</td>";
                                echo "<td>" . $row[total] . "</td>";
                                break;
                        }
                            echo "</tr>";
                    }
    
            
            ?>
            
        </table>    
    
    </body>
    
</html>
    