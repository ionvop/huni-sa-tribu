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

function SetNagivation(): string {
    return <<<HTML
        <div class="-navigation">
            <a class="-a home tab -pad" href="dashboard/">
                <div class="-iconlabel">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M240-200h120v-200q0-17 11.5-28.5T400-440h160q17 0 28.5 11.5T600-400v200h120v-360L480-740 240-560v360Zm-80 0v-360q0-19 8.5-36t23.5-28l240-180q21-16 48-16t48 16l240 180q15 11 23.5 28t8.5 36v360q0 33-23.5 56.5T720-120H560q-17 0-28.5-11.5T520-160v-200h-80v200q0 17-11.5 28.5T400-120H240q-33 0-56.5-23.5T160-200Zm320-270Z"/></svg>
                    </div>
                    <div class="label">
                        Home
                    </div>
                </div>
            </a>
            <a class="-a images tab -pad" href="dashboard/images/">
                <div class="-iconlabel">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0 0v-560 560Zm80-80h400q12 0 18-11t-2-21L586-459q-6-8-16-8t-16 8L450-320l-74-99q-6-8-16-8t-16 8l-80 107q-8 10-2 21t18 11Z"/></svg>
                    </div>
                    <div class="label">
                        Images
                    </div>
                </div>
            </a>
            <a class="-a music tab -pad" href="dashboard/music/">
                <div class="-iconlabel">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M400-120q-66 0-113-47t-47-113q0-66 47-113t113-47q23 0 42.5 5.5T480-418v-382q0-17 11.5-28.5T520-840h160q17 0 28.5 11.5T720-800v80q0 17-11.5 28.5T680-680H560v400q0 66-47 113t-113 47Z"/></svg>
                    </div>
                    <div class="label">
                        Music
                    </div>
                </div>
            </a>
            <a class="-a videos tab -pad" href="dashboard/videos/">
                <div class="-iconlabel">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h480q33 0 56.5 23.5T720-720v180l126-126q10-10 22-5t12 19v344q0 14-12 19t-22-5L720-420v180q0 33-23.5 56.5T640-160H160Zm0-80h480v-480H160v480Zm0 0v-480 480Z"/></svg>
                    </div>
                    <div class="label">
                        Videos
                    </div>
                </div>
            </a>
            <div></div>
            <a class="-a upload tab -pad" href="dashboard/upload/">
                <div class="-iconlabel">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M240-160q-33 0-56.5-23.5T160-240v-80q0-17 11.5-28.5T200-360q17 0 28.5 11.5T240-320v80h480v-80q0-17 11.5-28.5T760-360q17 0 28.5 11.5T800-320v80q0 33-23.5 56.5T720-160H240Zm200-486-75 75q-12 12-28.5 11.5T308-572q-11-12-11.5-28t11.5-28l144-144q6-6 13-8.5t15-2.5q8 0 15 2.5t13 8.5l144 144q12 12 11.5 28T652-572q-12 12-28.5 12.5T595-571l-75-75v286q0 17-11.5 28.5T480-320q-17 0-28.5-11.5T440-360v-286Z"/></svg>
                    </div>
                    <div class="label">
                        Upload
                    </div>
                </div>
            </a>
            <form class="-form logout tab -pad" action="server.php" method="post" enctype="multipart/form-data" onclick="if (confirm('Are you sure you want to logout?')) this.submit()">
                <div class="-iconlabel">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h240q17 0 28.5 11.5T480-800q0 17-11.5 28.5T440-760H200v560h240q17 0 28.5 11.5T480-160q0 17-11.5 28.5T440-120H200Zm487-320H400q-17 0-28.5-11.5T360-480q0-17 11.5-28.5T400-520h287l-75-75q-11-11-11-27t11-28q11-12 28-12.5t29 11.5l143 143q12 12 12 28t-12 28L669-309q-12 12-28.5 11.5T612-310q-11-12-10.5-28.5T613-366l74-74Z"/></svg>
                    </div>
                    <div class="label">
                        Logout
                    </div>
                </div>
                <input type="hidden" name="method" value="logout">
            </form>
        </div>
    HTML;
}

function SetHeader(): string {
    return <<<HTML
        <div class="-header">
            <div></div>
            <a class="-a upload -pad -center__flex" href="dashboard/upload/">
                <button>
                    <div class="-iconlabel">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M440-440H240q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h200v-200q0-17 11.5-28.5T480-760q17 0 28.5 11.5T520-720v200h200q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H520v200q0 17-11.5 28.5T480-200q-17 0-28.5-11.5T440-240v-200Z"/></svg>
                        </div>
                        <div class="label">
                            Upload
                        </div>
                    </div>
                </button>
            </a>
            <a class="-a avatar -pad -center__flex" href="dashboard/profile/">
                <img src="assets/image.png">
            </a>
        </div>
    HTML;
}

function RenderEntries(SQLite3 $db, string $type, int $userId, int $limit): string {
    $query = <<<SQL
        SELECT * FROM `entries` WHERE `user_id` = :userId AND `type` = :type ORDER BY `time` DESC LIMIT {$limit}
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":userId", $userId);
    $stmt->bindValue(":type", $type);
    $result = $stmt->execute();
    $output = "";

    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $row["title"] = htmlentities($row["title"]);
        $row["time"] = date("F j, Y, g:i A", $row["time"]);
        $image = "";

        switch ($type) {
            case "image":
                $image = <<<HTML
                    <img src="uploads/media/{$row['file']}">
                HTML;

                break;
            case "audio":
                $image = <<<HTML
                    <img src="assets/music.png">
                HTML;

                break;
            case "video":
                $image = <<<HTML
                    <video src="uploads/media/{$row['file']}"></video>
                HTML;

                break;
        }

        $output .= <<<HTML
            <a class="-a item" href="dashboard/edit/?id={$row['id']}">
                <div class="image -pad">
                    {$image}
                </div>
                <div class="title -pad">
                    {$row["title"]}
                </div>
                <div class="date -pad">
                    {$row["time"]}
                </div>
            </a>
        HTML;
    }

    return $output;
}