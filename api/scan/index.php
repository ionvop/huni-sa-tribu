<?php

chdir("../../");
require_once "common.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    $db = new SQLite3("database.db");
    $_POST = json_decode(file_get_contents("php://input"), true);

    switch ($_SERVER["REQUEST_METHOD"]) {
        case "OPTIONS":
            http_response_code(204);
            exit;
        case "POST":
            $query = <<<SQL
                SELECT * FROM `qr` WHERE `code` = :code
            SQL;

            $stmt = $db->prepare($query);
            $stmt->bindValue(":code", $_POST["code"]);
            $qr = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

            if ($qr == false) {
                http_response_code(404);
                echo json_encode(["error" => "QR code not found."]);
                exit;
            }

            $roleMap = [
                "Student" => "student",
                "Visitor" => "visitor"
            ];

            $role = $roleMap[$_POST["userData"]["role"]];

            if ($role == "visitor") {
                $_POST["userData"]["school"] = "N/A";
            }

            $query = <<<SQL
                INSERT INTO `qr_scans` (`qr_id`, `name`, `role`, `school`)
                VALUES (:qr_id, :name, :role, :school);
            SQL;

            $stmt = $db->prepare($query);
            $stmt->bindValue(":qr_id", $qr["id"]);
            $stmt->bindValue(":name", $_POST["userData"]["name"]);
            $stmt->bindValue(":role", $role);
            $stmt->bindValue(":school", $_POST["userData"]["school"]);
            $stmt->execute();

            echo json_encode([
                "success" => true
            ]);

            exit;
        default:
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed."]);
            exit;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}