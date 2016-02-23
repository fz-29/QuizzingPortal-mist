var loginUrl = 'http://mist.dcetech.com'; 
var boardPageSize = 20; //no. of entries per page
var delay = 2;  //delay in switching carousel users
var noOfTimes = 20;   //loading users how many times in carousel to make it as a infinite loop
function calltoast(value){
    Materialize.toast(value, 3000,'rounded');
}
function loadQuestion(level)
{
        document.getElementById("error").innerHTML = '';
        $.ajax({
        url: loginUrl+'/dashloader.php',
        type : "POST",
        data: {
            code : 'loadQuestion',
            level : level
            }
        })
    .done (function(data) { 
                
                if(data.success == '1')
                {

                    var htmlContent= "<div class=\"row\"><div class=\"col s12 z-depth-2\">";
                    htmlContent = htmlContent + "<br><div class=\"row\"><div class=\"col s12 center-align\"><h5>Level: "+ data.question.level + "</h5></div></div>";
                    if(data.question.text != "")
                    {
                        htmlContent = htmlContent + "<div class=\"row\"><div class=\"col s12 center-align\"><h4>"+ data.question.text + "</h4></div></div><br>";
                    }
                    if(data.question.image != "")
                    {
                        htmlContent = htmlContent + "<div class=\"row\"><div class=\"col s12 center-align\"><img class=\"responsive-img\" src=\"" + data.question.image + "\"></div></div><br>";
                    }

                    if(data.question.video != "")
                    {
//                        htmlContent = htmlContent + "<video class=\"responsive-video\" controls><source src=\"" + data.question.video +"\" type=\"video/mp4\">Your browser does not support the video tag.</video><br>";
                        htmlContent = htmlContent + "<div class=\"row\"><div class=\"col s12 center-align\"><div class=\"video-container\">" +  data.question.video + "</div></div></div><br>"
                    }
                    
                    if(data.question.audio != "")
                    {
                        htmlContent = htmlContent + "<div class=\"row\"><div class=\"col s12 center-align\"><audio controls><source src=\"" + data.question.audio +"\" type=\"audio/mpeg\">Your browser does not support the audio tag.</audio></div></div><br>";
                    }

                    //SUBMIT BUTTON
                    if(data.question.level == data.userLevel)
                    {
                        htmlContent = htmlContent + "<div class=\"row\"><div class=\"col s12\"><form name=\"subForm\" action=\"#\" id=\"submission-form\"class=\"row\"><div class=\"input-field col l8 offset-l2 m10 offset-m1 s12\"><i class=\"material-icons prefix\">vpn_key</i><input id=\"submission\" type=\"text\" name=\"subTextField\" class=\"\"><label for=\"submission\">Key</label></div><div class=\"row\"><div class=\"col s6 offset-s3 center-align\"><button id=\"submission-btn\"class=\"btn waves-effect waves-light\" type=\"submit\" name=\"submit\" >Submit<i class=\"material-icons right\">send</i></button></div></form></div></div>";
                        htmlContent = htmlContent + "<script>$('form').on('submit', function(e){e.preventDefault();submitAnswer();});</script>";
                        //htmlContent = htmlContent + "<script>document.subForm.subTextField.focus();</script>";
                    }
                    else
                    {
                        htmlContent = htmlContent + "<div class=\"row\"><div class=\"col s12 center-align\">You have already submitted the key</div></div><br><br>";   
                        
                    }
                    //closing row and col divs
                    htmlContent = htmlContent + "</div></div>";

                    if(data.question.script != "")
                    {
                        htmlContent = htmlContent + "<script>"+ data.question.script + "</script><br>";
                    }
                    document.getElementById("question").innerHTML = htmlContent;
                    var arr = document.getElementById("question").getElementsByTagName('script');
                    for (var n = 0; n < arr.length; n++)
                        eval(arr[n].innerHTML);
                }
                   
                else if(data.success == '0')
                {
                    calltoast(data.error);
                    //document.getElementById("error").innerHTML = data.error;
                }
                else if(data.success == '-1')
                {
                    alert("You are logged out!");
                    window.location=loginUrl + '/login.php';
                }
        })
    .fail (function() {}); 
}

