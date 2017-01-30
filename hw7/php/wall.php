<?php
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

<!------------------------------------------------HTML CODE-------------------------------------->
<!DOCTYPE html>
<html lang="en">
    <head>
      
        <title>Tyler Bourque</title>
      
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
      
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
                echo '<div class="navbar">
                        <div class="container">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                </button> 
                            </div>
                        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a type="button" class="btn btn-success" href="logout.php">Logout</a> 
                                </li>  
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="container">
                    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
                        <div class="panel panel-info" >
                            <div class="panel-heading">
                                <div class="panel-title">Welcome back ' . $username . '!</div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        ?>
    </body>
</html>
    