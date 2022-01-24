<?php
require_once(__DIR__ . "/../config.php");
$config = get_config();

function get_header($ssoToken) {
  if ($ssoToken) {
    return "Authorization: sso $ssoToken";
  }
  global $config;
  $apiKey = $config["apiKey"];
  $apiSecret = $config["apiSecret"];
  date_default_timezone_set('Asia/Seoul');
  $date = date('Y-m-d\TH:i:s.Z\Z', time());
  $salt = uniqid();
  $signature = hash_hmac('sha256', $date.$salt, $apiSecret);
  return "Authorization: HMAC-SHA256 apiKey={$apiKey}, date={$date}, salt={$salt}, signature={$signature}";
}

function request($method, $resource, $data = false, $ssoToken = null) {
  global $config;
  $url = "{$config['protocol']}://{$config['domain']}";
  if ($config['prefix']) $url .= $config['prefix'];
  $url .= $resource;

  try {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    switch ($method) {
      case "POST":
      case "PUT":
      case "DELETE":
        if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        break;
      default: // GET
        if ($data) $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(get_header($ssoToken), "Content-Type: application/json"));
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    if (curl_error($curl)) {
      print curl_error($curl);
    }
    $result = curl_exec($curl);
    curl_close($curl);
    return json_decode($result);
  } catch (Exception $err) {
    return $err;
  }
}

function get_sso_token($appId, $customerKey) {
  return request("GET", "/appstore/v2/sso/apps/$appId/customer-keys/$customerKey");
}

function create_sso_token($params) {
  return request("POST", "/appstore/v2/sso/connect", $params);
}

function get_oauth2_token($ssoToken) {
  return request("GET", "/appstore/v2/sso/issue-oauth2-token", false, $ssoToken);
}

function set_oauth2_token($ssoToken, $params) {
  return request("POST", "/appstore/v2/sso/connect-homepage", $params, $ssoToken);
}

