<?php include $_SERVER['DOCUMENT_ROOT'] . "../runtime.php" ?>
<!doctype html>
<html lang="en">
<head>
    <title>Nifi Deployer × Manage Server</title>
    <?php include($TEMPLATES_DIR . "/head/header.php") ?>
</head>
<body>
<div id="main">
    <header id="header">
        <?php include($TEMPLATES_DIR . "/head/navbar.php"); ?>
    </header>
    <div id="content">
        <form action="manage/editService.php" method="post">
            <input type="hidden" name="serverId" value="<?= $_GET['serverId'] ?>"/>
            <?php
            ob_start();
            include $API_DIR . "/server/serverDetails.php";
            $serverDetails = ob_get_contents();
            ob_end_clean();
            $serverDetails = json_decode($serverDetails, true)[0];
            echo "<input type=\"hidden\" name=\"serverName\" value=\"" . $serverDetails[1] . "\">";
            echo "<input type=\"hidden\" name=\"hostName\" value=\"" . $serverDetails[2] . "\">";
            echo "<input type=\"hidden\" name=\"userName\" value=\"" . $serverDetails[3] . "\">";
            echo "<input type=\"hidden\" name=\"password\" value=\"" . $serverDetails[4] . "\">";
            echo "<input type=\"hidden\" name=\"cert\" value=\"" . $serverDetails[5] . "\">";
            echo "<input type=\"hidden\" name=\"port\" value=\"" . $serverDetails[6] . "\">";
            ?>
            <button class="btn btn-dark" type="submit">Edit Service</button>
        </form>
    </div>
</body>
</html>