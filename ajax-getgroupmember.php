<?php
require_once 'core/init.php';
if(Input::exists()){
    $groupID = escape(Input::get('groupID'));

    $groupobject = new Group();
    $groupname = $groupobject->find($groupID);
    if($groupname){
        $groupname = $groupname->groups;
    }
    $html = "
    <div class='table-responsive-xl'>
      <table class='table table-sm table-hover' id='usersgroupmembership'>
        <thead>
          <tr>
            <th class='align-middle' width='30%'>".$array['firstname']."</th>
            <th class='align-middle' width='30%'>".$array['lastname']."</th>
            <th class='align-middle' width='20%'>".$array['jobposition']."</th>
            <th class='align-middle' width='10%'>".$array['role']."</th>
            <th class='align-middle' width='10%'>".$array['status']."</th>
          </tr>
        </thead>
        <tbody>";
    $groupresult = $groupobject->searchGroupMember($groupID);
    if($groupresult){
        
        $userobject = new User();
        foreach ($groupresult as $row) {
            $userresult = $userobject->searchOnly($row->member_id);
            if($userresult){
                $html .= "
                <tr>
                    <td>".$userresult->firstname."</td>
                    <td>".$userresult->lastname."</td>
                    <td>".$userresult->jobposition."</td>
                    <td>".$userresult->role."</td>
                    <td>".$userresult->status."</td>
                  </tr>
                ";
            }
        }
        $html .= "
            </tbody>
          </table>
        </div>";
    }else{
        $html .= "
        </tbody>
          </table>
        </div>
        <div class='row'>
            <div class='col'>
                <div class='card shadow-sm p-2 text-center'>
                    <i class='fas fa-user my-3' style='font-size:40px;'></i>
                    <h5>".$array['nouserfound']."</h5>
                    <p>".$array['nouserfoundexplain']."</p>
                </div>
            </div>
        </div>";
    }

    $array = [
        "html" => $html,
        "name" => $groupname
    ];


    echo json_encode($array);
}

?>