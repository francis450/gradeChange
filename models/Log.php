<?php

class Log extends BaseModel
{
    protected $table = 'logs';

    public function createLog($userId, $action, $details = '')
    {
        $data = [
            'user_id' => $userId,
            'action' => $action,
            'details' => $details
        ];
        
        return $this->create($data);
    }
}
