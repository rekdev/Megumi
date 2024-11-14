<?php
require_once "env.php";

define("PROJECT_NAME", $env["PROJECT_NAME"] ?: "default");
define("APP_ENV", $env["APP_ENV"] ?: "production");

if (APP_ENV == "development") {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}