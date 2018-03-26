<?php

include "bootstrap.php";

$data = json_decode($face->getFaces(convertBase64PhotoToBinary($_POST["photo"])));
if(isset($data[0])) {
  $result = $face->identify($data[0]->faceId);
  $data = json_decode($result);
  if($data) {

    if(!isset($data[0]->candidates) || count($data[0]->candidates) == 0) {
      echo "This user is unknown (not VIP / returning customer, probably)";
    } else {
      echo "<span style='color: red; font-weight: bold;'>BEWARE! This user might be VIP / returning customer (confidence: ". $data[0]->candidates[0]->confidence . ").</span>";
    }
  }
} else {
  echo "Face not recognized.";
}