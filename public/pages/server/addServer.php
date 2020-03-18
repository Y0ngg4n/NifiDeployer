<?php
include $_SERVER['DOCUMENT_ROOT'] . "../runtime.php";
include $CONTROLLER_DIR . "/requests/server.php";
?>
<!doctype html>
<html lang="en">
<head>
    <title>Nifi Deployer × Add Server</title>
    <?php include($TEMPLATES_DIR . "/head/header.php") ?>
</head>
<body>
<div id="main">
    <header id="header">
        <?php include($TEMPLATES_DIR . "/head/navbar.php"); ?>
    </header>

    <div id="content" class="container">
        <form method="post">
            <div class="col text-center">
                <input class="form-control" placeholder="Servername" type="text" name="serverName"/>
                <input class="form-control" placeholder="Hostname" type="text" name="hostName"/>
                <input class="form-control" placeholder="Port" type="number" name="port"/>
                <input class="form-control" placeholder="Username" type="text" name="userName" value="root"/>
                <input class="form-control" placeholder="Password" type="password" name="password"/>
                <textarea class="form-control" placeholder="Certificate" type="text" name="cert"></textarea>
                <button class="btn btn-dark">Add Server</button>
            </div>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //TODO: FIX this if!
            if (!isset($_POST['serverName']) || !isset($_POST['hostName']) || !isset($_POST['port'])
                || empty($_POST['serverName']) || empty($_POST['hostName']) || empty($_POST['port'])) {
                echo "<div class=\"alert alert-warning\" role=\"alert\">Please fill at least Servername, Hostname and Port!</div>";
            } else {
                $password = null;
                $cert = null;
                if (isset($_POST['password']) && !empty($_POST['password']))
                    $password = $_POST['password'];
                if (isset($_POST['cert']) && !empty($_POST['cert']))
                    $cert = $_POST['cert'];

                $result = addServer($_POST['serverName'], $_POST['hostName'], $_POST['port'], $_POST['userName'], $password, $cert);
            }
        }
        ?>
    </div>
</div>
</body>
</html>