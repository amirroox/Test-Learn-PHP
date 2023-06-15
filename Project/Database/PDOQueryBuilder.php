<?php
namespace App\Database ;

use PDO;

class PDOQueryBuilder {
    protected string $table ;
    protected PDO $connection;
    protected string $where ;
    public function __construct($connection)
    {
        $this->connection = $connection->Getconnection() ;
    }
    public function table($table): static
    {
        $this->table = $table;
        return $this;
    }
    public function where(string $where): static
    {
        $this->where = "$where";
        return $this;
    }
    public function create(array $data) :int
    {
        $array = $this->ConvertData($data);
        $field = $array['key'] ;
        $value = $array['value'];
        $sql = "INSERT INTO $this->table ($field) VALUES ($value)";
        $stmt= $this->connection->prepare($sql);
        $stmt->execute(array_values($data));
        return $stmt->rowCount();
    }
    public function update(array $data) :int
    {
        $setter = [];
        foreach ($data as $key => $value) $setter[] = $key . "=" . "?" ;
        $setter = implode(',' , $setter);

        $sql = "UPDATE $this->table SET $setter WHERE $this->where";
        $stmt= $this->connection->prepare($sql);
        $stmt->execute(array_values($data));
        return $stmt->rowCount();
    }

    public function delete() :int
    {
        $sql = "Delete from $this->table where $this->where";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function TRUNCATE() :void {
        $tables = $this->connection->prepare("SHOW TABLES");
        $tables->execute();
        foreach ($tables->fetchAll(PDO::FETCH_COLUMN) as $value) {
         $this->connection->prepare("TRUNCATE $value")->execute();
        }
    }
    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }
    public function rollBack(): void
    {
        $this->connection->rollBack();
    }
    private function ConvertData($data) :array {
        $key = implode(',' , array_keys($data));   // n1,n2,n3
        $value = [];
        foreach ($data as $e) $value[] = '?';
        $value = implode(',',$value);     // ?,?,?
        return [
            "key" => $key ,
            "value" => $value
        ];
    }
}
