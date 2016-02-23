<?php
require_once("includes/connection.php");
class Cookie
{
	private $cookieId,$cookieToken,$COOKIE_LIFETIME,$timeOfCreation;
	public function __construct($id, $returningUser = false)
	{
		$this->cookieId=(int)$id; //STORE AS INT
		$this->cookieToken=NULL; //STORE AS STRING
		$this->COOKIE_LIFETIME = 5*3600; // HOURS * 3600
		if($returningUser == true)
		{
			global $SERVER,$DB,$USER,$PSWD,$conn;
			//LOAD THE TIME STAMP OF COOKIE
			try 
			{
				//where id is sufficient as we have verified his fbId and from there we have got his userId
				$stmt=$conn->prepare("SELECT * FROM users WHERE id LIKE :cid");
			   	$stmt->bindParam(':cid',$this->cookieId);
				//set and execute
				$stmt->execute();
				$result = $stmt->fetchAll();
				if( count($result) == 1 ) 
				{ 
					$this->timeOfCreation=strtotime($result[0]['time']);
					$this->cookieToken=($result[0]['ctoken']);
				}
				else //NO SUCH COOKIE
				{
				    header("Location: index.php?msg=".urlencode("cookie alive but problem"));
		    		exit();
			    }
			}
			catch(PDOException $e)
			{
			    header("Location: index.php?msg=".urlencode("cookie validation error"));
		    	exit();
			}

		}
	}
	public function setCookieToken($token)
	{
		$this->cookieToken = $token;
	}	
	public function isValidCookie()
	{
		global $SERVER,$DB,$USER,$PSWD,$conn;
		
		try 
		{
			//prepare

		    $stmt=$conn->prepare("SELECT * FROM users WHERE id LIKE :cid AND ctoken LIKE :ct");
		    //bind
			$stmt->bindParam(':cid',$this->cookieId);
			$stmt->bindParam(':ct',$this->cookieToken);
			//set and execute
			$stmt->execute();
			$result = $stmt->fetchAll();
			if( count($result) == 1 ) 
			{ 
				$this->timeOfCreation = strtotime($result[0]['time']);
				if( time() - $this->timeOfCreation < $this->COOKIE_LIFETIME ) //NEW COOKIE
				{
					return true;
				}
				else //OLD COOKIE
				{
					return false;
				}
			}
			else //NO SUCH COOKIE
			{
			    return false;
		    }
		}
		catch(PDOException $e)
		{
		    header("Location: index.php?msg=".urlencode("cookie validation error"));
	    	exit();
		}
	}
	public function randomizeCookie()
	{
		$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
		//MY OWN SANDWICH TECHNIQUE
		$sudoRandom =  (string)time() . (string)$this->cookieId . $salt ;

		$token = hash('sha256', $sudoRandom);
		$this->cookieToken = $token;
	}
	public function setCookieOnServer()
	{

		global $SERVER,$DB,$USER,$PSWD,$conn;
		try 
		{
		    $sqlq = "UPDATE users SET ctoken = ? WHERE id = ?";
		    $stmt = $conn->prepare($sqlq);
		    $stmt->bindParam(1,$this->cookieToken);
			$stmt->bindParam(2,$this->cookieId);
			//set and execute
			$stmt->execute();

		}
		catch(PDOException $e)
		{
			header("Location: index.php?msg=".urlencode("cookie could not set on server"));
	    	exit();
		}
	}
	public function setCookieOnClient()
	{
		$tokenLife=time() + $this->COOKIE_LIFETIME;
		 // time is in epoch but in seconds
		setcookie("userid",(string) $this->cookieId, $tokenLife, "/","mist.dcetech.com",false,true);
		setcookie("token",$this->cookieToken, $tokenLife , "/","mist.dcetech.com",false,true);	
	}
	public function destroyCookie()
	{
		$tokenLife=time() - ($this->COOKIE_LIFETIME*100);
		 // time is in epoch but in seconds
		setcookie("userid",(string) $this->cookieId, $tokenLife, "/","mist.dcetech.com",false,true);
		setcookie("token",$this->cookieToken, $tokenLife , "/","mist.dcetech.com",false,true);
	}
	public function loadToSession()
	{
		require_once("includes/functions.php");
		$userid=$this->cookieId;
		global $SERVER,$DB,$USER,$PSWD,$conn;		
		try 
		{
			//prepare
		    $stmt=$conn->prepare("SELECT * FROM users WHERE id LIKE :uid");
		    //bind
			$stmt->bindParam(':uid',$this->cookieId);
			//set and execute
			$stmt->execute();
			$result = $stmt->fetchAll();

			if( count($result) == 1 ) 
			{ 
				$fbid = $result[0]['fbid'];
				$name = $result[0]['name'];
				$_SESSION["name"]=$name;
				$_SESSION["fbid"]=$fbid;
				$_SESSION["userid"]=$userid;
				//contact facebook to getCurrentFbToken
				$_SESSION["fbtoken"]= getFbToken();//fuctions.php
			}
			else //NO SUCH COOKIE
			{
			    header("Location: index.php?msg=".urlencode("database error while loading session: no such user"));
	    		exit();
		    }
		}
		catch(PDOException $e)
		{
		    header("Location: index.php?msg=".urlencode("database error while loading session"));
	    	exit();
		}
	}
	public function isCookieAlive()
	{
		if( time() - $this->timeOfCreation < $this->COOKIE_LIFETIME )
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function updateTimestamp()
	{
		//TO JUST UPDATE THE TIMESTAMP FOR COOKIE
		global $SERVER,$DB,$USER,$PSWD,$conn;		
		try 
		{
			//prepare
		    $stmt=$conn->prepare("UPDATE users SET time=CURRENT_TIMESTAMP WHERE id= :uid");
		    //bind
			$stmt->bindParam(':uid',$this->cookieId);
			//set and execute
			$stmt->execute();
		}
		catch(PDOException $e)
		{
		    header("Location: index.php?msg=".urlencode("timestamp not updated"));
	    	exit();
		}
	}
}
?>