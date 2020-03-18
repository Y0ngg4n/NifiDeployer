<?php
include $_SERVER['DOCUMENT_ROOT'] . "../runtime.php";
include $CONTROLLER_DIR . "/requests/server.php";

$result = (new ServerRequests($DBManager))->fetchServerList($_GET['searchWord'] ?? "test");
echo json_encode($result);


