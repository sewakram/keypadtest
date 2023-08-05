<!DOCTYPE html>

<html>
<head>
<title>test </title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
 
</head>
<body>
<div class="container">

  <div class="row">
  <table border="0" id = "stage" data-id="<?= $_GET['user'];?>">
      <tr>
        <td><button class="btn btn-light disabled">1</button></td>
        <td><button class="btn btn-light disabled">2</button></td>
        <td><button class="btn btn-light disabled">3</button></td>
        <td><button class="btn btn-light disabled">4</button></td>
        <td><button class="btn btn-light disabled">5</button></td>
      </tr> 
      <tr>
        <td><button class="btn btn-light disabled">6</button></td>
        <td><button class="btn btn-light disabled">7</button></td>
        <td><button class="btn btn-light disabled">8</button></td>
        <td><button class="btn btn-light disabled">9</button></td>
        <td><button class="btn btn-light disabled">10</button></td>
      </tr>   
  </table>
</div>
  <div class="row">
    <input style="margin-left: 5%;" class="btn btn-secondary" type = "button" id = "getcontrol" value = "Get Control" />
  </div>
</div>

</body>
<script>
$(document).ready(function () {
  
  $('#getcontrol').on('click', function () {
    $.ajax({
   dataType : "json",
   // contentType : 'application/json',
   type : "POST",
   url : "trackUserActivity.php",
   data : {'getcontrol':true,userid:$('#stage').data("id")},
   success : function(responseData) {
    console.log(responseData);
    $('.btn').removeClass('disabled');
   }
  });
  
  });
  $('.btn').on('click', function () {
  console.log($(this).text());
  if($(this).hasClass('disabled')){
    alert('disabled');

  }else if($('#stage').data("id")=='1'){
    $(this).toggleClass('btn-danger');
    $(this).removeClass('btn-light');
  }else{
    $(this).toggleClass('btn-warning');
    $(this).removeClass('btn-light');
  }
  });
  
  });
</script>
<script>

function saveUserActivity(userActivityDataStr) {
  console.log();
   $.ajax({
   dataType : "json",
    type : "POST",
   url : "trackUserActivity.php",
   data : {'time':JSON.parse(userActivityDataStr).total,'timer':JSON.parse(userActivityDataStr).timer,userid:$('#stage').data("id")},
   success : function(responseData) {
    console.log(responseData);
    setTimeout( saveUserActivity(localStorage.getItem("userActivityData")), 120000);
   }
   
  });
}

  var userActivityDataStr;
  var INITIAL_WAIT = 1200;
  var INTERVAL_WAIT = 1200;
  var ONE_SECOND = 1000;
  var events = ["mouseup", "keydown","scroll", "mousemove"];
  var startTime = Date.now();
  var endTime = startTime + INITIAL_WAIT;
  var totalTime = 0;
  var clickCount = 0;
  var userClicks = {
    total: 0,
  };
  var buttonClickCount = 0;
  var linkClickCount = 0;
  var keypressCount = 0;
  var scrollCount = 0;
  var mouseMovementCount = 0;

  setInterval(function () {
    if (!document.hidden && startTime <= endTime) {
      startTime = Date.now();
      totalTime += ONE_SECOND;
      userClicks["timer"] = formatTime(totalTime);
    }
  }, ONE_SECOND);

  document.addEventListener("DOMContentLoaded", function () {
    events.forEach(function (e) {
      document.addEventListener(e, function () {
        endTime = Date.now() + INTERVAL_WAIT;
        if (e === "mouseup") {
          clickCount++;
           if (event.target.nodeName === 'BUTTON') {          
            if(!userClicks[event.target.innerText]){
              userClicks[event.target.innerText] = 0;
            }
            userClicks[event.target.innerText] += 1;
            userClicks.total += 1;
            document.getElementsByTagName("button").innerHTML = JSON.stringify(userClicks, null, 2);          
          }
          
        }
        else if (e === "keydown") {
          keypressCount++;
    userClicks["keydown"] = keypressCount;
        }
        userActivityDataStr = JSON.stringify(userClicks, null, 2); 
        localStorage.setItem("userActivityData", userActivityDataStr);
      });
    });
  });

  function formatTime(ms) {
    return Math.floor(ms / 1000);
  }
   var isRefreshPage = sessionStorage.getItem('pageHasBeenLoaded');
  userActivityDataStr = localStorage.getItem("userActivityData");
    if (isRefreshPage) {
        saveUserActivity(userActivityDataStr);  
    }
    sessionStorage.setItem('pageHasBeenLoaded', 'true');

 </script>
</html>