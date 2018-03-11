<?php

class Users
{
  /**
   * @var PDO
   */
  private $connect;

  /**
   * インスタンスを生成する
   * 
   * @param PDO $connect
   */
  public function __construct($connect)
  {
    $this->connect = $connect;
  }

  /**
   * ユーザの追加
   * 
   * @param string $user_id
   * @param string $user_name
   * @param string $user_icon
   */
  public function addUser($user_id, $user_name, $user_icon)
  {
    $stmt = $this->connect->prepare('INSERT INTO users (user_id, user_name, user_icon) VALUES (:user_id, :user_name, :user_icon)');
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
    $stmt->bindValue(':user_icon', $user_icon, PDO::PARAM_STR);
    $stmt->execute();
  }

  /**
   * UPDATE
   * 
   * @param string $user_id
   * @param string $user_name
   * @param string $user_icon
   */
  public function updateUser($user_id, $user_name, $user_icon)
  {
    $stmt = $this->connect->prepare('UPDATE users set user_name = :user_name , user_icon = :user_icon where user_id =:user_id');
    $stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
    $stmt->bindValue(':user_icon', $user_icon, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();
  }

  /**
   * Get User Info
   * 
   * @param string $user_id
   */
  public function getUserData($user_id)
  {
    $stmt = $this->connect->prepare('SELECT * FROM users WHERE user_id = :user_id');
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return $data;
  }

}