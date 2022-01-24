<?php
require_once("../lib/sso.php");

// 발급받은 SSO_TOKEN으로 Access Token을 발급받는다.
// 해당 앱에서 이 기능을 호출하는 서버의 IP를 허용하여야 작동 가능하다.
// IP 허용 문의는 사이트에서 관리자에게 문의.
print_r(get_oauth2_token('##SSO_TOKEN##'));
