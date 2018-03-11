<?php
session_start();
require(__DIR__.'/../src/setting.php');
require_once(__DIR__.'/api/auth/checkLogin.php');
$checkLogin = checkLogin();
?>
<?php if($checkLogin['status'] == 200) : ?>

<?php
$_SESSION['back_url'] = "{$public_url}logined.php";
require_once(__DIR__.'/../src/Users.php');
$users = new Users($checkLogin['pdo']);
$profile = $users->getUserData($_SESSION['userId']);

// タスクの取得
require_once(__DIR__.'/api/task/get-all.php');
$tasks = getAllTask($checkLogin['pdo'], $_SESSION['userId']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>Task LINE - 全てのタスク</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width,user-scalable=0">
<link rel="stylesheet" href="css/reset.css">
<link rel="stylesheet" href="css/base.css">
<link rel="stylesheet" href="css/modal-multi.css">
</head>
<body>
  <header>
    <div id="title" class="w500">Task LINE</div>
    <div id="user-icon"><img src="<?php echo $profile['user_icon'] ?>"></div>
    <div id="new-task"><a href="#" class="modal-link" data-target="newtask">タスクの追加</a></div>
  </header>
  <div id="content">
    <div id="main-content">
      <div class="check-list">
        全て　-　<a href="./doing.php">未完了</a>　-　<a href="./done.php">完了済み</a>
      </div>
      <div class="table">
        <?php foreach($tasks as $task): ?>
          <?php if($task['status'] == 1): ?>
          <a  class="modal-link" data-target="<?php echo $task['id'] ?>">
            <div class="line">
              <?php echo $task['task_name'] ?>
            </div>
          </a>
          <?php else: ?>
          <a  class="modal-link" data-target="<?php echo $task['id'] ?>">
            <div class="line done">
              <?php echo $task['task_name'] ?>
            </div>
          </a>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
      <div class="logout">
        <a href="./api/auth/logout.php">- ログアウト -</a>
      </div>
    </div>
  </div>
  
  <!-- タスク追加 [開始] -->
  <div id="newtask" class="modal-content">
    <div class="title">タスクの追加</div>
    <form name="newtask" action="./api/task/regist.php" method="post">
      <div class='text-field'>
        <input type='text' name="task_name" onfocus='this.classList.add("focused")' />
        <label>Task</label>
      </div>

      <div class="buttons">
        <a href="./api/task/regist.php" onclick="document.newtask.submit();return false;" class="square_btn new">追加</a>
        <a href="#" id="modal-close" class="square_btn new-close">閉じる</a>
      </div>
    </form>
  </div>
  <!-- タスク追加 [終了] -->

  <!-- タスクをクリック時　[開始] -->
  <?php foreach($tasks as $task): ?>
    <div id="<?php echo $task['id'] ?>" class="modal-content">
      <div class="title">タスクの編集</div>
      <div>
        <?php echo $task['task_name'] ?>
      </div>

      <div class="buttons">
        <!-- 削除ボタン -->
        <form class="delete-form" name="delete<?php echo $task['id'] ?>" action="./api/task/delete.php" method="post">
          <input type="hidden" name="task_id" value="<?php echo $task['id'] ?>">
          <a href="./api/task/delete.php"  onclick="document.delete<?php echo $task['id'] ?>.submit();return false;" class="square_btn delete">　削除　</a>
        </form>
        <!-- 更新ボタン [開始] -->
        <form class="update-form" name="update<?php echo $task['id'] ?>" action="./api/task/update-task.php" method="post">
          <?php
          // $new_status = 1;
          if($task['status'] == 1){
            $new_status = 2;
          }else{
            $new_status = 1;
          }
          ?>
          <input type="hidden" name="task_id" value="<?php echo $task['id'] ?>">
          <input type="hidden" name="task_status" value="<?php echo $new_status ?>">
          <?php if($task['status'] == 1): ?>
          <a href="./api/task/update-task.php"  onclick="document.update<?php echo $task['id'] ?>.submit();return false;" class="square_btn done">　完了　</a>
          <?php else: ?>
          <a href="./api/task/update-task.php"  onclick="document.update<?php echo $task['id'] ?>.submit();return false;" class="square_btn">未完了</a>
          <?php endif; ?>
        </form>
        <!-- 更新ボタン [終了] -->
      </div>
      <div class="buttons">
        <a href="#" id="modal-close" class="square_btn close">閉じる</a>
      </div>
    </div>
  <?php endforeach; ?>
  <!-- タスクをクリック時　[終了] -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="js/modal-multi.js"></script>
</body>
</html>
<?php else : ?>
<?php header("Location: {$error_400}") ?>
<?php endif ; ?>