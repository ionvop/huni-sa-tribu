<?php

/**
 * Prints the given message and exits the script.
 *
 * @param mixed $message The message to be printed.
 * @return void
 */
function breakpoint($message) {
    header("Content-type: application/json");
    print_r($message);
    exit;
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

    exit;
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
    $user = $stmt->execute()->fetchArray();

    if ($user == false) {
        return false;
    }

    if ($user["session"] == null) {
        return false;
    }

    return $user;
}

function renderHeader($page) {
    $eval = function($x) {
        return $x;
    };

    return <<<HTML
        <div style="
            display: grid;
            grid-template-columns: max-content 1fr repeat(4, max-content);
            background-image: linear-gradient(to right, #000, #030);">
            <div>
                <div style="
                    padding: 1rem;
                    font-size: 1.5rem;
                    font-family: 'Times New Roman', Times, serif;">
                    HUNI SA TRIBU
                </div>
                <div style="
                    padding: 1rem;
                    padding-top: 0rem;
                    color: #aaa;">
                    Cultural Heritage Museum
                </div>
            </div>
            <div></div>
            <a style="
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;"
                href="home/">
                <div style="
                    padding: 1rem;
                    {$eval($page == 'home' ? 'background-color: #5c6;' : '')}
                    {$eval($page == 'home' ? 'color: #000;' : 'color: #fff;')}
                    border-radius: 1rem;">
                    Home
                </div>
            </a>
            <a style="
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;"
                href="content/">
                <div style="
                    padding: 1rem;
                    {$eval($page == 'content' ? 'background-color: #5c6;' : '')}
                    {$eval($page == 'content' ? 'color: #000;' : 'color: #fff;')}
                    border-radius: 1rem;">
                    Content Management
                </div>
            </a>
            <a style="
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;"
                href="visitors/">
                <div style="
                    padding: 1rem;
                    {$eval($page == 'visitors' ? 'background-color: #5c6;' : '')}
                    {$eval($page == 'visitors' ? 'color: #000;' : 'color: #fff;')}
                    border-radius: 1rem;">
                    Visitors Management
                </div>
            </a>
            <form style="
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;
                cursor: pointer;"
                action="server.php"
                method="post"
                enctype="multipart/form-data"
                id="g_btnLogout">
                <div style="
                    padding: 1rem;
                    color: #fff;
                    border-radius: 1rem;">
                    Logout
                </div>
                <input type="hidden"
                    name="method"
                    value="logout">
            </form>
        </div>
    HTML;
}

function renderVisitorTabs($tab) {
    $eval = function($x) {
        return $x;
    };

    return <<<HTML
        <div style="
            display: grid;
            grid-template-columns: repeat(3, max-content) 1fr;
            padding-top: 5rem;">
            <a style="
                display: block;
                padding: 1rem;"
                href="visitors/">
                <div style="
                    padding: 1rem;
                    border-radius: 1rem;
                    {$eval($tab == 'overview' ? 'background-color: #5c6;' : '')}">
                    Overview
                </div>
            </a>
            <a style="
                display: block;
                padding: 1rem;
                padding-left: 0rem;"
                href="visitors/visitors/">
                <div style="
                    padding: 1rem;
                    border-radius: 1rem;
                    {$eval($tab == 'visitors' ? 'background-color: #5c6;' : '')}">
                    Visitors
                </div>
            </a>
            <a style="
                display: block;
                padding: 1rem;
                padding-left: 0rem;"
                href="visitors/qr/">
                <div style="
                    padding: 1rem;
                    border-radius: 1rem;
                    {$eval($tab == 'qr' ? 'background-color: #5c6;' : '')}">
                    QR Scans
                </div>
            </a>
        </div>
    HTML;
}

function getFileType($file) {
    if (strpos(mime_content_type("uploads/{$file}"), "image/") === 0) {
        return "image";
    } else if (strpos(mime_content_type("uploads/{$file}"), "video/") === 0) {
        return "video";
    } else if (strpos(mime_content_type("uploads/{$file}"), "audio/") === 0) {
        return "audio";
    }

    return false;
}

function getQrContent($qr) {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT * FROM `content` WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $qr["content_id"]);
    return $stmt->execute()->fetchArray();
}

function getQrScans($qr) {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT COUNT(*) FROM `scans` WHERE `qr_id` = :id
    SQL;

    $result = $db->prepare($query);
    $result->bindValue(":id", $qr["id"]);
    return $result->execute()->fetchArray()[0];
}

function getQrLastScan($qr) {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT * FROM `scans` WHERE `qr_id` = :id ORDER BY `time` DESC LIMIT 1
    SQL;

    $result = $db->prepare($query);
    $result->bindValue(":id", $qr["id"]);
    $scan = $result->execute()->fetchArray();

    if ($scan == false) {
        return false;
    }

    return $scan["time"];
}

