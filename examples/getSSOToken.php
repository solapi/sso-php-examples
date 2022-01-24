<?php
require_once("../lib/sso.php");

// create_sso_token 에서 발급받은 Member ID와 Customer Key로 SSO Token을 조회한다.
print_r(get_sso_token('##MEMBER_ID##', '##CUSTOMER_KEY##'));
