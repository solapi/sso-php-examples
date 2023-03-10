<?php
$config = require_once(__DIR__ . "/../config.php");
require_once("../lib/sso.php");

$mysiteRedirectPage = $config["mysiteRedirectPage"];
$params = array(
  "accessToken" => "##ACCESS_TOKEN##", // 사이트에 저장할 Access Token
  "redirectUri" => "${mysiteRedirectPage}/dashboard" // 성공 후 리다이렉트할 주소 (Optional)
);

// Access Token을 APP의 사이트에 저장하여 따로 로그인을 하지 않아도 작동 되도록 한다.
print_r(hompage_login($params));
