<?php

include "bootstrap.php";

$data = json_decode($face->getFaces(convertBase64PhotoToBinary($_POST["photo"])));

if(count($data)) {

  $faceIds = [];
  foreach($data as $_face) {
    $faceIds[] = $_face->faceId;
  }

  $result = $face->identify($faceIds);

  $data = json_decode($result);
  if($data) {

    if(!isset($data[0]->candidates) || count($data[0]->candidates) == 0) {
      echo "This user is unknown (not VIP / returning customer, probably)";
    } else {
      echo "<br /><span style='color: red; font-weight: bold;'>BEWARE! This user might be VIP / returning customer (confidence: ". $data[0]->candidates[0]->confidence . ").</span>";
    }
  }
} else {
  echo "Face not recognized.";
}