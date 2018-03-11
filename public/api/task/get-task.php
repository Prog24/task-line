<?php
// ユーザのタスク取得（ステータス指定）

session_start();

function getTask($pdo, $user_id, $status)
{
  if($pdo)
  {
    // PDOあり
    require(__DIR__.'/../../../src/setting.php');
    require_once(__DIR__.'/../../../src/Users.php');
    $users = new Users($pdo);
    $profile = $users->getUserData($user_id);
    if($profile)
    {
      // ユーザあり
      require_once(__DIR__.'/../../../src/Tasks.php');
      $tasks = new Tasks($pdo);
      $task_data = $tasks->getTask($user_id, $status);
      return $task_data;
    }
    else
    {
      // ユーザなし
      header("Location: {$error_400}");
    }
  }
  else
  {
    header("Location: {$error_400}");
  }
}