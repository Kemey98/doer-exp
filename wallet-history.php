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
<title> Wallet History </title>

	 <?php
  include 'includes/header.php';
  ?>
<style>
.form-control {
    border: 0;
}
	.no-border {
    border: 0;
	text-align: center;	
    box-shadow: none;
		background-color: white;	/* You may want to include this as bootstrap applies these styles too */
}
		
	
</style>	
	
</head>
<?php
?>
<?php include 'includes/topbar.php';?>
  <div class="d-flex" id="wrapper">
    <?php include 'includes/navbar.php';?>
    <div id="page-content-wrapper">
    <div class="container-fluid" id="content"> 
      <div class="row my-4">
        <div class="col">
			<h4 class="m-0"><i class="fas fa-archive"></i> &nbsp;Wallet History</h4>
        </div>
      </div>

        <ul class="nav nav-tabs row px-2" id="historytable">

	          <li class='nav-item col-12 col-xl-2 p-0'>
	            <a class='nav-link rounded-0 text-center active' data-toggle='tab' href='#companytable'><span class="font-weight-bold">COMPANY</span></a>
	          </li>
	          <li class='nav-item col-12 col-xl-2 p-0'>
	            <a class='nav-link rounded-0 text-center' data-toggle='tab' href='#depttable'><span class="font-weight-bold">DEPARTMENT</span></a>
	          </li>
	          <li class='nav-item col-12 col-xl-2 p-0'>
	            <a class='nav-link rounded-0 text-center' data-toggle='tab' href='#postable'><span class="font-weight-bold">POSITION</span></a>
	          </li>
        </ul>

<div class="tab-content">
	<div class="tab-pane fade show active" id="companytable">
<br>	
		<div class="table-responsive text-nowrap">
			<table style="width:65%;" class="table">
				<thead >
					<tr style="text-align: center">
					<th style="min-width:150px;">Name </th>
					<th style="min-width:50px;">Wallet</th>
					<th style="min-width:50px;">Percentage</th>
					<th style="min-width:50px;">Total Value(RM)</th>
					<th ></th>
					</tr>
				</thead-dark>
				<tbody>
					<tr style="text-align: center">
						<th style="text-align: center; width: 50px;"><input type="text" name="compname" class="no-border" readonly disabled value="Doerprenuer Soft"></th>	
						<th style="text-align: center;"><input type="text" name="kpi" class="no-border" readonly value="Wallet 1" disabled></th>	
						<th style="text-align: center;"><input type="text" name="bonuspayout" class="no-border" readonly value="70" disabled></th>
						<th style="text-align: center;"><input type="text" name="bonuspayout" class="no-border" readonly value="1400.00" disabled></th>		
						
						<th><center><input type="submit" name="delete" class="btn btn-primary" data-toggle="modal" data-target="#Modalwallet" value="Details"></center></th>		
					</tr>
									<tr style="text-align: center">
						<th style="text-align: center; width: 50px;"><input type="text" name="compname" class="no-border" readonly disabled value="Doerprenuer Soft"></th>	
						<th style="text-align: center;"><input type="text" name="kpi" class="no-border" readonly value="Wallet 2" disabled></th>	
						<th style="text-align: center;"><input type="text" name="bonuspayout" class="no-border" readonly value="30" disabled></th>
						<th style="text-align: center;"><input type="text" name="bonuspayout" class="no-border" readonly value="600.00" disabled></th>		
						
						<th><center><input type="submit" name="delete" class="btn btn-primary" data-toggle="modal" data-target="#Modalwallet" value="Details"></center></th>		
					</tr>
									<tr style="text-align: center">
						<th style="text-align: center; width: 50px;"><input type="text" name="compname" class="no-border" readonly disabled value="Obsnap Instruments"></th>	
						<th style="text-align: center;"><input type="text" name="kpi" class="no-border" readonly value="Wallet 1" disabled></th>	
						<th style="text-align: center;"><input type="text" name="bonuspayout" class="no-border" readonly value="100" disabled></th>
						<th style="text-align: center;"><input type="text" name="bonuspayout" class="no-border" readonly value="500.00" disabled></th>		
						
						<th><center><input type="submit" name="delete" class="btn btn-primary" data-toggle="modal" data-target="#Modalwallet" value="Details"></center></th>		
					</tr>
				</tbody>
			</table>
				<div class="modal fade" id="Modalwallet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Wallet 1 </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="table-responsive text-nowrap">
	<table style="width:75%;" class="table">
		<thead >
		<tr style="text-align: center;">
		
		<th class="th-sm" style="width:15%;">Transaction(RM)</th>
		<th class="th-sm" style="min-width: 150px; width: 15%;">Date</th>
		
	</tr>
		</thead-dark>
		<tbody>
		<tr style="text-align: center">
			<th width=""><input type="text" name="weightage" class="form-control" readonly value="-200.00"></th>	
			<th width="40%"><input type="text" name="datez" class="form-control" readonly value="06/09/2020"></th>			
		</tr>	
		<tr style="text-align: center">
			<th width=""><input type="text" name="weightage" class="form-control" readonly value="+500.00"></th>	
			<th width="40%"><input type="text" name="datez" class="form-control" readonly value="05/08/2020"></th>			
		</tr>		
			
		</tbody>
			  </table>
			</div>	</form> </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>
		</div>
	</div>
