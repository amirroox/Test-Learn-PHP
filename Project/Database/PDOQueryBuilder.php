<?php
namespace App\Database ;

use PDO;

class PDOQueryBuilder {
    protected string $table ;
    protected PDO $connection;
    protected string $where = '1' ;
    protected string $limit = '' ;
    protected string $orderBy = '' ;
    public function __construct($connection)
    {
        $this->connection = $connection->Getconnection() ;
    }
    public function table($table): static
    {
        $this->table = $table;
        return $this;
    }
    public function where(array $where = ["1" => "1"]): static
    {
        $field = "" ;
        $element = 0 ;
        $endElement = count($where);
        foreach ($where as $key => $value) {
            $element++;
            $field .= "$key = '$value' " ;
            if ($element != $endElement) $field .= " AND ";
        }
        $this->where = "$field";
        return $this;
    }
    public function create(array $data) :int
    {
        $array = $this->ConvertData($data);
        $field = $array['key'] ;
        $value = $array['value'];
        $sql = "INSERT INTO $this->table ($field) VALUES ($value)";
        return $this->execute($sql , array_values($data))->rowCount();
    }
    public function update(array $data) :int
    {
        $setter = [];
        foreach ($data as $key => $value) $setter[] = $key . " = " . "?" ;
        $setter = implode(',' , $setter);

        $sql = "UPDATE $this->table SET $setter WHERE $this->where";

        return $this->execute($sql , array_values($data))->rowCount();
    }

    public function delete() :int
    {
        $sql = "Delete from $this->table where $this->where";
        return $this->execute($sql)->rowCount();
    }

    public function select($data = "*"): false|array
    {
        $sql = "SELECT $data FROM $this->table WHERE $this->where $this->orderBy $this->limit" ;
        return $this->execute($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function limit($lim = ''): static
    {
        if(empty($lim)) $this->limit = '' ;
        else $this->limit = "LIMIT $lim" ;
        return $this;
    }
    public function orderBy($order = 'id' , $asc = 'ASC') :static
    {
        $this->orderBy = "ORDER BY $order $asc";
        return $this;
    }
    private function execute($sql , $date = null): \PDOStatement|false
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($date);
        return $stmt;
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