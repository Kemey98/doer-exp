<?php
require_once 'core/init.php';
if(Input::exists()){
	
	
	$updatewallet = escape(Input::get('updatewallet'));
	$walletz = escape(Input::get('walletz'));
	$weightage = escape(Input::get('weightage'));
	$desc = escape(Input::get('desc'));
	$cid = escape (Input::get('cid'));
	$job_ID = escape(Input::get('job_ID'));
	$dateforposition_update = escape(Input::get('dateforposition_update'));
	
	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

	function weightagecalc($cid,$job_ID,$updatewallet,$weightage){
        
		$cweiobject2 = new Walletsetup();
        
		$datatrue = $cweiobject2->searchweightageeditpost($cid,$job_ID);
        $databaru = $cweiobject2->searchWalletID($updatewallet);
		
		$prevweight = $databaru->weightage;
        
		$sum=0;
             if ($datatrue){
                 foreach ($datatrue as $row ) {
					
                     $sum += $row->weightage;
                 }
             }
//		$count = count ($datatrue);

         $total = ($weightage+$sum)-$prevweight;

        if(($total) > 100){
   		return "Weightage exceed 100%. Current weightage: ".$total."%"; 
//			return $sum; 
        }else{
            return "Valid" ;
        }
    }
	
	function condition($data1,$data2,$data3,$data4,$data5){
		if($data1 === "Valid" && $data2 ==="Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}
    
	$walletediterror = exists($walletz);
    $weightediterror = exists($weightage);
    $descediterror   = exists($desc);
	$percenterror3   = weightagecalc($cid,$job_ID,$updatewallet,$weightage);
	$dateerror       = exists($dateforposition_update);
	
	if($weightediterror === "Valid" ){
	
		$percenterror3 = weightagecalc($cid,$job_ID,$updatewallet,$weightage); }
	else 
	{
		$percenterror3 ="Required";
	}
	
	$condition = condition($walletediterror,$weightediterror,$descediterror,$percenterror3,$dateerror);

	if($condition === "Passed"){
		$Walletobject = new Walletsetup();
		$Walletobject->updatewallet(array(
			"wallet" => $walletz,
			"weightage" => $weightage,
			"wallt_type" => $desc,
			"tarikh" => $dateforposition_update,
		), $updatewallet, "wallet_id");
		
		
		$Walletobject = new Walletsetup();
		$Walletobject->addwalletlog(array(
			"wallet_id"  => $updatewallet,
			"wallet"     => $walletz,
			"weightage"  => $weightage,
			"wallt_type" => $desc,
			"job_ID"     => $job_ID,
			"company_id" => $cid,
			"tarikh"     => $dateforposition_update,
			"wallet_type2" => 3,
			"action"     => "Update"
		));	
		
		$array = [
			"condition" => $condition
		];
	}
	else{
		$array = [
			"condition" => $condition,
	    	"walletz" => $walletediterror,
			"weightage1" => $weightediterror,
			"desc" => $descediterror,
			"weightage" => $percenterror3,
			"date3"  =>$dateerror
			
		];
	}

	echo json_encode($array);
}
?>