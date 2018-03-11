<?php
// ログイン
session_start();
require(__DIR__.'/../../../src/setting.php');
require_once(__DIR__.'/../../../src/connect.php');
require_once(__DIR__.'/../../../src/Auth.php');
require_once(__DIR__.'/../../../src/Users.php');
$auth_code = $_GET['code'];

$pdo = connect();
$auth = new Auth();
$users = new Users($pdo);

if($auth_code)
{
  if($_SESSION['accessToken'])
  {
    // アクセストークンを持っている
    if($auth->checkAccessToken($_SESSION['accessToken']))
    {
      // 有効なアクセストークン
      $profile = $auth->getProfile($_SESSION['accessToken']);
      $_SESSION['userId'] = null;
      $_SESSION['userId'] = $profile['userId'];
      if($users->getUserData($profile['userId']))
      {
        // 登録済み => OK
        $users->updateUser($_SESSION['userId'], $profile['displayName'], $profile['pictureUrl']);
        header("Location: {$logined_url}");
      }
      else
      {
        // 未登録(新規登録) => OK
        $users->addUser($_SESSION['userId'], $profile['displayName'], $profile['pictureUrl']);
        header("Location: {$logined_url}");
      }
    }
    else
    {
      // 無効なアクセストークン
      $_SESSION['accessToken'] = null;
      $_SESSION['accessToken'] = $auth->getAccessToken($auth_code);
      $profile = $auth->getProfile($_SESSION['accessToken']);
      $_SESSION['userId'] = null;
      $_SESSION['userId'] = $profile['userId'];
      if($users->getUserData($_SESSION['userId']))
      {
        // 登録済み => OK
        $users->updateUser($_SESSION['userId'], $profile['displayName'], $profile['pictureUrl']);
        header("Location: {$logined_url}");
      }
      else
      {
        // 未登録(新規登録) => OK
        $users->addUser($_SESSION['userId'], $profile['displayName'], $profile['pictureUrl']);
        header("Location: {$logined_url}");
      }
    }
  }
  else
  {
    // アクセストークンを持っていない
    $_SESSION['accessToken'] = $auth->getAccessToken($auth_code);
    $profile = $auth->getProfile($_SESSION['accessToken']);
    $_SESSION['userId'] = null;
    $_SESSION['userId'] = $profile['userId'];
    if($users->getUserData($_SESSION['userId']))
    {
      // 登録済み => OK
      $users->updateUser($_SESSION['userId'], $profile['displayName'], $profile['pictureUrl']);
      header("Location: {$logined_url}");
    }
    else
    {
      // 未登録(新規登録) => OK
      $users->addUser($_SESSION['userId'], $profile['displayName'], $profile['pictureUrl']);
      header("Location: {$logined_url}");
    }
  }
}
else
{
  // 正規のログインでない => NG
  header("Location: {$base_url}");
}
