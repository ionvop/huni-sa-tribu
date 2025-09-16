<?php

chdir("../../");
require_once "common.php";
$db = new SQLite3("database.db");

$data = [];

$query = <<<SQL
    SELECT * FROM `qr_scans`
SQL;

$stmt = $db->prepare($query);
$result = $stmt->execute();

while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $data[] = [
        "value" => 1,
        "time" => $row["time"]
    ];
}

$analytics = aggregateData($data, time());
$dailyMax = max(array_values($analytics["daily"]));
$dailyMin = min(array_values($analytics["daily"]));

$weeklyMax = max(array_values($analytics["weekly"]));
$weeklyMin = min(array_values($analytics["weekly"]));

$monthlyMax = max(array_values($analytics["monthly"]));
$monthlyMin = min(array_values($analytics["monthly"]));

?>

<html>
    <head>
        <title>
            Visitor Analytics
        </title>
        <base href="../../">
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body > .main {
                display: grid;
                grid-template-columns: max-content 1fr;
                height: 100%;
                overflow: hidden;

                & > .content {
                    overflow: auto;
                    background-color: #f5fafa;
                }
            }
        </style>
    </head>
    <body>
        <div class="main">
            <?=renderNavigation("visitor", "analytics")?>
            <div class="content">
                <div class="title -pad -title">
                    Analytics
                </div>
                <div class="description -pad">
                    View detailed analytics and reports
                </div>
                <div style="
                    padding: 1rem;">
                    <div style="
                        background-color: #fff;
                        border-radius: 1rem;
                        padding: 1rem;">
                        <div style="
                            padding: 1rem;
                            font-weight: bold;">
                            Guest Analytics
                        </div>
                        <div style="
                            padding: 1rem;
                            padding-top: 0rem;">
                            Track visitor patterns across different time periods
                        </div>
                        <div style="
                            padding: 1rem;">
                            <div style="
                                display: grid;
                                grid-template-columns: repeat(3, 1fr);
                                background-color: #eee;
                                border-radius: 1rem;">
                                <div style="
                                    padding: 1rem;">
                                    <div style="
                                        padding: 1rem;
                                        border-radius: 1rem;
                                        background-color: #fff;
                                        text-align: center;"
                                        id="tabDaily">
                                        Daily
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;">
                                    <div style="
                                        padding: 1rem;
                                        border-radius: 1rem;
                                        text-align: center;"
                                        id="tabWeekly">
                                        Weekly
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;">
                                    <div style="
                                        padding: 1rem;
                                        border-radius: 1rem;
                                        text-align: center;"
                                        id="tabMonthly">
                                        Monthly
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="
                            padding: 1rem;"
                            id="panelDaily">
                            <div style="
                                display: grid;
                                grid-template-columns: repeat(6, 1fr);">
                                <div style="
                                    display: grid;
                                    grid-template-rows: max-content 1fr max-content;">
                                    <div style="
                                        text-align: center;
                                        font-weight: bold;">
                                        <?=$dailyMax?>
                                    </div>
                                    <div></div>
                                    <div style="
                                        text-align: center;
                                        font-weight: bold;
                                        padding-bottom: 2rem;">
                                        0
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    display: grid;
                                    grid-template-rows: 1fr max-content;">
                                    <div></div>
                                    <div style="
                                        border-radius: 1rem;
                                        height: <?=20 * ($analytics["daily"]["4 days ago"] / $dailyMax)?>rem;
                                        background-color: #55a;">
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    display: grid;
                                    grid-template-rows: 1fr max-content;">
                                    <div></div>
                                    <div style="
                                        border-radius: 1rem;
                                        height: <?=20 * ($analytics["daily"]["3 days ago"] / $dailyMax)?>rem;
                                        background-color: #55a;">
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    display: grid;
                                    grid-template-rows: 1fr max-content;">
                                    <div></div>
                                    <div style="
                                        border-radius: 1rem;
                                        height: <?=20 * ($analytics["daily"]["2 days ago"] / $dailyMax)?>rem;
                                        background-color: #55a;">
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    display: grid;
                                    grid-template-rows: 1fr max-content;">
                                    <div></div>
                                    <div style="
                                        border-radius: 1rem;
                                        height: <?=20 * ($analytics["daily"]["yesterday"] / $dailyMax)?>rem;
                                        background-color: #55a;">
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    display: grid;
                                    grid-template-rows: 1fr max-content;">
                                    <div></div>
                                    <div style="
                                        border-radius: 1rem;
                                        height: <?=20 * ($analytics["daily"]["today"] / $dailyMax)?>rem;
                                        background-color: #55a;">
                                    </div>
                                </div>
                            </div>
                            <div style="
                                display: grid;
                                grid-template-columns: repeat(6, 1fr);">
                                <div></div>
                                <div style="
                                    text-align: center;">
                                    4 days ago
                                </div>
                                <div style="
                                    text-align: center;">
                                    3 days ago
                                </div>
                                <div style="
                                    text-align: center;">
                                    2 days ago
                                </div>
                                <div style="
                                    text-align: center;">
                                    Yesterday
                                </div>
                                <div style="
                                    text-align: center;">
                                    Today
                                </div>
                            </div>
                        </div>
                        <div style="
                            padding: 1rem;"
                            id="panelWeekly">
                            <div style="
                                display: grid;
                                grid-template-columns: repeat(6, 1fr);">
                                <div style="
                                    display: grid;
                                    grid-template-rows: max-content 1fr max-content;">
                                    <div style="
                                        text-align: center;
                                        font-weight: bold;">
                                        <?=$weeklyMax?>
                                    </div>
                                    <div></div>
                                    <div style="
                                        text-align: center;
                                        font-weight: bold;
                                        padding-bottom: 2rem;">
                                        0
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    display: grid;
                                    grid-template-rows: 1fr max-content;">
                                    <div></div>
                                    <div style="
                                        border-radius: 1rem;
                                        height: <?=20 * ($analytics["weekly"]["4 weeks ago"] / $weeklyMax)?>rem;
                                        background-color: #55a;">
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    display: grid;
                                    grid-template-rows: 1fr max-content;">
                                    <div></div>
                                    <div style="
                                        border-radius: 1rem;
                                        height: <?=20 * ($analytics["weekly"]["3 weeks ago"] / $weeklyMax)?>rem;
                                        background-color: #55a;">
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    display: grid;
                                    grid-template-rows: 1fr max-content;">
                                    <div></div>
                                    <div style="
                                        border-radius: 1rem;
                                        height: <?=20 * ($analytics["weekly"]["2 weeks ago"] / $weeklyMax)?>rem;
                                        background-color: #55a;">
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    display: grid;
                                    grid-template-rows: 1fr max-content;">
                                    <div></div>
                                    <div style="
                                        border-radius: 1rem;
                                        height: <?=20 * ($analytics["weekly"]["last week"] / $weeklyMax)?>rem;
                                        background-color: #55a;">
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    display: grid;
                                    grid-template-rows: 1fr max-content;">
                                    <div></div>
                                    <div style="
                                        border-radius: 1rem;
                                        height: <?=20 * ($analytics["weekly"]["this week"] / $weeklyMax)?>rem;
                                        background-color: #55a;">
                                    </div>
                                </div>
                            </div>
                            <div style="
                                display: grid;
                                grid-template-columns: repeat(6, 1fr);">
                                <div></div>
                                <div style="
                                    text-align: center;">
                                    4 weeks ago
                                </div>
                                <div style="
                                    text-align: center;">
                                    3 weeks ago
                                </div>
                                <div style="
                                    text-align: center;">
                                    2 weeks ago
                                </div>
                                <div style="
                                    text-align: center;">
                                    Last Week
                                </div>
                                <div style="
                                    text-align: center;">
                                    This Week
                                </div>
                            </div>
                        </div>
                        <div style="
                            padding: 1rem;"
                            id="panelMonthly">
                            <div style="
                                display: grid;
                                grid-template-columns: repeat(6, 1fr);">
                                <div style="
                                    display: grid;
                                    grid-template-rows: max-content 1fr max-content;">
                                    <div style="
                                        text-align: center;
                                        font-weight: bold;">
                                        <?=$monthlyMax?>
                                    </div>
                                    <div></div>
                                    <div style="
                                        text-align: center;
                                        font-weight: bold;
                                        padding-bottom: 2rem;">
                                        0
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    display: grid;
                                    grid-template-rows: 1fr max-content;">
                                    <div></div>
                                    <div style="
                                        border-radius: 1rem;
                                        height: <?=20 * ($analytics["monthly"]["4 months ago"] / $monthlyMax)?>rem;
                                        background-color: #55a;">
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    display: grid;
                                    grid-template-rows: 1fr max-content;">
                                    <div></div>
                                    <div style="
                                        border-radius: 1rem;
                                        height: <?=20 * ($analytics["monthly"]["3 months ago"] / $monthlyMax)?>rem;
                                        background-color: #55a;">
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    display: grid;
                                    grid-template-rows: 1fr max-content;">
                                    <div></div>
                                    <div style="
                                        border-radius: 1rem;
                                        height: <?=20 * ($analytics["monthly"]["2 months ago"] / $monthlyMax)?>rem;
                                        background-color: #55a;">
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    display: grid;
                                    grid-template-rows: 1fr max-content;">
                                    <div></div>
                                    <div style="
                                        border-radius: 1rem;
                                        height: <?=20 * ($analytics["monthly"]["last month"] / $monthlyMax)?>rem;
                                        background-color: #55a;">
                                    </div>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    display: grid;
                                    grid-template-rows: 1fr max-content;">
                                    <div></div>
                                    <div style="
                                        border-radius: 1rem;
                                        height: <?=20 * ($analytics["monthly"]["this month"] / $monthlyMax)?>rem;
                                        background-color: #55a;">
                                    </div>
                                </div>
                            </div>
                            <div style="
                                display: grid;
                                grid-template-columns: repeat(6, 1fr);">
                                <div></div>
                                <div style="
                                    text-align: center;">
                                    4 months ago
                                </div>
                                <div style="
                                    text-align: center;">
                                    3 months ago
                                </div>
                                <div style="
                                    text-align: center;">
                                    2 months ago
                                </div>
                                <div style="
                                    text-align: center;">
                                    Last Month
                                </div>
                                <div style="
                                    text-align: center;">
                                    This Month
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="script.js"></script>
        <script>
            let tabDaily = document.getElementById("tabDaily");
            let tabWeekly = document.getElementById("tabWeekly");
            let tabMonthly = document.getElementById("tabMonthly");
            let panelDaily = document.getElementById("panelDaily");
            let panelWeekly = document.getElementById("panelWeekly");
            let panelMonthly = document.getElementById("panelMonthly");
            update("daily");

            function update(type) {
                tabDaily.style.backgroundColor = "transparent";
                tabWeekly.style.backgroundColor = "transparent";
                tabMonthly.style.backgroundColor = "transparent";

                panelDaily.style.display = "none";
                panelWeekly.style.display = "none";
                panelMonthly.style.display = "none";

                switch (type) {
                    case "daily": {
                        tabDaily.style.backgroundColor = "#fff";
                        panelDaily.style.display = "block";
                    } break;
                    case "weekly": {
                        tabWeekly.style.backgroundColor = "#fff";
                        panelWeekly.style.display = "block";
                    } break;
                    case "monthly": {
                        tabMonthly.style.backgroundColor = "#fff";
                        panelMonthly.style.display = "block";
                    } break;
                }
            }

            tabDaily.onclick = () => update("daily");
            tabWeekly.onclick = () => update("weekly");
            tabMonthly.onclick = () => update("monthly");
        </script>
    </body>
</html>