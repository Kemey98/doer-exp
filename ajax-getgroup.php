<?php
require_once 'core/init.php';
if(Input::exists()){
  $groupID = escape(Input::get('groupID'));

  $group = new Group();
  $data = $group->find($groupID);




    $array = [
      "id" => $data->groupID,
      "group" => revertescape($data->groups),
      "type" => $data->type,
      "status" => $data->status,
      "leader" => $data->leaderID,
      "corporateID" => $data->corporateID,
      "companyID" => $data->companyID,
      "parentID" => $data->parentID
    ];


  echo json_encode($array);
}
?>