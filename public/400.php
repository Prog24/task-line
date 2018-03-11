<?php
require(__DIR__.'/../src/setting.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>Task LINE - 400 ERROR</title>
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
      <div class="error-code">400 ERROR</div>
      <div class="error-content">
        何かがおかしくありませんか？<br>
        <a href="<?php echo $base_url ?>">Topページ</a>に戻ることをオススメします
      </div>
    </div>
  </div>
</body>
</html>