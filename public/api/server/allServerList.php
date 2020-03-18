<?php
include $_SERVER['DOCUMENT_ROOT'] . "../runtime.php";
include $CONTROLLER_DIR . "/requests/server.php";

$result = (new ServerRequests($DBManager))->fetchAllServerList();
echo json_encode($result);


