<?php

chdir("../../");
require_once "common.php";
header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
$db = new SQLite3("database.db");

try {
    switch ($_SERVER["REQUEST_METHOD"]) {
        case "POST":
            $_POST = json_decode(file_get_contents("php://input"), true);

            if ($_POST["school"] == null) {
                $_POST["school"] = "";
            }

            $query = <<<SQL
                SELECT * FROM `qr` WHERE `code` = :code
            SQL;

            $stmt = $db->prepare($query);
            $stmt->bindValue(":code", $_POST["code"]);
            $qr = $stmt->execute()->fetchArray();

            if ($qr == false) {
                http_response_code(404);
                exit;
            }

            if ($qr["status"] != "active") {
                http_response_code(400);
                
                echo json_encode([
                    "error" => "This QR code is inactive."
                ]);
                
                exit;
            }

            $query = <<<SQL
                SELECT * FROM `visitors`
                WHERE `name` = :name
                AND `school` = :school
            SQL;

            $stmt = $db->prepare($query);
            $stmt->bindValue(":name", $_POST["name"]);
            $stmt->bindValue(":school", $_POST["school"]);
            $visitor = $stmt->execute()->fetchArray();

            if ($visitor == false) {
                $query = <<<SQL
                    INSERT INTO `visitors`(`name`, `school`)
                    VALUES (:name, :school)
                SQL;

                $stmt = $db->prepare($query);
                $stmt->bindValue(":name", $_POST["name"]);
                $stmt->bindValue(":school", $_POST["school"]);
                $stmt->execute();
                
                $query = <<<SQL
                    SELECT * FROM `visitors` WHERE `id` = :id
                SQL;

                $stmt = $db->prepare($query);
                $stmt->bindValue(":id", $db->lastInsertRowID());
                $visitor = $stmt->execute()->fetchArray();
            }

            $query = <<<SQL
                INSERT INTO `scans` (`visitor_id`, `qr_id`)
                VALUES (:visitor_id, :qr_id)
            SQL;

            $stmt = $db->prepare($query);
            $stmt->bindValue(":visitor_id", $visitor["id"]);
            $stmt->bindValue(":qr_id", $qr["id"]);
            $stmt->execute();

            $query = <<<SQL
                SELECT * FROM `content` WHERE `id` = :id
            SQL;

            $stmt = $db->prepare($query);
            $stmt->bindValue(":id", $qr["content_id"]);
            $content = $stmt->execute()->fetchArray();
            http_response_code(201);

            echo json_encode([
                "data" => $content
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