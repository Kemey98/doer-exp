<?php
require_once 'core/init.php';
if(Input::exists()){
  $companyID = escape(Input::get('companyID'));
  

  $walletObject = new Walletsetup();
  $walletlist = $walletObject->searchweightagebonus($companyID);

    
  echo json_encode($walletlist);
}
?>