<?php
require_once "../vendor/autoload.php";
use Ramsey\Uuid\Uuid;
$uuid = Uuid::uuid7();
echo $uuid->getBytes();