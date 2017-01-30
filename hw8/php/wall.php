<?php
    require_once "db_connect.php";
    require_once "functions.php";

    $connection = new mysqli($hn, $un, $pw, $db);

    if ($connection->connect_error) 
    {
        die($connection->connect_error);
    }

    $query = "CREATE TABLE IF NOT EXISTS WALL (
        USER_USERNAME VARCHAR(15) NOT NULL,
        STATUS_TEXT VARCHAR(140) NOT NULL,
        STATUS_TITLE VARCHAR(140) NOT NULL,
        IMAGE_NAME VARCHAR(50) NOT NULL,
        FILTER VARCHAR(140) NOT NULL,
        TIME_STAMP VARCHAR(50) NOT NULL,
        PRIMARY KEY (TIME_STAMP)
    )";           //creates a query that will create a table with will hold the wall information

    $result = $connection->query($query);

    if (!$result) 
    {
        die($connection->error);
    }

//------------------------------------------Logged onto the Wall------------------------------------
    session_start(); //This starts the session management

    if (isset($_SESSION['username'])) // if username is set, then continue
    {
        $username = $_SESSION['username']; // Set a local variable username from the session's username
    }
    else
    {
        echo '<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-5 col-sm-8 col-sm-offset-2"> 
                    <div class="col-md-4 controls">
                        <a id="btn-login" href="../index.php" class="btn btn-success">Return to the Log-in Screen  </a>        
                    </div>
                </div>';        //echos a button to return to the log-in page
      
        header('location: ../index.php');        
    }


    if(isset($_SESSION['username']) && isset($_POST['title']) && isset($_POST['text']))
    {    
        $name = $_SESSION['username'];
        $title = sanitizeString($connection, $_POST['title']);
        $text = sanitizeString($connection, $_POST['text']);
        $filter = $_POST['tempFilter'];
    
        $time = $_SERVER['REQUEST_TIME'];
	   $file_name = $name . '_' . $time . '.jpg';

        if ($_FILES)
        {
            $tmp_name = $_FILES['upload']['name'];
            $dstFolder = '../uploadedImages';
            move_uploaded_file($_FILES['upload']['tmp_name'], $dstFolder . DIRECTORY_SEPARATOR . $file_name);
            //echo "Uploaded image '$file_name'<br /><img src='$dstFolder/$file_name'/>";
        }

        SavePostToDB($connection, $name, $title, $text, $time, $filter, $file_name);
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
	
        <title>Tyler Bourque's Image Wall</title>
        
        <!-- Optional theme -->
        
        <link rel="stylesheet" href="../css/styles.css">
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/business-casual.css" />  
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
        
    </head>
    
    <body>
        <?php
            if($username)   //If the local variable username is not set, then print a blank page
            {
                echo '  <div class="navbar">
                            <div class="container">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                                        <span class="sr-only">Toggle navigation</span>
                                    </button> 
                                </div>
                            
                                <div class="collapse navbar-collapse" id="navbar-ex-collapse">
                                    <ul class="nav navbar-nav navbar-right">
                                        <li>
                                            <a type="button" class="btn btn-success" href="form.php">Upload Image</a> 
                                        </li> 
                                        <li>
                                            <a type="button" class="btn btn-warning" href="logout.php">Logout</a> 
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                
                    <div class="container">
                        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <div class="panel-title">Welcome back ' . $username . '!</div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="container">';
                        echo getPostcards($connection, $username) .  
                    '</div>';
            }
        ?>
    </body>



<?php $connection->close(); ?>