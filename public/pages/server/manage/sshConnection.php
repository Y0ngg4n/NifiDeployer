<?php
function connectSSHToServer($hostname, $port, $username, $password){
    $session = ssh2_connect($hostname, $port);
    $connection = ssh2_auth_password ($session , $username , $password);
    if ($connection) {
        echo "Authentication Successful!";
        echo ssh2_exec($connection, "ls");
    } else {
        echo('Authentication Failed...');
    }
}
