<?php
require_once(__DIR__.'/../src/setting.php');
require_once(__DIR__.'/api/auth/checkLogin.php');
$checkLogin = checkLogin();

var_dump($checkLogin);
var_dump($_SESSION);

if($checkLogin['status'] == 200)
{
  header("Location: {$logined_url}");
}
else{
  $login_url = "https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=$client_id&redirect_uri=$callback_url&state=12345abcde&scope=openid%20profile&nonce=09876xyz";
  header("Location: {$login_url}");
}
?>