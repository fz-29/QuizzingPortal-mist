<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
        <title>MIST</title>
                <!-- Mist icon -->
        <link rel="shortcut icon" href="images/mist_icon.ico">
        <!-- CSS  -->
<!--        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
        <!--Font Awesome CDN -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
        <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    </head>
    <body>
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
                    <h1><a id="mist-text" href="dashboard.php"><span class="thin animate-flicker">&nbsp;MIST</span></a></h1>
                </div>
            </div>
             <div class="row" id="button-div">
                <div class="col s12 center-align">
                  <a class="btn btn-medium red accent-3 waves-effect waves-light" href="dashboard.php"><i class="fa fa-play"></i>&nbsp;&nbsp;PLAY</a>
                </div>
            </div>
        </div>
        <div id="full-margin">
        

        <!--section-->
<!--         <div class="container fade-in" style="display: block; opacity: 1;">
            <div class="section fun-facts">
                <h2 class="header red-text lighten-1 section-title">
                    <span><i class="mdi-social-poll"></i>Fun Facts</span>
                </h2>
                <div class="row">
                    <div class="col s12 m3">
                        <div class="card pink accent-3">
                            <div class="card-content white-text">
                                <i class="fa fa-smile-o"></i>
                                <span class="card-title">Dragging</span>
                                <p class="bounceEffect animated bounceIn">
                                    Current Mood
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m3">
                        <div class="card pink accent-3">
                        
                                <div class="card-content white-text">
                                    <i class="fa fa-bar-chart"></i>
                                    <span class="card-title">1</span>
                                    <p class="bounceEffect animated bounceIn">
                                        Calories Burned
                                    </p>
                                </div>
                            
                        </div>
                    </div>
                    <div class="col s12 m3">
                        <div class="card pink accent-3">
                            <div class="card-content white-text">
                                <i class="fa fa-clock-o"></i>
                                <span class="card-title">abc</span>
                                <p class="bounceEffect animated bounceIn">
                                    Sleep Time
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m3">
                        <div class="card pink accent-3">
                            <div class="card-content white-text">
                                <i class="fa fa-glass"></i>
                                <span class="card-title">0</span>
                                <p class="bounceEffect animated bounceIn">
                                    Drinks Consumed
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m3">
                        <div class="card pink accent-3">
                            <div class="card-content white-text">
                                <i class="fa fa-heart text-red accent-4 heartEffect"></i>
                                <span class="card-title">76</span>
                                <p class="bounceEffect animated bounceIn">
                                    Heart Beat
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m3">
                        <div class="card pink accent-3">
                            <div class="card-content white-text">
                                <i class="fa fa-tachometer"></i>
                                <span class="card-title">15</span>
                                <p class="bounceEffect animated bounceIn">
                                    Steps Walk
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m3">
                        <div class="card pink accent-3">
                            
                                <div class="card-content white-text">
                                    <i class="fa fa-location-arrow"></i>
                                    <span class="card-title">N/A</span>
                                    <p class="bounceEffect animated bounceIn">
                                        Current Location
                                    </p>
                                </div>
                           
                        </div>
                    </div>
                    <div class="col s12 m3">
                        <div class="card pink accent-3">
                            <div class="card-content white-text">
                                <i class="fa fa-github-alt"></i>
                                <span class="card-title">51</span>
                                <p class="bounceEffect animated bounceIn">
                                    Git Repos
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!--section-->
        <h3 class="thin center" id="rules"></h3>
        <div class="row " id="simple">
            <div class="col s12 m8 offset-m2">
                <div class="spacer"></div>
                <p class="flow-text">“Mist is an infamous online treasure hunt which is and has always been the highlight of Troika. Mist will require you to answer questions based on what you know and what you can find. Navigate your way through hidden clues, obfuscated meanings and bewildering crypts, with your knowledge, lateral thinking, presence of mind, and most importantly, your I-won't-give-up attitude.</p>
                <p class="flow-text">With participation from across the globe, the competition will be as fierce as it can get. You will have to put your best foot forward to reach the pinnacle and be crowned as the champion, the last man standing.”</p>                
                <h3 class="thin center">Instructions and Rules</h3>
                <p class="flow-text">-Mist is an individual online event. You should posses a computing device with a fair internet connection to join the hunt.</p>
                <p class="flow-text">-The event consists of a series of levels with visuals and texts which are riddles and you should solve them to advance to the next level.</p>
                <p class="flow-text">-The answer should contain only alpha numeric symbols including space. For example, if the answer is “Noah’s Ark”, then you must enter “Noahs Ark” and that will be read as the correct answer.</p>
                <p class="flow-text">-Clues will be given on timely basis by the organizers. They will be released through our Facebook page and also on the Forum.</p>
                <p class="flow-text">-Any attempt to disclose the answers in public will lead to immediate disqualification of the participants.</p>
                <p class="flow-text">-The organizers' decisions will be final and binding.</p>

