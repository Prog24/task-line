<?php
session_start();
require(__DIR__.'/../src/setting.php');
require_once(__DIR__.'/api/auth/checkLogin.php');
$checkLogin = checkLogin();
?>
<?php if($checkLogin['status'] == 200): ?>
<?php header("Location: {$logined_url}") ?>
<?php else: ?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>Task LINE - TOP</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,user-scalable=0">
<link rel="stylesheet" href="css/reset.css">
<link rel="stylesheet" href="css/error.css">
</head>
<body>
  <header>
    <div id="title" class="w500">Task LINE</div>
  </header>
  <div id="content">
    <div id="main-content">
      <a href="./login.php">ログインページ</a>
    </div>
  </div>
</body>
</html>
<?php endif; ?>