<?php
namespace App\Database ;

use PDO;

class PDOQueryBuilder {
    protected string $table ;
    protected PDO $connection;
    public function __construct($connection)
    {
        $this->connection = $connection->Getconnection() ;
    }

    public function table($table): static
    {
        $this->table = $table;
        return $this;
    }

    public function create(array $data) :int
    {
        $key = implode(',' , array_keys($data));
        $value = [];
        foreach ($data as $datum) $value[] = '?';
        $value = implode(',',$value);
        $sql = "INSERT INTO {$this->table} ({$key}) VALUES ({$value})";
        $stmt= $this->connection->prepare($sql);
        $stmt->execute(array_values($data));
        return $stmt->rowCount();
    }
}
