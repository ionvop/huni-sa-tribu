<?php

require_once "common.php";

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
    header("Location: content/");
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

    if ($_POST["title"] == "" || $_POST["category"] == "" || $_POST["tribe"] == "") {
        alert("Please fill in all fields.");
    }

    $filename = $content["file"];

    if ($_FILES["file"]["error"] != 4) {
        if ($_FILES["file"]["error"] != 0) {
            alert("There was an error uploading the file.");
        }

        $filename = uniqid("file-");
        $filename .= "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/{$filename}") == false) {
            alert("There was an error uploading the file.");
        }
    }

    $query = <<<SQL
        UPDATE `content`
        SET `title` = :title,
        `category` = :category,
        `tribe` = :tribe,
        `description` = :description,
        `file` = :file
        WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":title", $_POST["title"]);
    $stmt->bindValue(":category", $_POST["category"]);
    $stmt->bindValue(":tribe", $_POST["tribe"]);
    $stmt->bindValue(":description", $_POST["description"]);
    $stmt->bindValue(":id", $_POST["id"]);
    $stmt->bindValue(":file", $filename);
    $stmt->execute();
    header("Location: content/");
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
    header("Location: content/archive/");
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
    header("Location: content/");
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
    header("Location: visitors/qr/view/?id={$qrId}");
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
    header("Location: visitors/qr/");
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

    header("Location: visitors/qr/");
}

function defaultMethod() {
    session_start();

    breakpoint([
        "post" => $_POST,
        "files" => $_FILES,
        "session" => $_SESSION
    ]);
}