<?php
require_once "env.php";

define("PROJECT_NAME", $env["PROJECT_NAME"] ?: "default");
define("APP_ENV", $env["APP_ENV"] ?: "production");
