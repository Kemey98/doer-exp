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
}

if(Input::exists()){
      
    $company_id = escape(Input::get('company_id'));
	$year = escape(Input::get('year'));
	$dept_id = escape(Input::get('dept_id'));
   
	$calculationObject2 = new Calculation();
	$calculationObject = new Calculation();
	$calculationExist = $calculationObject->searchCalcGroup($company_id,$dept_id,$year);
	$Walletsetupobject1= new Walletsetup();
	$Walletsetupobject= new Walletsetup();
	$userObject = new User();
	
	$data1 = $Walletsetupobject->searchwalletposition($company_id);
//	$existintablebonus = $calculationObject2->SearchBonusCalculation($company_id,$dept_id,$year);
	$existintablebonus = $calculationObject->searchCalcGroup2($company_id,$dept_id,$year);
	if($existintablebonus)
	{
	$view ="";
			$num = 0;
		    $payment=0;
	$view ="
	<br>
	<br>
	<form id='submitbonusslip'>	"
	;
	 
	 foreach ($existintablebonus as $row){
     $payment = $payment +1;
	$date=$row->date;
    $searchdate = $calculationObject->searchCalcByDate2($company_id,$dept_id,$date);
	//print_r($searchdate);
		$view .='
		Payment : '.$payment.' on '.$date.'
		<div class="table-responsive text-nowrap">
	
<table style="width:100%;" class="table">
		<thead-dark>
		<tr style="text-align: center">
		<th style="width:5%;">Number</th>
		<th style="width:30%;">Staff Name </th>
		<th style="width:15%;">Job Position </th>
		<th style="min-width:10%;"><br>KPI</th>
		<th style="width:10%;">Bonus<br> Payout (RM)</th>
		<th style="width:10%;">Bonus<br>Increment (RM)</th>
		<th style="width:10%;">Total<br>Payout (RM)</th>
		
	</tr>
		</thead-dark>
		';
	foreach($searchdate as $row2){
	$view .='	';
	$num = $num+1;	
	
	$datanew  = $userObject->searchuserlist3($row2->Staff_ID);
		 $name = $datanew->firstname.' '.$datanew->lastname;
		
		  $jobObject = new Jobposition();
		  $jobname = $jobObject->searchjob2($row2->Job_ID);		
		  $jobnamez = $jobname->jobname;	
		 
		if($row->KPI > 100){
			$totalview = $row2->Bonus_Payout + $row2->Bonus_Increment;
		$view .='
		<tr style="text-align: center">
			<td>'.$num.'</td>
			<td><center><input type="text" style="text-align: center;" class="no-border" disabled value="'.$name.'" ></td>
			<td>'.$jobnamez.'</td>
			<td>'.$row2->KPI.'</td>	
			<td >'.$row2->Bonus_Payout.'</td>	
			<td>'.$row2->Bonus_Increment.'</td>	
			<td>'.$totalview.'</td>	
			
			</tr>
			
			';
			$view .='
	<input type="hidden" name="KPI[]" value="'.$row2->KPI.'"/>
	<input type="hidden" name="bonuspay[]" value="'.$row2->Bonus_Payout.'"/>
	<input type="hidden" name="bonusincres[]" value="'.$row2->Bonus_Increment.'"/>
	<input type="hidden" name="totalbonus[]" value="'.$row2->Total_Bonus.'"/>
     <input type="hidden" name="staffid[]" value="'.$row2->Staff_ID.'"/>
	  <input type="hidden" name="jobid[]" value="'.$row2->Job_ID.'"/>';
		}
	else{
		
		$view .='
		<tr style="text-align: center">
			<td>'.$num.'</td>
			<td><center><input type="text" style="text-align: center;" class="no-border" disabled value="'.$name.'" ></td>
			<td>'.$jobnamez.'</td>
			<td>'.$row2->KPI.'</td>	
			<td >'.$row2->Bonus_Payout.'</td>	
			<td>'.$row2->Bonus_Increment.'</td>	
			<td>'.$row2->Total_Bonus.'</td>	
			
			</tr>
			
			';
			$view .='
	<input type="hidden" name="KPI[]" value="'.$row2->KPI.'"/>
	<input type="hidden" name="bonuspay[]" value="'.$row2->Bonus_Payout.'"/>
	<input type="hidden" name="bonusincres[]" value="'.$row2->Bonus_Increment.'"/>
	<input type="hidden" name="totalbonus[]" value="'.$row2->Total_Bonus.'"/>
     <input type="hidden" name="staffid[]" value="'.$row2->Staff_ID.'"/>
	  <input type="hidden" name="jobid[]" value="'.$row2->Job_ID.'"/>';
	}
	
	} 
	
	$view .='	
	</table></div>';
	} 
	
	$view .="
	<br>
	<input type='button' name='resetz' id='resetz' class='btn btn-primary' value='Reset'/>
	
	</form> 
	";
	$view .='		<script>
		
		 $(document).ready(function(){
		
         var form = $("#submitbonusslip");
         console.log(form);
	     $("#resetz").click(function(e){
         e.preventDefault();  
         e.stopPropagation(); 
      
        var data = form.serialize();
		var 
		alldata=data+"&company_id="+'."$company_id".'+"&year="+'."$year".'+"&dept_id="+'."$dept_id".';
        console.log(alldata);
		 $.ajax({
         url: "ajax-deletebonuscalculation.php",
         type: "POST",
         data: alldata,
         dataType:"json",
         success:function(data){ 
			
          if(data.condition === "Passed"){
			  getWeightage(data.company_id,data.dept_id,data.year);
		
          }
		  
        }

      });
	
   });   });
   
	function getWeightage(company_id,dept_id,year){
	   
	   
	   var alldata = 
               {
                 company_id:company_id, 
				 dept_id:dept_id,
				 year:year
               };
			   
		 console.log(alldata);
		
		$.ajax({
		url: "ajax-getviewbonusstaff.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        dataType:"json",
			success:function(data){
			$("#showTable").html(data); 
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
	
	else{
	$num = 0;	
	$view ="
	<br>
	<br>

	";$payment=1;
		
foreach ($calculationExist as $row){
	
	
	$date=$row->date;
	$percentage = $row->percentage;
	$view .="	<form id='submitbonusslip'>	<div class='table-responsive text-nowrap'>

	
	Payment : $payment on $date
	<table style='width:100%;' class='table'>
		<thead-dark>
		<tr style='text-align: center'>
		<th style='width:5%;'>Number</th>
		<th style='width:40%;'>Staff Name </th>
		<th style='width:15%;'>Job Position </th>
		<th style='min-width:10%;'><br>KPI</th>
		<th style='width:10%;'>Bonus<br> Payout (RM)</th>
		<th style='width:10%;'>Bonus<br>Increment (RM)</th>
		<th style='width:10%;'>Total<br>Payout (RM)</th>
	</tr>
		</thead-dark>";
	$searchdate = $calculationObject->searchCalcByDateFirstRow($company_id,$dept_id,$date);
		
	if($data1){
	$Walletsetupobject1 = new Walletsetup();	
	$allocation = $Walletsetupobject->searchAllocation2($company_id,$dept_id);
	$groupObject = new Group();
	$num = 0;	
	if($allocation){
	  foreach ($data1 as $row) {
		
		  $jobid = $row->job_ID;
		  $userlist=$userObject->searchuserlist2($jobid);
		  if($userlist){
			  
			foreach($userlist as $key){
		  $userID = $key->userID;
		 $azz = $Walletsetupobject->searchAllocationPosition($company_id,$userID);	
		
		// print_r($allocatepos);
		  if($row->wallet_type2==="3"){
			
		  if($row->wallt_type==="Bonus"){
			
		  $company_ids = $row->company_id;
		  $jobID = $row->job_ID;
		  
		 
		
		   $Mainallocationobj = new Mainallocation();
		   $com = $Mainallocationobj->searchFund2($row->company_id);	//budgettotal 3600
  	       $budget = $com->budgetAllocated;
		
	
		$aaa= $Walletsetupobject1->searchBasedOnCompanyID($company_id);
		$wallet_IDComp =$aaa->wallet_id;
		$weightagecompany = $aaa->weightage;//0.9   
			
		$allocation = $Walletsetupobject->searchAllocation($company_id,$dept_id);	
		$percentallocationcompany = $allocation->percentage_allocation;//0.5
		
	    $az = $Walletsetupobject->searchwalletinposview($company_id,$dept_id);	
		$weightagedept = $az->weightage;//0.8
		
		$allocatepos = $azz->percentage_allocation;//0.4
		
		$weightageposition = $row->weightage;
		//print_r($weightageposition);	  

		 	
				
			$userID = $key->userID;	
			$datakpi = $groupObject->searchKPI($userID);	
			$weightagekpi = $datakpi->weightage;
			$processkpi = $datakpi->progress;	
				
					$num = $num +1;
				  $name = $key->firstname.' '.$key->lastname;
		  $job = $key->jobposition;
		 
		 $jobObject = new Jobposition();
		  $jobname = $jobObject->searchjob($job);		
		  $jobnamez = $jobname->jobname;	
			$weightage1 = $searchdate->percentage;
			$payz = $searchdate->payment;
			
		$totalcompany = $budget * ($weightagecompany/100);	
		$totalallocationcompany = $totalcompany * ($percentallocationcompany/100);	
		
		$totalweightagedepartment = $totalallocationcompany   * ($weightagedept/100);
		$totalallocationdept      = $totalweightagedepartment * ($allocatepos/100);
		
		$realtotal = $totalallocationdept * ($weightageposition/100);	
		
			
//			$totalafterpercentpayment = $totalnew * ($weightage1/100); 
			
		
			$totalkpi = ($weightagekpi/100) * $processkpi;
		   		
					
			if($totalkpi < 100 ){
				
				$bonusbasedonkpi = 0.00;
			    
			   $realtotal = $realtotal*($percentage/100); 
			   $realtotalafterkpi = $realtotal * ($totalkpi/100);
				
				$view .=
			
			'<tr style="text-align: center">
			<td><center>'.$num.'</td>
			<td><center><input type="text" style="text-align: center;" class="no-border" disabled value="'.$name.'" ></td>
			<td>'.$jobnamez.'</td>
			<td>'.$totalkpi.'</td>	
			<td >'.$realtotal.'</td>	
			<td>'.$bonusbasedonkpi.'</td>	
			<td>'.$realtotalafterkpi.'</td>	
			</tr>
			
			
			'; 		  	$view .='
	<input type="hidden" name="totalafterpayment[]" value="'.$realtotal.'"/>
	<input type="hidden" name="staffid[]" value="'.$userID.'"/>
	<input type="hidden" name="jobid[]" value="'.$job.'"/>
	<input type="hidden" name="kpi[]" value="'.$totalkpi.'"/>
     <input type="hidden" name="bonusbasedonkpi[]" value="'.$bonusbasedonkpi.'"/>
	  <input type="hidden" name="totalvalue[]" value="'.$realtotalafterkpi.'"/>
	 <input type="hidden" name="date[]" value="'.$date.'"/>
	';
		} 			  
						
			else if($totalkpi>100){
				
			   $bonusbasedonkpi = $totalkpi - 100;
			   $bonusbasedonkpi = $bonusbasedonkpi*($percentage/100); 
			   $realtotal = $realtotal*($percentage/100); 
			   $realtotalafterkpi1 = $realtotal+$bonusbasedonkpi;
				  $realtotalafterkpi = $realtotal;	
			
//			$totalvalue = $bonusbasedonkpi + $totalafterpercentpayment1;
			 
			$view .=
			
			'<tr style="text-align: center">
			<td><center>'.$num.'</td>
			<td><center><input type="text" style="text-align: center;" class="no-border" disabled value="'.$name.'" ></td>
			<td>'.$jobnamez.'</td>
			<td>'.$totalkpi.'</td>	
			<td >'.$realtotal.'</td>	
			<td>'.$bonusbasedonkpi.'</td>	
			<td>'.$realtotalafterkpi1.'</td>	
			</tr>
			
			
			'; 		  	$view .='
	<input type="hidden" name="totalafterpayment[]" value="'.$realtotal.'"/>
	<input type="hidden" name="staffid[]" value="'.$userID.'"/>
	<input type="hidden" name="jobid[]" value="'.$job.'"/>
	<input type="hidden" name="kpi[]" value="'.$totalkpi.'"/>
     <input type="hidden" name="bonusbasedonkpi[]" value="'.$bonusbasedonkpi.'"/>
	  <input type="hidden" name="totalvalue[]" value="'.$realtotalafterkpi.'"/>
	 <input type="hidden" name="date[]" value="'.$date.'"/>
	';
		} }			  

				  
		 
			  }}
		  
		  }
	
	
	}}
	
	$view .="
	</tbody>
			</table>
			</div>
					
	";$payment= $payment+1;
}
}
		$view .=
			"
			<input type='button' name='submit' id='submit' value='Save' class='btn btn-primary'/>
			</form>
			
			
		";
	
	$view .='
<script type="text/javascript">
    
     $(document).ready(function(){
     var form = $("#submitbonusslip");
     console.log(form);
	 $("#submit").click(function(e){
        e.preventDefault();  
        e.stopPropagation(); 
      
        var data = form.serialize();
		var 
		alldata=data+"&company_id="+'."$company_id".'+"&year="+'."$year".'+"&dept_id="+'."$dept_id".'+"&payment="+'."$payz".';
        console.log(alldata);
		 $.ajax({
         url: "ajax-addBonusData.php",
         type: "POST",
         data: alldata,
         dataType:"json",
         success:function(data){ 
			
          if(data.condition === "Passed"){
			 

			 getWeightage(data.company_id,data.dept_id,data.year);

        }
		  else
		  {
			 
          }
        }

      });
	
   });

});
	function getWeightage(company_id,dept_id,year){
	   
	   
	   var alldata = 
               {
                 company_id:company_id, 
				 dept_id:dept_id,
				 year:year
               };
			   
		 console.log(alldata);
		
		$.ajax({
		url: "ajax-getviewbonusstaff.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
        dataType:"json",
			success:function(data){
			$("#showTable").html(data); 
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
	
';}
	echo json_encode($view);
}
?>