function loadSideNav(level)
{

    var sideNaveContenet = "";
    var nextLevel = level + 1;
    sideNaveContenet = sideNaveContenet + "<ul class=\"collection with-header\">";
    
    //LOAD LOCKED LEVELS
    sideNaveContenet = sideNaveContenet + "<li style=\"width: 100%;\" id=\"level-tab-"+  nextLevel.toString() + "\" class=\"collection-item waves-effect waves-light waves-light\" ><div>Level "+ nextLevel.toString() +"<i class=\"material-icons right\">lock</i></div></li>";
    sideNaveContenet = sideNaveContenet + "<li style=\"cursor: pointer;width: 100%;\" id=\"level-tab-"+level.toString() + "\" class=\"collection-item waves-effect waves-light waves-light orange accent-1\" onclick=\"loadCurrentQuestion()\"><div>Level "+ level.toString() +"<i class=\"material-icons right\">lock</i></div></li>";
    //LOAD OPEN LEVELS
    if(level >=2)
    { 
        for (var i = level - 1  ; i >= 1; i--) {
            sideNaveContenet = sideNaveContenet + "<li style=\"cursor: pointer;width: 100%;\" id=\"level-tab-"+i+ "\" class=\"collection-item waves-effect waves-light waves-light \" onclick=\"loadQuestion("+ i +")\"><div>Level "+ i +"<i class=\"material-icons right\">lock_open</i></div></li>";
        }
    }
    sideNaveContenet = sideNaveContenet + "</ul>";

    document.getElementById("level-tabs").innerHTML = sideNaveContenet;
}

function loadSideNavHam(level)
{

    var sideNaveContenet = "";
    var nextLevel = level + 1;
       
    //LOAD LOCKED LEVELS
    sideNaveContenet = sideNaveContenet + "<li style=\"width: 100%;\"id=\"level-tab-"+  nextLevel.toString() + "\" class=\"collection-item waves-effect waves-light waves-light\" ><div>Level "+ nextLevel.toString() +"<i class=\"material-icons right\">lock</i></div></li>";
    sideNaveContenet = sideNaveContenet + "<li style=\"cursor: pointer;width: 100%;\" id=\"level-tab-"+level.toString() + "\" class=\"collection-item waves-effect waves-light waves-light orange accent-1\" onclick=\"loadCurrentQuestion()\"><div>Level "+ level.toString() +"<i class=\"material-icons right\">lock</i></div></li>";
    //LOAD OPEN LEVELS
    if(level >=2)
    {
        for (var i = level- 1  ; i >= 1; i--) {
            sideNaveContenet = sideNaveContenet + "<li style=\"cursor: pointer;width: 100%;\" id=\"level-tab-"+i+ "\" class=\"collection-item waves-effect waves-light waves-light\" onclick=\"loadQuestion("+ i +")\"><div>Level "+ i +"<i class=\"material-icons right\">lock_open</i></div></li>";       
        }
    }   
    document.getElementById("level-tabs-ham").innerHTML = sideNaveContenet;
}

