<?php

chdir("../../");
include "common.php";

try {
    $_POST = json_decode(file_get_contents("php://input"), true);

    if (isset($_GET["method"])) {
        switch ($_GET["method"]) {
            case "get_content":
                getContent();
                break;
            default:
                defaultMethod();
                break;
        }
    }

    if (isset($_POST["method"])) {
        switch ($_POST["method"]) {
            case "send_email_verification":
                sendEmailVerification();
                break;
            case "check_email_status":
                checkEmailStatus();
                break;
            default:
                defaultMethod();
                break;
        }
    } else {
        defaultMethod();
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}

function getContent() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT * FROM `uploads`
    SQL;

    $stmt = $db->prepare($query);
    $result = $stmt->execute();
    $content = [];

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $content[] = $row;
    }

    echo json_encode(["success" => true, "content" => $content]);
}

function sendEmailVerification() {
    global $BREVO_API_KEY;
    $db = new SQLite3("database.db");

    $query = <<<SQL
        DELETE FROM `email_verifications` WHERE `time` < :time
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":time", time() - 600);
    $stmt->execute();
    $code = uniqid("verify-");

    $query = <<<SQL
        INSERT INTO `email_verifications` (`email`, `code`) VALUES (:email, :code)
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":email", $_POST["email"]);
    $stmt->bindValue(":code", $code);
    $stmt->execute();
    $email = urlencode($_POST["email"]);
    // $domain = $_SERVER["SERVER_NAME"];
    $domain = "{$_SERVER['SERVER_NAME']}:{$_SERVER['SERVER_PORT']}";
    $url = "http://{$domain}/server.php?method=verify&email={$email}&code={$code}";

    $headers = [
        "Content-Type: application/json",
        "Accept: application/json",
        "Api-Key: {$BREVO_API_KEY}"
    ];

    $body = [
        "sender" => [
            "name" => "Huni sa Tribu",
            "email" => "ionvop@gmail.com"
        ],
        "to" => [
            [
                "email" => $_POST["email"]
            ]
        ],
        "textContent" => "You may verify your email address by clicking the link below:\n\n{$url}\n\nIf you did not request this email, you can safely ignore this email.",
        "subject" => "Huni sa Tribu: Email Verification"
    ];

    $response = sendCurl("https://api.sendinblue.com/v3/smtp/email", "POST", $headers, json_encode($body));
    echo json_encode(["success" => true, "message" => $response]);
}

function checkEmailStatus() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        DELETE FROM `email_verifications` WHERE `time` < :time
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":time", time() - 600);
    $stmt->execute();

    $query = <<<SQL
        SELECT * FROM `email_verifications` WHERE `email` = :email AND `is_verified` = 'yes'
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":email", $_POST["email"]);
    $verification = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($verification == false) {
        echo json_encode(["success" => false, "message" => "Email is not verified."]);
        return;
    }

    echo json_encode(["success" => true, "message" => "Email is verified."]);
}

function defaultMethod() {
    session_start();

    echo json_encode([
        "post" => $_POST,
        "session" => $_SESSION
    ]);
}