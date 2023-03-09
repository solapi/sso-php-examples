<?php
$config = require_once(__DIR__ . "/../config.php");
$domain = $config->domain;
$redirectPage = $config->redirectPage;
require_once("../lib/sso.php");

### Step 1. 앱 아이디와 가입할 회원정보를 이용하여 SSO Token 발급
$params = array(
  "appId" =>  "##APP_ID##", // 회원가입 및 SSO Token의 주체가 되는 앱 아이디
  "email" => "##MEMBER_EMAIL##", // 회원가입에 사용될 이메일 주소
  "password" => "##MEMBER_PASSWORD#", // 회원가입에 사용될 암호
  "customerKey" => "##MEMBER_CUSTOMER_KEY##" // 회원 구분 키 (이미 가입된 회원일 경우 사용되지 않음)
);
// 파라미터 정보로 회원가입을 시킨 후 (이미 있으면 넘어감) SSO Token을 리턴 받는다.
$result = create_sso_token($params);
if ($result->errorCode) {
  print_r($result);
  print_r("\n");
  return;
}
$ssoToken = $result->ssoToken;

### Step 2. 발급받은 SSO Token으로 API 요청
// 발급받은 SSO_TOKEN으로 API 요청이 가능하다 
// 해당 앱에서 이 기능을 호출하는 서버의 IP를 허용하여야 작동 가능하다.
// IP 허용 문의는 사이트에서 관리자에게 문의.
// 호출 가능한 API는 README 파일을 참고해주세요.
$memberInfo = request("GET", "{$domain}/users/v1/member", null, $ssoToken);
print_r($memberInfo);
print_r("\n");

### Extra. SSO Token으로 홈페이지 로그인 처리
// 로그인 후 redirectUri로 리다이렉트 되며 자동으로 로그인 처리가 됩니다.
$params = array(
  "ssoToken" => $ssoToken,
  "redirectUri" => "${redirectPage}/dashboard" // 성공 후 리다이렉트할 주소 (Optional)
);
$loginResult  = hompage_login($params);
print_r($loginResult);
print_r("\n");
