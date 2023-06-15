<?php
namespace Tests\Unit;


use App\Contracts\DataBasesConnectionInterface;
use App\Database\PDOConnection;
use App\Exceptions\NotLoadConfigDataBaseException;
use App\Exceptions\PDONotConnectionException;
use App\Helpers\Config;
use PHPUnit\Framework\TestCase;
use PDO ;

class PDOConnectionTest extends TestCase {

    /**
     * @throws NotLoadConfigDataBaseException
     */
    public function testPDOConnectionImplementsDataBasesConnectionInterface()
    {
        $config = $this->GetConnection();
        $Connection = new PDOConnection($config);
        $this->assertInstanceOf(DataBasesConnectionInterface::class , $Connection);
    }


    /**
     * @throws NotLoadConfigDataBaseException
     * @throws PDONotConnectionException
     */
    public function testConnectionShouldBeConnectToDataBase() {
        $config = $this->GetConnection();
        $pdoConnection = new PDOConnection($config);
        $pdoConnection->connect();
        $this->assertInstanceOf(PDO::class , $pdoConnection->GetConnection());
    }


    /**
     * @throws NotLoadConfigDataBaseException
     * @throws PDONotConnectionException
     */
    public function ChecktestThrowExceptionIfConfigInvalid() {   //Timing Full
        $this->expectException(PDONotConnectionException::class);
        $config = $this->GetConnection();
        $config['host'] = 'Dumm' ;
        $connection = new PDOConnection($config);
        $connection->connect();
    }

    /**
     * @throws NotLoadConfigDataBaseException
     */
    private function GetConnection() {
        return Config::GetFileConfigDataBase('DataBase' , 'PDO-Testing');
    }
}