<html>
<head>
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
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Budgeting - DoerHRM</title> 
  <?php
  include 'includes/header.php';
  ?>
</head>
<body>
  <?php include 'includes/topbar.php';?>
  <div class="d-flex" id="wrapper">
    <?php include 'includes/navbar.php';?>
    <div id="page-content-wrapper">
    <div class="container-fluid" id="content"> 
      <div class="row my-4">
        <div class="col">
          <h4 class="m-0"><i class="fas fa-dollar-sign"></i> Budget Allocation</h4>
        </div>
      </div>
      


<style>
button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 9px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 12px;
  margin: 4px 2px;
  cursor: pointer;
}



.button2 {background-color: #008CBA;} /* Blue */


table, td, th {
  border: 1px solid black;
}

table {
  width: 70%;
  border-collapse: collapse;
}

th,td {
	padding: 8px;
}
th{
	
  color: white;
}


</style>
</head>
<body>

<h2></h2>
<br><br>
<center>
<table style ="width: 50%">
  <tr style="background-color:gray">
    <th>Initial Budget</th>
    <th>Budget Allocated</th>
	<th>Budget To Be Allocated</th>
	
  </tr>
  <tr>
    <td> 1000  </td>
    <td> 000 </td>
	<td>  0</td>
	
  </tr>
  </table>
  
<center>

 <table>   
<br><br>
<table>
  <tr style="background-color:deepskyblue">
    <th>Category</th>
    <th>Percentage of Allocation</th>
	<th>Budget Allocated</th>
	<th>Action</th>
  </tr>
  <tr>
    <td>Bonus and Incentives</td>
    
	
	<td></td>
	<td></td>
  

	<td class="editDelBtn"><a href="">Edit</a>&nbsp;|&nbsp;<a href="">Delete</a></td>

  </tr>
  <tr>
    <td>Others</td>
    <td><td>
	
	<td class="editDelBtn"><a href="">Edit</a>&nbsp;|&nbsp;<a href="">Delete</a></td>
  </tr>
  
  <tr>
    <td><b>TOTAL </td>
    <td></td>
	<td></td>
	<td></td>
  </tr>
</table>
<br>
<button  class="button button2">Save</button>
<script type="text/javascript">
    $(document).ready(function(){
       $("#sidebar-wrapper .active").removeClass("active");
       $("#budgetallocation").addClass("active").addClass("disabled");
       document.getElementById("budgetallocation").style.backgroundColor = "DeepSkyBlue";
    });
  </script>
  <?php
  include 'includes/footer.php';
  ?>
</body>
</html>
