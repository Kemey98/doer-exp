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
<title>Bonus Calculation</title>

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
          <h4 class="m-0"><i class="fas fa-calculator"></i> Bonus Calculation</h4>
        </div>
      </div>
      
			
    

<form method="post" action="" class="needs-validation" novalidate>
	
		
	
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
		
				<label>Fund Available (RM)</label><br>
				  <input type="text" id="fundbudj" name="fundbudj" class="form-control fundz" style="width: 180px" placeholder="Company Fund" disabled  />
		 </div>
		</div>
	<br> 
	
	 <br>	<br>
	
	 <div class="row">
		 
           <div class="col-sm-3">
		 <label>Department</label><br>
		 <select class="form-control az" id="departmentz" style="width:180px;">
         <option selected disabled value="">Choose...</option>
  	
		</select>
		 </div>
		
		<div class="col-sm-3">
			<label>Department Fund (RM)</label><br>
	     <input type="text" id="dfund" name="dfund" class="form-control dfundz" style="width: 180px" placeholder="Department fund" disabled  />
	
		 </div>

		 
		 <br>
	<div class="col-sm-3">
		 <label>Payment</label><br>
	<input type="text" id="payment" name="payment" class="form-control input-group-lg reg_name" style="width: 180px" placeholder="Enter payment" />
	
		 </div>
	</div>      
	<br>
			 <script> 
		 		
			 $(document).ready(function(){
				
//				function getcategoryview(){ 
//                      $.ajax({
//                        url:"ajax-getviewwallet.php",
//                        success:function(data){
//                          $("#showcategoryview").html(data); 
//                        }
//                      });
//                    }
//  			      getcategoryview();
            	
				//select pertama	
                $('#companynew').change(function () {
		        $('.yearz').empty();
				$('.dfundz').trigger("reset");	
                
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
                //select kedua
//          function monthrevenue(date) {
// $('.fundz').empty();
//           var day = new Date(date.getFullYear(), 1);
//           $('#yeardate').datepicker('update', day);
//           $('#yeardate').val(day.getFullYear());
//          var companyID = document.getElementById("companynew").value; 
//           var alldata = 
//           {
//             
//             companyID:companyID,
//             year:day.getFullYear(),
//           };
//           console.log(alldata);
//           $.ajax({
//           url:"ajax-getfund.php",
//           data: alldata,
//           dataType: "json",
//           method: "POST",
//           success:function(data){
//             $('#fundbudj').val(data);  // This is A
//           }
//           });
//           }
//
//           weekpicker = $('#yeardate');
//           weekpicker.datepicker({
//             autoclose: true,
//             forceParse: false,
//             orientation: 'bottom',
//             minViewMode: "years"
//             }).on("changeDate", function(e) {
//               monthrevenue(e.date);
//         });
//               monthrevenue(new Date);
     
				 
                $('#yeardate').change(function () {
				 $('.fundz').empty();	
					
                 var value = $(this).val();
                 var companyID = document.getElementById("companynew").value; 
                 var alldata = 
               {
                 year:value,
                 companyID:companyID
               };
     			
				$.ajax({
        		url:"ajax-getfund.php",
        		method:"POST",
        		data:alldata,
				dataType:"json",
        		success:function(data){
          		
                $('#fundbudj').val(data);            

        }
      });
    });
//				 
				 //SelectKetiga
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
		         $('.dfundz').empty();
                
				var depart = $(this).val();
			    var companyID = document.getElementById("companynew").value; 
				var year = document.getElementById("yeardate").value;
						
                 var alldata = 
               {
                 department:depart,
                 companyID:companyID,
				 year:year  
               };	
						
                $.ajax({
                url:"ajax-getdepartmentfund.php",
                method:"POST",
                data:alldata,
                dataType:"json",
						
                success:function(data){
				console.log(data);
				$('#dfund').val(data);	
					
//				$('#dfund').append('<option disabled selected value="">Choose..</option>');	
//				for(i=0; i< data.length;i++){
//               $('#departmentz').append('<option value="'+data[i].groupID+'">'+data[i].groups+'</option>');
//                    }
				}
      });
});
				 
				  $('#payment').change(function () {
				 	
					
                 var value = $(this).val();
                 var companyID = document.getElementById("companynew").value; 
                 var year      = document.getElementById("yeardate").value; 
				 var fund_avai = document.getElementById("fundbudj").value; 
				 var dept_id   = document.getElementById("departmentz").value;
				 var dept_fund = document.getElementById("dfund").value; 	  
			    
			     var alldata = 
               {
                payment:value,
                companyID:companyID,
				year:year,
				fund_available:fund_avai,
				dept_id : dept_id,
				dept_fund : dept_fund,
				   
               };

				
			    $.ajax({
        		url:"ajax-getviewcalculation.php",
        		method:"POST",
        		data:alldata,
				
        		success:function(data){
          		$("#showCalculationTable").html(data); 

        }
      });
    });
					
		

  });		 
		 
		 </script>
	
	<br>
  
	<div id="showCalculationTable"></div>
	<br>
	
	<br>
	<br>
	<?php //$CalculationObject = new calculation();
          //$dept_id = $CalculationObject->searchGroup("departmentz");
	//print_r($dept_id);
 	
	?>
