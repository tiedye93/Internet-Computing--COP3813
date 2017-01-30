<?php
    require_once "db_connect.php";
    require_once "functions.php";

    function sanitizeString($_db, $str)
    {
        $str = strip_tags($str);
        $str = htmlentities($str);
        $str = stripslashes($str);
        return mysqli_real_escape_string($_db, $str);
    }


    function SavePostToDB($_db, $_user, $_title, $_text, $_time, $_filter, $_file_name)
    {
	   /* Prepared statement, stage 1: prepare query */
	   if (!($stmt = $_db->prepare("INSERT INTO WALL(USER_USERNAME, STATUS_TITLE, STATUS_TEXT, TIME_STAMP, FILTER, IMAGE_NAME) VALUES (?, ?, ?, ?, ?, ?)")))
	   {
		  echo "Prepare failed: (" . $_db->errno . ") " . $_db->error;
	   }

	   /* Prepared statement, stage 2: bind parameters*/
	   if (!$stmt->bind_param('ssssss', $_user, $_title, $_text, $_time, $_filter, $_file_name))
	   {
		  echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	   }

	   /* Prepared statement, stage 3: execute*/
	   if (!$stmt->execute())
	   {
		  echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	   }
    }

    function getPostcards($_db, $_username)
    {
        
        $query = "SELECT USER_USERNAME, STATUS_TITLE, STATUS_TEXT, TIME_STAMP, FILTER, IMAGE_NAME FROM WALL ORDER BY TIME_STAMP DESC";
    
        if(!$result = $_db->query($query))
        {
            die('There was an error running the query [' . $_db->error . ']');
        }
    
        $output = '';
        $x = 0;
        
        while($row = $result->fetch_assoc())
        {
            $output = $output . '<div class="panel panel-default">
                                        <div class="panel-heading">
                                            <span>' . $row['STATUS_TITLE'] . '</span> -- Posted by ' . $row['USER_USERNAME'] . 
                                        '</div>
                                    
                                        <div class="body">
                                            <img src="' . '../uploadedImages/' . $row['IMAGE_NAME'] . '" style="-webkit-filter: ' . $row['FILTER'] . '; filter: ' . $row['FILTER'] . ';" width="300px">' . 
                                            $row['STATUS_TEXT'];
            
                    if($_username == $row['USER_USERNAME'])
                    {   
                        //$_SESSION['image'] = $row['IMAGE_NAME'];
                        $x= $x + 1;
                        
                        $output = $output . '<form method= "POST" action= "delete.php">
                                                <div class= "col-md-offset-11">
                                                    <input type= "hidden" id= "deleteImage" name="'. $x .'" value= ' . $row['IMAGE_NAME'] . '>
                                                    <input type= "submit" class= "btn btn-danger" value= "Delete">
                                                </div>
                                            </form>';
//                        <a type= "button" class="btn btn-danger" href="delete.php">Delete</a>
                    }
            
                    $output= $output . '</div>
                                </div>'; 
            
                                
                                
        }
    
        return $output;
    }
?>