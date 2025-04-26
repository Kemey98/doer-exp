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
      
    $company_id = escape(Input::get('companyID'));
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
		$aa = count($existintablebonus);

		$num = 0;
		 $payment=0;   
	$view ="
	<br>
	<br>
	<form id='submitbonusslip'>	
	<div id='print_setion'>
	"
	;
	 $i=0;
	 foreach ($existintablebonus as $row){
		 $payment=$payment + 1;
	$date=$row->date;
    $searchdate = $calculationObject->searchCalcByDate2($company_id,$dept_id,$date);
	
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
	
	$view .='	
	</table></div> ';
	} 
	
	$view .="
	<br>
	
	";
	$view.='	
	
	
<script>
 
function printDivSection(setion_id) {

   var Contents_Section = document.getElementById(setion_id).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = Contents_Section;

     window.print();

     document.body.innerHTML = originalContents;


}
    </script>
	</div>

	<input type="button" id="btnPrint" name="btnPrint" onclick=printDivSection("print_setion") value="Print Slip" class="btn btn-primary"/>
	</form> 
	';
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
		
		$view ="";
		$view ="No Data";
	}
		echo json_encode($view);
}