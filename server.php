<?php

require_once "common.php";
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST["method"])) {
    switch ($_POST["method"]) {
        case "register":
            register();
            break;
        case "login":
            login();
            break;
        case "logout":
            logout();
            break;
        case "upload":
            upload();
            break;
        case "edit":
            edit();
            break;
        case "archive":
            archive();
            break;
        case "restore":
            restore();
            break;
        case "generateQr":
            generateQr();
            break;
        case "editQr":
            editQr();
            break;
        case "deleteQr":
            deleteQr();
            break;
        case "exportData":
            exportData();
            break;
        default:
            defaultMethod();
            break;
    }
} else {
    defaultMethod();
}

function register() {
    $db = new SQLite3("database.db");

    if ($_POST["firstname"] == "" || $_POST["lastname"] == "" || $_POST["username"] == "" || $_POST["email"] == "" || $_POST["password"] == "") {
        alert("Please fill in all fields.");
    }

    if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) === false) {
        alert("Please enter a valid email address.");
    }

    if ($_POST["password"] != $_POST["repassword"]) {
        alert("Passwords do not match.");
    }

    $query = <<<SQL
        SELECT * FROM `users` WHERE `username` = :username OR `email` = :email
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":username", $_POST["username"]);
    $stmt->bindValue(":email", $_POST["email"]);
    $user = $stmt->execute()->fetchArray();

    if ($user != false) {
        alert("Username or email already in use.");
    }

    $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $session = uniqid("session-");

    $query = <<<SQL
        INSERT INTO `users` (`firstname`, `lastname`, `username`, `email`, `hash`, `session`)
        VALUES (:firstname, :lastname, :username, :email, :hash, :session)
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":firstname", $_POST["firstname"]);
    $stmt->bindValue(":lastname", $_POST["lastname"]);
    $stmt->bindValue(":username", $_POST["username"]);
    $stmt->bindValue(":email", $_POST["email"]);
    $stmt->bindValue(":hash", $hash);
    $stmt->bindValue(":session", $session);
    $stmt->execute();
    setcookie("session", $session, time() + 86400);
    header("Location: ./");
}

function login() {
    $db = new SQLite3("database.db");

    if ($_POST["username"] == "" || $_POST["password"] == "") {
        alert("Please fill in all fields.");
    }

    $query = <<<SQL
        SELECT * FROM `users` WHERE `username` = :username
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":username", $_POST["username"]);
    $user = $stmt->execute()->fetchArray();

    if ($user == false) {
        alert("Invalid credentials.");
    }

    if (password_verify($_POST["password"], $user["hash"]) == false) {
        alert("Invalid credentials.");
    }

    $session = uniqid("session-");

    $query = <<<SQL
        UPDATE `users` SET `session` = :session WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $user["id"]);
    $stmt->bindValue(":session", $session);
    $stmt->execute();
    setcookie("session", $session, time() + 86400);
    header("Location: ./");
}

function logout() {
    $db = new SQLite3("database.db");
    $user = getUser();

    if ($user == false) {
        alert("You are not logged in.");
    }

    $query = <<<SQL
        UPDATE `users` SET `session` = NULL WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $user["id"]);
    $stmt->execute();
    setcookie("session", "", time() - 86400);
    header("Location: ./");
}

function upload() {
    $db = new SQLite3("database.db");
    $user = getUser();

    if ($user == false) {
        alert("You are not logged in.");
    }

    if ($_POST["title"] == "" || $_POST["category"] == "" || $_POST["tribe"] == "") {
        alert("Please fill in all fields.");
    }

    if ($_FILES["file"]["error"] != 0) {
        alert("There was an error uploading the file.");
    }

    $allowedTypes = [
        "music"    => "audio",
        "video"    => "video",
        "artifact" => "image",
        "event"    => "image",
    ];

    if (!array_key_exists($_POST["category"], $allowedTypes)) {
        alert("Invalid category specified.");
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES["file"]["tmp_name"]);
    finfo_close($finfo);
    $expectedPrefix = $allowedTypes[$_POST["category"]];

    if (strpos($mime, $expectedPrefix) !== 0) {
        alert("Invalid file type for category '{$_POST['category']}'. Expected {$expectedPrefix} file.");
    }

    $filename = uniqid("file-");
    $filename .= "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/{$filename}") == false) {
        alert("There was an error uploading the file.");
    }

    $query = <<<SQL
        INSERT INTO `content`(`user_id`, `title`, `category`, `tribe`, `description`, `file`)
        VALUES (:user_id, :title, :category, :tribe, :description, :file)
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":user_id", $user["id"]);
    $stmt->bindValue(":title", $_POST["title"]);
    $stmt->bindValue(":category", $_POST["category"]);
    $stmt->bindValue(":tribe", $_POST["tribe"]);
    $stmt->bindValue(":description", $_POST["description"]);
    $stmt->bindValue(":file", $filename);
    $stmt->execute();
    // header("Location: content/");
    alert("Content uploaded successfully.", "content/");
}

