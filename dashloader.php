<?php
    session_start();
    
    require_once("includes/functions.php"); 
    require_once("includes/connection.php");
    require_once("includes/cookie.php");
    require_once("includes/user.php");
    require_once("fbapp/src/facebook.php");
    require_once("includes/dashfunctions.php");

    
    //IS COOKIE SET
    if(isset($_COOKIE['userid'])  && isset($_COOKIE['token']))
    {
           
    	$oldCookie = new Cookie($_COOKIE['userid']);
    	$oldCookie->setCookieToken($_COOKIE['token']);
        $response=array('success'=>'0');

    	if($oldCookie->isValidCookie())
    	{
            $user = new User();
            $user->loadUser((int)$_COOKIE['userid']);
            if($user->isLoad() == False)
            {
                $response=array('success'=>'0','error' =>'User Connection Problem');
            }
            else
            {    
                          
                //CALLING FUNCTIONS ACC TO CODE
                $code = $_POST["code"];
                switch($code)
                {
                    case "loadCurrentQuestion" : 
                        $question = loadQuestion($user->getLevel());
                        if($question == NULL)
                            $response=array('success'=>'0','error' =>'Connection Problem');
                        else
                            $response=array('success'=>'1','question'=>$question);
                        break;

                    case "loadQuestion" : 
                        $questionLevel = (int)$_POST["level"];
                        if($user->getLevel() >= $questionLevel) //ALLOWED TO SEE
                        {
                            $question = loadQuestion($questionLevel);
                            if($question == NULL)
                                $response=array('success'=>'0','error' =>'Connection Problem');
                            else
                                $response=array('success'=>'1','question'=>$question,'userLevel' =>(string) $user->getLevel());  
                        }
                        else
                        {
                            $response=array('success'=>'0','error' =>'Hey, don\'t be over smart');
                        }
                        break;

                    case "submitAnswer" :
                        $submission = $_POST["submission"];
                        $truth = checkSubmission($user->getLevel(),$submission);
                        // -1-> cookie invalid
                        // 0 -> Connection Problem
                        // 1 -> Wrong Answer
                        // 2 -> Correct Answer
                        // 3 -> Answer is correct, type Again
                        
                        // truth  value --> -1 (wrong) , 1 (correct)
                        if($truth == NULL)
                            $response=array('success'=>'0','error' =>'Connection Problem');
                        else
                        {
                            $submitResponse = submitAnswer($user->getUserId(), $submission, $truth, $user->getLevel());
                            
                            if($truth == 1 && $submitResponse == 1)
                            {
                                $incrementStatus=$user->incrementLevel(); /***** TO DO - CHANGE TIME ****/
                                //LOAD QUESTION
                                /*******************************/
                                $messageLevel = $user->getLevel();
                                $messageLevel = $messageLevel -1;
                                if($incrementStatus == 1)
                                {
                                    $response=array('success'=>'2','level' => (string)$messageLevel);
                                    //POST TO FACEBOOK :)
                                    //for posting on fb through php sdk
                                    //$user->postToFacebook();
                                }
                                else
                                    $response=array('success'=>'3','error' =>'Answer was correct, Type Again');                                
                            }
                            else if($truth == -1 && $submitResponse == 1)
                            {
                                $response=array('success'=>'1','error' =>'Wrong Answer'); 
                            }
                            else if($truth == 1 && $submitResponse == NULL)
                            {
                               $response=array('success'=>'3','error' =>'Answer was correct, Type Again'); 
                            }                             
                        }
                        break;
                    case "loadLeaderboard":
                        $pageNo = (int)$_POST["page"];
                        $pageSize = (int)$_POST["pageSize"];
                        //user rank
                        $rank = getUsersRanks($user->getUserId());
                        //LOADING THE DEMANDED LIST
                        $lowerLimit = $pageSize*($pageNo - 1); 

                        $leaderList =  loadLeaderboard($lowerLimit,$pageSize);
                        
                        $rowCount = count($leaderList);
                        //FOR PAGINATION TOTAL USERS
                        $totalUsers = checkNumberOfUsers();


                        $pageCount = ceil((int)$totalUsers/$pageSize);
                        

                        if($leaderList == -1 or $pageCount == -1 or $rowCount == -1) //ERROR IN CONNECTION
                            $response=array('success'=>'0','error' =>'Connection Problem, Please Try Later');
                        else
                            $response=array('success'=>'1','userRank'=>$rank,'totalPageCount'=>$pageCount,'pageNo'=>$pageNo, 'pageSize'=>$pageSize,'rowCount'=>$rowCount,'leaderList'=>$leaderList);
                        
                        break;
                    case 'loadFriends':
                        $friends = getFriends(); //functions.php
                        $response= array('success'=>'1','friends'=>$friends);
                        break;
                    /*only use this function if the loadFriend() fails to deliever images and content*/
                    case 'loadUsers':
                        $users = getUsers(); //dashfunctions.php
                        $response = array('success'=>'1','friends'=>$users,'fbid'=>$user->getFbId());
                        break;
                }

            }    		
    	}//VALID PORTION ENDS
    	else //COOKIE INVALID
    	{	//LOGIN REDIRECT
            $response=array('success'=>'-1');        		
    	}
    
    }
    else //LOGIN REDIRECT
    {
        $response=array('success'=>'-1');	
    }
    header('Content-Type: application/json');
    echo json_encode($response);    
    $conn=NULL;
?>
