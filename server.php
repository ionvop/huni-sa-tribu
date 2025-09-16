<?php

require_once "common.php";

if (isset($_GET["method"])) {
    switch ($_GET["method"]) {
        case "verify":
            verify();
            break;
        default:
            defaultMethod();
            break;
    }
} else if (isset($_POST["method"])) {
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
        case "delete":
            delete();
            break;
        case "new_qr":
            newQr();
            break;
        case "edit_qr":
            editQr();
            break;
        case "delete_qr":
            deleteQr();
            break;
        default:
            defaultMethod();
            break;
    }
} else {
    defaultMethod();
}

function verify() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        DELETE FROM `email_verifications` WHERE `time` < :time
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":time", time() - 600);
    $stmt->execute();

    $query = <<<SQL
        SELECT * FROM `email_verifications` WHERE `email` = :email AND `code` = :code
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":email", $_GET["email"]);
    $stmt->bindValue(":code", $_GET["code"]);
    $verification = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($verification == false) {
        alert("Invalid verification link. It may have expired.");
    }

    $query = <<<SQL
        UPDATE `email_verifications` SET `is_verified` = 'yes', `time` = :time WHERE `email` = :email AND `code` = :code
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":email", $_GET["email"]);
    $stmt->bindValue(":code", $_GET["code"]);
    $stmt->bindValue(":time", time());
    $stmt->execute();

    $query = <<<SQL
        DELETE FROM `email_verifications` WHERE `email` = :email AND `is_verified` = 'no'
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":email", $_GET["email"]);
    $stmt->execute();
    alert("Email address verified. Please register this email within 10 minutes.");
    header("Location: ./");
}

function register() {
    $db = new SQLite3("database.db");

    if (strlen($_POST["fullname"]) == 0 || strlen($_POST["fullname"]) > 50) {
        alert("Fullname must be between 1 and 50 characters.");
    }

    if (strlen($_POST["username"]) < 4 || strlen($_POST["username"]) > 20) {
        alert("Username must be between 4 and 20 characters.");
    }

    if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) === false) {
        alert("Invalid email address.");
    }

    if (strlen($_POST["password"]) < 6 || strlen($_POST["password"]) > 50) {
        alert("Password must be between 6 and 50 characters.");
    }

    if ($_POST["password"] != $_POST["repassword"]) {
        alert("Passwords do not match.");
    }

    $query = <<<SQL
        SELECT * FROM `email_verifications` WHERE `email` = :email AND `is_verified` = 'yes'
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":email", $_POST["email"]);
    $verification = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($verification == false) {
        alert("Email address not yet verified or it may have expired.");
    }

    $query = <<<SQL
        SELECT * FROM `users` WHERE `username` = :username OR `email` = :email
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":username", $_POST["username"]);
    $stmt->bindValue(":email", $_POST["email"]);
    $user = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($user != false) {
        if ($user["username"] == $_POST["username"]) {
            alert("Username is already taken.");
        }

        if ($user["email"] == $_POST["email"]) {
            alert("Email is already taken.");
        }
    }

    $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
    $query = <<<SQL
        INSERT INTO `users` (`fullname`, `email`, `username`, `hash`) VALUES (:fullname, :email, :username, :hash)
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":fullname", $_POST["fullname"]);
    $stmt->bindValue(":email", $_POST["email"]);
    $stmt->bindValue(":username", $_POST["username"]);
    $stmt->bindValue(":hash", $hash);
    $stmt->execute();
    alert("Account successfully created. Please login.", "login/");
}

function login() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT * FROM `users` WHERE `username` = :username
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":username", $_POST["username"]);
    $user = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

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
    $stmt->bindValue(":session", $session);
    $stmt->bindValue(":id", $user["id"]);
    $stmt->execute();
    setcookie("session", $session, time() + 86400 * 30);
    header("Location: ./");
}

function logout() {
    $db = new SQLite3("database.db");
    $user = getUser();

    $query = <<<SQL
        UPDATE `users` SET `session` = NULL WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $user["id"]);
    $stmt->execute();
    setcookie("session", "", time() - 3600);
    header("Location: ./");
    exit;
}

