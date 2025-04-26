<?php
require_once 'core/init.php';
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
}if(Input::exists()){
    $company_id = escape(Input::get('company_id'));
	 $dept_id = escape(Input::get('dept_id'));
//	print_r($dept_id);
	$Walletobject = new Walletsetup();
	$data = $Walletobject->	searchweightagebonusdepartment($company_id,$dept_id );

$view = "";
$dataexist = $Walletobject->searchInWeightageTable2($company_id,$dept_id);
	if ($dataexist){
$view =	"
<form id ='weightagesetup'>

  <div class='table-responsive text-nowrap'>
			
			<table style='width:100%;' class='table'>
				<thead >
					<tr style='text-align: center'>
					
					<th style='width:45%;'>Staff Name</th>
					<th style='width:45%;'> Job Position </th>
					<th>Percentage Allocation (%)</th>
					
					
					
					</tr>	</thead>
	
 
";	

	foreach($dataexist as $datavalid){
	
		  //jobpositionid

		    //$deptz = $groupObject->searchGroupnewzz($datavalid->dept_id);
		    $wallet = $datavalid->choosewallet;
			$memberid = $datavalid->jobpositionid;
	        $userObject = new User();
	        $datanew  = $userObject->searchuserlist($memberid);
	  	  
	  foreach($datanew as $row2){
		  $name = $row2->firstname.' '.$row2->lastname;
		  $job = $row2->jobposition;
		  $jobObject = new Jobposition();
		  $jobname = $jobObject->searchjob($job);		
		  $jobnamez = $jobname->jobname;
		$view .= 
		"
		<tbody>
		            <input type='hidden' name='wallet' value='$wallet' class='form-control'/> <br>
					<input type='hidden' name='jobID[]' value='$memberid' class='form-control'/> <br>
					<input type='hidden' name='jobpositionID[]' value='$job' class='form-control'/> <br>
					<input type='hidden' name='percent_allocation[]' value='$datavalid->percentage_allocation' class='form-control'/>
					 <input type='hidden' name='company_id' value='$company_id' class='form-control'/>
					 <input type='hidden' name='dept_id' value='$dept_id' class='form-control'/>
					<tr style='text-align: center'>
						
						
						<td style='text-align: center; width:45%;'>$name</td>	
						<td style='width:45%;'>$jobnamez </td>	
						<td style='text-align: center;'>$datavalid->percentage_allocation</td>
						<td> </td>
					
						
			</tr> </tbody>
		
		";		  

 } } $view .=" 
 </table>
<input type='button' id='Reset' Name='Reset' class='btn btn-primary' value='Reset'/>
 ";
  
	$view.="  </div></form>
	
	";
	
	$view .='
 <script>
		
		 $(document).ready(function(){
		
         var form = $("#weightagesetup");
         console.log(form);
	     $("#Reset").click(function(e){
         e.preventDefault();  
         e.stopPropagation(); 
      
        var data = form.serialize();
		var 
		alldata=data;
        console.log(alldata);
		 $.ajax({
         url: "ajax-deleteweightagedepartmentsetup.php",
         type: "POST",
         data: alldata,
         dataType:"json",
         success:function(data){ 
			
          if(data.condition === "Passed"){
		 getWeightage(data.company_id,data.dept_id);
          }
		  
        }

      });
	
   });
 
 
 });
 
   function getWeightage(company_id,dept_id){
	   
	   
	   var alldata = 
               {
                 company_id:company_id, 
				 dept_id:dept_id
               };
			   
		 console.log(alldata);
		
		$.ajax({
		url: "ajax-weightagesetupdepartment.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
       
			success:function(data){
		
			$("#showwalletsetupdepartment").html(data); 
        
		}
      });

}
 
 function checkvalidity(data1, data2, data3, data4){
  document.getElementById(data1).innerHTML = data4;
  if(data4 === "Required"){
    $(data2).removeClass("text-success").addClass("text-danger");
    $(data3).removeClass("border-success").addClass("border-danger");
  }else if(data4 === "Valid"){
    $(data2).removeClass("text-danger").addClass("text-success");
    $(data3).removeClass("border-danger").addClass("border-success");
  }else{
    $(data2).removeClass("text-success").addClass("text-danger");
    $(data3).removeClass("border-success").addClass("border-danger");
  }
}

function clearform(data1, data2, data3){ 
  $(data1).removeClass("text-success").removeClass("text-danger");
  document.getElementById(data2).textContent="";
  $(data3).removeClass("border-success").removeClass("border-danger");
}


 
 
 </script>
  ';
	
	
	}
	
else
{	
	
	if($data){
$view =	" <form id ='weightagesetupdepartment'>
<div id='percterror'>
<small><span id='percterrorspan' name='percterrorspan'></span></small>
  <div class='table-responsive text-nowrap'>
   
			  <label>Choose Wallet</label>
			  <input type='hidden' name='companyID' value='".$company_id."'/>
			  <input type='hidden' name='dept_id' value='".$dept_id."'/> 
			  <input type='hidden' name='type'  value='3' /> 
			  
			  <select id='choosewallet' name='chosewallet' style='width:150px;' class='form-control' required> 
							<option disabled selected> Choose..</option>
							"; 
	                  
					  foreach ($data as $row2){
						  $view .= "<option value='".$row2->wallet_id."'>".$row2->wallet."</option>
						  
					         ";}
					  
					    $view .="
			            </select> <br>
			
			<table style='width:100%;' class='table'>
				<thead >
					<tr style='text-align: center'>
					
					<th style='width:45%;'>Staff Name</th>
					<th style='width:45%'> Job Position </th>
					<th style='min-width;'>Percentage Allocation (%)</th>
					
					
					
					</tr>	</thead>
	
 
";	
 	
  $groupObject = new Group();
  $datamember = $groupObject->searchGroupMember($dept_id);
  
	if($datamember){
	
  $userObject = new User();
	$az = array();
//	print_r($datamember);
  foreach($datamember as $row){
	  
	  $memberid = $row->member_id;
	  
	  $datanew  = $userObject->searchuserlist($memberid);
	  	  
	  foreach($datanew as $row2){
		  $name = $row2->firstname.' '.$row2->lastname;
		  $job = $row2->jobposition;
		  $jobObject = new Jobposition();
		  $jobname = $jobObject->searchjob($job);		
		  $jobnamez = $jobname->jobname;
		  $view .= 
		"
		<input type='hidden' name='jobid[]' value='$memberid'/>
		<input type='hidden' name='jobpositionID[]' value='$job' class='form-control'/> <br>
		<tbody>
					<tr style='text-align: center'>
						<td style='text-align: center; width: 50px;'>$name</td>	
						<td>$jobnamez</td>	
						<td style='text-align: center;'><input type='text' name='weightagevalue[]' class='form-control'</td>
						<td> </td>
					
						
			</tr> </tbody>
		
		";		  

 }   
//		  
//	    $userlist = $row2->jobposition;;
//		array_push($az,$userlist);
//		  
	  } 	
		  
		  $view .=" 
 </table>
<input type='button' id='submitweightagen' class='btn btn-primary' value='Save'/>
 ";
	$view.="  </div>
	</div>
	</form>";    
}
else{
	$view .="
	</table></div>
	No workers available";
	
}

	}
	else{
		$view .= "No Wallet Available";
	}
}

//    $Walletobject = new Walletsetup();
//	$data = $Walletobject->searchwalletweightaage($company_id);//wallet

//	$groupObject = new Group();
//	
////	$aaaa= $data->wallet;
//    
//	

//	

	$view .='
	<script type="text/javascript">
	$(document).ready(function(){
 
	var form =$("#weightagesetupdepartment");
    
	 $("#submitweightagen").click(function(e){
        e.preventDefault();  
        e.stopPropagation(); 
      
        var data = form.serialize();
        console.log(data);
		 $.ajax({
         url: "ajax-addweightagedepartment.php",
         type: "POST",
         data: data,
         dataType:"json",
         success:function(data){ 
			
          if(data.condition === "Passed"){
           checkvalidity ("percterrorspan", "#percterrorspan", "#percterror", data.w);
		    getWeightage(data.company_id,data.dept_id);
	}
	else
		  {
			checkvalidity("percterrorspan", "#percterrorspan", "#percterror", data.w);
          }
        

      }
	
   });

});
	
	});
function getWeightage(company_id,dept_id){
	   
	   
	   var alldata = 
               {
                 company_id:company_id, 
				 dept_id:dept_id
               };
			   
		 console.log(alldata);
		
		$.ajax({
		url: "ajax-weightagesetupdepartment.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
       
			success:function(data){
		
			$("#showwalletsetupdepartment").html(data); 
        
		}
      });

}
 	
	
function checkvalidity(data1, data2, data3, data4){
  document.getElementById(data1).innerHTML = data4;
  if(data4 === "Required"){
    $(data2).removeClass("text-success").addClass("text-danger");
    $(data3).removeClass("border-success").addClass("border-danger");
  }else if(data4 === "Valid"){
    $(data2).removeClass("text-danger").addClass("text-success");
    $(data3).removeClass("border-danger").addClass("border-success");
  }else{
    $(data2).removeClass("text-success").addClass("text-danger");
    $(data3).removeClass("border-success").addClass("border-danger");
  }
}

function clearform(data1, data2, data3){ 
  $(data1).removeClass("text-success").removeClass("text-danger");
  document.getElementById(data2).textContent="";
  $(data3).removeClass("border-success").removeClass("border-danger");
}

</script>
';	

	
	
echo $view;}


?>
