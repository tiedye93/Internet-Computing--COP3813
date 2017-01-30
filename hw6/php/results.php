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
        $createStmt = 'CREATE TABLE IF NOT EXISTS `MALE_BABYNAMES` (' . PHP_EOL 
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
        
        
        $insertStmt = 'INSERT INTO `MALE_BABYNAMES` (id, name,total)' . PHP_EOL    
            . "  SELECT * FROM (SELECT NULL, '$result_name', '0') AS tmp" . PHP_EOL
            .  "WHERE NOT EXISTS (SELECT name FROM MALE_BABYNAMES WHERE name = '$result_name');";  //creating a string that will insert names into the Male result database
        
    
    
        if($db->query($insertStmt)) 
        {
            
        } 
        else 
        {   
            exit(); // Prevents the rest of the file from running
        }
        
         $updateStmt = 'UPDATE `MALE_BABYNAMES`' . PHP_EOL 
            . "SET total = total +1" . PHP_EOL
            .  "WHERE name = '$result_name';"; //creating a string that will update names' total number of votes in the Male result table
        
        
        if($db->query($updateStmt))
        {
        
        } 
        else 
        {    
            exit(); // Prevents the rest of the file from running
        }
        
    }

//--------------------------------------------------Female Database Manipulation------------------------------------------------------
        
    if($result_gender == "F")   //if the gender is female
    {   
        $createStmt = 'CREATE TABLE IF NOT EXISTS `FEMALE_BABYNAMES` (' . PHP_EOL  
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
        
        
        $insertStmt = 'INSERT INTO `FEMALE_BABYNAMES` (id, name,total)' . PHP_EOL
            . "  SELECT * FROM (SELECT NULL, '$result_name', '0') AS tmp" . PHP_EOL 
            .  "WHERE NOT EXISTS (SELECT name FROM FEMALE_BABYNAMES WHERE name = '$result_name');"; //creating a string that will insert names into the Female result database
    
        if($db->query($insertStmt)) //Query to insert names into the Female result table
        {
    
        } 
        else 
        {    
            exit(); // Prevents the rest of the file from running
        }
        
         $updateStmt = 'UPDATE `FEMALE_BABYNAMES`' . PHP_EOL   
            . "SET total = total +1" . PHP_EOL 
            .  "WHERE name = '$result_name';"; //creating a string that will update names' total number of votes in the Female result table
        
        
        if($db->query($updateStmt)) //Query to update the total number of votes in the Female result table
        {
        
        } 
        else 
        {    
            exit();
        }

    }


        $selectStmt = 'SELECT name, total FROM `MALE_BABYNAMES`' . PHP_EOL 
            . "ORDER BY total DESC LIMIT 10;";  // creating a string that will select data from the Male result table
        
            
       $male_table = $db->query($selectStmt); //Query to select data from the Male result table
        
        if(!$male_table)
        {
            die('Failed #1');
        }

        $selectStmt = 'SELECT name, total FROM `FEMALE_BABYNAMES`' . PHP_EOL 
            . "ORDER BY total DESC LIMIT 10;"; // creating a string that will select data from the Female result table
        
            
        $female_table = $db->query($selectStmt); //Query to select data from the Female result table
        
        if(!$female_table)
        {
            die('Failed #2');
        }


        $selectStmt = 'SELECT name, count FROM `BABYNAMES_TEST`' . PHP_EOL
            ."WHERE gender = 'M'". PHP_EOL
            . "ORDER BY count DESC LIMIT 5;"; // creating a string that will select data from the original Male table
        
            
        $male_original_table = $db->query($selectStmt); //Query to select data from the original Male table
        
        if(!$male_original_table)
        {
            die('Failed #3');
        }

        $selectStmt = 'SELECT name, count FROM `BABYNAMES_TEST`' . PHP_EOL 
            ."WHERE gender = 'F'". PHP_EOL
            . "ORDER BY count DESC LIMIT 5;"; // creating a string that will select data from the original Female table
        
            
        $female_original_table = $db->query($selectStmt); //Query to select data from the original Female table
        
        if(!$female_original_table)
        {
            die('Failed #4');
        }


     
    $db->close();    //Close th connection to the database
    
?>

<!----------------------------------------------------HTML CODE-------------------------------------------------------->

