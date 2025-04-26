<?php
require_once 'core/init.php';
if(Input::exists()){
  $companyID = escape(Input::get('companyID'));


  $groupObject = new Group();
  $listgroup = $groupObject->searchCompany($companyID);

    
  echo json_encode($listgroup);
}
?>