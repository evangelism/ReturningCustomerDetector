<?php

include "bootstrap.php";
$data = json_decode($face->getFaces(convertBase64PhotoToBinary($_POST["photo"])));

// Create person
$result = $face->createPersonAndFace($data[0]->faceId, $_POST["name"]);
$data = json_decode($result);

echo "<span style='color: green;'>Customer info stored</span>";
exit;