function loadCurrentQuestion()
{
    document.getElementById("error").innerHTML = '';
    $.ajax({
        url: loginUrl+'/dashloader.php',
        type : "POST",
        data: {
            code : 'loadCurrentQuestion'
        }
    })
    .done (function(data) { 
                document.getElementById("error").innerHTML = "";
                if(data.success == '1')
                {

                    var htmlContent= "<div class=\"row\"><div class=\"col s12 z-depth-2\">";
                    htmlContent = htmlContent + "<br><div class=\"row\"><div class=\"col s12 center-align\"><h5>Level: "+ data.question.level + "</h5></div></div>";
                    if(data.question.text != "")
                    {
                        htmlContent = htmlContent + "<div class=\"row\"><div class=\"col s12 center-align\"><h4>"+ data.question.text + "</h4></div></div><br>";
                    }
                    if(data.question.image != "")
                    {
                        htmlContent = htmlContent + "<div class=\"row\"><div class=\"col s12 center-align\"><img class=\"responsive-img\" src=\"" + data.question.image + "\"></div></div><br>";
                    }

                    if(data.question.video != "")
                    {
                        //htmlContent = htmlContent + "<video class=\"responsive-video\" controls><source src=\"" + data.question.video +"\" type=\"video/mp4\">Your browser does not support the video tag.</video><br>";
                        htmlContent = htmlContent + "<div class=\"row\"><div class=\"col s12 center-align\"><div class=\"video-container\">" +  data.question.video + "</div></div></div><br>"
                    }
                    
                    if(data.question.audio != "")
                    {
                        htmlContent = htmlContent + "<div class=\"row\"><div class=\"col s12 center-align\"><audio controls><source src=\"" + data.question.audio +"\" type=\"audio/mpeg\">Your browser does not support the audio tag.</audio></div></div><br>";
                    }
                    //htmlContent = htmlContent + "<div class=\"row\"><div class=\"col s12\"><div class=\"row\"><div class=\"input-field col l6 offset-l3 m10 offset-m1 s12\"><i class=\"material-icons prefix\">vpn_key</i><input id=\"submission\" type=\"text\" class=\"\"><label for=\"submission\">Key</label></div><div class=\"row\"><div class=\"col s6 offset-s3 center-align\"><button id=\"submit-btn\" class=\"btn waves-effect waves-light\" type=\"submit\" name=\"submit\" onclick=\"submitAnswer()\">Submit<i class=\"material-icons right\">send</i></button></div></div></div></div>";
                    htmlContent = htmlContent + "<div class=\"row\"><div class=\"col s12\"><form name=\"subForm\" action=\"#\" id=\"submission-form\"class=\"row\"><div class=\"input-field col l8 offset-l2 m10 offset-m1 s12\"><i class=\"material-icons prefix\">vpn_key</i><input id=\"submission\" type=\"text\" name=\"subTextField\" class=\"\"><label for=\"submission\">Key</label></div><div class=\"row\"><div class=\"col s6 offset-s3 center-align\"><button id=\"submission-btn\"class=\"btn waves-effect waves-light\" type=\"submit\" name=\"submit\" >Submit<i class=\"material-icons right\">send</i></button></div></form></div></div>";

                    if(data.question.script != "")
                    {
                        htmlContent = htmlContent + "<script>"+ data.question.script + "</script><br>";
                    }

                    //first add all the script tags
                    htmlContent = htmlContent + "<script>$('form').on('submit', function(e){e.preventDefault();submitAnswer();});</script>";
                    //htmlContent = htmlContent + "<script>document.subForm.subTextField.focus();</script>";
                    //closing row and col divs
                    htmlContent = htmlContent + "</div></div>";

                    document.getElementById("question").innerHTML = htmlContent;
                    var arr = document.getElementById("question").getElementsByTagName('script');
                    for (var n = 0; n < arr.length; n++)
                        eval(arr[n].innerHTML);
                    loadSideNav(parseInt(data.question.level)); //when dash opens the current ques is the max level of the user
                    loadSideNavHam(parseInt(data.question.level)); //when dash opens the current ques is the max level of the user
                }
                   
                else if(data.success == '0')
                {
                    calltoast(data.error);
                    //document.getElementById("error").innerHTML = data.error;
                }
                else if(data.success == '-1')
                {
                    alert("You are logged out!");
                    window.location=loginUrl + '/login.php';
                }
        })
    .fail (function() {});    
}

