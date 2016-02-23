<?php
	session_start();

	require_once("includes/functions.php");
	require_once("includes/connection.php");
	require_once("includes/cookie.php");
	require_once("includes/user.php");
	require_once("fbapp/src/facebook.php");
	
	if(isset($_COOKIE['userid'])  && isset($_COOKIE['token'])) //HAS A COOKIE
	{
		$oldCookie = new Cookie($_COOKIE['userid']);
		$oldCookie->setCookieToken($_COOKIE['token']);
		if($oldCookie->isValidCookie())	//COOKIE IS VALID AND HE WANTS TO LOGOUT, CLEAR HIS COOKIE AND CHANGE ON DB
		{
			//NORMAL - SHOW DASH
			$oldCookie -> destroyCookie(); 
			$oldCookie -> randomizeCookie();  //CREATE NEW TOKEN

			$oldCookie -> setCookieOnServer(); //CHANGE TOKEN ON SERVER

			/**************/
			
		}
		else //COOKIE INVALID -- EXPIRED COOKIED / PHISHED COOKIE
		{	
			//TELL HIM YOU ARE ALREADY LOGGED OUT
			
		}
	}
	else //LOGIN REDIRECT
	{
		
	}
	unset($_SESSION);
	session_destroy();
	$conn=NULL;
	header("Location: login.php");
	exit();
?>