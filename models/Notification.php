<?php

class Notification extends BaseModel
{
    protected $table = 'notifications';

    public function __construct()
    {
        parent::__construct();
    }

    public function getUnreadNotifications($userId)
    {
        $sql = "SELECT * FROM $this->table WHERE user_id = :user_id AND is_read = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}