<br>

<div class="tab-pane fade show " id="depttable">
		<div class="table-responsive text-nowrap">
			<table style="width:65%;" class="table">
				<thead >
					<tr style="text-align: center">
					<th style="min-width:150px;">Name </th>
					<th style="min-width:117px;">Wallet</th>
					<th style="min-width:117px;">Percentage</th>
					<th ></th>
					</tr>
				</thead-dark>
				<tbody>
					<tr style="text-align: center">
						<th width="25%"><input type="text" name="staffnum" class="no-border" disabled value="IT Department"></th>	
						<th width="10%"><input type="text" name="kpi" class="no-border" disabled  value="Wallet 1"></th>	
						<th width="10%"><input type="text" name="bonuspayout" class="no-border" disabled  value="50"></th>	
						<th width="10%"><input type="submit" name="delete" class="btn btn-primary" value="Details"></th>		
					</tr >
								<tr style="text-align: center">
						<th width=""><input type="text" name="staffnum" class="no-border" disabled  value="IT Department"></th>	
						<th width=""><input type="text" name="kpi" class="no-border" disabled  value="Wallet 2"></th>	
						<th width=""><input type="text" name="bonuspayout" class="no-border" disabled  value="50"></th>	
						<th width=""><input type="submit" name="delete" class="btn btn-primary" value="Details"></th>		
					</tr>
								<tr style="text-align: center">
						<th width=""><input type="text" name="staffnum" class="no-border" disabled value="Human Resources"></th>	
						<th width=""><input type="text" name="kpi" class="no-border" disabled  value="Wallet 1"></th>	
						<th width=""><input type="text" name="bonuspayout" class="no-border" disabled  value="100"></th>	
						<th width=""><input type="submit" name="delete" class="btn btn-primary" value="Details"></th>	
					</tr>
				</tbody>
			</table>
		</div>
	</div>	
	
<div class="tab-pane fade show " id="postable">
		<div class="table-responsive text-nowrap">
			<table style="width:65%;" class="table">
				<thead >
					<tr style="text-align: center">
					<th style="min-width:150px;">Name </th>
					<th style="min-width:117px;">Wallet</th>
					<th style="min-width:117px;">Percentage</th>
					<th ></th>
					</tr>
				</thead-dark>
				<tbody>
					<tr style="text-align: center">
						<th width="25%"><input type="text" name="staffnum" class="no-border" disabled value="Supervisor"></th>	
						<th width="10%"><input type="text" name="kpi" class="no-border" disabled  value="Wallet 1"></th>	
						<th width="10%"><input type="text" name="bonuspayout" class="no-border" disabled  value="100"></th>	
						<th width="10%"><input type="submit" name="delete" class="btn btn-primary" value="Details"></th>		
					</tr >
								<tr style="text-align: center">
						<th width=""><input type="text" name="staffnum" class="no-border" disabled  value="Personel"></th>	
						<th width=""><input type="text" name="kpi" class="no-border" disabled  value="Wallet 1"></th>	
						<th width=""><input type="text" name="bonuspayout" class="no-border" disabled  value="100"></th>	
						<th width=""><input type="submit" name="delete" class="btn btn-primary" value="Details"></th>		
					</tr>
								<tr style="text-align: center">
						<th width=""><input type="text" name="staffnum" class="no-border" disabled  value="Intern"></th>	
						<th width=""><input type="text" name="kpi" class="no-border" disabled value="Wallet 1"></th>	
						<th width=""><input type="text" name="bonuspayout" class="no-border" disabled  value="100"></th>	
						<th width=""><input type="submit" name="delete" class="btn btn-primary" value="Details"></th>	
					</tr>
				</tbody>
			</table>
		</div>
	</div>
<br>

	<script type="text/javascript">
    $(document).ready(function(){
       $("#sidebar-wrapper .active").removeClass("active");
       $("#wallet-history").addClass("active").addClass("disabled");
       document.getElementById("wallet-history").style.backgroundColor = "DeepSkyBlue";
    });
  </script>
  <?php
  include 'includes/footer.php';
  ?>
</body>
</html>