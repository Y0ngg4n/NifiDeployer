<?php include $_SERVER['DOCUMENT_ROOT'] . "../runtime.php" ?>
<!doctype html>
<html lang="en">
<head>
    <title>Nifi Deployer × Server List</title>
    <?php include($TEMPLATES_DIR . "/head/header.php") ?>
    <script type="application/javascript" src="<?= $JS_WEB_PATH ?>/actions/server.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= $CSS_WEB_PATH ?>/pages/serverList.css">
</head>
<body>
<div id="main">
    <header id="header">
        <?php include($TEMPLATES_DIR . "/head/navbar.php"); ?>
    </header>

    <div id="content">
        <div class="input-group">
            <input type="text" onchange="getServer()" class="form-control" id="searchWord" placeholder="Search...">
            <form action="pages/server/addServer.php">
                <button class="btn btn-dark input-group-append">Add Server</button>
            </form>
        </div>
        <table class="table">
            <thead class="thead-dark">
            <trow>
                <th scope="col">#</th>
                <th scope="col">ID</th>
                <th scope="col">Servername</th>
                <th scope="col">Hostname</th>
                <th scope="col">Port</th>
            </trow>
            </thead>
            <tbody id="serverListTable">
            </tbody>
        </table>
    </div>
    <script>getAllServer()</script>
</div>
</body>
</html>