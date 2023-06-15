<?php

namespace Tests\Unit;

use App\Database\PDOConnection;
use App\Database\PDOQueryBuilder;
use App\Exceptions\NotLoadConfigDataBaseException;
use App\Exceptions\PDONotConnectionException;
use App\Helpers\Config;
use App\Helpers\Faker;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase {

    private PDOQueryBuilder $QueryBuilder;


    /**
     * @throws NotLoadConfigDataBaseException
     * @throws PDONotConnectionException
     */
    public function setUp(): void
    {
        $pdoConnection = new PDOConnection($this->getConnection());
        $this->QueryBuilder = new PDOQueryBuilder($pdoConnection->connect());
        $this->QueryBuilder->beginTransaction();
        parent::setUp();
    }

    public function testItCanInsertToTable()
    {
        $result = $this->insertToTable();
        $this->assertIsInt($result);
        $this->assertEquals(1 , $result);
    }

    public function testItCanUpdateToTable(){
        $this->insertToTable();
        $FakerInfo = new Faker();
        $data = [
            "name" => $FakerInfo->info['Name'],
            "age" => $FakerInfo->info['Age'],
        ];
        $result = $this->QueryBuilder ->table('users')->where("id=1")->update($data);
        $this->assertIsInt($result);
//        $this->assertEquals(1 , $result);
    }

    public function testItCanDeleteToTable(){
        $this->insertToTable();
        $result = $this->QueryBuilder ->table('users')->where("id=1")->delete();
        $this->assertIsInt($result);
//        $this->assertEquals(1 , $result);
    }

    public function tearDown(): void
    {
//        $this->QueryBuilder->TRUNCATE();
        $this->QueryBuilder->rollBack();
        parent::tearDown();
    }

    private function insertToTable() :int
    {
        $FakerInfo = new Faker();
        $data = [
            "name" => $FakerInfo->info['Name'],
            "email" => $FakerInfo->info['Email'],
            "age" => $FakerInfo->info['Age'],
            "link" => $FakerInfo->info['Link'],
        ];
        return $this->QueryBuilder->table('users')->create($data);
    }
    /**
     * @throws NotLoadConfigDataBaseException
     */
    private function getConnection() {
        return Config::GetFileConfigDataBase('Database','PDO-Testing');
    }
}
