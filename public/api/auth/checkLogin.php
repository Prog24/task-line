<?php
// ログイン確認
session_start();

function checkLogin()
{
  if($_SESSION['accessToken'])
  {
    // アクセストークンを持っている
    if($_SESSION['userId'])
    {
      // ユーザIDを持っている
      require_once(__DIR__.'/../../../src/connect.php');
      require_once(__DIR__.'/../../../src/Users.php');
      $pdo = connect();
      $users = new Users($pdo);
      if($users->getUserData($_SESSION['userId']))
      {
        // 登録済み
        require_once(__DIR__.'/../../../src/Auth.php');
        $auth = new Auth();
        if($auth->checkAccessToken($_SESSION['accessToken']))
        {
          // 有効なアクセストークン
          // ==> 200 OK
          $return = array(
            'status'=>200,
            'pdo'=>$pdo
          );
          return $return;
        }
        else
        {
          // 無効なアクセストークン
          // ==> 400 NG
          $return = array('status'=>400);
          return $return;
        }
      }
      else
      {
        // 未登録
        // ==> 400 NG
        $return = array('status'=>400);
        return $return;
      }
    }
    else
    {
      // ユーザIDを持っていない
      // ==> 400 NG
      $return = array('status'=>400);
      return $return;
    }

  }
  else
  {
    // アクセストークンを持っていない
    // ==> 400 NG
    $return = array('status'=>400);
    return $return;
  }
}