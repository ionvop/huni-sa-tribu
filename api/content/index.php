<?php

chdir("../../");
require_once "common.php";
header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
$db = new SQLite3("database.db");

try {
    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            if (isset($_GET["id"])) {
                $query = <<<SQL
                    SELECT * FROM `content` WHERE `id` = :id
                SQL;

                $stmt = $db->prepare($query);
                $stmt->bindValue(":id", $_GET["id"]);
                $content = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

                echo json_encode([
                    "data" => $content
                ]);

                exit;
            }

            $query = <<<SQL
                SELECT * FROM `content`
            SQL;

            $conditions = ["`is_archived` = 0"];
            $bindings = [];

            if (isset($_GET["category"])) {
                $conditions[] = "`category` = :category";
                $bindings["category"] = $_GET["category"];
            }

            if (isset($_GET["tribe"])) {
                $conditions[] = "`tribe` = :tribe";
                $bindings["tribe"] = $_GET["tribe"];
            }

            if (count($conditions) > 0) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }

            $stmt = $db->prepare($query);

            foreach ($bindings as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }

            $result = $stmt->execute();
            $output = [];

            while ($content = $result->fetchArray(SQLITE3_ASSOC)) {
                if (isset($_GET["type"])) {
                    if (getFileType($content["file"]) != $_GET["type"]) {
                        continue;
                    }
                }

                $output[] = $content;
            }

            echo json_encode([
                "data" => $output
            ]);

            exit;
        case "OPTIONS":
            http_response_code(204);
            exit;
    }
} catch (Exception $e) {
    http_response_code(500);

    echo json_encode([
        "error" => $e->getMessage()
    ]);
}