<?php

/**
 * Prints the given message and exits the script.
 *
 * @param mixed $message The message to be printed.
 * @return void
 */
function Breakpoint(mixed $message): void {
    header("Content-type: application/json");
    print_r($message);
    exit();
}

/**
 * Prints the given message as an alert and redirects the user.
 *
 * @param string $message The message to be displayed.
 * @param string $redirect The URL to redirect the user to. If empty, the user will be redirected back.
 * @return void
 */
function Alert(string $message, string $redirect = ""): void {
    $message = json_encode($message);

    $redirectScript = <<<JS
        window.history.back();
    JS;
    
    if ($redirect != "") {
        $redirect = json_encode($redirect);

        $redirectScript = <<<JS
            location.href = {$redirect};
        JS;
    }

    echo <<<HTML
        <script>
            alert({$message});
            {$redirectScript}
        </script>
    HTML;

    exit();
}

function GetUser(SQLite3 $db): array|false {
    if (isset($_COOKIE["session"]) == false) {
        return false;
    }

    $query = <<<SQL
        SELECT * FROM `users` WHERE `session` = :session LIMIT 1;
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":session", $_COOKIE["session"]);
    $user = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($user == false) {
        return false;
    }

    if ($user["session"] == null) {
        return false;
    }

    return $user;
}