<?php
    require_once 'db_connect.php';


    $result_name = "";
    $result_gender = "";

    $result_name = $_POST['nameinput'];
    $result_gender = $_POST['radios'];


    $result_name = strtolower($result_name);
    $result_name = ucfirst($result_name);



    $result_name = preg_replace("/[^a-zA-Z]/" , "" ,  $result_name);
    

    if($result_gender == "M")
    { 
        $createStmt = 'CREATE TABLE IF NOT EXISTS `MALE_BABYNAMES_TEST` (' . PHP_EOL 
            . '  `id` int(11) NOT NULL AUTO_INCREMENT,' . PHP_EOL
            . '  `name` varchar(50) DEFAULT NULL,' . PHP_EOL
            . '  `total` int(11) DEFAULT NULL,' . PHP_EOL
            . '  PRIMARY KEY (`id`)' . PHP_EOL
            . ') ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';
        
        if($db->query($createStmt)) {
                
        } else {
            
            exit();
        }
        
        
        $insertStmt = 'INSERT INTO `MALE_BABYNAMES_TEST` (id, name,total)' . PHP_EOL    
            . "  SELECT * FROM (SELECT NULL, '$result_name', '0') AS tmp" . PHP_EOL
            .  "WHERE NOT EXISTS (SELECT name FROM MALE_BABYNAMES_TEST WHERE name = '$result_name');";
        
    
    
        if($db->query($insertStmt)) {
            
        } else {   
            
            exit();
        }
        
         $updateStmt = 'UPDATE `MALE_BABYNAMES_TEST`' . PHP_EOL 
            . "SET total = total +1" . PHP_EOL
            .  "WHERE name = '$result_name';";
        
        
        if($db->query($updateStmt)) {
        
        } else {
            
            exit();
        }
        
        $selectStmt = 'SELECT name, total FROM `MALE_BABYNAMES_TEST`' . PHP_EOL 
            . "ORDER BY total DESC LIMIT 10;";
        
            
       $table = $db->query($selectStmt);
        
        if(!$table) {
            
            die('Failed #1');
        }
    }


    if($result_gender == "F")
    {   
        $createStmt = 'CREATE TABLE IF NOT EXISTS `FEMALE_BABYNAMES_TEST` (' . PHP_EOL  
            . '  `id` int(11) NOT NULL AUTO_INCREMENT,' . PHP_EOL
            . '  `name` varchar(50) DEFAULT NULL,' . PHP_EOL
            . '  `total` varchar(50) DEFAULT NULL,' . PHP_EOL
            . '  PRIMARY KEY (`id`)' . PHP_EOL
            . ') ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';

        if($db->query($createStmt)) {
           
        } else {
            
            exit();
        }
        
        
        $insertStmt = 'INSERT INTO `FEMALE_BABYNAMES_TEST` (id, name,total)' . PHP_EOL
            . "  SELECT * FROM (SELECT NULL, '$result_name', '0') AS tmp" . PHP_EOL 
            .  "WHERE NOT EXISTS (SELECT name FROM FEMALE_BABYNAMES_TEST WHERE name = '$result_name');";
    
        if($db->query($insertStmt)) {
    
        } else {  
            
            exit();
        }
        
         $updateStmt = 'UPDATE `FEMALE_BABYNAMES_TEST`' . PHP_EOL   
            . "SET total = total +1" . PHP_EOL 
            .  "WHERE name = '$result_name';";
        
        if($db->query($updateStmt)) {
        
        } else { 
            
            exit();
        }
        
        $selectStmt = 'SELECT name, total FROM `FEMALE_BABYNAMES_TEST`' . PHP_EOL 
            . "ORDER BY total DESC LIMIT 10;";
        
            
        $table = $db->query($selectStmt);
        
        if(!$table) {
            
            die('Failed #2');
        }
    }
     
    $db->close();
    
?>


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
        
        <table style="width:100%">
            <tr>
                <th>Rank</th>
                <th> Male Names</th>
                <th>Votes</th>
            </tr>
            
            <?php
                echo "WORK DAMNIT";
                    
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
    