<!DOCTYPE html>
<html lang="en">
    <head>
      
        <title>Results</title>
      
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    
      
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/business-casual.css" />  
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
    
      
  </head>
    <body>
        

        <div class="cover">  
            <div class="navbar">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button> 
                    </div>

                    <div class="collapse navbar-collapse" id="navbar-ex-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li id="home" class="active">
                                <a class="active" href="../index.php">Click Here To Re-cast Your Vote!</a>
                            </li>  
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="cover-image" style="background-image:../img/bg.jpg)"></div>
            
            
             <div class="container"> 
                 <br>
                 <br>
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="text-info">Male Names</h2>
                    </div>
                    
                    <div class="col-md-6">
                        <h2 class="text-info">Female Names&nbsp;</h2>
                    </div>
                </div>
                 
                <div class="row"> 
                    <div class="col-md-6">
                        <table class="table">   <!--Male Vote Table-->
                            <thead>
                                <tr>
                                    <th class="active">Rank</th>
                                    <th class="active">Male Name</th>
                                    <th class="active">Votes</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php
            
                                    if(!$male_table) //How to populate the Male Voting Table
                                    {
                                        die('Failed #5');
                                    }
            
                            
                                    for($rank = 1; $rank<= 10 ; $rank++)
                                    {       
                                        echo "<tr>";
                                            echo "<td class='active'>" . $rank . "</td>";               
        
                                        while($row = mysqli_fetch_array($male_table))
                                        {
                                            echo "<td class='active'>" . $row['name'] . "</td>";
                                            echo "<td class='active'>" . $row['total'] . "</td>";
                                            
                                            break;
                                        }
                                        
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <table class="table">   <!--Female Vote Table-->
                            <thead>
                                <tr>
                                    <th class="active">Rank</th>
                                    <th class="active">Female Name</th>
                                    <th class="active">Votes</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php
            
                                    if(!$female_table)  //How to populate the Female Voting Table
                                    {
                                        die('Failed #6');
                                    }
            
                            
                                    for($rank = 1; $rank<= 10 ; $rank++)
                                    {       
                                        echo "<tr>";
                                            echo "<td class='active'>" . $rank . "</td>";               
        
                                    while($row = mysqli_fetch_array($female_table))
                                    {
                                            echo "<td class='active'>" . $row['name'] . "</td>";
                                            echo "<td class='active'>" . $row['total'] . "</td>";
                                
                                            break;
                                    }
                                        
                                        echo "</tr>";
                                    }
    
            
                                ?>
                            </tbody>
                        </table>
                    </div>
                 </div>
                 
                 <div class="col-md-6">
                    <h2></h2>
                    <h2 class="text-info">2014 Most Popular Male Names&nbsp;</h2>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-info">2014 Most Popular Female Names&nbsp;</h2>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        
                        <table class="table">   <!--2014 Male Table-->
                            <thead>
                                <tr>
                                    <th class="active">Male Name</th>
                                    <th class="active">Total Born In 2014</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php
            
                                    if(!$male_original_table)   //How to populate the 2014 Male Table
                                    {
                                        die('Failed #7');
                                    }
            
                            
                                    for($rank = 1; $rank<= 5 ; $rank++)
                                    {       
                                        echo "<tr>";               
        
                                    while($row = mysqli_fetch_array($male_original_table))
                                    {
                                            echo "<td class='active'>" . $row['name'] . "</td>";
                                            echo "<td class='active'>" . $row['count'] . "</td>";
                                
                                            break;
                                    }
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <table class="table">   <!--2014 Female Table-->
                            <thead>
                                <tr>
                                    <th class="active">Female Name</th>
                                    <th class="active">Total Born In 2014</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php
            
                                    if(!$female_original_table)     //How to populate the 2014 Female Table 
                                    {
                                        die('Failed #8');
                                    }
            
                            
                                    for($rank = 1; $rank<= 5 ; $rank++)
                                    {       
                                        echo "<tr>";               
        
                                        while($row = mysqli_fetch_array($female_original_table))
                                        {
                                            echo "<td class='active'>" . $row['name'] . "</td>";
                                            echo "<td class='active'>" . $row['count'] . "</td>";
                                            break;
                                        }
                                        
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                 </div>
            </div>
        </div>
    </body>
</html>