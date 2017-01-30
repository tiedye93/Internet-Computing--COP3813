<?php //setupusers.php
  require_once 'php/db_connect.php';

  $connection = new mysqli($hn, $un, $pw, $db);

  if ($connection->connect_error) 
  {
      die($connection->connect_error);
  }

  $query = "CREATE TABLE IF NOT EXISTS USERS (
    userid VARCHAR(32) NOT NULL UNIQUE,
    password VARCHAR(32) NOT NULL
  )";


  $result = $connection->query($query);

  if (!$result) 
  {
      die($connection->error);
  }


//  $salt1    = "qm&h*";
//  $salt2    = "pg!@";
//
//  $forename = 'Bill';
//  $surname  = 'Smith';
//  $username = 'bsmith';
//  $password = 'mysecret';
//  $token    = hash('ripemd128', "$salt1$password$salt2");
//
//  add_user($connection, $forename, $surname, $username, $token);
//
//  $forename = 'Pauline';
//  $surname  = 'Jones';
//  $username = 'pjones';
//  $password = 'acrobat';
//  $token    = hash('ripemd128', "$salt1$password$salt2");
//
//  add_user($connection, $forename, $surname, $username, $token);
//
//  function add_user($connection, $fn, $sn, $un, $pw)
//  {
//    $query  = "INSERT INTO users VALUES('$fn', '$sn', '$un', '$pw')";
//    $result = $connection->query($query);
//    if (!$result) die($connection->error);
//  }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
      
        <title>Tyler Bourque</title>
      
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
      
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/business-casual.css" />  
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
        
        <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
        
        <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-34731274-1']);
            _gaq.push(['_trackPageview']);
            _gaq.push(['_trackEvent', 'sharing', 'viewed full-screen', 'snippet yPR4e',0,true]);
        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
        </script>
        <script type="text/javascript">
        (function($) { 
            $('#theme_chooser').change(function(){
                whichCSS = $(this).val();
                document.getElementById('snippet-preview').contentWindow.changeCSS(whichCSS);
            });
        })(jQuery);
        </script>
      
    </head>
    
    <body>
        <div class="container">    
            <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
                <div class="panel panel-info" >
                        <div class="panel-heading">
                            <div class="panel-title">Sign In</div>
<!--                            <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div>-->
                        </div>     

                        <div style="padding-top:30px" class="panel-body" >
                            <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                            <form id="loginform" class="form-horizontal" role="form">
                                    
                                <div style="margin-bottom: 25px" class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="Username">                                        
                                </div>
                                
                                <div style="margin-bottom: 25px" class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input id="login-password" type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                                
                                <div class="input-group">
                                      <div class="checkbox">
                                            <label>
                                                <input id="login-remember" type="checkbox" name="remember" value="1"> Remember me
                                            </label>
                                      </div>
                                </div>


                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->
                                    <div class="col-sm-12 controls">
                                        <a id="btn-login" href="#" class="btn btn-success">Login  </a>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 control">
                                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                            Don't have an account? 
                                            <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                                Sign Up Here
                                            </a>
                                        </div>
                                    </div>
                                </div>    
                            </form>     
                        </div>                     
                    </div>  
                </div>
        
            <div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">Sign Up  <span>  *Required</span></div>
                        <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Sign In</a></div>
                    </div>  
                    
                    <div class="panel-body" >
                        <form id="signupform" class="form-horizontal" role="form"> 
                            <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                            </div>
 
                            <div class="form-group">
                                <label for="email" class="col-md-3 control-label">Username <span>*</span></label>
                                
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="new_username" placeholder="Username">
                                </div>
                            </div>
                                    
<!--
                            <div class="form-group">
                                <label for="firstname" class="col-md-3 control-label">First Name</label>
                                
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="firstname" placeholder="First Name">
                                </div>
                            </div>
-->
                            
<!--
                            <div class="form-group">
                                <label for="lastname" class="col-md-3 control-label">Last Name</label>
                                    
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="lastname" placeholder="Last Name">
                                </div>
                            </div>
-->
                                
                            <div class="form-group">
                                <label for="password" class="col-md-3 control-label">Password <span>*</span></label>
                                    
                                <div class="col-md-9">
                                    <input type="password" class="form-control" name="new_password" placeholder="Password">
                                </div>
                            </div>
                                    
<!--
                            <div class="form-group">
                                <label for="icode" class="col-md-3 control-label">Invitation Code</label>
                                   
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="icode" placeholder="">
                                </div>
                            </div>
-->

                            <div class="form-group">
                                <!-- Button -->                                        
                                <div class="col-md-offset-3 col-md-9">
                                    <button id="btn-signup" type="button" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Sign Up</button> 
                                </div>
                            </div>
                                                                
                        </form>
                    </div>
                </div>       
            </div> 
        </div>
    </body>
</html>

<?php
    $connection->close();
?>