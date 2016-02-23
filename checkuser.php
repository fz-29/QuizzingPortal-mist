<?php
	session_start();
	require_once("includes/connection.php");
    require_once("fbapp/src/facebook.php");
    require_once("includes/functions.php");    
    require_once("includes/cookie.php");
    require_once("includes/user.php");
	
	
	if(!isset($_SESSION["fbloginrequest"]))
	{
		//ANY BACK REQUEST FROM DASHBOARD MAY LAND UP HERE
		//header("Location: index.php?msg=".urlencode("invalid checkuser"));
		header("Location: dashboard.php");
		exit();
	}
	unset($_SESSION["fbloginrequest"]);

	// Create our Application instance (replace this with your appId and secret).
	$facebook = new Facebook(array(
	  'appId'  => '1960176640873628',
	  'secret' => '8ad5c1c717be01b86d7d986b39783548',
	));
	// Get User ID
	//USER HAS BEEN REDIRECTED HERE AFTER SUCCESSFUL LOGIN
	$fbId = $facebook->getUser();

	$fbUser = new User();
	$fbUser->setFbId($fbId);
	$userId=0;
	if($fbId)
	{
		if($fbUser->isNewUser())
		{	
			try
			{
				// Proceed knowing you have a logged in user who's authenticated.
				$user_profile = $facebook->api('/me');
				$user_email = $facebook->api('/me?fields=email');
				$fbToken = $facebook->getAccessToken();	
			}
			catch (FacebookApiException $e)
			{
				header("Location: "."index.php?msg=".urlencode("new user check"));
				exit();	
			}
			$fbUser->addNewUser($fbId,$user_profile['name'],$user_email['email']);
			$userId = $fbUser->getUserId();
			$fbUser ->setFbToken($fbToken);
			$newCookie = new Cookie($userId);
			//ONLY RANDOMIZE IF COOKIE OLDER THAN 5
			$newCookie -> randomizeCookie();
			$newCookie -> setCookieOnServer();
			$newCookie -> setCookieOnClient();
			
		}
		else //RETURNING USER
		{

			try
			{
				// Proceed knowing you have a logged in user who's authenticated.
				$fbToken = $facebook->getAccessToken();	
			}
			catch (FacebookApiException $e)
			{
				header("Location: "."index.php?msg=".urlencode("cannot get fbtoken"));
				exit();	
			}

			//GIVE HIM THE COOKIE, QUESTION IS NEW OR OLD?, OLD TOKEN MIGHT BE ACTIVE ON OTHER DEVICE
			$userId = $fbUser->getUserId();
			$oldCookie = new Cookie($userId,true); //returning user is TRUE, will load the cookie and its time of creation

			if($oldCookie->isCookieAlive())
			{
				//, update on server
				//in case of CookieAlive, the lifetimewill increase of the old cookie
			}
			else //COOKIE HAS EXPIRED
			{
				$oldCookie->randomizeCookie();
				$oldCookie -> setCookieOnServer();	
			}

			$oldCookie -> setCookieOnClient();
			$fbUser ->setFbToken($fbToken);
		}
		header("Location: dashboard.php");
		exit();
	}
	else
	{
		// PROBABLY SHOULD NOT EXECUTE EVER
		header("Location: "."index.php?msg=".urlencode("no fbId still in checkuser"));
		exit();
	}	
?>