<?php
	session_start();
	require_once("includes/connection.php");
    require_once("fbapp/src/facebook.php");
    require_once("includes/functions.php");    
    require_once("includes/cookie.php");
    require_once("includes/user.php");


	//IS COOKIE SET
	// if(isset($_COOKIE['userid'])  && isset($_COOKIE['token']) && isFbLoggedIn())
	// {
 //    	$oldCookie = new Cookie($_COOKIE['userid']);
	// 	$oldCookie->setCookieToken($_COOKIE['token']);

	// 	if($oldCookie->isValidCookie()) //EVERYTHING FINE
	// 	{
 //            if(!isset($_SESSION["name"]))
	// 		{
	// 			$oldCookie->loadToSession();
	// 		}
	// 		//REDIRECT TO DASHBOARD
	// 		$conn=NULL;
	// 		header("Location: dashboard.php");
	// 		exit();

	// 	}
	// 	else //COOKIE INVALID
	// 	{	
	// 		//GENERATE LOGIN URL AND DISPLAY
	// 		$_SESSION["fbloginrequest"]="true";
	// 		$loginUrl=getFbLoginUrl();	
	// 	}

	// }
	// else //NO COOKIE
	// {
	// 	//GENERATE LOGIN URL AND DISPLAY
	// 	$_SESSION["fbloginrequest"]="true";
	// 	$loginUrl=getFbLoginUrl();	//in functions.php
	// }
    $_SESSION["fbloginrequest"]="true";
    $loginUrl=getFbLoginUrl();  
	$conn=NULL;
?>

<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
        <title>MIST Login</title>
                <!-- Mist icon -->
        <link rel="shortcut icon" href="images/mist_icon.ico">
        <!-- CSS  -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Font Awesome CDN -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
        <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
	</head>

	<body style="overflow: hidden;">
        
                <div id="full-height">
            <div class="view hide-on-small-only" id="background-animation">
                <div class="plane main">
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                </div>
            </div>
            <div class="row" id="index-text">
                <div class="col s12">
                    <div class="center-align">
                        <h5 class="header light">
                            <?php 
                                if(isset($_GET["msg"])) { 
                                    echo $_GET["msg"];
                                } 
                            ?>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="row" id="mist-text-div">
                <div class="col s12 center-align">
                    <h1 id="mist-text"><span class="thin animate-flicker">&nbsp;MIST</span></h1>
                </div>
            </div>
            <div class="row" id="button-div">
                <div class="col s12 center-align">
                    <a class="btn btn-medium waves-effect waves-light"id="fb-button" href=<?php echo $loginUrl; ?> > <i class="fa fa-facebook fa-lg logos"></i>&nbsp;&nbsp;<strong>Login</strong></a>
                </div>
            </div>

        </div>
		
        
        
        
        
               <!--  Scripts-->
        
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
        <script src="js/script.js"></script>
        
	</body>
</html>