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

        $i = 0;

        while(1)
        {   
            if(isset($_POST[$i]))
            {
                $image = $_POST[$i];
                echo $image;
                break;
            }
            $i = $i + 1;
        }
        
        $query = "DELETE FROM WALL WHERE IMAGE_NAME= '" . $image . "';";

        $result = $connection->query($query);

        if (!$result) 
        {
            die($connection->error);
        }

        header('location: postcard.php');
?>      


