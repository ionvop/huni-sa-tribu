<?php

chdir("../../");
require_once "common.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    $db = new SQLite3("database.db");
    $_POST = json_decode(file_get_contents("php://input"), true);

    switch ($_SERVER["REQUEST_METHOD"]) {
        case "OPTIONS":
            http_response_code(204);
            exit;
        case "GET":
            if (isset($_GET["id"])) {
                $query = <<<SQL
                    SELECT * FROM `uploads` WHERE `id` = :id
                SQL;

                $stmt = $db->prepare($query);
                $stmt->bindValue(":id", $_GET["id"]);
                $content = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
                echo json_encode($content);
                exit;
            } else if (isset($_GET["tribe"])) {
                $query = <<<SQL
                    SELECT * FROM `uploads` WHERE `tribe` = :tribe
                SQL;

                if (isset($_GET["category"])) {
                    $query .= " AND `category` = :category";
                }

                $stmt = $db->prepare($query);
                $stmt->bindValue(":tribe", $_GET["tribe"]);

                if (isset($_GET["category"])) {
                    $stmt->bindValue(":category", $_GET["category"]);
                }

                $content = [];
                $result = $stmt->execute();

                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                    $row["file"] = "uploads/{$row['file']}";
                    $content[] = $row;
                }

                echo json_encode($content);
                exit;
            } else if (isset($_GET["category"])) {
                $query = <<<SQL
                    SELECT * FROM `uploads` WHERE `category` = :category
                SQL;

                $stmt = $db->prepare($query);
                $stmt->bindValue(":category", $_GET["category"]);
                $content = [];
                $result = $stmt->execute();

                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                    $row["file"] = "uploads/{$row['file']}";
                    $content[] = $row;
                }

                echo json_encode($content);
                exit;
            } else {
                $content = [];

                $query = <<<SQL
                    SELECT * FROM `uploads`
                SQL;

                $stmt = $db->prepare($query);
                $result = $stmt->execute();

                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                    $row["file"] = "uploads/{$row['file']}";
                    $content[] = $row;
                }

                echo json_encode($content);
                exit;
            }

            exit;
        default:
            defaultMethod();
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}