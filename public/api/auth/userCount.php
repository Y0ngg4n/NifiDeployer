<?php
include $_SERVER['DOCUMENT_ROOT'] . "../runtime.php";
include $CONTROLLER_DIR . "/requests/auth.php";

$result = (new AuthRequests($DBManager))->fetchUserCount();
echo json_encode($result);