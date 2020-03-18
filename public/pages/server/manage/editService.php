<!doctype html>
<html lang="en">
<head>
    <title>Nifi Deployer × Edit Service</title>
    <?php include($TEMPLATES_DIR . "/head/header.php") ?>
</head>
<body>

<div id="main">
    <header id="header">
        <?php include($TEMPLATES_DIR . "/head/navbar.php"); ?>
    </header>
    <?php
    include("sshConnection.php");
    echo implode(",", $_POST);
    connectSSHToServer($_POST['hostName'], $_POST['port'], $_POST['userName'], $_POST['password']);
    ?>
</div>


</body>
</html>