function edit() {
    $db = new SQLite3("database.db");
    $user = getUser();

    if ($user == false) {
        alert("You are not logged in.");
    }

    $query = <<<SQL
        SELECT * FROM `content` WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $_POST["id"]);
    $content = $stmt->execute()->fetchArray();

    if ($content == false) {
        alert("This content does not exist.");
    }

    if ($_POST["title"] == "" || $_POST["tribe"] == "") {
        alert("Please fill in all fields.");
    }

    $query = <<<SQL
        UPDATE `content`
        SET `title` = :title,
        `tribe` = :tribe,
        `description` = :description
        WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":title", $_POST["title"]);
    $stmt->bindValue(":tribe", $_POST["tribe"]);
    $stmt->bindValue(":description", $_POST["description"]);
    $stmt->bindValue(":id", $_POST["id"]);
    $stmt->execute();
    // header("Location: content/");
    alert("Content updated successfully.", "content/");
}

function archive() {
    $db = new SQLite3("database.db");
    $user = getUser();

    if ($user == false) {
        alert("You are not logged in.");
    }

    $query = <<<SQL
        UPDATE `content` SET `is_archived` = 1 WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $_POST["id"]);
    $stmt->execute();
    // header("Location: content/archive/");
    alert("Content archived successfully.", "content/archive/");
}

function restore() {
    $db = new SQLite3("database.db");
    $user = getUser();

    if ($user == false) {
        alert("You are not logged in.");
    }

    $query = <<<SQL
        UPDATE `content`
        SET `is_archived` = 0
        WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $_POST["id"]);
    $stmt->execute();
    // header("Location: content/");
    alert("Content restored successfully.", "content/");
}

function generateQr() {
    $db = new SQLite3("database.db");
    $user = getUser();

    if ($user == false) {
        alert("You are not logged in.");
    }

    $query = <<<SQL
        SELECT * FROM `qr` WHERE `content_id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $_POST["id"]);
    $qr = $stmt->execute()->fetchArray();

    if ($qr != false) {
        alert("This content already has a QR code.");
    }

    $code = uniqid("qr-");

    $query = <<<SQL
        INSERT INTO `qr` (`content_id`, `code`)
        VALUES (:id, :code)
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $_POST["id"]);
    $stmt->bindValue(":code", $code);
    $stmt->execute();
    $qrId = $db->lastInsertRowID();
    // header("Location: visitors/qr/view/?id={$qrId}");
    alert("QR code generated successfully.", "visitors/qr/view/?id={$qrId}");
}

function editQr() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        UPDATE `qr` SET `status` = :status WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":status", $_POST["status"]);
    $stmt->bindValue(":id", $_POST["id"]);
    $stmt->execute();
    // header("Location: visitors/qr/");
    alert("QR code status updated successfully.", "visitors/qr/");
}

function deleteQr() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        DELETE FROM `qr` WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $_POST["id"]);
    $stmt->execute();

    $query = <<<SQL
        DELETE FROM `scans` WHERE `qr_id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $_POST["id"]);
    $stmt->execute();

    // header("Location: visitors/qr/");
    alert("QR code deleted successfully.", "visitors/qr/");
}

