<?php
require_once 'core/init.php';
if(Input::exists()){
	
	
	$updatewallet = escape(Input::get('updatewallet'));
	$walletz = escape(Input::get('walletz'));
	$weightage = escape(Input::get('weightage'));
	$desc = escape(Input::get('desc'));
	$cid = escape (Input::get('cid'));
	$dept_id = escape(Input::get('dept_id'));
	$datedepartment_update = escape(Input::get('datedepartment_update')); 
	
	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}

	function weightagecalc($cid,$dept_id,$updatewallet,$weightage){
        
		$cweiobject2 = new Walletsetup();
        
		$datatrue = $cweiobject2->searchweightageeditdept($cid,$dept_id);
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
	$percenterror2   = weightagecalc($cid,$dept_id,$updatewallet,$weightage);
	$datedepartmenterror   = exists($datedepartment_update);
	
	if($weightediterror === "Valid" ){
	
		$percenterror2 = weightagecalc($cid,$dept_id,$updatewallet,$weightage); }
	else 
	{
		$percenterror2 ="Required";
	}
	
	$condition = condition($walletediterror,$weightediterror,$descediterror,$percenterror2,$datedepartmenterror);

	if($condition === "Passed"){
		$Walletobject = new Walletsetup();
		$Walletobject->updatewallet(array(
			"wallet"     => $walletz,
			"weightage"  => $weightage,
			"wallt_type" => $desc,
			"tarikh"     => $datedepartment_update,
		), $updatewallet, "wallet_id");
		
			$Walletobject = new Walletsetup();
		    $Walletobject->addwalletlog(array(
			"wallet_id"    => $updatewallet,
			"wallet"       => $walletz,
			"weightage"    => $weightage,
			"wallt_type"   => $desc,
			"dept_id"      =>$dept_id,
			"company_id"   => $cid,
			"tarikh"       => $datedepartment_update,
			"wallet_type2" => 2,
			"action"       => "Update"
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
			"weightage" => $percenterror2,
			"datedepartment" =>$datedepartmenterror
			
		];
	}

	echo json_encode($array);
}
?>