function getTotalVisitors() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT COUNT(*) FROM `visitors`
    SQL;

    $result = $db->query($query);
    return $result->fetchArray()[0];
}

function getVisitorsWithinMonth() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT COUNT(*)
        FROM (
            SELECT * FROM `visits`
            WHERE `time` > :time
            GROUP BY `visitor_id`
        )
    SQL;

    $result = $db->prepare($query);
    $result->bindValue(":time", time() - (86400 * 30));
    return $result->execute()->fetchArray()[0];
}

function majorityHour(array $timestamps): ?int {
    if (empty($timestamps)) {
        return false; // No timestamps to analyze
    }

    $hourCounts = [];

    foreach ($timestamps as $ts) {
        // Ensure it's a valid integer timestamp
        $ts = (int)$ts;
        $hour = (int)date('G', $ts); // 'G' gives 0-23 without leading zero
        $hourCounts[$hour] = ($hourCounts[$hour] ?? 0) + 1;
    }

    // Find the hour with the maximum count
    arsort($hourCounts); // Sort by count descending, preserving keys
    $majorityHour = array_key_first($hourCounts);

    return $majorityHour;
}

function convertToAmPm(int $hour): string {
    if ($hour < 0 || $hour > 23) {
        throw new InvalidArgumentException("Hour must be between 0 and 23.");
    }

    $suffix = $hour < 12 ? 'AM' : 'PM';
    $hour12 = $hour % 12;
    if ($hour12 === 0) {
        $hour12 = 12;
    }

    return $hour12 . $suffix;
}

function getPeakHour() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT `time` FROM `visits`
        WHERE `time` > :time
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":time", time() - (86400 * 30));
    $result = $stmt->execute();
    $timestamps = [];

    while ($row = $result->fetchArray()) {
        $timestamps[] = $row["time"] + 28800;
    }

    return convertToAmPm(majorityHour($timestamps));
}

function getReturningVisitorsRatio() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT * FROM `visitors`
    SQL;

    $result = $db->query($query);
    $total = 0;
    $ratio = 0;

    while ($visitor = $result->fetchArray()) {
        $query = <<<SQL
            SELECT COUNT(*) FROM `visits`
            WHERE `visitor_id` = :visitor_id
        SQL;

        $stmt = $db->prepare($query);
        $stmt->bindValue(":visitor_id", $visitor["id"]);
        $count = $stmt->execute()->fetchArray()[0];

        if ($count > 1) {
            $ratio++;
        }

        $total++;
    }

    return $ratio / $total;
}

function getVisitorLastVisit($visitor) {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT * FROM `visits` WHERE `visitor_id` = :id ORDER BY `time` DESC
    SQL;

    $result = $db->prepare($query);
    $result->bindValue(":id", $visitor["id"]);
    return $result->execute()->fetchArray()["time"];
}

function getVisitorContentViews($visitor) {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT COUNT(*) FROM `scans` WHERE `visitor_id` = :id
    SQL;

    $result = $db->prepare($query);
    $result->bindValue(":id", $visitor["id"]);
    return $result->execute()->fetchArray()[0];
}

function getVisitorVisitCount($visitor) {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT COUNT(*) FROM `visits` WHERE `visitor_id` = :id
    SQL;

    $result = $db->prepare($query);
    $result->bindValue(":id", $visitor["id"]);
    return $result->execute()->fetchArray()[0];
}

function getVisitorEngagement($visitor) {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT COUNT(*) FROM `scans`
        WHERE `time` > :time
        GROUP BY `visitor_id`
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":time", time() - (86400 * 7));
    $result = $stmt->execute();
    $total = 0;

    while ($row = $result->fetchArray()) {
        $total += $row[0];
    }

    $query = <<<SQL
        SELECT COUNT(*) FROM `scans`
        WHERE `time` > :time
        AND `visitor_id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":time", time() - (86400 * 7));
    $stmt->bindValue(":id", $visitor["id"]);
    $count = $stmt->execute()->fetchArray()[0];

    if ($total == 0) {
        return 0;
    }

    return $count / $total;
}

function getTotalScans() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT COUNT(*) FROM `scans`
    SQL;

    return $db->query($query)->fetchArray()[0];
}

function getMostScanned() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT COUNT(*) AS `count`, `qr_id` FROM `scans`
        GROUP BY `qr_id` ORDER BY `count` DESC
    SQL;

    $result = $db->query($query);
    $qrId = $result->fetchArray();

    if ($qrId == false) {
        return false;
    }
    
    $query = <<<SQL
        SELECT * FROM `qr` WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $qrId["qr_id"]);
    $qr = $stmt->execute()->fetchArray();

    $query = <<<SQL
        SELECT * FROM `content` WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $qr["content_id"]);
    return $stmt->execute()->fetchArray();
}

function getLeastScanned() {
    $db = new SQLite3("database.db");

    $query = <<<SQL
        SELECT COUNT(*) AS `count`, `qr_id` FROM `scans`
        GROUP BY `qr_id` ORDER BY `count`
    SQL;

    $result = $db->query($query);
    $qrId = $result->fetchArray();

    if ($qrId == false) {
        return false;
    }
    
    $query = <<<SQL
        SELECT * FROM `qr` WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $qrId["qr_id"]);
    $qr = $stmt->execute()->fetchArray();

    $query = <<<SQL
        SELECT * FROM `content` WHERE `id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $qr["content_id"]);
    return $stmt->execute()->fetchArray();
}

