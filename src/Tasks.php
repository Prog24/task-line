<?php

class Tasks
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
   * New Task
   * 
   * @param string $task_name
   * @param string $user_id
   * @param int $status
   * 
   * @return int $return
   */
  public function newTask($task_name, $user_id, $status)
  {
    $stmt = $this->connect->prepare('INSERT INTO tasks (task_name, user_id, status) VALUES (:task_name, :user_id, :status)');
    $stmt->bindValue(':task_name', $task_name, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindValue(':status', $status, PDO::PARAM_INT);
    $stmt->execute();
  }

  /**
   * Update Task
   * 
   * @param int $id(task_id)
   * @param int $status
   * 
   * @return int $return
   */
  public function updateTask($id, $status)
  {
    $stmt = $this->connect->prepare('UPDATE tasks set status =:status WHERE id =:id');
    $stmt->bindValue(':status', $status, PDO::PARAM_INT);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  /**
   * Delete Task(使用しない？)
   * 
   * @param int $id(task_id)
   * 
   * @return int $return
   */
  public function deleteTask($id)
  {
    $stmt = $this->connect->prepare('DELETE FROM tasks WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  /**
   * Get All Tasks
   * 
   * @param string $user_id
   * 
   * @return any $taskss
   */
  public function getAllTask($user_id)
  {
    $stmt = $this->connect->prepare('SELECT * FROM tasks WHERE user_id = :user_id');
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $data;
  }

  /**
   * Get Task Status
   * 
   * @param string $user_id
   * @param int $status
   * 
   * @return any $tasks
   */
  public function getTask($user_id, $status)
  {
    $stmt = $this->connect->prepare('SELECT * FROM tasks WHERE user_id = :user_id AND status = :status');
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $data;
  }

  /**
   * Get Task Data
   * 
   * @param int $id
   */
  public function getTaskData($id)
  {
    $stmt = $this->connect->prepare('SELECT * FROM tasks WHERE id = :id');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return $data;
  }

}