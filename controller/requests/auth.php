<?php

class AuthRequests
{
    protected $DBManager = null;

    public function __construct($DBManager)
    {
        $this->DBManager = $DBManager;
    }

    public function fetchUserCount(){
        $dbh = $this->DBManager->getDBConnection();
        $stmt = $dbh->prepare("SELECT COUNT(id) FROM users;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_NUM)[0][0];
    }
}
