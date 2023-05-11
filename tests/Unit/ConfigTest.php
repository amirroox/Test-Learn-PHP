<?php
namespace Tests\Unit;
use App\Exceptions\NotLoadConfigDataBaseException;
use \PHPUnit\Framework\TestCase;
use App\Helpers\Config;
class ConfigTest extends TestCase {
    /**
     * @throws NotLoadConfigDataBaseException
     */
    function testValidConfigFile() { # 1
        $this->assertIsArray(Config::ReadFileConfigDataBase('DataBase'));
        $this->assertIsArray(Config::GetFileConfigDataBase("DataBase" , "PDO"));
    }
    function testErrorConfigException() { # 2 - Test Error Handling
        $this->expectException(NotLoadConfigDataBaseException::class);
        $config = Config::ReadFileConfigDataBase("Data");
    }

    /**
     * @throws NotLoadConfigDataBaseException
     */
    function testValidDataConfig() { # 3 - Test Validation Data array
        $config = Config::GetFileConfigDataBase("Database" , "PDO");

        $check = [
            'driver' => 'mysql',
            'host' => 'localhost',
            'Data' => 'ORM-Test-Project',
            'user' => 'root',
            'password' => ''
        ];

        $this->assertEquals($config,$check);
    }
}
