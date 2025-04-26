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
<title>Wallet Setup</title>

	 <?php
  include 'includes/header.php';
  ?>
<style>
	
	span.ex1{
  min-width: 20%;
  display: inline-block;
}

	.no-border {
    border: 0;
	text-align: center;	
    box-shadow: none;
		background-color: white;
}
	.editDelBtn { 
      text-align: center;
      width: 1%;
    }

    .dots {
      background-color: transparent;
      border: none;
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
          <h4 class="m-0"><i class="fas fa-wallet"></i> Wallet Setup</h4>
        </div>
      </div>
		
		
			<label> <strong>Company</strong></label><br>
			<div class="row"><div class="col-xl-3 col-5">
			<br>	
			<select name="companyy" class="form-control" id="companyy" style="width:180px;">
   			 <option disabled selected> Choose..</option>
	
				<?php foreach($listcompany as $row ) { ?>
		
				<option value="<?php echo $row->companyID ?>"><?php echo $row->company ?> </option>
				<?php
        

													 	}
					?>
				</select></div>
			<div class="col"></div>	
			
		</div>
		<br>
		<br>
		
	 <ul class="nav nav-tabs row px-2">
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center active" data-toggle="tab" href="#companyshow"><span class="font-weight-bold">Company</span></a>
        </li>
        <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center" data-toggle="tab" href="#departmenttab"><span class="font-weight-bold">Department</span></a>
        </li>
		  <li class="nav-item col-12 col-xl-2 p-0">
          <a class="nav-link rounded-0 text-center" data-toggle="tab" href="#position"><span class="font-weight-bold">Position</span></a>
        </li>
      </ul>
		
		<div class="tab-content">
        
			<div class="tab-pane active" id="companyshow">
		<script>
			
			 $(document).ready(function(){
				 $('#companyy').change(function () {
				 	
					
                 var value1 = $(this).val(); 
//                 var dept_id = document.getElementById("department").value =null;
     			 var alldata = 
               {
                 companyID:value1,
//                 department:dept_id
               };	
					 console.log(alldata);
				
			    $.ajax({
        		url:"ajax-getviewwalletcompany.php",
				method:"POST",
        		data:alldata,
        		success:function(data){
          		console.log(data);
				$("#showcategoryview1").html(data); 

        }
      });
    });
				 		 
				 
				 $(document).on('click', "#addwalletcompanybutton", function(){
      
	 			 var companyID = document.getElementById("companyy").value; 
	 			
     			{ $("#addcompanyid").val(companyID);
//				$('.dept_0').empty();
//				var companyIDs = document.getElementById("addcompanyid").value;
//                console.log(companyIDs); 
//				$.ajax({
//                url:"ajax-getgrouplist.php",
//                method:"POST",
//                data:{companyID:companyIDs},
//                dataType:"json",	
//                success:function(data){
//				console.log(data);	
//				$('#descriptioncompany').append('<option disabled selected value="">Choose..</option>');	
//				for(i=0; i< data.length;i++){
//                $('#descriptioncompany').append('<option value="'+data[i].groups+'">'+data[i].groups+'</option>');
//			   
//                    }
//				  $('#descriptioncompany').append('<option value="Other">Other</option>');}
//				 
//			   });
				}
					 
      
    			});
		  });		
				</script>
				<br>
				
				<div class="float-right" style="padding-right: 15px;">
					
					
				</div>
				
				<br>
				 <div id="showcategoryview1"> </div>
				
			</div> 
			
			
			<div class="tab-pane" id="departmenttab"> 
			<br>
				
				<label style="margin-left: 20px;"><strong>Department</strong></label>
				
			
		
			
	<?php 
			
//		  $groupObject = new Group();
//		  $listgroup = $groupObject->searchCompany($resultresult->companyID);
		  	?>
			 <?php
//		print_r($listgroup);
			?>		
		<div class="row">	
	<select name="department" class="form-control departmentz" id="department" style="width:180px; margin-left: 30px;">
    <option disabled selected> Choose..</option>
		
	</select>
		 
					
				</div>
     
		<br>
			
	
		
		<br>
		<br>
		
		
       <script type="text/javascript"> 
		   
		   
                $(document).ready(function(){
				
				function getcategoryview(){ 
                      $.ajax({
                        url:"ajax-getviewwallet.php",
                        success:function(data){
                          $("#showcategoryview").html(data); 
                        }
                      });
                    }
  			      getcategoryview();
            	
				//select pertama	
                $('#companyy').change(function () {
		        $('.departmentz').empty();
                
				var companyID = $(this).val();
                $.ajax({
                url:"ajax-getgrouplist.php",
                method:"POST",
                data:{companyID:companyID},
                dataType:"json",
					
                success:function(data){
					
				$('#department').append('<option disabled selected value="">Choose..</option>');	
				for(i=0; i< data.length;i++){
               $('#department').append('<option value="'+data[i].groupID+'">'+data[i].groups+'</option>');
                    }
				}
      });

                });
                //select kedua
                $('#department').change(function () {
				 	
					
                 var value = $(this).val();
                 var companyID = document.getElementById("companyy").value; 
                 var alldata = 
               {
                 department:value,
                 companyID:companyID
               };
     			console.log();
				$.ajax({
        		url:"ajax-getviewwallet.php",
        		method:"POST",
        		data:alldata,
				
        		success:function(data){
          		$("#showcategoryview").html(data); 

        }
      });
    });
				
					
				$(document).on('click', "#addwalletbutton", function(){
      
	 			var companyID = document.getElementById("companyy").value; 
	 			var dept_id = document.getElementById("department").value;
     			{ $("#addcategorycompany").val(companyID);      
       			$("#addcategorydept").val(dept_id);
				 
				$('.bonuschoose').empty();
				var companyIDz = document.getElementById("addcategorycompany").value;
//				var dept_idz   = document.getElementById("addcategorydept").value;
                var alldata =
				{
					companyID:companyIDz,
//					dept_id:dept_idz,
				};
				 
				$.ajax({
                url:"ajax-getwalletbonus.php",
                method:"POST",
               
				data:alldata,
                dataType:"json",	
                success:function(data){
				console.log(data);	
				$('#choosewallet').append('<option disabled selected value="">Choose..</option>');	
				for(i=0; i< data.length;i++){
                $('#choosewallet').append('<option value="'+data[i].wallet_id+'">Wallet '+" "+data[i].wallet+'</option>');
			   
                    }
				  ;}
				 
			   });
				
				}
      
    });

  });
		   
		   
 </script>
		
<div id="showcategoryview">
	
	</div> </div>
			
<!--	END OF DEPARTMENT		-->
			
<!--	Start of Position		-->
			
			<div class="tab-pane" id="position">
				
			<br>
				<br>
				
						<div id="row">
				<label><strong>Position</strong></label><br>
	    <select name="positionz" class="form-control poss" id="positionz" style="width:200px;">
		 <option disabled selected> Choose..</option>
			
		</select>
	
				</div>
		<script type="text/javascript"> 
		   
		   
                $(document).ready(function(){
				
				
				//select pertama	
                $('#companyy').change(function () {
		        $('.poss').empty(); 
                
				var companyIDs = $(this).val();
                $.ajax({
                url:"ajax-getjoblist.php",
                method:"POST",
                data:{companyID:companyIDs},
				dataType:"json",	
                success:function(data){
				console.log(data)	
				$('#positionz').append('<option disabled selected value="">Choose..</option>');	
				for(i=0; i<data.length;i++){
               $('#positionz').append('<option value="'+data[i].jobID+'">'+data[i].jobname+'</option>');
                    }
				}
      });  });

			   $('#positionz').change(function () {
		        
                
				var posid = $(this).val();
			    var companyID = document.getElementById("companyy").value;
			    var dept = document.getElementById("department").value; 
				   
				var alldata = 
				  
				  {
					companyID:companyID,
					posid:posid,
					dept:dept  
				  }
                
				$.ajax({
                url:"ajax-getviewposition.php",
                method:"POST",
                data:alldata,
               
					
				success:function(data){
					
          		$("#showpositionview3").html(data); 

        }
      });
    });
		
				$(document).on('click', "#addwalletposition", function(){
      
	 			var companyID = document.getElementById("companyy").value; 
	 			var posid = document.getElementById("positionz").value;
     			
				{ $("#companyposid").val(companyID);      
       			  $("#posid").val(posid);
			    } 
	
		
		});

  });
		   
		   
 </script>		
		
		<br><br>
		<div id="showpositionview3"></div>
		
		<br>
			
		<br><br>
		

		<br>
			</div>
			</div>
		
		
			</div>
<!--
		<div class="col-md-3 offset-md-3">
		<input type="submit" name="confirm" value="Confirm" class="btn btn-primary" >	
		
		<input type="submit" name="history" value="View History" class="btn btn-primary" >	
		</div>
-->
		</form>
		<br>
	<script type="text/javascript">
    $(document).ready(function(){
       $("#sidebar-wrapper .active").removeClass("active");
       $("#walletview").addClass("active").addClass("disabled");
       document.getElementById("walletview").style.backgroundColor = "DeepSkyBlue";
    });
  </script>
  <?php
  include 'includes/footer.php';
include 'includes/form.php';		
  ?></div></div></div>
</body>
	
</html>