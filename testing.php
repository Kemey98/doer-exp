<?php
require_once 'core/init.php';
$userlevel = "";
$user = new User();
if(!$user->isLoggedIn()){
  Redirect::to("login.php");
}else{
  $resultresult = $user->data();
  $userlevel = $resultresult->role;
  if($resultresult->verified == false || $resultresult->superadmin == true){
    $user->logout();
    Redirect::to("login.php?error=error");
  }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
	  
	
	<?php
  include 'includes/header.php';
  ?>
	
	<style>
	body {
     background-color: #FAFAFA
 }

 .buttonbox {
     position: absolute;
     left: 50%;
     top: 50%;
     transform: translate(-50%, -50%);
		
 }

 .spinner-button {
     border: 2px solid #000;
     display: inline-block;
     padding: 8px 20px 9px;
     font-size: 12px;
     color: #000;
     background-color: transparent
 }

 .btn-primary:disabled {
     color: #fff;
     background-color: #000;
     border-color: #000
 }
		
.spinner-button:hover {
     background-color: #000;
     border: 2px solid #000;
     color: #fff
 }

 .spinner-button i {
     color: #fff
 }

 .spinner-button:hover i {
     color: #fff
 }

 .fa {
     color: #fff
 }

 .fa:hover {
     color: #fff
 }		
	</style>
</head>

<body>
	<?php include 'includes/topbar.php';?>
  <div class="d-flex" id="wrapper">
    <?php include 'includes/navbar.php';?>
    <div id="page-content-wrapper">
    <div class="container-fluid" id="content"> 
      <div class="row my-4">
        <div class="col">
          <h4 class="m-0"><i class="fa fa-calendar"></i> Calendar</h4>
        </div>
      </div>
      
      
	<ul class="nav nav-tabs row px-2">
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center active" data-toggle="tab" href="#calendarshow"><span class="font-weight-bold">CALENDAR</span></a>
        </li>
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center" data-toggle="tab" href="#tags"><span class="font-weight-bold">MANAGE TAGS</span></a>
        </li>
      </ul>
	
		<form name="123" method="post" action="testing 2.php">
		<div class="buttonbox">
			
			<button name="submit" id="btnFetch" class="spinner-button btn btn-primary mb-2" >Click Me</button>
			
			
		</div>
		</form>
		
		
		
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script type="text/javascript">
		
			$(document).ready(function() {
$("#btnFetch").click(function() {
// disable button

// add spinner to button
$(this).html(
'<i class="fa fa-circle-o-notch fa-spin"></i> loading...'
	
	
);
});
});
setTimeout(function(){
        /*submit the form after 5 secs*/
        $('#123').submit();
    },5000)		
		</script>
</body>
</html>