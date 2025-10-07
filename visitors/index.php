<?php

chdir("../");
require_once "common.php";
$db = new SQLite3("database.db");
$data = [];

$query = <<<SQL
    SELECT * FROM `scans`
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
$topSchools = getTopSchools();
$first = isset($topSchools[0]) ? $topSchools[0] : "N/A";
$second = isset($topSchools[1]) ? $topSchools[1] : "N/A";
$third = isset($topSchools[2]) ? $topSchools[2] : "N/A";

?>

<html>
    <head>
        <title>
            Visitors Management | Huni Sa Tribu
        </title>
        <base href="../">
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            option {
                color: #000;
                background-color: #fff;
            }
        </style>
    </head>
    <body>
        <div style="
            display: grid;
            grid-template-rows: max-content 1fr;
            height: 100%;
            box-sizing: border-box;">
            <?=renderHeader("visitors")?>
            <div style="
                background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/visitors_bg.jpg');
                background-size: cover;
                background-position: bottom;
                overflow: auto;">
                <div style="
                    padding: 5rem;">
                    <div style="
                        display: grid;
                        grid-template-columns: max-content 1fr repeat(2, max-content);">
                        <div>
                            <div style="
                                padding: 1rem;
                                font-size: 1.5rem;
                                font-weight: bold;">
                                Visitors Management
                            </div>
                            <div style="
                                padding: 1rem;
                                padding-top: 0rem;">
                                Visitors Engagement and Activities
                            </div>
                        </div>
                        <div></div>
                        <div>
                            <div style="
                                display: grid;
                                grid-template-columns: repeat(2, 1fr);">
                                <div style="
                                    display: flex;
                                    align-items: center;
                                    padding: 1rem;">
                                    Filter Start Date:
                                </div>
                                <div style="
                                    padding: 1rem;
                                    padding-left: 0rem;">
                                    <input type="date"
                                        id="inputStartDate">
                                </div>
                            </div>
                            <div style="
                                display: grid;
                                grid-template-columns: repeat(2, 1fr);">
                                <div style="
                                    display: flex;
                                    align-items: center;
                                    padding: 1rem;
                                    padding-top: 0rem;">
                                    Filter End Date:
                                </div>
                                <div style="
                                    padding: 1rem;
                                    padding-left: 0rem;
                                    padding-top: 0rem;">
                                    <input type="date"
                                        id="inputEndDate">
                                </div>
                            </div>
                        </div>
                        <div style="
                            display: flex;
                            align-items: center;
                            padding: 1rem;">
                            <button style="
                                border-radius: 1rem;
                                background-color: #5c6;"
                                id="btnResetFilters">
                                Reset Filters
                            </button>
                        </div>
                    </div>
                    <?=renderVisitorTabs("overview")?>
                    <div style="
                        padding: 1rem;">
                        <div style="
                            display: grid;
                            grid-template-columns: repeat(3, 1fr);
                            border: 1px solid #fff5">
                            <div style="
                                padding: 1rem;">
                                <div style="
                                    background-image: linear-gradient(to bottom, #555a, #5555);
                                    border-radius: 1rem;">
                                    <div style="
                                        padding: 1rem;
                                        text-align: center;
                                        font-size: 1.5rem;
                                        font-weight: bold;">
                                        Total Visitors
                                    </div>
                                    <div style="
                                        padding: 1rem;
                                        padding-top: 0rem;
                                        text-align: center;
                                        font-size: 2rem;
                                        font-weight: bold;">
                                        <?=getTotalVisitors()?>
                                    </div>
                                </div>
                            </div>
                            <div style="
                                padding: 1rem;">
                                <div style="
                                    background-image: linear-gradient(to bottom, #555a, #5555);
                                    border-radius: 1rem;">
                                    <div style="
                                        padding: 1rem;
                                        text-align: center;
                                        font-size: 1.5rem;
                                        font-weight: bold;">
                                        Visitors this date range
                                    </div>
                                    <div style="
                                        padding: 1rem;
                                        padding-top: 0rem;
                                        text-align: center;
                                        font-size: 2rem;
                                        font-weight: bold;">
                                        <?=getVisitorsWithinRange()?>
                                    </div>
                                </div>
                            </div>
                            <div style="
                                padding: 1rem;">
                                <div style="
                                    background-image: linear-gradient(to bottom, #555a, #5555);
                                    border-radius: 1rem;">
                                    <div style="
                                        padding: 1rem;
                                        text-align: center;
                                        font-size: 1.5rem;
                                        font-weight: bold;">
                                        Peak Hour
                                    </div>
                                    <div style="
                                        padding: 1rem;
                                        padding-top: 0rem;
                                        text-align: center;
                                        font-size: 2rem;
                                        font-weight: bold;">
                                        <?=getPeakHour()?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="
                        padding: 1rem;">
                        <div style="
                            display: grid;
                            grid-template-columns: repeat(2, 1fr);
                            padding: 1rem;
                            border: 1px solid #fff5;">
                            <div>
                                <?php
                                    $content = getMostScanned();

                                    if ($content == false) {
                                        echo <<<HTML
                                            <img style="
                                                width: 100%"
                                                src="assets/image.png">
                                        HTML;
                                    } else {
                                        echo renderContent($content);
                                    }
                                ?>
                            </div>
                            <div style="
                                display: grid;
                                grid-template-rows: 1fr repeat(3, max-content) 1fr;
                                background-image: linear-gradient(to bottom, #555a, #5555);">
                                <div></div>
                                <div style="
                                    padding: 1rem;
                                    font-size: 2rem;
                                    font-weight: bold;
                                    text-align: center;">
                                    MOST SCANNED
                                </div>
                                <div style="
                                    padding: 1rem;
                                    font-size: 1.5rem;
                                    text-align: center;">
                                    <?=getMostScanned()["title"] ?? "None"?>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    padding-top: 0rem;
                                    color: #aaa;
                                    text-align: center;">
                                    <?=getScanCount(getMostScanned())?> total scans
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="
                        padding: 1rem;">
                        <div style="
                            display: grid;
                            grid-template-columns: repeat(2, 1fr);
                            padding: 1rem;
                            border: 1px solid #fff5">
                            <div style="
                                display: grid;
                                grid-template-rows: 1fr repeat(4, max-content) 1fr;
                                background-image: linear-gradient(to bottom, #555a, #5555);">
                                <div></div>
                                <div style="
                                    padding: 1rem;
                                    font-size: 2rem;
                                    font-weight: bold;
                                    text-align: center;">
                                    School Visit Leaderboard
                                </div>
                                <div style="
                                    padding: 1rem;
                                    font-size: 1.5rem;
                                    text-align: center;">
                                    1. <?=$first?>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    padding-top: 0rem;
                                    font-size: 1.5rem;
                                    text-align: center;">
                                    2. <?=$second?>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    padding-top: 0rem;
                                    font-size: 1.5rem;
                                    text-align: center;">
                                    3. <?=$third?>
                                </div>
                            </div>
                            <div>
                                <img style="
                                    width: 100%;"
                                    src="assets/tagum.jpg">
                            </div>
                        </div>
                    </div>
                </div>
                <div style="
                    padding: 5rem;
                    background-image: linear-gradient(to bottom, #020, #000);">
                    <div style="
                        padding: 1rem;
                        text-align: center;">
                        <select style="
                            width: 10rem;
                            color: #fff;
                            border: none;
                            background-color: transparent;
                            border-bottom: 1px solid #fff5;"
                            id="selectChart">
                            <option value="daily">
                                Daily
                            </option>
                            <option value="weekly">
                                Weekly
                            </option>
                            <option value="monthly">
                                Monthly
                            </option>
                        </select>
                    </div>
                    <div style="
                        padding: 1rem;">
                        <canvas style="
                            display: none;
                            width: 100%;
                            height: 30rem;"
                            id="canvasChartDaily">
                        </canvas>
                        <canvas style="
                            display: none;
                            width: 100%;
                            height: 30rem;"
                            id="canvasChartWeekly">
                        </canvas>
                        <canvas style="
                            display: none;
                            width: 100%;
                            height: 30rem;"
                            id="canvasChartMonthly">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="script.js"></script>
        <script>
            const canvasChartDaily = document.getElementById('canvasChartDaily');
            const canvasChartWeekly = document.getElementById('canvasChartWeekly');
            const canvasChartMonthly = document.getElementById('canvasChartMonthly');
            const selectChart = document.getElementById('selectChart');
            const inputStartDate = document.getElementById('inputStartDate');
            const inputEndDate = document.getElementById('inputEndDate');
            const btnResetFilters = document.getElementById('btnResetFilters');
            initialize();

            function initialize() {
                let startDate = new URLSearchParams(location.search).get("startDate");
                let endDate = new URLSearchParams(location.search).get("endDate");
                if (startDate) inputStartDate.value = new Date(startDate * 1000).toISOString().split("T")[0];
                if (endDate) inputEndDate.value = new Date(endDate * 1000).toISOString().split("T")[0];
            }

            inputStartDate.onchange = () => {
                const searchParams = new URLSearchParams(location.search);
                searchParams.set('startDate', new Date(inputStartDate.value).getTime() / 1000);
                location.search = searchParams;
            }

            inputEndDate.onchange = () => {
                const searchParams = new URLSearchParams(location.search);
                searchParams.set('endDate', new Date(inputEndDate.value).getTime() / 1000);
                location.search = searchParams;
            }

            btnResetFilters.onclick = () => location.href = "visitors/";

            selectChart.onchange = () => {
                canvasChartDaily.style.display = "none";
                canvasChartWeekly.style.display = "none";
                canvasChartMonthly.style.display = "none";

                if (selectChart.value == "daily") {
                    canvasChartDaily.style.display = "block";

                    new Chart(canvasChartDaily, {
                        type: 'bar',
                        data: {
                            labels: ['4 days ago', '3 days ago', '2 days ago', 'Yesterday', 'Today'],
                            datasets: [
                                {
                                    label: '# of Visits',
                                    data: <?=json_encode([$analytics["daily"]["4 days ago"], $analytics["daily"]["3 days ago"], $analytics["daily"]["2 days ago"], $analytics["daily"]["yesterday"], $analytics["daily"]["today"]])?>,
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                } else if (selectChart.value == "weekly") {
                    canvasChartWeekly.style.display = "block";

                    new Chart(canvasChartWeekly, {
                        type: 'bar',
                        data: {
                            labels: ['4 weeks ago', '3 weeks ago', '2 weeks ago', 'Last Week', 'This Week'],
                            datasets: [
                                {
                                    label: '# of Visits',
                                    data: <?=json_encode([$analytics["weekly"]["4 weeks ago"], $analytics["weekly"]["3 weeks ago"], $analytics["weekly"]["2 weeks ago"], $analytics["weekly"]["last week"], $analytics["weekly"]["this week"]])?>,
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                } else if (selectChart.value == "monthly") {
                    canvasChartMonthly.style.display = "block";

                    new Chart(canvasChartMonthly, {
                        type: 'bar',
                        data: {
                            labels: ['4 months ago', '3 months ago', '2 months ago', 'Last Month', 'This Month'],
                            datasets: [
                                {
                                    label: '# of Visits',
                                    data: <?=json_encode([$analytics["monthly"]["4 months ago"], $analytics["monthly"]["3 months ago"], $analytics["monthly"]["2 months ago"], $analytics["monthly"]["last month"], $analytics["monthly"]["this month"]])?>,
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            }

            selectChart.onchange();
        </script>
    </body>
</html>