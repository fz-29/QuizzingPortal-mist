<?php
require_once("includes/connection.php");
require_once("includes/cookie.php");
class User
{
	private $userId;
	private $fbId;
	private $fbToken;
	private $name;
	private $level;
	
	public function __construct()
	{
		$this->userId=NULL;
		$this->fbId=NULL;
		$this->name=NULL;
		$this->level=NULL;
		$this->fbToken=NULL;
	}
	public function setFbId($fid)
	{
		$this->fbId = $fid;
	}
	public function setFbToken($fbToken)
	{
		$this->fbToken = $fbToken;
		global $SERVER,$DB,$USER,$PSWD,$conn;		
		try 
		{
			//prepare
		    $stmt=$conn->prepare("UPDATE users SET fbtoken=:fbtoken WHERE id= :uid");
		    //bind
            $tempLevel = $this->level +1;
		    $stmt->bindParam(':fbtoken',$this->fbToken);
			$stmt->bindParam(':uid',$this->userId);
			//set and execute
			$stmt->execute();
			return 1;
		}
		catch(PDOException $e)
		{
		    header("Location: index.php?msg=".urlencode("cannot set FBTOKEN"));
	    	exit();
		}
	}
	public function updateLeveltime()
	{
		//TO JUST UPDATE THE TIMESTAMP FOR COOKIE
		global $SERVER,$DB,$USER,$PSWD,$conn;		
		try 
		{
			//prepare
		    $stmt=$conn->prepare("UPDATE users SET leveltime=CURRENT_TIMESTAMP WHERE id= :uid");
		    //bind
			$stmt->bindParam(':uid',$this->userId);
			//set and execute
			$stmt->execute();
		}
		catch(PDOException $e)
		{
		    header("Location: index.php?msg=".urlencode("timestamp not updated"));
	    	exit();
		}
	}
	public function incrementLevel()
	{
		
		global $SERVER,$DB,$USER,$PSWD,$conn;		
		try 
		{
			//prepare
		    $stmt=$conn->prepare("UPDATE users SET level=:level WHERE id= :uid");
		    //bind
            $tempLevel = $this->level +1;
		    $stmt->bindParam(':level',$tempLevel);
			$stmt->bindParam(':uid',$this->userId);
			//set and execute
			$stmt->execute();
			$this->level = $this->level + 1;
			$this->updateLeveltime();
			return 1;
		}
		catch(PDOException $e)
		{
		    return NULL;
		}
	}

	public function addNewUser($fbId,$name,$email)
	{
		global $SERVER,$DB,$USER,$PSWD,$conn;
		$level=1;//As user is NEW	
		try 
		{
		    $sqlq = "INSERT INTO users (fbid, name, email, level) ";
		    $sqlq .= " VALUES (?,?,?,?);";
		    $stmt = $conn->prepare($sqlq);
		    $stmt->bindParam(1,$fbId);
			$stmt->bindParam(2,$name);
			$stmt->bindParam(3,$email);
			$stmt->bindParam(4,$level);//Setting User to LEVEL 1			
			//set and execute
			$stmt->execute();
			
		}
		catch(PDOException $e)
		{
			header("Location: index.php?msg=".urlencode("user creation error"));
	    	exit();
		}
		$this->userId = $this->getUserId();
	}
	public function getUserId()
	{
		global $SERVER,$DB,$USER,$PSWD,$conn;
		try 
		{
		    $stmt=$conn->prepare('SELECT * FROM users WHERE fbid LIKE :fid');
		    //bind
			$stmt->bindParam(':fid',$this->fbId);
			//set and execute
			$stmt->execute();
			$result = $stmt->fetchAll();
			//WE HAVE ALREADY CHECK THAT ID AND TOKEN IS CORRECT SO WE CAN BE SURE ID exists and there is one result		 
			if( count($result) == 1) 
			{
				return $result[0]['id'];
			}
			else
			{
				return 0;
		    }
		}
		catch(PDOException $e)
		{
		    header("Location: index.php?msg=".urlencode("cookie validation error"));
	    	exit();
		}
	}

	public function isNewUser() //fbID should be set in any case
	{
		if($this->getUserId() == 0)
			{	return 1; }
		else
			{ return 0; }
	}
	public function loadUser($userid)
	{
		global $SERVER,$DB,$USER,$PSWD,$conn;
		try 
		{
		    $stmt=$conn->prepare('SELECT * FROM users WHERE id LIKE :userid');
		    //bind
			$stmt->bindParam(':userid',$userid);
			//set and execute
			$stmt->execute();
			$result = $stmt->fetchAll();
			//WE HAVE ALREADY CHECK THAT ID AND TOKEN IS CORRECT SO WE CAN BE SURE ID exists and there is one result		 
			if( count($result) == 1) 
			{
				$this->userId = $userid;
				$this->fbId = $result[0]['fbid'];
				$this->name = $result[0]['name'];
				$this->level = $result[0]['level'];
			}
			else
			{

		    }
		}
		catch(PDOException $e)
		{
		    header("Location: index.php?msg=".urlencode("cookie validation error"));
	    	exit();
		}

	}
	public function isLoad()
	{
		if($this->name == NULL)
			return False;
		else
			return True;
	}
	public function getLevel()
	{
		return $this->level;
	}
	public function getFbId()
	{
		return $this->fbId;
	}
	public function postToFacebook()
	{
		require_once("includes/functions.php");
		$message = "DD";
		postToFB($message); //in functions.php
	}
}