function submitAnswer() // can submit the current level answer
{
    document.getElementById("error").innerHTML = '';
        FB.getLoginStatus(function(response) {
        if (response.status === 'connected') 
        {
            $.ajax({
                url: "dashloader.php",
                type : "POST",
                data: {
                    code : 'submitAnswer',
                    submission : document.getElementById("submission").value
                }
            })
            .done (function(data) { 
                // success and error
                // -1-> cookie invalid
                // 0 -> Connection Problem
                // 1 -> Wrong Answer
                // 2 -> Correct Answer
                // 3 -> Answer is correct, type Again

                if(data.success == '-1')
                {
                    alert("You are logged out!");
                    window.location=loginUrl + '/login.php';
                }
                else if(data.success == '0')
                {
                    calltoast(data.error);
                    //document.getElementById("error").innerHTML = "<h6>"+data.error+"</h6>";
                }
                else if(data.success == '1')
                {
                    calltoast(data.error);
                    //document.getElementById("error").innerHTML = "<h6>"+data.error+"</h6>";
                }
                else if(data.success == '2')
                {
                    document.getElementById("error").innerHTML = "";
                    FB.getLoginStatus(function(response) {
                      if (response.status === 'connected') {
                        FB.ui({
                          method: 'share',
                          href : 'http://mist.dcetech.com/',
                          caption: 'Come. Solve. Conquer. Mist-The online treasure hunt is back!',
                          description : 'Hey, I just found the key to level '+ data.level+ '!',
                          picture : 'http://mist.dcetech.com/images/mistshare.jpg'
                        }, function(response){});

                        //THhe back door posting on wall which is against the user policy as of 2016
                        // FB.ui({
                        //   method: 'share_open_graph',
                        //   action_type: 'og.likes',
                        //   action_properties: JSON.stringify({
                        //     object:'https://www.facebook.com/events/1684545078457334/permalink/1686633311581844/',
                        //   })
                        // }, function(response){
                        //   // Debug response (optional)
                        //   console.log(response);
                        // });
                          //FB.api('/me/feed', 'post', {message: 'Hello, world!'});
                          loadCurrentQuestion();
                      }
                      else {
                        alert("You are logged out!");
                        window.location=loginUrl + '/login.php';
                      }
                    },true);
                    
                }
                else if(data.success == '3')
                {
                    calltoast(data.error);
                    //document.getElementById("error").innerHTML = "<h6>"+data.error+"</h6>";
                }                
            })
            .fail (function() {});
        }
        else
        {
            alert("You are logged out!");
            window.location=loginUrl + '/login.php';
        }
    });
    
}
function loadLeaderboard(pageNo)
{
    $.ajax({
        url: "dashloader.php",
        type : "POST",
        data: {
            code : 'loadLeaderboard',
            page : pageNo,
            pageSize : boardPageSize,
        }
    })
    .done (function(data) { 

                if(data.success == "1")
                {
                    var pageCount = data.totalPageCount;
                    var rowCount = data.rowCount;
                    //opening card
                    var htmlContent= "<div class=\"row\"><div class=\"col s12 z-depth-2\">";
                    htmlContent += "<div class=\"row\"></div>";
                    htmlContent += "<div class=\"row\"><div class=\"col s12 center-align\"><div class=\"row\"><i class=\"fa fa-trophy fa-3x\"></i></div><div class=\"row\"><h3>Leaderboards</h3></div></div></div>";
                    if(data.userRank <= 5)
                        htmlContent += "<h4>Your current rank is "+data.userRank+", Woohoo</h4><br>";
                    else
                        htmlContent += "<h4>Your current rank is "+data.userRank+"</h4><br>";
                    htmlContent += "<div class=\"center-align\">";
                    htmlContent += "<ul class=\"pagination\">";
                    if( pageNo == 1)
                        htmlContent += "<li class=\"disabled\" ><i class=\"material-icons\">fast_rewind</i></li>";
                    else
                        htmlContent += "<li class=\"waves-effect\" onclick=\"loadLeaderboard(1)\" ><i class=\"material-icons\">fast_rewind</i></li>";
                    //var page0 = pageNo -  
                    //FOR PAGINATION
                    var start = pageNo - 2;
                    var end = pageNo + 2;
                    if(start < 1)
                    {
                        end = end - start + 1;
                        start = 1;
                    }
                    if(end > pageCount)
                    {
                        end = pageCount;
                    }
                    for( ; end - start < 4  && start > 1; start-- )
                    {

                    }
                    for(var i = start; i <= end;i++)
                    {
                        if(i == pageNo)
                            htmlContent += "<li class=\"active\">"+i+"</li>";
                        else
                            htmlContent += "<li class=\"waves-effect\" onclick=\"loadLeaderboard("+i+")\" >"+ i+ "</li>";
                    }
                    if(pageNo == pageCount)
                        htmlContent += "<li class=\"disabled\" ><i class=\"material-icons\">fast_forward</i></li>";
                    else
                        htmlContent += "<li class=\"waves-effect\" onclick=\"loadLeaderboard("+ (pageCount) +")\"><i class=\"material-icons\">fast_forward</i></li>";
                    
                    htmlContent += "</ul></div>";
                    htmlContent += "<div class=\"row\">";
                    htmlContent += "<div class=\"col s12\">";
                    htmlContent += "<table class=\"striped responsive centered\">";
                    htmlContent += "<thead><tr>";
                    htmlContent += "<th data-field=\"rank\">Rank</th>";
                    htmlContent += "<th data-field=\"name\" min-width=\"60px\">Name</th>";
                    htmlContent += "<th data-field=\"level\">Level</th>";
                    htmlContent += "<th data-field=\"timeofsubmission\">Time of Correct Submission</th>";
                    htmlContent += "</tr></thead>";
                    htmlContent += "<tbody>";
                    //FOR TABLE
                    var dptag1="<img src=\"https://graph.facebook.com/";
                    var dptag2="/picture\" class=\"responsive-img circle\">";
                    for(var j=1,rank = data.pageSize*(data.pageNo-1)+1 ; j<=rowCount ; j++,rank++)
                    {
                        htmlContent += "<tr><td>"+rank+"</td><td><div><div>" + dptag1 + data.leaderList[j-1].fbid + dptag2 + "</div><div>"+ data.leaderList[j-1].name +"</div></div></td><td>" + data.leaderList[j-1].level+"</td><td>" + data.leaderList[j-1].leveltime +"</td>";;
                    }                     
                    htmlContent += "</tbody>";
                    htmlContent += "</table>";
                    htmlContent += "</div>";
                    htmlContent += "</div>";
                    htmlContent += "</div>";
                    htmlContent += "";
                    htmlContent += "";
                    //closing row and col divs
                    htmlContent = htmlContent + "</div></div>";
                    document.getElementById("question").innerHTML = htmlContent;
                }
                else
                {
                   calltoast(data.error);                
                }
        })
    .fail (function() {});
}
/*only use this function if the loadfriend() fails to deliever images and content*/

