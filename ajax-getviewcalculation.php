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
	$year       = escape(Input::get('year'));
	$fund       = escape(Input::get('fund_available'));
	$dept_id   = escape(Input::get('dept_id'));
	$dept_fund  = escape(Input::get('dept_fund'));
	$payment    = escape(Input::get('payment'));

//	$newGroup = new Group();
//	$aaa = $newGroup->searchGroupnew2($dept_ids);
//	
//	$dept_id = $aaa->groupID;
  
$view = 
	" 
		";
    
	$walletObj = new Walletsetup();
	
	$listwallet = $walletObj->searchwallet($company_id,$dept_id);
	$listwalletcount = count ($listwallet);
	
   $calculationObject = new Calculation();
   $calculationExist = $calculationObject->searchCalcGroup($company_id,$dept_id,$year);
//	print_r($calculationExist);
	
	if($calculationExist)
	{

		
			$view.="
			
			<form id='submitupdatecalculate'>
			<div class='table-responsive text-nowrap'>
			<table style='width:100%;' class='table'>
				<thead>
					<tr style='text-align: center;'>
					<th text-align: center;' style='width:2%'>Number</th>
					<th  style='width:60px;align:center;'>Percentage per payment (%)</th>
					<th style='width:60px;'>Date</th>";
			
		if($listwallet){
			
		$dept_fundz = array();
	  
				foreach($listwallet as $row){
					
			    array_push($dept_fundz,$row->weightage);
				
				$view .= "<th class='th-sm' style='width: 20%;'> Wallet ".$row->wallet ."</th>";
			  
			}
		}
				
	$view .="
		
	</tr>
		</thead>
 
";		

		  $view .= 
		"
		
		<tbody>";
		$num=0;
		$i = 0;
       foreach ($calculationExist as $row){
			 $num = $num + 1;
		   $view .=
				"
				<tr style='text-align: center;'>
				<td>". $num ."</td>
				
				<td style='text-align:center;'><input type='text' name='perc' id='perc' value='".$row->percentage."' class='form-control'/></td> 
				
				<td style='width: 150px;'><input type='date' name='datecalc[]'  id='datecalc' value='".$row->date."' class='form-control'</td>";
		   
		$date = $row->date;
//		print_r($date);
        $searchdate = $calculationObject->searchCalcByDate($company_id,$dept_id,$date);
		
		   
		   foreach($searchdate as $rowzz){
//		 print_r($rowzz);
		   
				
				$view .="
				
				
				<td><input type='text' name='wallet_new' id='wallet_new' value='".$rowzz->wallet."' disabled class='form-control'/> </td>
				
	  ";
		$i++;  
		
	}
		   $view .="</tr>";
}
	   
		
//		}
      $view .= "	
         
		 </tbody>
		 </table>
		 </div>
		</form>
		";	
	 
		
		$view .="
		<input type='button' name='calculatebonusstaff' id='calculatebonusstaff' class='btn btn-primary' value='Calculate'/>
		<input type='submit' name='reset' id='reset' class='btn btn-primary' value='Reset'/>
		<br>
		<br>
		<div id='showTable'></div>
		";
		$view .='
		<script>
		
		 $(document).ready(function(){
		
         var form = $("#submitupdatecalculate");
         console.log(form);
	     $("#reset").click(function(e){
         e.preventDefault();  
         e.stopPropagation(); 
      
        var data = form.serialize();
		var 
		alldata=data+"&company_id="+'."$company_id".'+"&year="+'."$year".'+"&dept_id="+'."$dept_id".';
        console.log(alldata);
		 $.ajax({
         url: "ajax-deletecalculation.php",
         type: "POST",
         data: alldata,
         dataType:"json",
         success:function(data){ 
			
          if(data.condition === "Passed"){
			 
				 			
                 var value     = document.getElementById("payment").value;
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
   
		 	 
	
		
          }
		  
        }

      });
	
   });
		 $(document).on("click", "#calculatebonusstaff", function(){
      	
     			
				 
		       var alldata="&company_id="+'."$company_id".'+"&year="+'."$year".'+"&dept_id="+'."$dept_id".';
                console.log(alldata);
				$.ajax({
                url:"ajax-getviewbonusstaff.php",
                method:"POST",
                data:alldata,
                dataType:"json",	
                success:function(data)
				{
					
				 $("#showTable").html(data); 
				
				}
    			});
				});	
	});	
	
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
	
	else
	{
	if($listwallet){
			
		$dept_fundz = array();
	
		$view .="
		<form id='submitcalculatezz'>
		<div id='percterror'>
		<small><span id='percterrorspan' name='percterrorspan'></span></small>
		<div class='table-responsive text-nowrap'>
		<table style='width:100%;' class='table'>
		<thead>
		<tr style='text-align: center;'>
		<th class='th-sm' style='width: 5%; text-align: center;'>Number</th>
		<th class='th-sm' style='width:'>Percentage per payment</th>
		<th class='th-sm' style='width:'>Date</th>
		";
			
			foreach($listwallet as $row){
			array_push($dept_fundz,$row->weightage);
				
				$view .= "<th class='th-sm' style='width: 30%;'> Wallet ".$row->wallet ."</th>";
			  
			}
			
		
		
	$view .="
		
	</tr>
		</thead>
 
";

	  
//		 if($row->wallet_type2=== "3" ){
		  $view .= 
		"
		
		<tbody>
	
		";
	 $num=0;
	 $inputid = $payment * $listwalletcount ; 		
	 
	for($i=0;$i<$payment;$i++) {  
	
		$inputid = $inputid -1;
		 
		$num = $num + 1;			 
			 
		$view .= 	
			
			"<tr>
				<td>". $num ."</td>
				
				
				<td><input type='text' name='perc".$i."' id='perc".$i."' class='form-control'/>  
				  </td>
				
				
				
				<td><input type='date' name='datecalc".$i."' id='datecalc".$i."' class='form-control'/>  
				  </td>
				 <small>
				<script>
				
				$('#perc".$i."').on('input', function(e) {
                var input = $(this);
                var val = input.val();
                
				
                if (input.data('lastval') != val) {
                input.data('lastval', val);
                var total = (val/100) * ".$dept_fund.";		
                ";
				for($k=0;$k<$listwalletcount;$k++)
				{
				$view .="
				
				$('#wallet_val".$k.$i."').val((total * (".$dept_fundz[$k]."/100)));
				 ";
				} 
				
		$view .= "
               
  				}

	 			});</script>
		  		
		  "; 
				$aa = count($listwallet);
			  
		for($j=0;$j<$aa;$j++){
			 
	  $view .= "
		    	
		  <td><input type='text' name='wallet_".$i."[]' id='wallet_val".$j.$i."' class='form-control'/>
		   
		   </td>
		       
		  ";
		}}
		
     
      $view .= "	
         </tr>
		 "; }
		
		$view .="
         </tbody>
		 </table>
		 </div>
		<input type='submit' name='submitcalculate' id='submitcalculate' class='btn btn-primary' value='Save'/> &nbsp;
	
		";	 }
	
	
$view .= 
"
		
		</div>
		</form>
		
		
";
$view .='
<script type="text/javascript">
    
     $(document).ready(function(){
	function slitData(data){
     		// var res = data.split("wallet_1");
     		var alldata="";
     		for (var i = 0; i < data.length; i++) {
			  
			    alldata+="&"+data[i].value;
			  
			}

     		return alldata;

     	}
     var form = $("#submitcalculatezz");
     console.log(form);
	 $("#submitcalculate").click(function(e){
        e.preventDefault();  
        e.stopPropagation(); 
      
        var data = form.serialize();
		var 
		alldata=data+"&company_id="+'."$company_id".'+"&year="+'."$year".'+"&fund="+'."$fund".'+"&dept_id="+'."$dept_id".'+"&dept_fund="+'."$dept_fund".'+"&payment="+'."$payment".';
        console.log(alldata);
		var countW = document.getElementsByName("wallet_0").length; 
		 $.ajax({
         url: "addcalculation.php",
         type: "POST",
         data: alldata,
         dataType:"json",
         success:function(data){ 
			
          if(data.condition === "Passed"){
			 
			 checkvalidity ("percterrorspan", "#percterrorspan", "#percterror", data.w);
			     
				 var value     = document.getElementById("payment").value;
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
//     			console.log(alldata);
				
			    $.ajax({
        		url:"ajax-getviewcalculation.php",
        		method:"POST",
        		data:alldata,
				
        		success:function(data){
          		$("#showCalculationTable").html(data); 

        }
      });
	
		
          }
		  else
		  {
		  checkvalidity("percterrorspan", "#percterrorspan", "#percterror", data.w);
			 
          }
        }

      });
	
   });

});
	
	
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

//function ShowCalculationTable(){ 
//                      	
//                 var value = document.getElementById("department").value; 
//                 var companyID = document.getElementById("companyy").value; 
//                 var alldata = 
//   			 $calculationObject = new Calculation();
//	             $calculationExist = $calculationObject->searchCalc($company_id, $dept_id , $year);
//               {
//                 department:value,
//                 companyID:companyID
//               };
//     			console.log();
//				$.ajax({
//        		url:"ajax-getviewwallet.php",
//        		method:"POST",
//        		data:alldata,
//				
//        		success:function(data){
//          		$("#showcategoryview").html(data); 
//
//        }
//                    });	} 



</script>
	
';
echo $view;}

?>
