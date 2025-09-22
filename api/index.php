<?php

chdir("../");
require_once "common.php";
header("Content-type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");

try {
    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            echo json_encode([
                "data" => $_POST
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