<!--

	<div class="table-responsive text-nowrap">
	<table style="width:80%;" class="table">
		<thead-dark>
		<tr style="text-align: center">
		<th style="min-width:150px;">Staff </th>
		<th style="min-width:117px;">KPI</th>
		<th style="min-width:117px;">Bonus Payout</th>
		<th style="min-width: 117px;">Bonus Increment</th>
		<th style="min-width: 117px;">Total Payout</th>
	</tr>
		</thead-dark>
		<tbody>
		<tr>
			<th width="25%"><center><input type="text" style="text-align: center;" name="staffnum" class="no-border" disabled value="001001 Abu" ></th>	
			<th width="10%"><input type="text" name="kpi" class="form-control" value="80.00"></th>	
			<th width="15%"><input type="text" name="bonuspayout" class="form-control" value="64.00" ></th>	
			<th width="15%"><input type="text" name="bonusincrement" class="form-control" value="-"></th>	
			<th width="15%"><input type="text" name="totalpayout" class="form-control" value="64.00"></th>	
		</tr>
					<tr>
			<th width=""><center><input type="text" style="text-align: center;" name="staffnum" class="no-border" disabled value="001002 Ali" ></th>	
			<th width=""><input type="text" name="kpi" class="form-control" value="80.00"></th>	
			<th width=""><input type="text" name="bonuspayout" class="form-control" value="49.00" ></th>	
			<th width=""><input type="text" name="bonusincrement" class="form-control" value="-"></th>	
			<th width=""><input type="text" name="totalpayout" class="form-control" value="48.00"></th>	
		</tr>
					<tr>
			<th width=""><center><input type="text" style="text-align: center;" name="staffnum" class="no-border" disabled value="001003 Ahmad" ></th>	
			<th width=""><input type="text" name="kpi" class="form-control" value="120.00"></th>	
			<th width=""><input type="text" name="bonuspayout" class="form-control" value="60.00" ></th>	
			<th width=""><input type="text" name="bonusincrement" class="form-control" value="12.00"></th>	
			<th width=""><input type="text" name="totalpayout" class="form-control" value="72.00"></th>	
		</tr>
		</tbody>
		</table></div>
-->

	<br>
	
		</form>
	

		<br>
		<br>
	<script type="text/javascript">
    $(document).ready(function(){
       $("#sidebar-wrapper .active").removeClass("active");
       $("#calculation").addClass("active").addClass("disabled");
       document.getElementById("calculation").style.backgroundColor = "DeepSkyBlue";
    });
  </script>
		  
  <?php
  include 'includes/footer.php';
  include 'ajax-getviewcalculation.php';		
  ?></div></div></div>
</body>
</html>