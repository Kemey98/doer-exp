<?php
require_once 'core/init.php';
if(Input::exists()){
	
  $companyID = escape(Input::get('companyID'));
  $year      = escape(Input::get('year'));

  $mainallocateObject = new Mainallocation();
//  $calculationObject = new Calculation();
//  $exist = $calculationObject->searchTrue($companyID,$year);	
	
  $funds = $mainallocateObject->searchFund($companyID, $year);
if($funds){
	foreach($funds as $row) {
    $value = $row -> budgetAllocated;
	}

}
   
  echo json_encode($value);
}
?>