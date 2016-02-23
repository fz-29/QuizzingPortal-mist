<?php
    session_start();
    require_once("includes/connection.php");
    require_once("fbapp/src/facebook.php");
    require_once("includes/functions.php");    
    require_once("includes/cookie.php");
    require_once("includes/user.php");

    //IS COOKIE SET
    if(isFbLoggedIn() && isset($_COOKIE['userid'])  && isset($_COOKIE['token']))
    {
           
        $oldCookie = new Cookie($_COOKIE['userid']);
        $oldCookie->setCookieToken($_COOKIE['token']);
    
        if($oldCookie->isValidCookie())
        {
               
            if(!isset($_SESSION["name"]))
            {
                $oldCookie->loadToSession();
            }
            //NORMAL - SHOW DASH
        }
        else //COOKIE INVALID
        {   //LOGIN REDIRECT
            $conn=NULL;
            header("Location: login.php");
            exit();
        }
    
    }
    else //LOGIN REDIRECT
    {
        $conn=NULL;
        header("Location: login.php");
        exit();

    }
    $conn=NULL;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
        <meta http-equiv="refresh" content="600; URL=http://mist.dcetech.com/dashboard.php">
        <title>MIST DashBoard</title>
        <!-- Mist icon -->
        <link rel="shortcut icon" href="images/mist_icon.ico">
        <!-- CSS  -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Font Awesome CDN -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
        <link rel="stylesheet" href="css/style-dash.css">
    </head>
    <body>
    <script>
    var fb_api_id = 1960176640873628 ;
          window.fbAsyncInit = function() {
            FB.init({
              appId      : fb_api_id,
              xfbml      : true,
              version    : 'v2.5'
            });            
          };

          (function(d, s, id){
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement(s); js.id = id;
             js.src = "//connect.facebook.net/en_US/sdk.js";
             fjs.parentNode.insertBefore(js, fjs);
           }(document, 'script', 'facebook-jssdk'));
        </script>
        <div class="navbar-fixed">
            <nav>
                <div class="nav-wrapper cyan z-depth-2">
<!-- top nav bar-->
                    <a href="index.php" class="brand-logo center" id="mist-logo">MIST</a>
                    <a href="" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="https://www.facebook.com/mist.troika/app/202980683107053/" target="_blank">Forum</a></li>
                    </ul>
                    
                    <a href="http://troika.dcetech.com" target="_blank"><img src="images/ieee_logo.gif" class="left hide-on-med-and-down" width="50" height="50" style="margin-left: 20px;margin-top: 5px;"/></a>
                    

<!-- side nav bar-->
                    
                            <ul class="side-nav black-text" id="mobile-demo">
                                <div class="row">
                                    <div class="col s12 center-align">
                                        <?php echo '<img alt="Your-pic" class="circle responsive-img" id="profile-img" src="https://graph.facebook.com/'. $_SESSION["fbid"].'/picture">';?>
                                    </div>
                                </div>
                                <li class="center-align card-panel blue lighten-5 z-depth-1 ">
                                    <?php  echo "Hello, ".$_SESSION["name"];?>

                                </li>
                                <li id="leaderboard-tab" class="collection-item waves-effect waves-light waves-light" onclick="loadLeaderboard(1)"><div>Leaderboards<i class="material-icons right">equalizer</i></div></li>
                                <div id="level-tabs-ham">

                                </div>
                                <li class="center-align"><a style="padding-left:0;margin-left:0;" href=" <?php echo "https://www.facebook.com/mist.troika/app/202980683107053/";?>">Forum</a></li>

                            </ul>

                            
                </div>
            </nav>
        </div>
<!-- left side nav bar -->
        <div class="row" id="full-height">
            <div id="left-nav" class="col s12 m12 l2 hide-on-med-and-down scrollable cyan lighten-1 z-depth-5">
                
                        <div id="user-details"class="blue lighten-5 z-depth-1 valign" style="">
                            <div class="row valign-wrapper" style="padding-top: 20px;">
                                <div class="col s3 offset-s1">
                                    <?php echo '<img alt="Your-pic" class="circle responsive-img" src="https://graph.facebook.com/'. $_SESSION["fbid"].'/picture">';?>
                                </div>
                                <div class="col s8">
                                    <span class="white-text">
                                    <?php  echo "Hello <br>".$_SESSION["name"];?>
                                    </span>
                                </div>
                            </div>
                        </div>
                <li id="leaderboard-tab" class="card-panel blue lighten-5 z-depth-1 collection-item waves-effect waves-light waves-light" onclick="loadLeaderboard(1)"><div>Leaderboards<i class="material-icons right">equalizer</i></div></li>
                
                <div class="row" id="level-tabs">

                </div>
            </div>
<!--right side-->
            <div class="col s12 m12 l10 scrollable" id="right-nav">
                <div class="row">
                </div>
                <div class="row" id="hide-display">
                    <div class="col s12 center-align">
                    People Currently Playing
                    </div>
                </div>
                <div class="row" id= "hide-display">
                    <div class="col s12 m10 offset-m1 center-align">
                        <div class="carou">
                            <div class="slider-wrap" id="loadfriends">
                                <div class="slider" >
                                </div>                                    
                                <a href="#" class="slider-arrow sa-left">&lt;</a> <a href="#" class="slider-arrow sa-right">&gt;</a> 
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row" id="question-div">
                    

                    <div class="col s12 m10 offset-m1 center-align">
                        <div id="question">
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div class="col s12 m10 offset-m1 center-align">
                            <div class="progress" id="progress-bar">
                            <!-- <div class="indeterminate"></div> -->
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col s12 m10 offset-m1 center-align">
                        <div id="error" class="">
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  Scripts-->
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
        <script src="js/dashboard.js"></script>
       
        </script>
        <script type="text/javascript">
        $(document).ajaxStart(function(){
            $("#progress-bar").css('visibility', 'visible');
            document.getElementById("progress-bar").innerHTML = "<div class=\"indeterminate\"></div>";
        });
        $(document).ajaxStop(function(){
            document.getElementById("progress-bar").innerHTML = "";
            $("#progress-bar").css('visibility', 'hidden');
        });
            loadCurrentQuestion();
        </script>
        <script src="js/script.js"></script>
        <script src="js/jquery.lbslider.js"></script> 
        <script>
        //loadFriends();
        // use this if facebook tries to play a game with us
        var w = $(window).width();
        var h = $(window).height();
        if(w > 540 && h > 540)
        { 
            loadUsers();  
        }
        
        
        


        </script>
    </body>
</html>
</html>