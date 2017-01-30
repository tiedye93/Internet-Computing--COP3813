<?php

//------------------------------------------------Verify and Register a New User--------------------------------------
    require_once 'db_connect.php'; //Credentials

    $connection = new mysqli($hn, $un, $pw, $db); //connection to the database being made

    if ($connection->connect_error) // If there is an error, then continue
    {
        die($connection->connect_error);
    }

    function add_user($connection, $un, $pw) //Decleration for the function that will add a user to the database
        {
            $query  = "INSERT INTO USERS VALUES('$un', '$pw')"; //create a query that will insert the username and the password into the database
                                
            $result = $connection->query($query); //aend the query
        
            if (!$result) //if the query was unsuccessful, then continue
            {
                die($connection->error);
            }
        }

    if(isset($_POST['register_submit'])) //check to see if the registered form was posted; if so, continue
    {
        $new_username = $_POST['new_username']; //recieve the Username from the form
        $new_password = $_POST['new_password'];  //recieve the Password from the form
        $new_password1 = $_POST['new_password1'];  //recieve the Re-Entered Password from the form
        
        $result = $connection->query("SELECT userid FROM USERS WHERE userid='".$new_username."';"); //send a query that will create a new user
            
        if($result->num_rows==1)  //if the username was already in the database, continue
        {
            echo '<div class="container">
                    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
                        <div class="panel panel-info" >
                            <div class="panel-heading">
                                <div class="panel-title">Username already Exists</div>
                            </div>
                        </div>
                    </div>
                </div>'; //Username already exists
        }
        else if($new_username && $new_password && $new_password1) //if all the variables are occupied, then continue
        {
            if($new_password == $new_password1) // if the password and password 1 are equal, then continue
            {
                $salt1 = "qm&h*";       //salt1 for encryption
                $salt2 = "pg!@";        //salt2 for encryption

                $token = hash('ripemd128', "$salt1$new_password$salt2"); //create a token that is hashed and salted with the password

                add_user($connection, $new_username, $token); //send all the information to the add_user function
                
                echo "Registration Successful!";
                
                session_start();    //start the session
                
                $_SESSION['username'] = $new_username; //set the session username to the new registered user
                
                header("Location: wall.php");       //redirect to the wall page
                
            }
            else
            {

                echo '<div class="container">
                    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
                        <div class="panel panel-info" >
                            <div class="panel-heading">
                                <div class="panel-title">Passwords did not Match</div>
                            </div>
                        </div>
                    </div>
                </div>'; //Passwords did not match
            }
        }
    }

//------------------------------------------------Verify and Log in a Previous User--------------------------------------

    if(isset($_POST['login_submit'])) //check to see if the login form was posted; if so, continue
    {  
        
        session_start(); //start the session
        
        $username = $_POST['username']; //recieve the username from the form
        $password = $_POST['password']; //recieve the Password from the form
        
        $salt1 = "qm&h*"; //salt1 for encryption
        $salt2 = "pg!@"; //salt2 for encryption

        $token = hash('ripemd128', "$salt1$password$salt2"); //create a token that is hashed and salted with the password
        
        if($username && $password) //if both username and password were filled out, then continue
        {
            $query = mysqli_query($connection, "SELECT * FROM USERS WHERE userid= '$username';"); //create a query the will select the user fro the database == the username inputted
        
            if(!$query) //if the query failed, continue
            {
                die("Information Does Not Match Our Records. Plase Try Again.");
            }
        
            $numrows = mysqli_num_rows($query); //save the number of rows from the query into a variable
        
            if($numrows != 0) //if the query recieved a user from the database, then continue
            {
                while($row= mysqli_fetch_assoc($query)) //Place all information from the query into local variables
                {
                    $dbusername = $row['userid'];
                    $dbpassword = $row['password'];
                }
            
                if($username == $dbusername && $token == $dbpassword) //if the database username and password match the username and password inputted, then continue
                {
                    echo "Login Successful!";
                    
                    $_SESSION['username'] = $dbusername; //save the session username as the username inputted
                
                    header("Location: wall.php"); //redirect to the wall
                }
                else
                {
                    echo '<div class="container">
                    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
                        <div class="panel panel-info" >
                            <div class="panel-heading">
                                <div class="panel-title">Information Does Not Match Our Records. Plase Try Again.</div>
                            </div>
                        </div>
                    </div>
                </div>'; //information does not match the records
                }
            }
            else
            {
                echo '<div class="container">
                    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
                        <div class="panel panel-info" >
                            <div class="panel-heading">
                                <div class="panel-title">Information Does Not Match Our Records. Plase Try Again.</div>
                            </div>
                        </div>
                    </div>
                </div>'; //information does not match the records
            }  
        }
        else
        {
            echo '<div class="container">
                    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
                        <div class="panel panel-info" >
                            <div class="panel-heading">
                                <div class="panel-title">Please Enter your Credentials</div>
                            </div>
                        </div>
                    </div>
                </div>'; //please enter your credentials
                        
        }
    }
?>


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
        <!-- Button -->
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-5 col-sm-8 col-sm-offset-2"> 
            <div class="col-md-4 controls">
                <a id="btn-login" href="../index.php" class="btn btn-success">Return to the Log-in Screen  </a>  <!--Creates a button to return to the log-in screen-->
            </div>
        </div>
    </body>
</html>
                        