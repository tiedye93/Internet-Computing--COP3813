<?php

//------------------------------------------Logging out of the Session------------------------------------

  session_start();
  unset($_SESSION['username']); // remove username from the session
  session_destroy(); //destroy the session
  header('location: ../index.php'); // redirect back to index.php

?>