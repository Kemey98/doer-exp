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
//	 $dept_id = escape(Input::get('department'));
    $Walletobject = new Walletsetup();
	$data = $Walletobject->searchwalletweightaage($company_id);//wallet
//	print_r($data);
	$groupObject = new Group();
	
//	$aaaa= $data->wallet;
    
$view = "";
	
$dataexist = $Walletobject->searchInWeightageTable($company_id);
	if ($dataexist){
$view =	"
<form id ='weightagesetup'>

  <div class='table-responsive text-nowrap'>
			
			<table style='width:100%;' class='table'>
				<thead >
					<tr style='text-align: center'>
					
					<th style='width:80%;'>Department Name</th>
					<th style='width:20%;'>Percentage Allocation (%)</th>
					
					
					
					</tr>	</thead>
	
 
";	

	foreach($dataexist as $datavalid){
	
		

		    $deptz = $groupObject->searchGroupnewzz($datavalid->dept_id);
		    $wallet = $datavalid->choosewallet;
		   
		foreach($deptz as $department)
		{
		$view .= 
		"
		<tbody>
		           <input type='hidden' name='company_id' value='$company_id' class='form-control'/>
				   <input type='hidden' name='wallet' value='$wallet' class='form-control'/> <br>
					<input type='hidden' name='deptID[]' value='$department->groupID' class='form-control'/>
					<input type='hidden' name='percent_allocation[]' value='$datavalid->percentage_allocation' class='form-control'/>
					
					
					<tr style='text-align: center'>
						
						
						<td style='text-align: center; width:80%;'>$department->groups</td>	
							
						<td style='text-align: center; width:20%;'>$datavalid->percentage_allocation</td>
					
						
			</tr> </tbody>
		
		";		  

 } } $view .=" 
 </table>
<input type='button' id='Reset' name='Reset' class='btn btn-primary' value='Reset'/>
 ";
		
	$view.="  
	
	</div></form>
	
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
         url: "ajax-deleteweightagecompanysetup.php",
         type: "POST",
         data: alldata,
         dataType:"json",
         success:function(data){ 
			
          if(data.condition === "Passed"){
			 getWeightage(data.company_id);
         
		 }

      }
	
   });
 
 
 });
 
  });
  function getWeightage(company_id){
	   
	   
	   var alldata = 
               {
                 company_id:company_id, 
               };
			   
		 console.log(alldata);
		
		$.ajax({
		url: "ajax-weightagesetup.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
       
			success:function(data){
		
			$("#showwalletsetup").html(data); 
        
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
$view =	" <form id ='weightagesetup'>
<div id='percterror'>
<small><span id='percterrorspan' name='percterrorspan'></span></small>
  <div class='table-responsive text-nowrap'>
   
			  <label>Choose Wallet</label>
			  <input type='hidden' name='companyID' value='".$company_id."'/> 
			  <input type='hidden' name='type'  value='2' /> 
			  
			  <select id='choosewallet' name='chosewallet' style='width:150px;' class='form-control' required> 
							<option disabled selected> Choose..</option>
							"; 
	                  if($data){
					  foreach ($data as $row2){
						  $view .= "<option value='".$row2->wallet_id."'>".$row2->wallet."</option>
						  
					         ";}
					  }
	
	               else{ $view.= "No Wallet Available";}
					  
					    $view .="
			            </select> <br>
			
			<table style='width:100%;' class='table'>
				<thead >
					<tr style='text-align: center'>
					
					<th style='width:80%;'>Department Name</th>
					<th style='width:20%;'>Percentage Allocation (%)</th>
					
					
					
					</tr>	</thead>
	
 
";
	   
			$data2 = $groupObject->searchGroupName($company_id);
	if($data2){
			foreach($data2 as $rowz){
		    $dept = $rowz->groups;
		  
		   $view .= 
		"
		<tbody>
					<input type='hidden' name='dept_id[]' value='".$rowz->groupID."'/> 
					<tr style='text-align: center'>
						<td style='text-align: center; width: 70%;'>$dept</td>	
							
						<td style='text-align: center; width:30%;'><input type='text' name='weightagevalue[]' class='form-control'</td>
						<td> </td>
					
						
			</tr> </tbody>
		
		";		  

 }  $view .=" 
 </table>
<input type='button' id='submitweightagen' class='btn btn-primary' value='Save'/>
 ";
  }
	$view.="  </div>
	</div>
	</form>"; }
	$view .='
	<script type="text/javascript">
	$(document).ready(function(){
 
	var form =$("#weightagesetup");
    
	 $("#submitweightagen").click(function(e){
        e.preventDefault();  
        e.stopPropagation(); 
      
        var data = form.serialize();
        console.log(data);
		 $.ajax({
         url: "ajax-addweightage.php",
         type: "POST",
         data: data,
         dataType:"json",
         success:function(data){ 
			
          if(data.condition === "Passed"){
           checkvalidity ("percterrorspan", "#percterrorspan", "#percterror", data.w);
		    
           getWeightage(data.company_id);
	
	}
	
		   
		   
		  
		  else
		  {
			checkvalidity("percterrorspan", "#percterrorspan", "#percterror", data.w);
          }
        

      }
	
   });

});
	
	});
function getWeightage(company_id){
	   
	   
	   var alldata = 
               {
                 company_id:company_id, 
               };
			   
		 console.log(alldata);
		
		$.ajax({
		url: "ajax-weightagesetup.php?lang=<?php echo $extlg;?>",
        type: "POST",
        data: alldata,
       
			success:function(data){
		
			$("#showwalletsetup").html(data); 
        
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
