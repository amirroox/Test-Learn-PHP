<?php
namespace App\Database ;

use App\Contracts\DataBasesConnectionInterface ;
use App\Exceptions\PDONotConnectionException;
use PDO;
use PDOException;

class PDOConnection implements DataBasesConnectionInterface {
    protected array $config;
    protected PDO $connection;
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @throws PDONotConnectionException
     */
    public function connect(): static
    {
        $dsn = $this->getConfigToPart();
        try {
            $this->connection = new PDO(...$dsn);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            throw new PDONotConnectionException($e->getMessage());
        }
        return $this;
    }
    public function GetConnection(): PDO
    {
        return $this->connection;
    }

    private function getConfigToPart(): array
    {
        $dsn = "{$this->config['driver']}:host={$this->config['host']};dbname={$this->config['dbname']}";
        return [$dsn , $this->config['user'] , $this->config['password']];
    }
}
