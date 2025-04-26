<?php
require_once 'core/init.php';
if(Input::exists()){
  $userID = escape(Input::get('userID'));

  $user = new User();
  $data = $user->searchOnly($userID);

  $grouparray = array();
  $groupobject = new Group();
  $groupresult = $groupobject->searchGroupInvolve($userID);
  if($groupresult){
    foreach ($groupresult as $row) {
      array_push($grouparray, $row->group_id);
    }
  }

  $array = [
    "id" => $data->userID,
    "firstname" => revertescape($data->firstname),
    "lastname" => revertescape($data->lastname),
    "jobposition" => revertescape($data->jobposition),
    "email" => $data->email,
    "corporateID" => $data->corporateID,
    "companyID" => $data->companyID,
    "role" => $data->role,
    "admin" => $data->admin,
    "becomesupervisor" => $data->becomesupervisor,
    "yoursupervisor" => $data->yoursupervisor,
    "status" => $data->status,
    "grouparray" => $grouparray
  ];


  echo json_encode($array);
}
?>