<?php

class ServerRequests
{
    protected $DBManager = null;

    public function __construct($DBManager)
    {
        $this->DBManager = $DBManager;
    }

    function fetchAllServerList()
    {
        $dbh = $this->DBManager->getDBConnection();
        $stmt = $dbh->prepare("SELECT id,serverName,hostname,port FROM servers ORDER BY serverName ASC;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_NUM);
    }

    function fetchServerList($searchWord)
    {
        $dbh = $this->DBManager->getDBConnection();
        $stmt = $dbh->prepare("SELECT id,serverName,hostname,port FROM servers WHERE servername like :searchWord 
        OR hostname like :searchWord OR port = :searchWordInt ORDER BY serverName ASC;");

        $stmt->bindValue(':searchWord', '%' . $searchWord . '%', PDO::PARAM_STR);
        $stmt->bindValue(':searchWordInt', is_numeric($searchWord) ? intval($searchWord) : 0, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_NUM);
    }

    function fetchServer($uuid)
    {
        $dbh = $this->DBManager->getDBConnection();
        $stmt = $dbh->prepare("SELECT * FROM servers WHERE id=:serverId;");

        $stmt->bindValue(':serverId', $uuid, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_NUM);
    }

    function addServer($serverName, $hostName, $port, $username, $password, $cert)
    {
        $dbh = $this->DBManager->getDBConnection();
        if ($cert == null) {
            $stmt = $dbh->prepare("INSERT INTO servers (servername, hostname, username, password, port) VALUES (:servername, :hostname, :username,:password, :port);");
            $stmt->bindValue(':servername', $serverName, PDO::PARAM_STR);
            $stmt->bindValue(':hostname', $hostName, PDO::PARAM_STR);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $stmt->bindValue(':port', $port, PDO::PARAM_INT);
        } else {
            $stmt = $dbh->prepare("INSERT INTO servers (servername, hostname, username, password, port, cert) VALUES (:servername, :hostname, :username, :password, :port, :cert);");
            $stmt->bindValue(':servername', $serverName, PDO::PARAM_STR);
            $stmt->bindValue(':hostname', $hostName, PDO::PARAM_STR);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $stmt->bindValue(':port', $port, PDO::PARAM_INT);
            $stmt->bindValue(':cert', $cert, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_NUM);
    }
}