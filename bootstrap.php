<?php

include __DIR__ . "/FaceApi.php";
include __DIR__ . "/config.php";

// functions

function convertBase64PhotoToBinary($photoData) {
  $photoData = str_replace("data:image/jpeg;base64,", "", $photoData);
  return base64_decode($photoData);
}

$face = new FaceApi($subscriptionKey);