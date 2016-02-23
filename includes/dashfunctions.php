<?php

function loadQuestion($level)
{
	global $SERVER,$DB,$USER,$PSWD,$conn;
	try 
	{
	    $stmt=$conn->prepare('SELECT * FROM questions WHERE level LIKE :level');
	    //bind
		$stmt->bindParam(':level',$level);
		//set and execute
		$stmt->execute();
		$result = $stmt->fetchAll();
		//WE HAVE ALREADY CHECK THAT ID AND TOKEN IS CORRECT SO WE CAN BE SURE ID exists and there is one result		 
		if( count($result) >= 1) 
		{
			return $result[0];
		}
		else
		{
			return NULL;
	    }
	}
	catch(PDOException $e)
	{
	    return NULL;
	}

}

function submitAnswer($userid, $submission, $truth, $level)
{
	global $SERVER,$DB,$USER,$PSWD,$conn;
	try 
	{
	    $stmt=$conn->prepare('INSERT INTO submissions (userid, submission, truth, level) VALUES (:userid, :submission, :truth, :level) ;');
	    //bind
	    $stmt->bindParam(':userid',$userid);
	    $stmt->bindParam(':submission',$submission);
	    $stmt->bindParam(':truth',$truth);
		$stmt->bindParam(':level',$level);
		//set and execute
		$stmt->execute();
		return 1;
	}
	catch(PDOException $e)
	{
	    return NULL;
	}
}

function loadSideNavHam()
{
	global $SERVER,$DB,$USER,$PSWD,$conn;
	try 
	{
	    $stmt=$conn->prepare('SELECT * FROM questions WHERE level LIKE :level');
	    //bind
		$stmt->bindParam(':level',$level);
		//set and execute
		$stmt->execute();
		$result = $stmt->fetchAll();
		//WE HAVE ALREADY CHECK THAT ID AND TOKEN IS CORRECT SO WE CAN BE SURE ID exists and there is one result		 
		if( count($result) == 1) 
		{
			return $result;
		}
		else
		{
			return NULL;
	    }
	}
	catch(PDOException $e)
	{
	    return NULL;
	}

}
function loadSideNav()
{
	global $SERVER,$DB,$USER,$PSWD,$conn;
	try 
	{
	    $stmt=$conn->prepare('SELECT * FROM questions WHERE level LIKE :level');
	    //bind
		$stmt->bindParam(':level',$level);
		//set and execute
		$stmt->execute();
		$result = $stmt->fetchAll();
		//WE HAVE ALREADY CHECK THAT ID AND TOKEN IS CORRECT SO WE CAN BE SURE ID exists and there is one result		 
		if( count($result) == 1) 
		{
			return $result;
		}
		else
		{
			return NULL;
	    }
	}
	catch(PDOException $e)
	{
	    return NULL;
	}

}
function checkSubmission($level,$submission) //To check truthfullness of the submission
{
	global $SERVER,$DB,$USER,$PSWD,$conn;
	try 
	{
	    $stmt=$conn->prepare('SELECT answer FROM answers WHERE questionid = (SELECT id FROM questions WHERE level = :level);');
	    //bind
		$stmt->bindParam(':level',$level);
		//set and execute
		$stmt->execute();
		$result = $stmt->fetchAll();
		//WE HAVE ALREADY CHECK THAT ID AND TOKEN IS CORRECT SO WE CAN BE SURE ID exists and there is one result		 
		if( count($result) == 1) 
		{
			$ans_db = $result[0]['answer'];
			if($ans_db[strlen($ans_db)-1] === '|')
			{
				$ans_db = substr($ans_db, 0,-1); //removing last '|' as it may explode an empty string as one of the answer
			}
			$answers = explode('|', $ans_db);
			$submission = strtolower($submission);
			$truthfullness = -1;
			foreach ($answers as $answer)
			{
				$lowerans = strtolower($answer);
				if($submission === $lowerans)
				{
					$truthfullness = 1;
				}
			}
			return $truthfullness;
		}
		else
		{
			return NULL;
	    }
	}
	catch(PDOException $e)
	{
	    return NULL;
	}
}
function checkNumberOfUsers()
{
	global $SERVER,$DB,$USER,$PSWD,$conn;
	try 
	{
	    $stmt=$conn->prepare('SELECT COUNT(*) FROM users;');
	    //bind
		//set and execute
		$stmt->execute();
		$result = $stmt->fetchAll();
		//WE HAVE ALREADY CHECK THAT ID AND TOKEN IS CORRECT SO WE CAN BE SURE ID exists and there is one result		 
		return $result[0][0];
	}
	catch(PDOException $e)
	{
	    return -1;
	}

}
function loadLeaderboard($lowerLimit,$interval)
{
	global $SERVER,$DB,$USER,$PSWD,$conn;
	try 
	{

		$query = 'SELECT fbid,name, level, leveltime FROM users ORDER BY level DESC, leveltime ASC LIMIT '.$lowerLimit.' , ' . $interval . ' ;';
	    $stmt=$conn->prepare($query);

		$stmt->execute();
		$result = $stmt->fetchAll();
		//array_slice($result,$limit1,$limit2-$limit1);
		//WE HAVE ALREADY CHECK THAT ID AND TOKEN IS CORRECT SO WE CAN BE SURE ID exists and there is one result		 
		return $result;
	}
	catch(PDOException $e)
	{
		error_log($e);
	    return NULL;
	}

}

function getUsersRanks($userID)
{
	$userID = (int)$userID;
	global $SERVER,$DB,$USER,$PSWD,$conn;
	try 
	{
		$query = 'SET @rownum = 0; ';
		$stmt=$conn->prepare($query);	    
		$stmt->execute();

		$query = 'SELECT rank,id FROM ( SELECT @rownum := @rownum +1 AS rank, id FROM users ORDER BY level DESC , leveltime ASC) AS result	WHERE id ='.$userID.';';
	    $stmt=$conn->prepare($query);	    
		$stmt->execute();
		$result = $stmt->fetchAll();
		//WE HAVE ALREADY CHECK THAT ID AND TOKEN IS CORRECT SO WE CAN BE SURE ID exists and there is one result
		//error_log(print_r($result));		 
		return $result[0]['rank'];
	}
	catch(PDOException $e)
	{
	    return NULL;		 ;
	}
}
function getUsers()
{
	
	global $SERVER,$DB,$USER,$PSWD,$conn;
	try 
	{
		$query = 'SELECT fbid,name,level FROM users; ';
		$stmt=$conn->prepare($query);	    
		$stmt->execute();

		
		$result = $stmt->fetchAll();
		//WE HAVE ALREADY CHECK THAT ID AND TOKEN IS CORRECT SO WE CAN BE SURE ID exists and there is one result
		//error_log(print_r($result));		 
		return $result;
	}
	catch(PDOException $e)
	{
	    return NULL;		 ;
	}
}
/*
function loadLeaderboardFriend()
{
	global $SERVER,$DB,$USER,$PSWD,$conn;
	try 
	{
	    $stmt=$conn->prepare('SELECT * FROM questions WHERE level LIKE :level');
	    //bind
		$stmt->bindParam(':level',$level);
		//set and execute
		$stmt->execute();
		$result = $stmt->fetchAll();
		//WE HAVE ALREADY CHECK THAT ID AND TOKEN IS CORRECT SO WE CAN BE SURE ID exists and there is one result		 
		if( count($result) == 1) 
		{
			return $result;
		}
		else
		{
			return NULL;
	    }
	}
	catch(PDOException $e)
	{
	    return NULL;
	}

}
*/
?>