function exportData() {
    $db = new SQLite3("database.db");
    $startDate = isset($_POST['startDate']) ? (int)$_POST['startDate'] : 0;
    $endDate   = isset($_POST['endDate']) ? (int)$_POST['endDate'] : time();

    // Get total scans & visits
    $totalScans = $db->querySingle("
        SELECT COUNT(scans.id)
        FROM scans
        WHERE scans.time BETWEEN $startDate AND $endDate
    ");
    $totalVisits = $db->querySingle("
        SELECT COUNT(visits.id)
        FROM visits
        WHERE visits.time BETWEEN $startDate AND $endDate
    ");

    if ($totalScans == 0 && $totalVisits == 0) {
        die("No scans or visits in this timeframe.");
    }

    // Prepare spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('School Analytics');

    // Set headers
    $headers = [
        'A1' => 'School Name',
        'B1' => 'Student Count',
        'C1' => 'Most Scanned Content',
        'D1' => 'Most Scanned Content Count',
        'E1' => 'Least Scanned Content',
        'F1' => 'Least Scanned Content Count',
        'G1' => 'Content Engagement',
        'H1' => 'Visitor Engagement',
        'I1' => 'Total Scans'
    ];

    foreach ($headers as $cell => $text) {
        $sheet->setCellValue($cell, $text);
    }

    // Query schools with visits in timeframe
    $stmt = $db->prepare("
        SELECT visitors.school, COUNT(visits.id) AS visit_count
        FROM visits
        JOIN visitors ON visits.visitor_id = visitors.id
        WHERE visits.time BETWEEN :start AND :end
        GROUP BY visitors.school
        HAVING visit_count > 0
        ORDER BY visitors.school ASC
    ");
    $stmt->bindValue(':start', $startDate, SQLITE3_INTEGER);
    $stmt->bindValue(':end', $endDate, SQLITE3_INTEGER);
    $schools = $stmt->execute();

    $row = 2; // Start data from row 2
    while ($schoolRow = $schools->fetchArray(SQLITE3_ASSOC)) {
        $school = $schoolRow['school'];

        // Student count
        $studentCount = $db->querySingle("
            SELECT COUNT(DISTINCT visitors.id)
            FROM visitors
            WHERE school = '{$school}'
        ");

        // Total scans by this school
        $schoolTotalScans = $db->querySingle("
            SELECT COUNT(scans.id)
            FROM scans
            JOIN visitors ON scans.visitor_id = visitors.id
            WHERE visitors.school = '{$school}'
              AND scans.time BETWEEN $startDate AND $endDate
        ");

        // Most scanned content
        $mostScanned = $db->querySingle("
            SELECT content.title
            FROM scans
            JOIN visitors ON scans.visitor_id = visitors.id
            JOIN qr ON scans.qr_id = qr.id
            JOIN content ON qr.content_id = content.id
            WHERE visitors.school = '{$school}'
              AND scans.time BETWEEN $startDate AND $endDate
            GROUP BY content.id
            ORDER BY COUNT(scans.id) DESC
            LIMIT 1
        ");

        $mostScannedCount = $db->querySingle("
            SELECT COUNT(scans.id)
            FROM scans
            JOIN visitors ON scans.visitor_id = visitors.id
            JOIN qr ON scans.qr_id = qr.id
            JOIN content ON qr.content_id = content.id
            WHERE visitors.school = '{$school}'
              AND scans.time BETWEEN $startDate AND $endDate
              AND content.title = '{$mostScanned}'
        ");

        // Least scanned content
        $leastScanned = $db->querySingle("
            SELECT content.title
            FROM scans
            JOIN visitors ON scans.visitor_id = visitors.id
            JOIN qr ON scans.qr_id = qr.id
            JOIN content ON qr.content_id = content.id
            WHERE visitors.school = '{$school}'
              AND scans.time BETWEEN $startDate AND $endDate
            GROUP BY content.id
            ORDER BY COUNT(scans.id) ASC
            LIMIT 1
        ");

        $leastScannedCount = $db->querySingle("
            SELECT COUNT(scans.id)
            FROM scans
            JOIN visitors ON scans.visitor_id = visitors.id
            JOIN qr ON scans.qr_id = qr.id
            JOIN content ON qr.content_id = content.id
            WHERE visitors.school = '{$school}'
              AND scans.time BETWEEN $startDate AND $endDate
              AND content.title = '{$leastScanned}'
        ");

        // Engagement calculations
        $contentEngagement = $totalScans > 0 ? round(($schoolTotalScans / $totalScans) * 100, 2) . "%" : "0%";
        $visitorEngagement = $totalVisits > 0 ? round(($schoolRow['visit_count'] / $totalVisits) * 100, 2) . "%" : "0%";

        // Fill row
        $sheet->setCellValue("A{$row}", $school == "" ? 'N/A' : $school);
        $sheet->setCellValue("B{$row}", $studentCount);
        $sheet->setCellValue("C{$row}", $mostScanned);
        $sheet->setCellValue("D{$row}", $mostScannedCount);
        $sheet->setCellValue("E{$row}", $leastScanned);
        $sheet->setCellValue("F{$row}", $leastScannedCount);
        $sheet->setCellValue("G{$row}", $contentEngagement);
        $sheet->setCellValue("H{$row}", $visitorEngagement);
        $sheet->setCellValue("I{$row}", $schoolTotalScans);

        $row++;
    }

    // Auto-size columns for readability
    foreach (range('A', 'I') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Output Excel file to browser
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="school_analytics.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

function defaultMethod() {
    session_start();

    breakpoint([
        "post" => $_POST,
        "files" => $_FILES,
        "session" => $_SESSION
    ]);
}