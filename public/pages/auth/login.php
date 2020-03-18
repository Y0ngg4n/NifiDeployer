<?php

use Delight\Auth\Auth;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\UserAlreadyExistsException;

include $_SERVER['DOCUMENT_ROOT'] . "../runtime.php";


$auth = new Auth($dbh);

//try {
//    $userId = $auth->register("andresschuele@gmail.com", "PASSSSSSS12312312", "Yonggan", function ($selector, $token) {
//        echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
//    });
//
//    echo 'We have signed up a new user with the ID ' . $userId;
//}
//catch (InvalidEmailException $e) {
//    echo('Invalid email address');
//}
//catch (InvalidPasswordException $e) {
//    echo('Invalid password');
//}
//catch (UserAlreadyExistsException $e) {
//    echo('User already exists');
//}
//catch (TooManyRequestsException $e) {
//    echo('Too many requests');
//}catch(Exception $e){
//    echo($e->getMessage());
//}