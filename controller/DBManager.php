<?php

Class DBManager
{

    protected $configFilename = "";
    protected $configDir = "";
    protected $dbConnection = null;
    protected $dbConfig = "";

    protected static $instance = null;

    function __construct($configDir, $configFilename)
    {

        $this->configFilename = $configFilename;
        $this->configDir = $configDir;

        if (self::$instance == null) {
            self::$instance = $this;
        }
        return self::$instance;
    }

    function getDBConnection()
    {
        if ($this->dbConnection) {
            return $this->dbConnection;
        }

        try {
            $configFile = parse_ini_file($this->configDir . "/" . $this->configFilename, true);
            $this->dbConfig = $configFile['Database'];
            //TODO: change PDO::ATTR_EMULATE_PREPARES => false to true
            return $this->dbConnection = new PDO(
                $this->dbConfig['mode'] . ':host=' . $this->dbConfig['host'] .
                ';port=' . $this->dbConfig['port'] .
                ';dbname=' . $this->dbConfig['dbname'] .
                ';sslmode=require' .
                ';sslcert=' . $this->dbConfig['sslcert'] .
                ';sslkey=' . $this->dbConfig['sslkey'] . ';',
                $this->dbConfig['username'], $this->dbConfig['password'], array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => true
            ));
        } catch (Exception $e) {
            print $e->getMessage() . "\r\n";
            return null;
        }
    }

    function createTables()
    {
        $dbh = $this->getDBConnection();
        try {
            $dbh->beginTransaction();
            // This savepoint allows us to retry our transaction.
            $dbh->exec("SAVEPOINT cockroach_restart");
        } catch (Exception $e) {
            throw $e;
        }

        while (true) {
            try {
                $stmt = $dbh->prepare(
                    "CREATE TABLE IF NOT EXISTS servers " .
                    "(id UUID PRIMARY KEY NOT NULL DEFAULT gen_random_uuid(),
                 serverName STRING NOT NULL, 
                 hostname STRING NOT NULL,
                 username STRING NOT NULL DEFAULT 'root',
                 password STRING,
                 cert STRING,
                 port SMALLINT NOT NULL);");
                $stmt->execute();
                $stmt = $dbh->prepare(
                    "CREATE TABLE IF NOT EXISTS containers " .
                    "(id UUID PRIMARY KEY NOT NULL DEFAULT gen_random_uuid(),
                 instanceName STRING NOT NULL DEFAULT 'Main', 
                 containerName STRING NOT NULL DEFAULT 'multiconnector8090_nifi-new_1',
                 port SMALLINT NOT NULL DEFAULT 8090,
                 actions UUID REFERENCES servers(id) ON UPDATE CASCADE ON DELETE CASCADE);");
                $stmt->execute();
                $dbh->commit();
                return;
            } catch (PDOException $e) {
                if ($e->getCode() != '40001') {
                    // Non-recoverable error. Rollback and bubble error up the chain.
                    $dbh->rollBack();
                    throw $e;
                } else {
                    // Cockroach transaction retry code. Rollback to the savepoint and
                    // restart.
                    $dbh->exec('ROLLBACK TO SAVEPOINT cockroach_restart');
                }
            }
        }
    }

    function createPhpAuthTables()
    {
        $dbh = $this->getDBConnection();
        $query = null;
        switch ($this->dbConfig['mode']) {
            default:
                die("Please change Database mode to a valid Database");
                break;
            case "pgsql":
                $query = file_get_contents($this->configDir . "/" . $this->dbConfig['pgsqlPHPAuthFile']);
                break;
            case "mysql":
                $query = file_get_contents($this->configDir . "/" . $this->dbConfig['mysqlPHPAuthFile']);
                break;
            case "sqlite":
                $query = file_get_contents($this->configDir . "/" . $this->dbConfig['sqlitePHPAuthFile']);
                break;
        }
        $dbh->exec($query);
    }

}