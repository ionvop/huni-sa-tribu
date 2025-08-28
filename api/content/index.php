<?php

chdir("../../");
require_once "common.php";
$db = new SQLite3("database.db");
$_POST = json_decode(file_get_contents("php://input"), true);

if (isset($_GET["id"])) {
    $query = <<<SQL
        SELECT * FROM `uploads` WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $_GET["id"]);    
    $content = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
    echo json_encode($content);
    exit();
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
    exit();
}

?>