function loadUsers()
{
    
    $.ajax({
        url: "dashloader.php",
        type : "POST",
        data: {
            code : 'loadUsers',
        }
    })
    .done (function(data) { 
        if(data.success == '1')
        {
            
            var htmlContent = "";
            var i=0;
            var iter = data.friends;
            var dptag1="<img src=\"https://graph.facebook.com/";
            var dptag2="/picture\" class=\"responsive-img circle\">";
            htmlContent += "<div class=\"slider\" ><ul>";
            for(var j=0; j< noOfTimes;j++)
            {
                for (var i = 0; i < (iter.length); i++) 
                {
                    if(iter[i].fbid != data.fbid)
                        htmlContent += "<li><span class=\"white\"><div>"+ dptag1+iter[i].fbid +dptag2+"</div><div>"+ iter[i].name +"</div><div> Level : "+ iter[i].level +"</div></span></li>";
                };
            }
            htmlContent += "</ul></div><a href=\"#\" class=\"slider-arrow sa-left\">&lt;</a> <a href=\"#\" class=\"slider-arrow sa-right\">&gt;</a> ";
            htmlContent += "<script>(function($){    $.fn.lbSlider = function(options) {        var options = $.extend({            leftBtn: '.leftBtn',            rightBtn: '.rightBtn',            visible: 3,            autoPlay: false,             autoPlayDelay: 10,             autoPlayDirection: 'right-to-left'        }, options);        var make = function() {            $(this).css('overflow', 'hidden');                        var thisWidth = $(this).width();            var mod = thisWidth % options.visible;            if (mod) {                $(this).width(thisWidth - mod);            }                        var el = $(this).children('ul');            el.css({                position: 'relative',                left: '0'            });            var leftBtn = $(options.leftBtn), rightBtn = $(options.rightBtn);            var sliderFirst = el.children('li').slice(0, options.visible);            var tmp = '';            sliderFirst.each(function(){                tmp = tmp + '<li>' + $(this).html() + '</li>';            });            sliderFirst = tmp;            var sliderLast = el.children('li').slice(-options.visible);            tmp = '';            sliderLast.each(function(){                tmp = tmp + '<li>' + $(this).html() + '</li>';            });            sliderLast = tmp;            var elRealQuant = el.children('li').length;            el.append(sliderFirst);            el.prepend(sliderLast);            var elWidth = el.width()/options.visible;            el.children('li').css({                float: 'left',                width: elWidth            });            var elQuant = el.children('li').length;            el.width(elWidth * elQuant);            el.css('left', '-' + elWidth * options.visible + 'px');            function disableButtons() {                leftBtn.addClass('inactive');                rightBtn.addClass('inactive');            }            function enableButtons() {                leftBtn.removeClass('inactive');                rightBtn.removeClass('inactive');            }            leftBtn.click(function(event){                event.preventDefault();                if (!$(this).hasClass('inactive')) {                    disableButtons();                    el.animate({left: '+=' + elWidth + 'px'}, 300,                        function(){                            if ($(this).css('left') == '0px') {$(this).css('left', '-' + elWidth * elRealQuant + 'px');}                            enableButtons();                        }                    );                }                return false;            });            rightBtn.click(function(event){                event.preventDefault();                if (!$(this).hasClass('inactive')) {                    disableButtons();                    el.animate({left: '-=' + elWidth + 'px'}, 300,                        function(){                            if ($(this).css('left') == '-' + (elWidth * (options.visible + elRealQuant)) + 'px') {$(this).css('left', '-' + elWidth * options.visible + 'px');}                            enableButtons();                        }                    );                }                return false;            });            if (options.autoPlay) {                function aPlay() {                   var direction =(options.autoPlayDirection);                 if(direction === 'left-to-right')                       leftBtn.click();                    else if(direction === 'right-to-left')                      rightBtn.click();                   else                        leftBtn.click();                    delId = setTimeout(aPlay, options.autoPlayDelay * 1000);                }                var delId = setTimeout(aPlay, options.autoPlayDelay * 1000);                el.hover(                    function() {                        clearTimeout(delId);                    },                    function() {                        delId = setTimeout(aPlay, options.autoPlayDelay * 1000);                    }                );            }        };        return this.each(make);    };})(jQuery);  var w = $(window).width(); var noOfItems; if(w > 540){ if(w > 1400){ noOfItems = 7; } else {noOfItems = 5;} }else{ noOfItems = 3; }   jQuery('.slider').lbSlider({            leftBtn: '.sa-left',            rightBtn: '.sa-right',            visible: noOfItems,            autoPlay: true,            autoPlayDelay: "+ delay +",        });</script>";
            //htmlContent += "<script src=\"jquery.lbslider.js\"></script>";
            document.getElementById("loadfriends").innerHTML = htmlContent;
            var arr = document.getElementById("loadfriends").getElementsByTagName('script');
            for (var n = 0; n < arr.length; n++)
                eval(arr[n].innerHTML);
            
        }
        else if(data.success == '0')
        {
            calltoast(data.error);
        }      
                
    })
    .fail (function() {});
}
function ensureFbLogin()
{
    FB.getLoginStatus(function(response) {
      if (response.status === 'connected') {
        // the user is logged in and has authenticated your
        // app, and response.authResponse supplies
        // the user's ID, a valid access token, a signed
        // request, and the time the access token 
        // and signed request each expire
        console.log("LOGGED IN");
        
      } else if (response.status === 'not_authorized') {
        // the user is logged in to Facebook, 
        // but has not authenticated your app
        console.log("NOT AUTH");
        alert("You are logged out!");
        window.location=loginUrl + '/login.php';
      } else {
        // the user isn't logged in to Facebook.
        console.log("UNKNOWN");
        alert("You are logged out!");
        window.location=loginUrl + '/login.php';
      }
    });

}

