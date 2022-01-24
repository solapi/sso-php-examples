<?php
require_once("../lib/sso.php");

$params = array(
  "accessToken" => "##ACCESS_TOKEN##", // 사이트에 저장할 Access Token
  "returnUrl" => "##RETURN_URL##" // 성공 후 리다이렉트할 주소 (Optional)
);

// Access Token을 APP의 사이트에 저장하여 따로 로그인을 하지 않아도 작동 되도록 한다.
print_r(set_oauth2_token("##SSO_TOKEN##", $params));
