<?php
require_once("../lib/sso.php");


### Step 1. 앱 아이디와 가입할 회원정보를 이용하여 SSO Token 발급
$params = array(
  "appId" =>  "##APP_ID##", // 회원가입 및 SSO Token의 주체가 되는 앱 아이디
  "email" => "##MEMBER_EMAIL##", // 회원가입에 사용될 이메일 주소
  "password" => "##MEMBER_PASSWORD#", // 회원가입에 사용될 암호
  "customerKey" => "##MEMBER_CUSTOMER_KEY##" // 회원 구분 키 (이미 가입된 회원일 경우 사용되지 않음)
);
// 파라미터 정보로 회원가입을 시킨 후 (이미 있으면 넘어감) SSO Token을 리턴 받는다.
print_r(create_sso_token($params));


### Step 2. 발급받은 SSO Token으로 Access Token 발급
// 발급받은 SSO_TOKEN으로 Access Token을 발급받는다.
// 해당 앱에서 이 기능을 호출하는 서버의 IP를 허용하여야 작동 가능하다.
// IP 허용 문의는 사이트에서 관리자에게 문의.
print_r(get_oauth2_token('##SSO_TOKEN##'));


### Step3. 발급받은 Access Token을 앱 사이트에 저장하여 로그인 처리
$params = array(
  "accessToken" => "##ACCESS_TOKEN##", // 사이트에 저장할 Access Token
  "returnUrl" => "##RETURN_URL##" // 성공 후 리다이렉트할 주소 (Optional)
);
// Access Token을 APP의 사이트에 저장하여 따로 로그인을 하지 않아도 작동 되도록 한다.
print_r(set_oauth2_token("##SSO_TOKEN##", $params));
