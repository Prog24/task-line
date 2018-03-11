<?php
// ログアウト
session_start();
require(__DIR__.'/../../../src/setting.php');
require_once(__DIR__.'/../../../src/Auth.php');

$auth = new Auth();
$auth->revokeAccessToken($_SESSION['accessToken']);
$_SESSION['accessToken'] = null;
$_SESSION['userId'] = null;
header("Location: {$base_url}");