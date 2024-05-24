<?php

 class User extends BaseModel
 {
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
 }