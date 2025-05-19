<?php

include "common.php";
$db = new SQLite3("database.db");

if (isset($_POST["method"])) {
    switch ($_POST["method"]) {
        case "register":
            Register($db);
            break;
        case "login":
            Login($db);
            break;
        case "logout":
            Logout($db);
            break;
        case "upload":
            Upload($db);
            break;
        default:
            DefaultMethod();
            break;
    }
} else {
    DefaultMethod();
}

function Register(SQLite3 $db): void {
    if (strlen($_POST["password"]) < 8) {
        Alert("Password must be at least 8 characters long.");
    }

    if ($_POST["password"] != $_POST["repassword"]) {
        Alert("Passwords do not match.");
    }

    $query = <<<SQL
        SELECT * FROM `users` WHERE `email` = :email
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":email", $_POST["email"]);
    $user = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($user != false) {
        Alert("Email already exists.");
    }

    $query = <<<SQL
        SELECT * FROM `users` WHERE `username` = :username
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":username", $_POST["username"]);
    $user = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($user != false) {
        Alert("Username already exists.");
    }

    $query = <<<SQL
        INSERT INTO `users`(`username`, `firstname`, `lastname`, `email`, `contact`, `hash`, `gender`, `birthdate`, `role`)
        VALUES (:username, :firstname, :lastname, :email, :contact, :hash, :gender, :birthdate, :role)
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":username", $_POST["username"]);
    $stmt->bindValue(":firstname", $_POST["firstname"]);
    $stmt->bindValue(":lastname", $_POST["lastname"]);
    $stmt->bindValue(":email", $_POST["email"]);
    $stmt->bindValue(":contact", $_POST["contact"]);
    $stmt->bindValue(":hash", password_hash($_POST["password"], PASSWORD_DEFAULT));
    $stmt->bindValue(":gender", $_POST["gender"]);
    $stmt->bindValue(":birthdate", $_POST["birthdate"]);
    $stmt->bindValue(":role", "contributor");
    $stmt->execute();
    Alert("Successfully registered.", "login/");
}

function Login(SQLite3 $db): void {
    $query = <<<SQL
        SELECT * FROM `users` WHERE `email` = :email
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":email", $_POST["email"]);
    $user = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($user == false) {
        Alert("Invalid email or password.");
    }

    if (password_verify($_POST["password"], $user["hash"]) == false) {
        Alert("Invalid email or password.");
    }

    $session = uniqid("session_");

    $query = <<<SQL
        UPDATE `users`
        SET `session` = :session
        WHERE `email` = :email
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":session", $session);
    $stmt->bindValue(":email", $_POST["email"]);
    $stmt->execute();
    setcookie("session", $session, time() + 86400);
    header("Location: ./");
}

function Logout(SQLite3 $db): void {
    $query = <<<SQL
        UPDATE `users`
        SET `session` = null
        WHERE `session` = :session
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":session", $_COOKIE["session"]);
    $stmt->execute();
    setcookie("session", "", time() - 3600);
    header("Location: ./");
}

function Upload(SQLite3 $db): void {
    $user = GetUser($db);

    if ($user == false) {
        Alert("You are not logged in.");
    }

    if ($_FILES["media"]["error"] != 0) {
        Alert("Error uploading file.");
    }

    $type = "";

    if (strpos($_FILES["media"]["type"], "image") === 0) {
        $type = "image";
    } else if (strpos($_FILES["media"]["type"], "audio") === 0) {
        $type = "audio";
    } else if (strpos($_FILES["media"]["type"], "video") === 0) {
        $type = "video";
    } else {
        Alert("Invalid file type.");
    }

    $fileId = uniqid("media_");
    $filename = "{$fileId}." . pathinfo($_FILES["media"]["name"], PATHINFO_EXTENSION);
    
    if (move_uploaded_file($_FILES["media"]["tmp_name"], "uploads/media/{$filename}") == false) {
        Alert("Error uploading file.");
    }

    $query = <<<SQL
        INSERT INTO `entries`(`user_id`, `title`, `group`, `board`, `description`, `type`, `file`)
        VALUES (:user_id, :title, :group, :board, :description, :type, :file)
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":user_id", $user["id"]);
    $stmt->bindValue(":title", $_POST["title"]);
    $stmt->bindValue(":group", $_POST["group"]);
    $stmt->bindValue(":board", $_POST["board"]);
    $stmt->bindValue(":description", $_POST["description"]);
    $stmt->bindValue(":type", $type);
    $stmt->bindValue(":file", $filename);
    $stmt->execute();
    header("Location: dashboard/");
}

function DefaultMethod(): void {
    Breakpoint([
        "post" => $_POST,
        "files" => $_FILES
    ]);
}