<!--                 <p class="flow-text">Communicating with a group of people by email should be as simple as communicating with one - but it isn't.  What happens if someone doesn't use reply-to-all? Or what if someones changes their email address?</p>
                <p class="flow-text">Gaggle Mail solves these problems by giving your group it's own permanent <span class="bold">@gaggle.email</span> email address that anyone in the group can use to reach everyone else in the group.</p>
                
                <h2><strong>General Instructions</strong></h2><br/><br/><br/><br/>
                There is an ocean of knowledge out there. <br/>
                Don't get overpowered by it. Don't get lost in it. <br/>

                The answers are right in front of your eyes.<br/><br/>

                Be patient.<br/>
                Consider all the alternatives.<br/>
                Listen.  <br/>

                Best of luck!<br/>
                <h3><strong>Minimum Requirements</strong></h3> <br /><br/>


                <li>Any modern computer</li>

                <li>A compatible web browser (preferably Mozilla Firefox 3.5,Google Chrome,IE 7 or above)</li>

                <li>Internet connection</li>

                <li>Human Brain</li> -->
                <div class="spacer"></div>
                <div class="section center-align">
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="spacer">
            </div>
        </div>
        <!-- Section -->
        <!-- <div class="row">
            <div class="container">
                <div class="col s12 m3">
                    <div class="card orange">
                        <div class="card-image">
                            <span class="card-title">
                            <i class="mdi-file-cloud-done"></i>&nbsp;Cloud
                            </span>
                        </div>
                        <div class="card-content white-text">
                            <span class="card-title">
                            <i class="mdi-file-cloud-done"></i>&nbsp;Cloud</span>
                            <p>From cloud database to SSD Servers, we got you covered.</p>
                        </div>
                        <div class="card-action white-text">
                            <a class="white-text" href="/cloud">Get started</a>
                        </div>
                    </div>
                </div>
                <div class="col s12 m3">
                    <div class="card grey">
                        <div class="card-image">
                            <span class="card-title">
                            <i class="mdi-image-grain"></i>&nbsp;Big data
                            </span>
                        </div>
                        <div class="card-content white-text">
                            <span class="card-title">
                            <i class="mdi-image-grain"></i>&nbsp;Big data</span>
                            <p>We make it easy for you to analyse your critical data.</p>
                        </div>
                        <div class="card-action white-text">
                            <a class="white-text" href="/big-data">Get started</a>
                        </div>
                    </div>
                </div>
                <div class="col s12 m3">
                    <div class="card blue">
                        <div class="card-image">
                            <span class="card-title">
                            <i class="mdi-hardware-cast-connected"></i>&nbsp;IOT
                            </span>
                        </div>
                        <div class="card-content white-text">
                            <span class="card-title">
                            <i class="mdi-hardware-cast-connected"></i>&nbsp;IOT</span>
                            <p>Get access to platforms and skills to connect things around you.</p>
                        </div>
                        <div class="card-action white-text">
                            <div>
                                <a class="white-text" href="/iot">Internet of things</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m3">
                    <div class="card cyan">
                        <div class="card-image">
                            <span class="card-title">
                            <i class="mdi-action-settings-ethernet"></i>&nbsp;Development
                            </span>
                        </div>
                        <div class="card-content white-text">
                            <span class="card-title">
                            <i class="mdi-action-settings-ethernet"></i>&nbsp;Development</span>
                            <p>Let us turn your dream project to reality. Hire only the best.</p>
                        </div>
                        <div class="card-action white-text">
                            <div>
                                <a class="white-text" href="/development">Nairobicoder</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!--Reviews-->
        <div class="section white" style="margin-top: 0px;">
            <div class="container">
                <h5 class="text-primarycolor">Reviews</h5>
                <div class="row">
                    <div class="col s12 valign-wrapper">
                        <div class="col s2 valign">
                            <img width="65" height="65" src="http://www.android-kiosk.com/wp-content/themes/androidkioskcom/images/material_man1.png" class="circle">
                        </div>
                        <div class="col s10">
                            <blockquote>
                                <p class="grey-text text-darken-3">
                                    <span style="font-weight:500;">Contact and Help</span>
                                </p>
                                <p class="grey-text text-darken-3"><span style="font-weight:500;">Email :</span> mist.troika@dcetech.com</p>
                                <p class="grey-text text-darken-3"><span style="font-weight:500;">Forum :</span><a href="https://www.facebook.com/mist.troika/app/202980683107053/" target="_blank"> https://www.facebook.com/mist.troika/app/202980683107053/</a></p>
                                <p class="grey-text text-darken-3"><span style="font-weight:500;">Facebook :</span><a href="https://www.facebook.com/mist.troika/" target="_blank"> https://www.facebook.com/mist.troika/</a></p>
                                
                                <div class="divider"></div>
                            </blockquote>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 center-align">
                        
                    </div>
                </div>
            </div>
        </div>
        <!--  Scripts-->
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
        <script src="js/script.js"></script>
    </body>
</html>
