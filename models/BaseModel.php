<?php
class BaseModel
{
    protected $table;
    protected $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public  function create($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);
        // $this->logAction('create', json_encode($data));
        return $stmt->execute($data) ? $this->lastInsertedId() : false;
    }

    public  function read($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public  function update($column, $columnValue, $data = [])
    {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= $key . ' = :' . $key . ', ';
        }
        $fields = rtrim($fields, ', ');
        // update the records column by column
        $sql = "UPDATE {$this->table} SET $fields WHERE $column = :columnValue";
        $stmt = $this->conn->prepare($sql);
        $data['columnValue'] = $columnValue; // Assign the column value to the correct placeholder
        return $stmt->execute($data);
    }


    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public   function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE $this->table.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public   function where($column, $value)
    {
        $sql = "SELECT * FROM {$this->table} WHERE $column = :value";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function whereAnd(array $conditions)
    {
        $sql = "SELECT * FROM {$this->table} WHERE ";

        $clauses = [];
        $params = [];

        foreach ($conditions as $column => $value) {
            $clauses[] = "$column = :$column";
            $params[$column] = $value;
        }

        $sql .= implode(' AND ', $clauses);

        $stmt = $this->conn->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public  function lastInsertedId()
    {
        return $this->conn->lastInsertId();
    }

    public function belongsTo($model, $foreignKey)
    {
        // Get the related model's table name
        $relatedModel = new $model();
        $relatedTable = $relatedModel->table;

        // Get the foreign key value from the current instance
        $foreignKeyValue = $this->$foreignKey;

        // Prepare and execute the SQL query to fetch the related record
        $sql = "SELECT * FROM {$relatedTable} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $foreignKeyValue]);

        // Return the fetched record
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function belongsToMany($model, $pivotTable, $foreignKey, $localKey)
    {
        $sql = "SELECT * FROM {$model->table} JOIN $pivotTable ON {$model->table}.id = $pivotTable.$localKey WHERE $pivotTable.$foreignKey = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function has($model, $foreignKey, $localKey)
    {
        $sql = "SELECT * FROM {$model->table} WHERE $foreignKey = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $this->$localKey]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function hasMany($model, $foreignKey)
    {
        $sql = "SELECT * FROM {$model->table} WHERE $foreignKey = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function exists($conditions = [])
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE ";

        $params = [];
        foreach ($conditions as $column => $value) {
            $sql .= "$column = :$column AND ";
            $params[$column] = $value;
        }
        $sql = rtrim($sql, ' AND ');

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchColumn() > 0;
    }

    protected function logAction( $action, $details)
    {
        $userId = $_SESSION['user_id'];
        if ($userId !== null) {
            $log = new Log();
            $log->createLog($userId, $action, $details);
        }
    }
}
