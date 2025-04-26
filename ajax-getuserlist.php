<?php
require_once 'core/init.php';
if(Input::exists()){
  $companyID = escape(Input::get('companyIDs'));

print_r($companyID);
  $userObject = new User ();
  $listuserzz = $userObject->searchCompanies($companyID);

    
  echo json_encode($listuserzz);
}
?>