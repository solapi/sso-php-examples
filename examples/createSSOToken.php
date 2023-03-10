<?php
require_once("../lib/sso.php");

$params = array(
  "appId" => "##APP_ID##", // 회원가입 및 SSO Token의 주체가 되는 앱 아이디
  "email" => "##MEMBER_EMAIL##", // 회원가입에 사용될 이메일 주소
  "password" => "##MEMBER_PASSWORD#", // 회원가입에 사용될 암호
  "customerKey" => "##MEMBER_CUSTOMER_KEY##" // 회원 구분 키 (이미 가입된 회원일 경우 사용되지 않음)
);

// 파라미터 정보로 회원가입을 시킨 후 (이미 있으면 넘어감) SSO Token을 리턴 받는다.
print_r(create_sso_token($params));
