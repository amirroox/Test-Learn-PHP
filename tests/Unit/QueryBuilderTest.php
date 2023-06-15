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
        $this->insertToTable(["age"=> "18"]);
        $FakerInfo = new Faker();
        $data = [
            "name" => $FakerInfo->info['Name'],
            "age" => $FakerInfo->info['Age'],
        ];
        $result = $this->QueryBuilder->table('users')->where("age = 18")->update($data);
        $this->assertIsInt($result);
        $this->assertEquals(1 , $result);
    }

    public function testItCanDeleteToTable(){
        $this->insertToTable(["age"=> "18"]);
        $result = $this->QueryBuilder ->table('users')->where("age = 18")->delete();
        $this->assertIsInt($result);
        $this->assertEquals(1 , $result);
    }

    public function sstestItCanReadToTable() {
        $this->multiInsert(10);
//        $result =
    }
    public function tearDown(): void
    {
//        $this->QueryBuilder->TRUNCATE();
        $this->QueryBuilder->rollBack();
        parent::tearDown();
    }

    private function insertToTable($data_add = []) :int
    {
        $FakerInfo = new Faker();
        $data = [
            "name" => $FakerInfo->info['Name'],
            "email" => $FakerInfo->info['Email'],
            "age" => $FakerInfo->info['Age'],
            "link" => $FakerInfo->info['Link'],
        ];
        $data = array_merge($data , $data_add);
        return $this->QueryBuilder->table('users')->create($data);
    }

    private function multiInsert($count = 1){
        for ($i = 0 ; $i <= $count ; $i++) {
            $this->insertToTable();
        }
    }

    /**
     * @throws NotLoadConfigDataBaseException
     */
    private function getConnection() {
        return Config::GetFileConfigDataBase('Database','PDO-Testing');
    }
}