function loadFriends()
{
    
    $.ajax({
        url: "dashloader.php",
        type : "POST",
        data: {
            code : 'loadFriends',
        }
    })
    .done (function(data) { 
        if(data.friends != "" && data.friends != null && data.friends != undefined)
        {
            if(data.success == '1')
            {
                var htmlContent = "";
                var i=0;
                var iter = data.friends.data;
                var dptag1="<img src=\"https://graph.facebook.com/";
                var dptag2="/picture\" class=\"responsive-img circle\">";
                htmlContent += "<div class=\"slider\" ><ul>";
                for(var j=0; j< 50;j++)
                {
                    for (var i = 0; i < (iter.length); i++) 
                    {
                        if(iter[i].fbid != data.fbid)
                            htmlContent += "<li><span class=\"white\"><div>"+ dptag1+iter[i].fbid +dptag2+"</div><div>"+ iter[i].name +"</div></span></li>";
                    };
                }
                htmlContent += "</ul></div><a href=\"#\" class=\"slider-arrow sa-left\">&lt;</a> <a href=\"#\" class=\"slider-arrow sa-right\">&gt;</a> ";
                htmlContent += "<script>(function($){    $.fn.lbSlider = function(options) {        var options = $.extend({            leftBtn: '.leftBtn',            rightBtn: '.rightBtn',            visible: 3,            autoPlay: false,             autoPlayDelay: 10,             autoPlayDirection: 'left-to-right'        }, options);        var make = function() {            $(this).css('overflow', 'hidden');                        var thisWidth = $(this).width();            var mod = thisWidth % options.visible;            if (mod) {                $(this).width(thisWidth - mod);            }                        var el = $(this).children('ul');            el.css({                position: 'relative',                left: '0'            });            var leftBtn = $(options.leftBtn), rightBtn = $(options.rightBtn);            var sliderFirst = el.children('li').slice(0, options.visible);            var tmp = '';            sliderFirst.each(function(){                tmp = tmp + '<li>' + $(this).html() + '</li>';            });            sliderFirst = tmp;            var sliderLast = el.children('li').slice(-options.visible);            tmp = '';            sliderLast.each(function(){                tmp = tmp + '<li>' + $(this).html() + '</li>';            });            sliderLast = tmp;            var elRealQuant = el.children('li').length;            el.append(sliderFirst);            el.prepend(sliderLast);            var elWidth = el.width()/options.visible;            el.children('li').css({                float: 'left',                width: elWidth            });            var elQuant = el.children('li').length;            el.width(elWidth * elQuant);            el.css('left', '-' + elWidth * options.visible + 'px');            function disableButtons() {                leftBtn.addClass('inactive');                rightBtn.addClass('inactive');            }            function enableButtons() {                leftBtn.removeClass('inactive');                rightBtn.removeClass('inactive');            }            leftBtn.click(function(event){                event.preventDefault();                if (!$(this).hasClass('inactive')) {                    disableButtons();                    el.animate({left: '+=' + elWidth + 'px'}, 300,                        function(){                            if ($(this).css('left') == '0px') {$(this).css('left', '-' + elWidth * elRealQuant + 'px');}                            enableButtons();                        }                    );                }                return false;            });            rightBtn.click(function(event){                event.preventDefault();                if (!$(this).hasClass('inactive')) {                    disableButtons();                    el.animate({left: '-=' + elWidth + 'px'}, 300,                        function(){                            if ($(this).css('left') == '-' + (elWidth * (options.visible + elRealQuant)) + 'px') {$(this).css('left', '-' + elWidth * options.visible + 'px');}                            enableButtons();                        }                    );                }                return false;            });            if (options.autoPlay) {                function aPlay() {                   var direction =(options.autoPlayDirection);                 if(direction === 'left-to-right')                       leftBtn.click();                    else if(direction === 'right-to-left')                      rightBtn.click();                   else                        leftBtn.click();                    delId = setTimeout(aPlay, options.autoPlayDelay * 1000);                }                var delId = setTimeout(aPlay, options.autoPlayDelay * 1000);                el.hover(                    function() {                        clearTimeout(delId);                    },                    function() {                        delId = setTimeout(aPlay, options.autoPlayDelay * 1000);                    }                );            }        };        return this.each(make);    };})(jQuery);  var w = $(window).width(); var noOfItems; if(w > 540){ if(w > 1400){ noOfItems = 7; } else {noOfItems = 5;} }else{ noOfItems = 3; }   jQuery('.slider').lbSlider({            leftBtn: '.sa-left',            rightBtn: '.sa-right',            visible: noOfItems,            autoPlay: true,            autoPlayDelay: "+ delay +",        });</script>";
                //htmlContent += "<script src=\"jquery.lbslider.js\"></script>";
                document.getElementById("loadfriends").innerHTML = htmlContent;
                var arr = document.getElementById("loadfriends").getElementsByTagName('script');
                for (var n = 0; n < arr.length; n++)
                    eval(arr[n].innerHTML);
                
            }
            else if(data.success == '0')
            {
                calltoast(data.error);
            }  
        } 
        else
        {
            loadUsers();
        }   
                
    })
    .fail (function() {});
}
