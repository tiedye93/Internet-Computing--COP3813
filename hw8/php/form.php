<?php
    require_once "db_connect.php";
    require_once "functions.php";

    $connection = new mysqli($hn, $un, $pw, $db);

        if ($connection->connect_error) 
        {
            die($connection->connect_error);
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
?>

<!DOCTYPE html>
<html>
    <head>
	   <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
	
	   <title>Image uploader</title>
	
	   <!-- Latest compiled and minified CSS -->
	   <link rel="stylesheet" href="../css/bootstrap.min.css">

	   <!-- Optional theme -->
	   <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
    
        <link rel="stylesheet" href="../css/styles.css">
	
	   <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/business-casual.css" />  
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
        
    </head>
    
    <body> <!--onload="initialize();"-->
        <div class="navbar navbar-nav navbar-center">
                        <div class="container">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                </button> 
                            </div>
                            
                            <div class="collapse navbar-collapse" id="navbar-ex-collapse">
                                <ul class="nav navbar-nav navbar-right">
                                    <li>
                                        <a type="button" class="btn btn-success" href="wall.php">Return To the Wall</a> 
                                    </li> 
                                    <li>
                                        <a type="button" class="btn btn-warning" href="logout.php">Logout</a> 
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
        
                    <br>
                    <br>
                    <br>
                    <br>
        
        <div class="container">
           <div class="row">
			 <div id="formParent" class="col-md-6 col-md-offset-3 ">
                 
                    
                    <div class= "panel panel-default col-md-12">
                    <form id="form" class="form-horizontal" method="POST" action="wall.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <br>
                            <label for="title" class="control-label col-xs-1">Title</label>
                            <div class="col-xs-11">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-header fa-fw"></span></span>
                                    <input type="text" class="form-control" id="title" name="title" 
                                    maxlength="20" size="20" value="" required placeholder="Summer Vacation" autofocus>
                                </div>
                            </div>
                        </div>
                     
                        <div class="form-group">
                            <label for="text" class="control-label col-xs-1">Text</label>
                            <div class="col-xs-11">
                                <textarea class="form-control" id="text" name="text" maxlength="140" placeholder="140 characters" required></textarea>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <label class="sr-only" for="image">Original Image</label>
                            <img id="image" name="image" src="http://placehold.it/400x400" width="100%">
                            <br>
                            <br>
                            <input type="file" id="upload" name="upload" accept="image/*">
                        </div>
                    
                    
                        <div class="form-group">
                            <h3>Filter Photo</h3>
                            <div class="checkbox-inline">
                                <label for="myNostalgia">My Nostalgia</label>
                                <input type="radio" name="filter" id="myNostalgia" value="myNostalgia" onclick="applyMyNostalgiaFilter();">
                            </div>
                            
                            <div class="checkbox-inline">
                                <label for="grayscale">Grayscale</label>
                                <input type="radio" name="filter" id="grayscale" value="grayscale" onclick="applyGrayscaleFilter();">
                            </div>
                        
                            <div class="checkbox-inline">
                                <label for="original">Revert to Original</label>
                                <input type="radio" name="filter" id="lomo" value="lomo" onclick="revertToOriginal();">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="input-group">
                                <input type="hidden" class="form-control" id="tempFilter" name="tempFilter" 
                             value="brightness(.5);">
                            </div>
                    </div>
                                
                        <input type="submit" value="Upload image to Wall!" class="btn btn-primary col-md-offset-4">
<!--                        <input type="button" id="resetForm" value="Start over!" class="btn btn-default">-->
				    </form>
            
                    <br>
                    <br>
                 
                </div>
           </div>
        </div>
        </div>

	   <!-- JavaScript placed at bottom for faster page loadtimes. -->
	   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        
        <!-- Latest compiled and minified JavaScript -->
        <script src="../js/bootstrap.min.js"></script>
	
	   <script src="../js/filter.js"></script>

    </body>
</html>

<?php $connection->close(); ?>