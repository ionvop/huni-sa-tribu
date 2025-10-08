<?php

chdir("../../");
require_once "common.php";
$db = new SQLite3("database.db");

?>

<html>
    <head>
        <title>
            QR Code | Huni Sa Tribu
        </title>
        <base href="../../">
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            button {
                color: #fff;
                border-radius: 2rem;
            }

            table {
                border-collapse: collapse;
                width: 100%;

                & > thead {
                    position: sticky;
                    top: 0rem;

                    & > tr {
                        border-bottom: 1px solid #0005;

                        & > th {
                            padding: 1rem;
                        }
                    }
                }

                & > tbody {
                    & > tr {
                        border-bottom: 1px solid #0005;

                        & > td {
                            padding: 1rem;
                            text-align: center;
                        }
                    }
                }
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
                    padding: 5rem;
                    padding-bottom: 1rem;">
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
                                Monitor visitor engagement across web and mobile platforms
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
                    <?=renderVisitorTabs("qr")?>
                    <div style="
                        display: grid;
                        grid-template-columns: repeat(3, 1fr);
                        border: 1px solid #fff5">
                        <div style="
                            padding: 1rem;">
                            <div style="
                                display: grid;
                                grid-template-rows: 1fr repeat(2, max-content) 1fr;
                                padding: 3rem;
                                height: 100%;
                                box-sizing: border-box;
                                background-image: linear-gradient(to bottom, #555a, #5555);
                                border-radius: 1rem;">
                                <div></div>
                                <div style="
                                    padding: 1rem;
                                    text-align: center;
                                    font-size: 1.5rem;
                                    font-weight: bold;">
                                    Total Scans
                                </div>
                                <div style="
                                    padding: 1rem;
                                    padding-top: 0rem;
                                    text-align: center;
                                    font-size: 2rem;
                                    font-weight: bold;">
                                    <?=getTotalScans()?>
                                </div>
                                <div></div>
                            </div>
                        </div>
                        <div style="
                            padding: 1rem;">
                            <div style="
                                display: grid;
                                grid-template-rows: 1fr repeat(3, max-content) 1fr;
                                padding: 3rem;
                                height: 100%;
                                box-sizing: border-box;
                                background-image: linear-gradient(to bottom, #555a, #5555);
                                border-radius: 1rem;">
                                <div></div>
                                <div style="
                                    padding: 1rem;
                                    text-align: center;
                                    font-size: 1.5rem;
                                    font-weight: bold;">
                                    Least Scanned
                                </div>
                                <div style="
                                    padding: 1rem;
                                    text-align: center;
                                    font-size: 2rem;
                                    font-weight: bold;">
                                    <?=getLeastScanned()["title"] ?? "none"?>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    padding-top: 0rem;
                                    text-align: center;
                                    font-size: 1.5rem;
                                    font-weight: bold;">
                                    <?=getScanCount(getLeastScanned())?> total scans
                                </div>
                                <div></div>
                            </div>
                        </div>
                        <div style="
                            padding: 1rem;">
                            <div style="
                                display: grid;
                                grid-template-rows: 1fr repeat(3, max-content) 1fr;
                                padding: 3rem;
                                height: 100%;
                                box-sizing: border-box;
                                background-image: linear-gradient(to bottom, #555a, #5555);
                                border-radius: 1rem;">
                                <div></div>
                                <div style="
                                    padding: 1rem;
                                    text-align: center;
                                    font-size: 1.5rem;
                                    font-weight: bold;">
                                    Most Scanned
                                </div>
                                <div style="
                                    padding: 1rem;
                                    text-align: center;
                                    font-size: 2rem;
                                    font-weight: bold;">
                                    <?=getMostScanned()["title"] ?? "none"?>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    padding-top: 0rem;
                                    text-align: center;
                                    font-size: 1.5rem;
                                    font-weight: bold;">
                                    <?=getScanCount(getMostScanned())?> total scans
                                </div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="
                    background-image: linear-gradient(to bottom, #020, #000);">
                    <div style="
                        display: grid;
                        grid-template-columns: 1fr max-content;">
                        <div style="
                            display: flex;
                            align-items: center;
                            padding: 1rem;
                            font-size: 1.5rem;
                            font-weight: bold;
                            text-align: center;">
                            QR Code Scans Monitor
                        </div>
                        <div style="
                            display: flex;
                            align-items: center;
                            padding: 1rem;">
                            <input style="
                                border-radius: 1rem;"
                                id="inputSearch"
                                placeholder="Search">
                        </div>
                    </div>
                    <div style="
                        padding: 5rem;
                        padding-top: 1rem;">
                        <div style="
                            background-image: linear-gradient(to bottom, #454, #222);
                            border-radius: 1rem;
                            overflow: hidden;">
                            <table id="qrTable">
                                <thead>
                                    <tr>
                                        <th>
                                            Item Name
                                        </th>
                                        <th>
                                            Type
                                        </th>
                                        <th>
                                            Total Scans
                                        </th>
                                        <th>
                                            Last Scanned
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Engagement
                                        </th>
                                        <th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = <<<SQL
                                            SELECT * FROM `qr`
                                        SQL;

                                        $result = $db->query($query);
                                        
                                        $statusMap = [
                                            "active" => "Active",
                                            "inactive" => "Inactive"
                                        ];

                                        $categoryMap = [
                                            "music" => "Music",
                                            "video" => "Video",
                                            "artifact" => "Artifact",
                                            "event" => "Event"
                                        ];

                                        while ($qr = $result->fetchArray()) {
                                            $content = getQrContent($qr);
                                            $count = getQrScans($qr);
                                            $time = getQrLastScan($qr);
                                            $engagement = getQrEngagement($qr);

                                            if ($time == false) {
                                                $date = "Never scanned";
                                            } else {
                                                $date = date("m/d/y", $time + 28800);
                                            }

                                            echo <<<HTML
                                                <tr>
                                                    <td>
                                                        {$content["title"]}
                                                    </td>
                                                    <td>
                                                        {$categoryMap[$content["category"]]}
                                                    </td>
                                                    <td>
                                                        {$count}
                                                    </td>
                                                    <td>
                                                        {$date}
                                                    </td>
                                                    <td>
                                                        {$statusMap[$qr["status"]]}
                                                    </td>
                                                    <td>
                                                        {$engagement}%
                                                    </td>
                                                    <td>
                                                        <a href="visitors/qr/view?id={$qr['id']}">
                                                            <button style="
                                                                background-color: #5c6;">
                                                                View
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            HTML;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="script.js"></script>
        <script>
            const inputSearch = document.getElementById("inputSearch");
            const inputStartDate = document.getElementById('inputStartDate');
            const inputEndDate = document.getElementById('inputEndDate');
            const btnResetFilters = document.getElementById('btnResetFilters');
            initialize();

            function initialize() {
                let startDate = new URLSearchParams(location.search).get("startDate");
                let endDate = new URLSearchParams(location.search).get("endDate");
                
                if (startDate) {
                    inputStartDate.value = new Date(startDate * 1000).toISOString().split("T")[0];
                    inputEndDate.min = new Date(startDate * 1000).toISOString().split("T")[0];
                }

                if (endDate) {
                    inputEndDate.value = new Date(endDate * 1000).toISOString().split("T")[0];
                    inputStartDate.max = new Date(endDate * 1000).toISOString().split("T")[0];
                }
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

            btnResetFilters.onclick = () => location.href = "visitors/qr/";

            inputSearch.oninput = () => filterTable(inputSearch.value);

            function filterTable(searchTerm) {
                const table = document.getElementById("qrTable");
                const tbody = table.querySelector("tbody");
                const rows = tbody.querySelectorAll("tr");
                
                // Normalize the search term for case-insensitive matching
                const term = searchTerm.trim().toLowerCase();

                rows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    // Show row if it contains the term, hide if not
                    row.style.display = rowText.includes(term) ? "" : "none";
                });
            }


        </script>
    </body>
</html>