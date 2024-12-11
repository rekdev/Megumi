<?php
require_once "../models/user.php";

$user_model = new User();

if (isset($_GET["action"])) {
    $action = $_GET["action"] ?? "";

    switch ($action) {
        case "register";
            $user_name = $_POST["username"] ?? "";
            $display_name = $_POST["displayname"] ?? "";
            $password = $_POST["password"] ?? "";
            $email = $_POST["email"] ?? "";

            if ($user_name !== "" && $display_name !== "" && $password !== "" && $email !== "") {
                try {
                    echo json_encode($user_model->create(
                        $user_name,
                        $display_name,
                        $password,
                        $email
                    ));
                } catch (Exception $e) {
                    http_response_code(500);
                    die(json_encode(["message" => "An error has occurred: " . $e->getMessage()]));
                }
            }

            break;

        default;
            echo json_encode(["message" => "You did not choose any action"]);
            break;
    }
}