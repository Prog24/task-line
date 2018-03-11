<?php
// タスク削除
// POST
require(__DIR__.'/../../../src/setting.php');
require_once(__DIR__.'/../auth/checkLogin.php');
$checkLogin = checkLogin();
$back_url = $_SESSION['back_url'];

if($checkLogin['status'] == 200)
{
  // ログインOK
  $task_id = $_POST['task_id'];
  if($task_id)
  {
    // タスクIDあり
    require_once(__DIR__.'/../../../src/Tasks.php');
    $tasks = new Tasks($checkLogin['pdo']);
    $tasks->deleteTask($task_id);
    header("Location: {$back_url}");
  }
  else
  {
    // タスクIDなし
    header("Location: {$error_400}");
  }
}
else
{
  // ログインNG
  header("Location: {$error_400}");
}