function getScanCount($content) {
    $db = new SQLite3("database.db");

    if ($content == false) {
        return 0;
    }

    $query = <<<SQL
        SELECT * FROM `qr` WHERE `content_id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $content["id"]);
    $qr = $stmt->execute()->fetchArray();

    if ($qr == false) {
        return 0;
    }

    $query = <<<SQL
        SELECT COUNT(*) FROM `scans` WHERE `qr_id` = :id
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $qr["id"]);
    return $stmt->execute()->fetchArray()[0];
}

function aggregateData(array $data, int $currentTime): array {
    // Use provided current time or system time
    $currentTime = $currentTime ?? time();
    $today = new DateTimeImmutable("@$currentTime");

    $result = [
        "daily" => [
            "4 days ago" => 0,
            "3 days ago" => 0,
            "2 days ago" => 0,
            "yesterday" => 0,
            "today" => 0,
        ],
        "weekly" => [
            "4 weeks ago" => 0,
            "3 weeks ago" => 0,
            "2 weeks ago" => 0,
            "last week" => 0,
            "this week" => 0,
        ],
        "monthly" => [
            "4 months ago" => 0,
            "3 months ago" => 0,
            "2 months ago" => 0,
            "last month" => 0,
            "this month" => 0,
        ],
    ];

    foreach ($data as $entry) {
        $value = $entry["value"];
        $time = $entry["time"];
        $date = new DateTimeImmutable("@$time");

        // Daily grouping
        $daysDiff = (int)$today->diff($date)->format('%r%a'); // signed day difference
        if ($daysDiff === 0) {
            $result["daily"]["today"] += $value;
        } elseif ($daysDiff === -1) {
            $result["daily"]["yesterday"] += $value;
        } elseif ($daysDiff >= -4 && $daysDiff <= -2) {
            $result["daily"][abs($daysDiff) . " days ago"] += $value;
        }

        // Weekly grouping
        $weekToday = (int)$today->format("oW"); // ISO year+week
        $weekDate = (int)$date->format("oW");
        $weekDiff = $weekDate - $weekToday;

        if ($weekDiff === 0) {
            $result["weekly"]["this week"] += $value;
        } elseif ($weekDiff === -1) {
            $result["weekly"]["last week"] += $value;
        } elseif ($weekDiff >= -4 && $weekDiff <= -2) {
            $result["weekly"][abs($weekDiff) . " weeks ago"] += $value;
        }

        // Monthly grouping
        $monthToday = (int)$today->format("Ym");
        $monthDate = (int)$date->format("Ym");
        $monthDiff = $monthDate - $monthToday;

        if ($monthDiff === 0) {
            $result["monthly"]["this month"] += $value;
        } elseif ($monthDiff === -1) {
            $result["monthly"]["last month"] += $value;
        } elseif ($monthDiff >= -4 && $monthDiff <= -2) {
            $result["monthly"][abs($monthDiff) . " months ago"] += $value;
        }
    }

    return $result;
}

function renderContent($content, $maxHeight = 20) {
    $type = getFileType($content["file"]);

    switch ($type) {
        case "image":
            return <<<HTML
                <img style="
                    width: 100%;
                    max-height: {$maxHeight}rem;
                    object-fit: cover;"
                    src="uploads/{$content['file']}">
            HTML;

            break;
        case "video":
            return <<<HTML
                <video style="
                    width: 100%;
                    max-height: {$maxHeight}rem;
                    object-fit: cover;"
                    src="uploads/{$content['file']}"
                    controls></video>
            HTML;

            break;
        case "audio":
            return <<<HTML
                <audio style="
                    width: 100%;"
                    src="uploads/{$content['file']}"
                    controls></audio>
            HTML;

            break;
    }
}

function hasVisitorScannedToday($visitor) {
    $lastVisit = getVisitorLastVisit($visitor);
    $lastVisit = date("Y-m-d", $lastVisit + (8 * 60 * 60));
    $currentDate = date("Y-m-d", time() + (8 * 60 * 60));
    return $lastVisit == $currentDate;
}