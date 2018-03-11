<?php

// ユーザのタスク全件取得
// @param $pdo, $user_id
session_start();

function getAllTask($pdo, $user_id)
{
  if($pdo)
  {
    // pdoあり
    require(__DIR__.'/../../../src/setting.php');
    require_once(__DIR__.'/../../../src/Users.php');
    $users = new Users($pdo);
    $profile = $users->getUserData($user_id);
    if($profile)
    {
      // ユーザ有り
      require_once(__DIR__.'/../../../src/Tasks.php');
      $tasks = new Tasks($pdo);
      $task_data = $tasks->getAllTask($user_id);
      return $task_data;
    }
    else
    {
      // ユーザ無し(不正アクセス)
      header("Location: {$error_400}");
    }
  }
  else
  {
    header("Location: {$error_400}");
  }
}