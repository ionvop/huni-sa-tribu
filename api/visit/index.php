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

            $lastVisit = getVisitorLastVisit($visitor);
            $lastVisit = date("Y-m-d", $lastVisit + (8 * 60 * 60));
            $currentDate = date("Y-m-d", time() + (8 * 60 * 60));

            if ($lastVisit == $currentDate) {
                http_response_code(409);
                exit;
            }

            $query = <<<SQL
                INSERT INTO `visits`(`visitor_id`)
                VALUES (:visitor_id)
            SQL;

            $stmt = $db->prepare($query);
            $stmt->bindValue(":visitor_id", $visitor["id"]);
            $stmt->execute();
            http_response_code(201);
            
            echo json_encode([
                "debug" => [
                    "lastVisit" => $lastVisit,
                    "currentDate" => $currentDate
                ]
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