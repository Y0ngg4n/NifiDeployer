<?php
include $_SERVER['DOCUMENT_ROOT'] . "../runtime.php";
include $CONTROLLER_DIR . "/requests/server.php";

$result = (new ServerRequests($DBManager))->fetchServer($_GET['serverId']);
echo json_encode($result);