<?php
$config = require(__DIR__ . "/../config.php");
$domain = $config["domain"];
$mysiteRedirectPage = $config["mysiteRedirectPage"];
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

### Step 2. SSO Token으로 SSO Code 발급
// 허용된 IP에서만 작동합니다.
// 홈페이지 로그인에 필요한 SSO Code값을 발급받기 위한 코드입니다.
$ssoCodeResult = get_sso_code($ssoToken);
$ssoCode = $ssoCodeResult->ssoCode;
print_r($ssoCodeResult);
print_r("\n");

### Step 3. SSO Token으로 홈페이지 로그인 처리
// 로그인 후 redirectUri로 리다이렉트 되며 자동으로 로그인 처리가 됩니다.
$params = array(
  "ssoCode" => $ssoCode,
  "redirectUri" => "${mysiteRedirectPage}/dashboard" // 성공 후 리다이렉트할 주소 (Optional)
);
$loginResult = hompage_login($params);
print_r($loginResult);
print_r("\n");

### 아래처럼 브라우저에서 직접 요청할수도 있습니다. 
// https://##마이사이트 주소##/api/appstore/v2/sso/connect-homepage?redirectUri=##마이사이트 주소##/dashboard&ssoCode=##SSO Code##
// print_r("{$mysiteRedirectPage}/api/appstore/v2/sso/connect-homepage?redirectUri={$mysiteRedirectPage}/dashboard&ssoCode={$ssoCode}");
// print_r("\n");
