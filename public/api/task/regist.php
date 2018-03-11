<?php
// タスク登録
// POST
require(__DIR__.'/../../../src/setting.php');
require_once(__DIR__.'/../auth/checkLogin.php');
$checkLogin = checkLogin();

if($checkLogin['status'] == 200)
{
  // ログインOK
  $task_name = $_POST['task_name'];
  $status = 1;
  if($task_name)
  {
    // タスク名有り
    require_once(__DIR__.'/../../../src/Tasks.php');
    $tasks = new Tasks($checkLogin['pdo']);
    $tasks->newTask($task_name, $_SESSION['userId'], $status);
    header("Location: {$logined_url}");
  }
  else
  {
    // タスク名無し
    header("Location: {$error_400}");
  }
  
}
else
{
  // ログインNG
  header("Location: {$error_400}");
}