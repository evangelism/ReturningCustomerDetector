<?php

class FaceApi
{
  private $url;
  private $subscriptionKey;
  private $image;

  /**
   * Constructor
   */
  public function __construct($subscriptionKey, $url = "https://northeurope.api.cognitive.microsoft.com/face/v1.0") {
    $this->subscriptionKey = $subscriptionKey;
    $this->url = $url;
  }

  public function getFaces($image)
  {
    $params = array(
      'returnFaceId' => true
    );

    $query = http_build_query($params);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->url . "/detect" . '?' . $query);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $image);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Ocp-Apim-Subscription-Key: ' . $this->subscriptionKey,
        'Content-Type: application/octet-stream',
        'Content-Length: ' . strlen($image)
      )
    );
    $response = curl_exec($ch);

    return $response;
  }

  public function identify(array $faceids, $groupId = "securityapp")
  {
    $data = [
      "faceIds" => $faceids,
      "personGroupId" => $groupId
    ];
    $data = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->url . "/identify");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Ocp-Apim-Subscription-Key: ' . $this->subscriptionKey,
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
      )
    );
    $response = curl_exec($ch);


    return $response;
  }

  public function train($groupId = "securityapp")
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->url . "/persongroups/" . $groupId . "/train");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Ocp-Apim-Subscription-Key: ' . $this->subscriptionKey,
        'Content-Type: application/json',
        'Content-Length: ' . 0
      )
    );
    $response = curl_exec($ch);

    return $response;
  }

  public function createPersonAndFace($faceId, $customerName, $groupId = "securityapp")
  {

    $data = [
      "name" => $customerName,
    ];

    $data = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->url . "/persongroups/" . $groupId . "/persons");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Ocp-Apim-Subscription-Key: ' . $this->subscriptionKey,
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
      )
    );
    $response = curl_exec($ch);

    $personId = json_decode($response)->personId;

    // Assign face

    $image = $this->image;

    $params = [];
    $query = http_build_query($params);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->url . "/persongroups/" . $groupId . "/persons/" . $personId . "/persistedFaces/" . '?' . $query);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $image);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Ocp-Apim-Subscription-Key: ' . $this->subscriptionKey,
        'Content-Type: application/octet-stream',
        'Content-Length: ' . strlen($image)
      )
    );
    $response = curl_exec($ch);

    $this->train($groupId);

    return $response;
  }
}