function upload() {
    $db = new SQLite3("database.db");
    $user = getUser();

    if ($user == false) {
        alert("You must be logged in to upload.");
    }

    if (strlen($_POST["title"]) <= 0 || strlen($_POST["title"]) > 50) {
        alert("Title must be between 1 and 50 characters.");
    }

    if (strlen($_POST["description"]) > 1000) {
        alert("Description must be less than 1000 characters.");
    }

    if ($_FILES["media"]["error"] != 0) {
        alert("File could not be uploaded.");
    }

    $filename = uniqid("upload-") . "." . pathinfo($_FILES["media"]["name"], PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["media"]["tmp_name"], "uploads/{$filename}") == false) {
        alert("File could not be uploaded.");
    }

    $type = "";

    if (strpos(mime_content_type("uploads/{$filename}"), "image/") === 0) {
        $type = "image";
    } else if (strpos(mime_content_type("uploads/{$filename}"), "video/") === 0) {
        $type = "video";
    } else if (strpos(mime_content_type("uploads/{$filename}"), "audio/") === 0) {
        $type = "audio";
    }

    $query = <<<SQL
        INSERT INTO `uploads` (`user_id`, `title`, `tribe`, `description`, `category`, `type`, `file`)
        VALUES (:user_id, :title, :tribe, :description, :category, :type, :file)
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":user_id", $user["id"]);
    $stmt->bindValue(":title", $_POST["title"]);
    $stmt->bindValue(":tribe", $_POST["tribe"]);
    $stmt->bindValue(":description", $_POST["description"]);
    $stmt->bindValue(":category", $_POST["category"]);
    $stmt->bindValue(":type", $type);
    $stmt->bindValue(":file", $filename);
    $stmt->execute();
    header("Location: content/");
}

function edit() {
    $db = new SQLite3("database.db");
    $user = getUser();

    if ($user == false) {
        alert("You must be logged in to edit.");
    }

    if (strlen($_POST["title"]) <= 0 || strlen($_POST["title"]) > 50) {
        alert("Title must be between 1 and 50 characters.");
    }

    if (strlen($_POST["description"]) > 1000) {
        alert("Description must be less than 1000 characters.");
    }

    $query = <<<SQL
        SELECT * FROM `uploads` WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $_POST["id"]);
    $post = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
    $filename = $post["file"];

    if ($_FILES["media"]["error"] != 4) {
        if ($_FILES["media"]["error"] != 0) {
            alert("File could not be uploaded.");
        }

        $filename = uniqid("upload-") . "." . pathinfo($_FILES["media"]["name"], PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES["media"]["tmp_name"], "uploads/{$filename}") == false) {
            alert("File could not be uploaded.");
        }

        $query = <<<SQL
            UPDATE `uploads` SET `file` = :file WHERE `id` = :id
        SQL;

        $stmt = $db->prepare($query);
        $stmt->bindValue(":file", $filename);
        $stmt->bindValue(":id", $_POST["id"]);
        $stmt->execute();
    }

    $type = "";

    if (strpos(mime_content_type("uploads/{$filename}"), "image/") === 0) {
        $type = "image";
    } else if (strpos(mime_content_type("uploads/{$filename}"), "video/") === 0) {
        $type = "video";
    } else if (strpos(mime_content_type("uploads/{$filename}"), "audio/") === 0) {
        $type = "audio";
    }

    $query = <<<SQL
        UPDATE `uploads` SET `title` = :title, `tribe` = :tribe, `description` = :description, `category` = :category, `type` = :type WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":title", $_POST["title"]);
    $stmt->bindValue(":tribe", $_POST["tribe"]);
    $stmt->bindValue(":description", $_POST["description"]);
    $stmt->bindValue(":category", $_POST["category"]);
    $stmt->bindValue(":type", $type);
    $stmt->bindValue(":id", $_POST["id"]);
    $stmt->execute();
    header("Location: content/");
}

function delete() {
    $db = new SQLite3("database.db");
    $user = getUser();

    if ($user == false) {
        alert("You must be logged in to delete.");
    }

    $query = <<<SQL
        DELETE FROM `uploads` WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $_POST["id"]);
    $stmt->execute();
    header("Location: content/");
}

function newQr() {
    $db = new SQLite3("database.db");
    $code = uniqid("qr-");

    $query = <<<SQL
        INSERT INTO `qr` (`code`) VALUES (:code)
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":code", $code);
    $stmt->execute();
    $id = $db->lastInsertRowID();
    header("Location: visitor/qr/edit/?id={$id}");
}

function editQr() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        UPDATE `qr` SET `name` = :name, `type` = :type, `status` = :status WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":name", $_POST["name"]);
    $stmt->bindValue(":type", $_POST["type"]);
    $stmt->bindValue(":status", $_POST["status"]);
    $stmt->bindValue(":id", $_POST["id"]);
    $stmt->execute();
    header("Location: visitor/qr/");
}

function deleteQr() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        DELETE FROM `qr` WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $_POST["id"]);
    $stmt->execute();
    header("Location: visitor/qr/");
}

function defaultMethod() {
    session_start();

    breakpoint([
        "post" => $_POST,
        "files" => $_FILES,
        "session" => $_SESSION
    ]);
}