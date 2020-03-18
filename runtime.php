<?php

if (!function_exists('transformWebRootPath')) {
    function transformWebRootPath($WEB_ROOT_PATH)
    {
        $WEB_ROOT_PATH = ltrim($WEB_ROOT_PATH, '/');
        $WEB_ROOT_PATH = strstr($WEB_ROOT_PATH, '/', true);
        $WEB_ROOT_PATH = "/" . $WEB_ROOT_PATH . "/";
        if (strpos($WEB_ROOT_PATH, '.') !== false) {
            $WEB_ROOT_PATH = dirname($WEB_ROOT_PATH) . "/";
        }
        return $WEB_ROOT_PATH;
    }
}

$APP_ROOT = __DIR__;
$CONF_DIR = $APP_ROOT . "/config";
$PUBLIC_DIR = $APP_ROOT . "/public";
$API_DIR = $PUBLIC_DIR . "/api";
$TEMPLATES_DIR = $PUBLIC_DIR . "/templates";
$CONTROLLER_DIR = $APP_ROOT . "/controller";

$WEB_ROOT_PATH = strtok($_SERVER['REQUEST_URI'], '?');
$WEB_ROOT_PATH = transformWebRootPath($WEB_ROOT_PATH);

$API_WEB_PATH = $WEB_ROOT_PATH . "/api";
$JS_WEB_PATH = $WEB_ROOT_PATH . "/js";
$CSS_WEB_PATH = $WEB_ROOT_PATH . "/css";


require __DIR__ . '/vendor/autoload.php';
require $CONTROLLER_DIR . "/DBManager.php";


$DBManager = new DBManager($CONF_DIR, "config.ini.php");
$DBManager->createTables();
$DBManager->createPhpAuthTables();