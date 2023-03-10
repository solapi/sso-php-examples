<?php
require_once("../lib/sso.php");

// 홈페이지 인증을 위한 SSO Code 발급요청
print_r(get_sso_code('##SSO_TOKEN##'));
