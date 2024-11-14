<?php
require_once "env.php";

define("DB_HOST", $env["DB_HOST"] ?? "localhost");
define("DB_USERNAME", $env["DB_USERNAME"] ?? "root");
define("DB_PASSWORD", $env["DB_PASSWORD"] ?? "");
define("DB_NAME", $env["DB_NAME"] ?? "database");


try {
    $db = new mysqli(
        DB_HOST,
        DB_USERNAME,
        DB_PASSWORD,
        DB_NAME
    );

    if ($db->connect_errno) {
        die(json_encode(["message" => "Connect error: $db->connect_errno"]));
    }
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    die(json_encode(["message" => "Unable to connect to the database: " . $e->getMessage()]));
}

function execute_query($query, $fetch_all = false, $types = "", ...$vars)
{
    global $db;
    $data = null;

    $stmn = $db->prepare($query);

    if (!$stmn) {
        throw new Exception(
            "An error has occurred during statement preparation: $db->error"
        );
    }

    if ($types && count($vars) > 0)
        $stmn->bind_param($types, ...$vars);


    if (!$stmn->execute()) {
        throw new Exception(
            "An error has occurred during query execution: $stmn->error"
        );
    }

    $result = $stmn->get_result();

    if ($result) {
        $data = $fetch_all ? $result->fetch_all(MYSQLI_ASSOC) : $result->fetch_array(MYSQLI_ASSOC);
        $result->free();
    }

    $stmn->close();
    return $data;

}