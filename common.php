<?php

require_once "config.php";

/**
 * Prints the given message and exits the script.
 *
 * @param mixed $message The message to be printed.
 * @return void
 */
function breakpoint($message) {
    header("Content-type: application/json");
    print_r($message);
    exit();
}

/**
 * Prints the given message as an alert and redirects the user.
 *
 * @param mixed $message The message to be displayed.
 * @param string $redirect The URL to redirect the user to. If empty, the user will be redirected back.
 * @return void
 */
function alert($message, $redirect = "") {
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

/**
 * Sends an HTTP request using cURL and returns the response.
 *
 * This function initiates a cURL session to send an HTTP request to the specified URL using the given method, headers, 
 * and data. It supports custom request methods and bypasses SSL verification. If the request fails, the function returns false.
 *
 * @param string $url     The URL to which the request is sent.
 * @param string $method  The HTTP method to use for the request (e.g., 'GET', 'POST', 'PUT', 'DELETE').
 * @param array  $headers An array of HTTP headers to include in the request.
 * @param mixed  $data    The data to send with the request. Typically an associative array or a JSON string.
 *
 * @return mixed The response from the server as a string, or false if the request fails.
 */
function sendCurl($url, $method, $headers, $data) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);

    if (curl_errno($ch) != 0) {
        throw new Exception(curl_error($ch));
    }

    curl_close($ch);
    return $result;
}

