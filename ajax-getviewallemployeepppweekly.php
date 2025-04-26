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
	$startdate = escape(Input::get('startdate'));
  $enddate = escape(Input::get('enddate'));
  $selectpppuser = escape(Input::get('selectpppuser'));
  $PPPOOOobject = new Pppoooreport();
  $userobject = new User();
  $view = 
  "
  <ul class='list-group list-group-flush my-3' id='allpppuser'>
  ";
  if($selectpppuser){
    $allppp = $PPPOOOobject->searchOnlyPPPbytimeandyourselfAll($startdate, $enddate, $selectpppuser);
    $username = $userobject->searchOnly($selectpppuser);
    if($username->userID == $resultresult->userID){
      $me = "<span class='badge badge-info'>me</span>";
    }else{
      $me = "";
    }
    if($allppp){
      foreach ($allppp as $row1) {
        $view .= 
        "
        <li class='list-group-item'>
          <div class='row'>
            <div class='col-12 col-xl-6'>".$username->firstname." ".$username->lastname." ".$me."</div>
            <div class='col-12 col-xl-6 text-right'>
              <div class='dropdown'>
                <button type='button' class='btn btn-sm py-0 btn-primary showpppuserdetail' data-id='".$row1->ppp_ID."' data-toggle='modal' data-target='#showpppusermodal'>View PPP</button>
              </div>
            </div>
          </div>
        </li>
        ";
      }
    }else{
      $view .= 
      "
      <li class='list-group-item'>
        <div class='row'>
          <div class='col-12 col-xl-6'>".$username->firstname." ".$username->lastname."</div>
          <div class='col-12 col-xl-6 text-right'>
            <div class='dropdown'>
              <button type='button' class='btn btn-sm py-0 btn-warning'>No PPP created</button>
            </div>
          </div>
        </div>
      </li>
      ";
    }
  }else{
    if($resultresult->corporateID){
      $useresult = $userobject->searchWithCorporate($resultresult->corporateID);
    }else{
      $useresult = $userobject->searchWithCompany($resultresult->companyID);
    }
    if($useresult){
      foreach ($useresult as $row) {
        $allppp = $PPPOOOobject->searchOnlyPPPbytimeandyourselfAll($startdate, $enddate, $row->userID);
        $username = $userobject->searchOnly($row->userID);
        if($username->userID == $resultresult->userID){
          $me = "<span class='badge badge-info'>me</span>";
        }else{
          $me = "";
        }
        if($allppp){
          foreach ($allppp as $row1) {
            $view .= 
            "
            <li class='list-group-item'>
              <div class='row'>
                <div class='col'>".$username->firstname." ".$username->lastname." ".$me."</div>
                <div class='col text-right'>
                  <div class='dropdown'>
                    <button type='button' class='btn btn-sm py-0 btn-primary showpppuserdetail' data-id='".$row1->ppp_ID."' data-toggle='modal' data-target='#showpppusermodal'>View PPP</button>
                  </div>
                </div>
              </div>
            </li>
            ";
          }
        }else{
          $view .= 
          "
          <li class='list-group-item'>
            <div class='row'>
              <div class='col'>".$username->firstname." ".$username->lastname."</div>
              <div class='col text-right'>
                <div class='dropdown'>
                  <button type='button' class='btn btn-sm py-0 btn-warning'>No PPP created</button>
                </div>
              </div>
            </div>
          </li>
          ";
        }
      }
    }
  }
  $view .= 
  "
  </ul>
  ";

  $array = 
  [
    "view" => $view
  ];
	echo json_encode($array);
}
?>