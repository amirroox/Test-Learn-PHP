<?php
namespace App\Database ;

use PDO;

class PDOQueryBuilder {
    protected string $table ;
    protected PDO $connection;
    protected array $where ;
    public function __construct($connection)
    {
        $this->connection = $connection->Getconnection() ;
    }
    public function table($table): static
    {
        $this->table = $table;
        return $this;
    }
    public function where(string $column ,string $where): static
    {
        $this->where = [
            "column" => $column,
            "where" => $where
        ];
        return $this;
    }
    public function create(array $data) :int
    {
        $array = $this->ConvertData($data);
        $sql = "INSERT INTO $this->table ({$array['key']}) VALUES ({$array['value']})";
        $stmt= $this->connection->prepare($sql);
        $stmt->execute(array_values($data));
        return $stmt->rowCount();
    }
    public function update(array $data) :int
    {
        $setter = [];
        foreach ($data as $key => $value) $setter[] = $key . "=" . "?" ;
        $setter = implode(',' , $setter);

        $sql = "UPDATE $this->table SET $setter WHERE {$this->where['column']} = {$this->where['where']}";
        $stmt= $this->connection->prepare($sql);
        $stmt->execute(array_values($data));
        return $stmt->rowCount();
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