function getUser() {
    $db = new SQLite3("database.db");

    if (isset($_COOKIE["session"]) == false) {
        return false;
    }

    $query = <<<SQL
        SELECT * FROM `users` WHERE `session` = :session
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

function renderHeader($type) {
    switch ($type) {
        case "login":
            return <<<HTML
                <div class="-header">
                    <div></div>
                    <div class="title">
                        <div class="title -pad -title">
                            Huni sa Tribu
                        </div>
                        <div class="subtitle -pad">
                            Administrative Access
                        </div>
                    </div>
                    <div></div>
                </div>
            HTML;

            break;
        case "home":
            return <<<HTML
                <div class="-header -header--user">
                    <div></div>
                    <div class="title">
                        <div class="title -pad -title">
                            Huni sa Tribu
                        </div>
                        <div class="subtitle -pad">
                            Administrative Access
                        </div>
                    </div>
                    <div></div>
                    <form action="server.php" class="-form logout -pad -center__flex" method="post" enctype="multipart/form-data">
                        <button class="-button" name="method" value="logout">
                            <div class="-iconlabel">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111111"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
                                </div>
                                <div class="label">
                                    Logout
                                </div>
                            </div>
                        </button>
                    </form>
                </div>
            HTML;

            break;
        case "content":
            return <<<HTML
                <div class="-header__content">
                    <a href="./" class="-a back -pad">
                        <div class="button -pad -center__flex">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m313-440 196 196q12 12 11.5 28T508-188q-12 11-28 11.5T452-188L188-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l264-264q11-11 27.5-11t28.5 11q12 12 12 28.5T508-715L313-520h447q17 0 28.5 11.5T800-480q0 17-11.5 28.5T760-440H313Z"/></svg>
                        </div>
                        <div class="label -pad -center__flex">
                            Back to Admin
                        </div>
                    </a>
                    <div class="title">
                        <div class="title -pad -title">
                            Content Management
                        </div>
                        <div class="subtitle -pad">
                            Manage cultural artifacts and media
                        </div>
                    </div>
                    <div></div>
                </div>
            HTML;

            break;
    }
}

function renderNavigation($type, $selected) {
    switch ($type) {
        case "content_old":
            $allSelected = "";
            $musicSelected = "";
            $instrumentsSelected = "";
            $videosSelected = "";

            if ($selected == "all") {
                $allSelected = "tab--selected";
            } else if ($selected == "music") {
                $musicSelected = "tab--selected";
            } else if ($selected == "instruments") {
                $instrumentsSelected = "tab--selected";
            } else if ($selected == "videos") {
                $videosSelected = "tab--selected";
            }

            return <<<HTML
                <div class="-navigation">
                    <div class="title -pad -center">
                        CONTENT CATEGORIES
                    </div>
                    <a href="content/" class="-a all tab {$allSelected} -pad">
                        <div class="box -pad -center">
                            All Content
                        </div>
                    </a>
                    <a href="content/?type=music" class="-a music tab {$musicSelected} -pad">
                        <div class="box -pad -center">
                            Music
                        </div>
                    </a>
                    <a href="content/?type=instrument" class="-a instruments tab {$instrumentsSelected} -pad">
                        <div class="box -pad -center">
                            Instruments
                        </div>
                    </a>
                    <a href="content/?type=video" class="-a videos tab {$videosSelected} -pad">
                        <div class="box -pad -center">
                            Videos
                        </div>
                    </a>
                </div>
            HTML;
        case "content":
            $allSelected = "";
            $musicSelected = "";
            $instrumentsSelected = "";
            $videosSelected = "";
            $artifactsSelected = "";

            if ($selected == "all") {
                $allSelected = "box--selected";
            } else if ($selected == "music") {
                $musicSelected = "box--selected";
            } else if ($selected == "instrument") {
                $instrumentsSelected = "box--selected";
            } else if ($selected == "video") {
                $videosSelected = "box--selected";
            } else if ($selected == "artifact") {
                $artifactsSelected = "box--selected";
            }

            return <<<HTML
                <div class="-navigation -navigation--content">
                    <a href="./" class="-a back -pad">
                        <div class="-iconlabel">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m313-440 196 196q12 12 11.5 28T508-188q-12 11-28 11.5T452-188L188-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l264-264q11-11 27.5-11t28.5 11q12 12 12 28.5T508-715L313-520h447q17 0 28.5 11.5T800-480q0 17-11.5 28.5T760-440H313Z"/></svg>
                            </div>
                            <div class="label">
                                Back to Admin
                            </div>
                        </div>
                    </a>
                    <div class="title -pad -title">
                        Content Management
                    </div>
                    <div class="description -pad">
                        Manage cultural artifacts and media
                    </div>
                    <div class="categories">
                        <div class="title -pad">
                            CONTENT CATEGORIES
                        </div>
                        <div class="tabs">
                            <a href="content/" class="-a all tab -pad">
                                <div class="box {$allSelected} -pad">
                                    All Content
                                </div>
                            </a>
                            <a href="content/?category=music" class="-a music tab -pad">
                                <div class="box {$musicSelected} -pad">
                                    Music
                                </div>
                            </a>
                            <a href="content/?category=instrument" class="-a instruments tab -pad">
                                <div class="box {$instrumentsSelected} -pad">
                                    Instruments
                                </div>
                            </a>
                            <a href="content/?category=video" class="-a videos tab -pad">
                                <div class="box {$videosSelected} -pad">
                                    Videos
                                </div>
                            </a>
                            <a href="content/?category=artifact" class="-a artifacts tab -pad">
                                <div class="box {$artifactsSelected} -pad">
                                    Artifacts
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            HTML;
        case "visitor":
            $visitorSelected = "";
            $qrSelected = "";
            $analyticsSelected = "";

            if ($selected == "visitor") {
                $visitorSelected = "box--selected";
            } else if ($selected == "qr") {
                $qrSelected = "box--selected";
            } else if ($selected == "analytics") {
                $analyticsSelected = "box--selected";
            }

            return <<<HTML
                <div class="-navigation -navigation--visitor">
                    <a href="./" class="-a back -pad">
                        <div class="-iconlabel">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m313-440 196 196q12 12 11.5 28T508-188q-12 11-28 11.5T452-188L188-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l264-264q11-11 27.5-11t28.5 11q12 12 12 28.5T508-715L313-520h447q17 0 28.5 11.5T800-480q0 17-11.5 28.5T760-440H313Z"/></svg>
                            </div>
                            <div class="label">
                                Back to Admin
                            </div>
                        </div>
                    </a>
                    <div class="title -pad -title">
                        Visitor Management
                    </div>
                    <div class="description -pad">
                        Visitors Engagement and Activities
                    </div>
                    <div class="categories">
                        <div class="title -pad">
                            VISITOR CATEGORIES
                        </div>
                        <div class="tabs">
                            <a href="visitor/" class="-a all tab -pad">
                                <div class="box {$visitorSelected} -pad">
                                    Visitors
                                </div>
                            </a>
                            <a href="visitor/qr/" class="-a music tab -pad">
                                <div class="box {$qrSelected} -pad">
                                    QR Codes
                                </div>
                            </a>
                            <a href="visitor/analytics/" class="-a instruments tab -pad">
                                <div class="box {$analyticsSelected} -pad">
                                    Analytics
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            HTML;
    }
}

function renderContentRowOld($row) {
    $date = date("m/d/Y", $row["time"]);

    return <<<HTML
        <div class="date data -pad -center__flex">
            {$date}
        </div>
        <div class="title data -pad -center__flex">
            {$row["title"]}
        </div>
        <div class="tribe data -pad -center__flex">
            {$row["tribe"]}
        </div>
        <div class="category data -pad -center__flex">
            {$row["category"]}
        </div>
        <div class="type data -pad -center__flex">
            {$row["type"]}
        </div>
        <div class="engagement data -pad -center__flex">
            0%
        </div>
        <div class="webviews data -pad -center__flex">
            0
        </div>
        <div class="appscans data -pad -center__flex">
            0
        </div>
        <a href="content/edit/?id={$row['id']}" class="actions data -pad -center__flex">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111111"><path d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z"/></svg>
        </a>
    HTML;
}

function renderContentRow($row) {
    $date = date("m/d/Y", $row["time"]);

    return <<<HTML
        <tr>
            <td class="date data -pad -center">
                {$date}
            </td>
            <td class="title data -pad -center">
                {$row["title"]}
            </td>
            <td class="tribe data -pad -center">
                {$row["tribe"]}
            </td>
            <td class="category data -pad -center">
                {$row["category"]}
            </td>
            <td class="type data -pad -center">
                {$row["type"]}
            </td>
            <td class="engagement data -pad -center">
                0%
            </td>
            <td class="appscans data -pad -center">
                0
            </td>
            <td class="actions data -pad -center">
                <a href="content/edit/?id={$row['id']}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111111"><path d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z"/></svg>
                </a>
            </td>
        </tr>
    HTML;
}

function buildQuery(SQLite3 $db, string $query, array $conditons = [], array $binds = [], string $options = ""): SQLite3Result|false {
    if (count($conditons) > 0) {
        $query .= " WHERE " . implode(" AND ", $conditons);
    }

    $query .= " {$options}";
    $stmt = $db->prepare($query);

    foreach ($binds as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $result = $stmt->execute();
    return $result;
}