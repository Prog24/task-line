<?php
// タスクのアップデート
session_start();
require(__DIR__.'/../../../src/setting.php');
require_once(__DIR__.'/../auth/checkLogin.php');
$checkLogin = checkLogin();

if($checkLogin['status'] == 200)
{
  // ログインOK
  $task_id = (int)$_POST['task_id'];
  $task_status = (int)$_POST['task_status'];
  $back_url = $_SESSION['back_url'];
  if($task_id)
  {
    if($task_status)
    {
      // OK
      var_dump($task_id);
      var_dump($task_status);
      require_once(__DIR__.'/../../../src/Tasks.php');
      $tasks = new Tasks($checkLogin['pdo']);

      $task_data = $tasks->getTaskData($task_id);
      if($task_data['user_id'] == $_SESSION['userId'])
      {
        // ユーザのものだよ
        $tasks->updateTask($task_id, $task_status);
        header("Location: {$back_url}");
      }
      else
      {
        // 他のユーザからの要求(不正)
        echo "他のユーザからのアクセス";
        header("Location: {$error_400}");
      }
    }
    else
    {
      echo "ステータスなし";
      // 新しいステータスなし
      header("Location: {$error_400}");
    }
  }
  else
  {
    echo "タスクIDなし";
    // タスクIDなし
    header("Location: {$error_400}");
  }
}
else
{
  echo "ログインNG";
  // ログインNG
  header("Location: {$error_400}");
}
