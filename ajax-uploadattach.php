<?php
require_once 'core/init.php';

if(isset($_FILES['customFile'])){
  $num = count($_FILES['customFile']['name']);
  $files = [];
  $names = [];
  $types = [];
  for ($i=0; $i < $num; $i++) { 
    $names[$i] = $_FILES['customFile']['name'][$i];
    $types[$i] = $_FILES['customFile']['type'][$i];
    $files[$i] = file_get_contents($_FILES['customFile']['tmp_name'][$i]);
  }

  $ppp121reportobject = new Ppp121report();
  $report = json_decode($_POST['data']);


  if($report->reporttype === "PPP"){
    for ($i=0; $i < $num; $i++) { 
      $ppp121reportobject->submitPPPattach(array(
        "pppID" => $report->reportID,
        "name" => $names[$i],
        "type" => $types[$i],
        "attachment" => $files[$i]
      ));
    }
  }else{
    for ($i=0; $i < $num; $i++) { 
      $ppp121reportobject->submit121attach(array(
        "121ID" => $report->reportID,
        "name" => $names[$i],
        "type" => $types[$i],
        "attachment" => $files[$i]
      ));
    }
  }

  $array = [
    "array" => $files,
    "id" => $report->reportID,
    "type" => $report->reporttype
  ];

}else{
  $file = "No";
}

?>


