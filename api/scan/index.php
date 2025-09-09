<?php

chdir("../../");
require_once "common.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
        http_response_code(204);
        exit;
    }

    $db = new SQLite3("database.db");
    $_POST = json_decode(file_get_contents("php://input"), true);

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

    $query = <<<SQL
        INSERT INTO `qr_scans` (`qr_id`)
        VALUES (:qr_id);
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":qr_id", $qr["id"]);
    $stmt->execute();

    echo json_encode([
        "success" => true
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}