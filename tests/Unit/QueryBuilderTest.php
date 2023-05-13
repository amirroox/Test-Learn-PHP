<?php

namespace Tests\Unit;

use App\Database\PDOConnection;
use App\Database\PDOQueryBuilder;
use App\Exceptions\NotLoadConfigDataBaseException;
use App\Exceptions\PDONotConnectionException;
use App\Helpers\Config;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase {

    /**
     * @throws NotLoadConfigDataBaseException
     * @throws PDONotConnectionException
     */
    public function testItCanInsertToTable()
    {
        $pdoConnection = new PDOConnection($this->getConnection());
        $QueryBuilder = new PDOQueryBuilder($pdoConnection->connect());
        $data = [
          "name" => "Amir",
          "email" => "AmirRoox@yahoo.com",
          "age" => "21",
          "link" => "https://ro-ox.com",
        ];
        $result = $QueryBuilder->table('Users')->create($data);
        $this->assertIsInt($result);
        $this->assertEquals(1 , $result);
    }

    /**
     * @throws NotLoadConfigDataBaseException
     * @throws PDONotConnectionException
     */
    public function testItCanUpdateToTable(){
        $pdoConnection = new PDOConnection($this->getConnection());
        $QueryBuilder = new PDOQueryBuilder($pdoConnection->connect());
        $data = [
            "name" => "Amir Roox",
            "age" => "20",
        ];
        $result = $QueryBuilder->table('Users')->where("id",1)->update($data);
        $this->assertIsInt($result);
        $this->assertEquals(1 , $result);


    }
    /**
     * @throws NotLoadConfigDataBaseException
     */
    private function getConnection() {
        return Config::GetFileConfigDataBase('DataBase','PDO-Testing');
    }
}
