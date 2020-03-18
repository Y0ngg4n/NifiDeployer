<?php

include $_SERVER['DOCUMENT_ROOT'] . "../runtime.php";
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
        <?php
        $auth = new \Delight\Auth\Auth($DBManager->getDBConnection());

        ob_start();
        include $API_DIR . "/auth/userCount.php";
        $userCount = ob_get_contents();
        ob_end_clean();
        $userCount = json_decode($userCount, true);
        if ($userCount <= 0) {
            echo <<<EOF
<h1  class="text-center">Create First Admin User</h1>
<form method="post">
    <div class="col text-center">
         <input class="form-control" placeholder="Email" type="email" name="email"/>
         <input class="form-control" placeholder="Username" type="text" name="userName"/>
         <input class="form-control" placeholder="Password" type="password" name="password"/>
         <button class="btn btn-dark" type="submit">Register</button>
    </div>
</form>
EOF;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo "POST";
            try {
                $userId = $auth->register($_POST['email'], $_POST['password'], $_POST['userName'], function ($selector, $token) {
//                    echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
                });

                echo "<div class=\"alert alert-success\">We have signed up a new user with the ID " . $userId . "</div>";
                try {
                    $auth->admin()->addRoleForUserById($userId, \Delight\Auth\Role::ADMIN);
                }catch (\Delight\Auth\UnknownIdException $e) {
                    echo "<div class=\"alert alert-danger\">Couldn´t give admin rights</div>";
                }
                if ($auth->hasRole(\Delight\Auth\Role::ADMIN)) {
                    echo "<div class=\"alert alert-success\">User has Admin rights</div>";
                }else{
                    echo "<div class=\"alert alert-danger\">User has no Admin rights</div>";
                }
            } catch (\Delight\Auth\InvalidEmailException $e) {
                echo "<div class=\"alert alert-danger\">Invalid email address</div>";
            } catch (\Delight\Auth\InvalidPasswordException $e) {
                echo "<div class=\"alert alert-danger\">Invalid password</div>";
            } catch (\Delight\Auth\UserAlreadyExistsException $e) {
                echo "<div class=\"alert alert-danger\">User already exists</div>";
            } catch (\Delight\Auth\TooManyRequestsException $e) {
                echo "<div class=\"alert alert-danger\">Too many requests</div>";
            }
        }else{
        }
        ?>
    </div>
</div>
</body>
</html>