<?php
require_once "../global/config.php";
require_once "../global/db.php";

class Post
{
    static function get_all(): array
    {
        global $db;

        try {
            $posts = execute_query(
                "SELECT * FROM posts",
                true
            ) ?: [];
        } catch (Exception $e) {
            throw new Exception(
                "Any post could not be retrieved",
                $e->getCode(),
                $e
            );
        }

        return $posts;
    }

    static function get_by_id($id): array
    {
        global $db;

        try {
            $posts = execute_query(
                "SELECT * FROM posts WHERE id=?",
                false,
                "s",
                $id
            ) ?: [];
        } catch (Exception $e) {
            throw new Exception(
                "",
                $e->getCode(),
                $e
            );
        }

        return $posts;
    }

    static function create($title, $description): bool
    {
        global $db;

        try {
            $posts = execute_query(
                "INSERT INTO posts(title, description) VALUES(?, ?)",
                false,
                "ss",
                $title,
                $description
            ) ?: [];
        } catch (Exception $e) {
            throw new Exception(
                "",
                $e->getCode(),
                $e
            );
        }

        return $posts;
    }

    static function update($id, $title, $description)
    {
        global $db;

        try {
            execute_query(
                "UPDATE posts SET title=?, description=? WHERE id=?",
                false,
                "ssi",
                $id,
                $title,
                $description
            );
        } catch (Exception $e) {
            throw new Exception(
                "",
                $e->getCode(),
                $e
            );
        }
    }

    static function delete($id)
    {
        global $db;

        try {
            execute_query("DELETE FROM posts WHERE id=?", false, "i", $id);
        } catch (Exception $e) {
            throw new Exception(
                "",
                $e->getCode(),
                $e
            );
        }
    }
}