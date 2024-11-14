<?php

require_once "../vendor/autoload.php";
require_once "../global/config.php";
require_once "../global/db.php";

use Ramsey\Uuid\Uuid;

class User
{
    function create($user_name, $display_name, $password, $email)
    {
        try {
            $uuid = Uuid::uuid7();

            return execute_query(
                "CALL create_user(?, ?, ?, ?, ?)",
                false,
                "sssss",
                $uuid->toString(),
                $user_name,
                $display_name,
                password_hash($password, PASSWORD_BCRYPT),
                $email
            );
        } catch (Exception $e) {
            switch ($e->getCode()) {
                case 1062:
                    throw new Exception(
                        "This user already exists",
                        $e->getCode(),
                        $e
                    );
                default:
                    throw new Exception(
                        "The user was not registered",
                        $e->getCode(),
                        $e
                    );
            }
        }
    }

    function get_by_user_name($user_name)
    {
        try {
            return execute_query(
                "SELECT * FROM users WHERE username=?",
                false,
                "s",
                $user_name
            );
        } catch (Exception $e) {
            throw new Exception(
                "The user could not be retrieved",
                $e->getCode(),
                $e
            );
        }
    }

    function get_by_email($email)
    {
        try {
            return execute_query(
                "SELECT * FROM users WHERE email=?",
                false,
                "s",
                $email
            );
        } catch (Exception $e) {
            throw new Exception(
                "The user could not be retrieved",
                $e->getMessage(),
                $e
            );
        }
    }

    function get_by_id($id)
    {
        try {
            return execute_query(
                "SELECT * FROM users WHERE id=?",
                false,
                "i",
                $id
            );
        } catch (Exception $e) {
            throw new Exception(
                "The user could not be retrieved",
                $e->getCode(),
                $e
            );
        }
    }

    function update($id, $user_name, $display_name, $password, $email)
    {
        try {
            execute_query(
                "UPDATE users SET user_name=?, display_name=?, password=?, email=? WHERE id=?",
                false,
                "ssssi",
                $user_name,
                $display_name,
                $password,
                $email,
                $id
            );
        } catch (Exception $e) {
            throw new Exception(
                "The user could not be updated",
                $e->getCode(),
                $e
            );
        }
    }

    function delete($id)
    {
        try {
            execute_query(
                "DELETE FROM users WHERE id=?",
                false,
                "i",
                $id
            );
        } catch (Exception $e) {
            throw new Exception(
                "The user could not be deleted",
                $e->getCode(),
                $e
            );
        }
    }
}

try {
    $user = new User();

    $user_ret = $user->create("juanin", "Juan", "juan2006", "juan2007@gmail.com");
    echo var_dump($user_ret);

    $user_ret = $user->get_by_user_name("juanin");
    echo var_dump($user_ret);
} catch (Exception $e) {
    echo $e->getPrevious();
}