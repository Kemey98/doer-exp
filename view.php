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
$companyobject = new Company();
$listcompany = $companyobject->searchCompanyCorporate( $resultresult->corporateID); 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title> View Bonus </title>

	 <?php
  include 'includes/header.php';
  ?>
<style>
	.no-border {
    border: 0;
	text-align: ;	
    box-shadow: none;
		background-color: white;	/* You may want to include this as bootstrap applies these styles too */
}
	
	</style>	
	
</head>
<?php
?>
<body>
  <?php include 'includes/topbar.php';?>
  <div class="d-flex" id="wrapper">
    <?php include 'includes/navbar.php';?>
    <div id="page-content-wrapper">
    <div class="container-fluid" id="content"> 
      <div class="row my-4">
        <div class="col">
			<h4 class="m-0"><i class="fas fa-archive"></i> &nbsp;View Bonus</h4>
        </div>
      </div>

		
<form method="post" action="">
<div class="row">
		<div class="col-sm-3">
			<label>Company</label><br>
			<select class="form-control" id="companynew" style="width:180px;">
   			 <option selected disabled value="">Choose...</option>
                <?php foreach($listcompany as $rowz ) { ?>
		
				<option value="<?php echo $rowz->companyID ?>"><?php echo $rowz->company ?> </option>
				<?php
        									 	} ?>
    
    </select>
		
		</div>	
	

	<div class="col-sm-3">
			<label class="form-label">Year</label>
	<select class="form-control yearz" name="yeardate" id="yeardate" style="width:180px; " >
	<option selected disabled value="">Choose...</option>	
   
			</select>
			</div>

	 
    <div class="col-sm-3">
		 <label>Department</label><br>
		 <select class="form-control az" id="departmentz" style="width:180px;">
         <option selected disabled value="">Choose...</option>
  	
		</select>
		 </div>
		</div>
	 	
		
	<br>
		<br>
	<script>
		$(document).ready(function(){
		$('#companynew').change(function () {
		        $('.yearz').empty();
					
                
				var companyID = $(this).val();
                $.ajax({
                url:"getyear.php",
                method:"POST",
                data:{companyID:companyID},
           
				dataType:"json",
					
                success:function(data){
			  		
				$('#yeardate').append('<option disabled selected value="">Choose..</option>');	
				for(i=0; i< data.length;i++){
               $('#yeardate').append('<option value="'+data[i].year+'">'+data[i].year+'</option>');
                    }
				}
      });

                });
		
//		 $('#yeardate').change(function () {
//					
//					
//                 var value = $(this).val();
//                 var companyID = document.getElementById("companynew").value; 
//                 var alldata = 
//               {
//                 year:value,
//                 companyID:companyID
//               };
//     			
//				$.ajax({
//        		url:"ajax-getfund.php",
//        		method:"POST",
//        		data:alldata,
//				dataType:"json",
//        		success:function(data){
//          		
//                $('#fundbudj').val(data);            
//
//        }
//      });
//    });
		
				$('#companynew').change(function () {
		        $('.az').empty();
                
				var companyID = $(this).val();
                $.ajax({
                url:"ajax-getgrouplist.php",
                method:"POST",
                data:{companyID:companyID},
                dataType:"json",
					
                success:function(data){
					
				$('#departmentz').append('<option disabled selected value="">Choose..</option>');	
				for(i=0; i< data.length;i++){
               $('#departmentz').append('<option value="'+data[i].groupID+'">'+data[i].groups+'</option>');
                    }
				}
      });
});
		
		 $('#departmentz').change(function () {
				 	
					
                 var value = $(this).val();
                 var companyID = document.getElementById("companynew").value; 
                 var year      = document.getElementById("yeardate").value; 
			     var alldata = 
               {
                dept_id:value,
                companyID:companyID,
				year:year,
				   
               };
			    $.ajax({
        		url:"ajax-getviewbonus.php",
        		method:"POST",
        		data:alldata,
				dataType:"json",
        		success:function(data){
          		$("#showCalculationTable").html(data); 

        }
      });
    });
					
		

  });		 
		
	</script>	
		
		
		<div id="showCalculationTable"></div>
<!--
	<div class="table-responsive-sm text-nowrap">
	<table style="width:75%;" class="table table-bordered">
		<thead-dark>
		<tr style="text-align: center;">
		
			<th class="th-sm" style="min-width: 120px; width: 25%;text-align: center;">Staff</th>
		<th class="th-sm" style="width: 15%; min-width:inherit; ">Basic Salary</th>
		<th class="th-sm" style="width:15%;">KPI</th>
		<th class="th-sm" style="width: 15%">Bonus Payout</th>
		<th class="th-sm" style="width: 15%">Bonus Increment</th>
		<th class="th-sm" style="width: 15%">Total Payout</th>	
	</tr>
		</thead>
		<tbody>
		<tr style="text-align: center;">
			
		</tr>
				
		
				
		</tbody>
		</table></div>	
-->
		</form>
	<script type="text/javascript">
    $(document).ready(function(){
       $("#sidebar-wrapper .active").removeClass("active");
       $("#view").addClass("active").addClass("disabled");
       document.getElementById("view").style.backgroundColor = "DeepSkyBlue";
    });
  </script>
  <?php
  include 'includes/footer.php';
  ?>
		</div></div></div>
</body>
</html>