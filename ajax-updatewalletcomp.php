<?php
require_once 'core/init.php';
if(Input::exists()){
	
	
	$updatewallet       = escape(Input::get('updatewallet_comp'));
	$walletz            = escape(Input::get('wallet_comp'));
	$weightage          = escape(Input::get('weightage_comp'));
	$desc               = escape(Input::get('desc_comp'));
	$cid                = escape(Input::get('cid'));
    $datecompany_update = escape(Input::get('datecompany_update'));
//	print_r($cid);
	function exists($data){
		if(empty($data)){
			return "Required";
		}else{
			return "Valid";
		}
	}
	
	function weightagecalc($cid,$updatewallet,$weightage){
        $cweiobject = new Walletsetup();
        $datatrue = $cweiobject->searchweightageeditcomp($cid);
        $databaru = $cweiobject->searchWalletID($updatewallet);
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

	function condition($data1, $data2 ,$data3,$data4,$data5){
		if($data1 === "Valid" && $data2 ==="Valid" && $data3 === "Valid" && $data4 === "Valid" && $data5 === "Valid"){
			return "Passed";
		}else{
			return "Failed";
		}
	}
    
	$walletediterrorcomp = exists($walletz);
    $weightediterrorcomp = exists($weightage);
    $descediterrorcomp   = exists($desc);
	$percenterror        = weightagecalc($cid,$updatewallet,$weightage);
	$datecompanyerror    = exists($datecompany_update);
	
	
	if($weightediterrorcomp === "Valid" ){
	
		$percenterror = weightagecalc($cid,$updatewallet,$weightage); }
	else 
	{
		$percenterror ="Required";
	}
	
	$condition = condition($walletediterrorcomp,$weightediterrorcomp,$descediterrorcomp,$percenterror, $datecompanyerror);

	
	if($condition === "Passed"){
		$Walletobject = new Walletsetup();
		$Walletobject->updatewallet(array(
			"wallet"     => $walletz,
			"weightage"  => $weightage,
			"wallt_type" => $desc,
			"tarikh"     => $datecompany_update
		), $updatewallet, "wallet_id");
		
		$Walletobject = new Walletsetup();
		    $Walletobject->addwalletlog(array(
			"wallet_id"    => $updatewallet,
			"wallet"       => $walletz,
			"weightage"    => $weightage,
			"wallt_type"   => $desc,
			"company_id"   => $cid,
			"tarikh"       => $datecompany_update,
			"wallet_type2" => 1,
			"action"       => "Update"
		));
		
		$array = [
			"condition" => $condition
		];
	}
	
	else{
		$array = [
			"condition"  => $condition,
	    	"walletz"    => $walletediterrorcomp,
			"weightage1" => $weightediterrorcomp,
			"desc"       => $descediterrorcomp,
			"weightage"  => $percenterror,
			"datecerr"   => $datecompanyerror
		];
	}

	echo json_encode($array);
}
?>