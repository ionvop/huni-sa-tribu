<?php

chdir("../../");
require_once "common.php";
$db = new SQLite3("database.db");

?>

<html>
    <head>
        <title>
            Visitors | Huni Sa Tribu
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
                    <?=renderVisitorTabs("visitors")?>
                    <div style="
                        padding: 1rem;">
                        <div style="
                            display: grid;
                            grid-template-columns: repeat(2, 1fr);
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
                                        Returning Visitors
                                    </div>
                                    <div style="
                                        padding: 1rem;
                                        padding-top: 0rem;
                                        text-align: center;
                                        font-size: 2rem;
                                        font-weight: bold;"
                                        id="panelReturningVisitors">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="
                    background-image: linear-gradient(to bottom, #020, #000);">
                    <div style="
                        display: grid;
                        grid-template-columns: 1fr repeat(4, max-content);">
                        <div style="
                            display: flex;
                            align-items: center;
                            padding: 1rem;
                            font-size: 1.5rem;
                            font-weight: bold;
                            text-align: center;">
                            Detailed Visitor Engagement
                        </div>
                        <form style="
                            display: flex;
                            align-items: center;
                            padding: 1rem;"
                            action="server.php"
                            method="post"
                            enctype="multipart/form-data"
                            target="_blank">
                            <button style="
                                background-color: #5c6;
                                border-radius: 1rem;
                                color: #fff;"
                                name="method"
                                value="exportData"
                                id="btnExportData">
                                Export Data
                            </button>
                            <input type="hidden"
                                name="startDate"
                                value="<?=isset($_GET["startDate"]) ? $_GET["startDate"] : 9?>">
                            <input type="hidden"
                                name="endDate"
                                value="<?=isset($_GET["endDate"]) ? $_GET["endDate"] : time()?>">
                        </form>
                        <div style="
                            display: flex;
                            align-items: center;
                            padding: 1rem;
                            color: #aaa;
                            line-height: 1.5rem;"
                            id="panelCount">
                        </div>
                        <div style="
                            display: flex;
                            align-items: center;
                            padding: 1rem;">
                            <select style="
                                border-radius: 1rem;"
                                id="selectSort">
                                <option value="">
                                    Select Sort
                                </option>
                                <option value="engagement">
                                    Engagement
                                </option>
                            </select>
                        </div>
                        <div style="
                            display: flex;
                            align-items: center;
                            padding: 1rem;">
                            <select style="
                                border-radius: 1rem;"
                                id="selectSchools">
                                <option value="">
                                    Filter Schools
                                </option>
                            </select>
                        </div>
                    </div>
                    <div style="
                        padding: 5rem;
                        padding-top: 1rem;">
                        <div style="
                            background-image: linear-gradient(to bottom, #454, #222);
                            border-radius: 1rem;
                            overflow: hidden;">
                            <table>
                                <thead>
                                    <tr>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            School
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            Content Viewed
                                        </th>
                                        <th>
                                            Returning Visitor
                                        </th>
                                        <th>
                                            Engagement
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    <?php
                                        // $query = <<<SQL
                                        //     SELECT * FROM `visitors`
                                        // SQL;

                                        // $result = $db->query($query);

                                        // while ($visitor = $result->fetchArray()) {
                                        //     $school = $visitor["school"];

                                        //     if ($school == "") {
                                        //         $school = "N/A";
                                        //     }

                                        //     $date = date("m/d/y", $visitor["time"] + 28800);
                                        //     $contentViews = getVisitorContentViews($visitor);
                                        //     $returningVisitor = getVisitorVisitCount($visitor) > 1 ? "Yes" : "No";
                                        //     $engagement = getVisitorEngagement($visitor);
                                        //     $engagement = round($engagement * 100, 2);

                                        //     echo <<<HTML
                                        //         <tr>
                                        //             <td>
                                        //                 {$visitor['name']}
                                        //             </td>
                                        //             <td>
                                        //                 {$school}
                                        //             </td>
                                        //             <td>
                                        //                 {$date}
                                        //             </td>
                                        //             <td>
                                        //                 {$contentViews}
                                        //             </td>
                                        //             <td>
                                        //                 {$returningVisitor}
                                        //             </td>
                                        //             <td>
                                        //                 {$engagement}%
                                        //             </td>
                                        //         </tr>
                                        //     HTML;
                                        // }

                                        $startDate = isset($_GET['startDate']) ? (int)$_GET['startDate'] : 0;
                                        $endDate   = isset($_GET['endDate']) ? (int)$_GET['endDate'] : time();

                                        $query = <<<SQL
                                            SELECT COUNT(*) AS `total_scans`
                                            FROM `scans`
                                            WHERE time BETWEEN :start AND :end
                                        SQL;

                                        $totalScanStmt = $db->prepare($query);
                                        $totalScanStmt->bindValue(':start', $startDate, SQLITE3_INTEGER);
                                        $totalScanStmt->bindValue(':end', $endDate, SQLITE3_INTEGER);
                                        $totalScans = (int)$totalScanStmt->execute()->fetchArray(SQLITE3_ASSOC)['total_scans'];

                                        if ($totalScans === 0) {
                                            $totalScans = 1;
                                        }

                                        $query = <<<SQL
                                            SELECT 
                                                `v`.`id`,
                                                `v`.`name`,
                                                `v`.`school`,
                                                `v`.`time` AS `first_visit_time`,
                                                COUNT(DISTINCT `vi`.`id`) AS `total_visits`,
                                                (
                                                    SELECT COUNT(*) 
                                                    FROM `scans` `s`
                                                    WHERE `s`.`visitor_id` = `v`.`id` AND `s`.`time` BETWEEN :start AND :end
                                                ) AS `scans_made`
                                            FROM `visitors` `v`
                                            JOIN `visits` `vi` ON `vi`.`visitor_id` = `v`.`id`
                                            WHERE `vi`.`time` BETWEEN :start AND :end
                                            GROUP BY `v`.`id`
                                            ORDER BY `v`.`name`
                                        SQL;

                                        $stmt = $db->prepare($query);
                                        $stmt->bindValue(':start', $startDate, SQLITE3_INTEGER);
                                        $stmt->bindValue(':end', $endDate, SQLITE3_INTEGER);
                                        $result = $stmt->execute();
                                        $visitors = [];

                                        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                                            $engagement = ($row['scans_made'] / $totalScans) * 100;

                                            // $visitors[] = [
                                            //     'Name'              => $row['name'],
                                            //     'School'            => $row['school'],
                                            //     'Date'              => date('m/d/Y', $row['first_visit_time']),
                                            //     'Content Viewed'    => (int)$row['scans_made'],
                                            //     'Returning Visitor' => $row['total_visits'] > 1 ? 'Yes' : 'No',
                                            //     'Engagement'        => round($engagement, 2) . '%'
                                            // ];

                                            $school = $row['school'] == '' ? 'N/A' : $row['school'];
                                            $date = date('m/d/Y', $row['first_visit_time']);
                                            $contentViews = (int)$row['scans_made'];
                                            $returningVisitor = $row['total_visits'] > 1 ? 'Yes' : 'No';
                                            $engagement = round($engagement, 2);

                                            echo <<<HTML
                                                <tr>
                                                    <td>
                                                        {$row['name']}
                                                    </td>
                                                    <td>
                                                        {$school}
                                                    </td>
                                                    <td>
                                                        {$date}
                                                    </td>
                                                    <td>
                                                        {$contentViews}
                                                    </td>
                                                    <td>
                                                        {$returningVisitor}
                                                    </td>
                                                    <td>
                                                        {$engagement}%
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
                <div style="
                    padding: 5rem;
                    background-image: linear-gradient(to bottom, #020, #000);">
                    <canvas style="
                        width: 100%;
                        height: 30rem;"
                        id="canvasChart">
                    </canvas>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="script.js"></script>
        <script>
            const selectSchools = document.getElementById("selectSchools");
            const selectSort = document.getElementById("selectSort");
            const panelCount = document.getElementById("panelCount");
            const inputStartDate = document.getElementById('inputStartDate');
            const inputEndDate = document.getElementById('inputEndDate');
            const btnResetFilters = document.getElementById('btnResetFilters');
            const panelReturningVisitors = document.getElementById("panelReturningVisitors");
            const canvasChart = document.getElementById("canvasChart");
            const btnExportData = document.getElementById("btnExportData");
            const tbody = document.getElementById("tbody");
            let tbodyOriginalHtml = tbody.innerHTML;
            const schools = [];
            initialize();

            function initialize() {
                let startDate = new URLSearchParams(location.search).get("startDate");
                let endDate = new URLSearchParams(location.search).get("endDate");
                if (startDate) inputStartDate.value = new Date(startDate * 1000).toISOString().split("T")[0];
                if (endDate) inputEndDate.value = new Date(endDate * 1000).toISOString().split("T")[0];

                for (const tr of tbody.querySelectorAll("tr")) {
                    const school = tr.children[1].textContent.trim();
                    const option = document.createElement("option");
                    option.value = school;
                    if (schools.includes(school)) continue;
                    schools.push(school);
                    option.textContent = school;
                    selectSchools.appendChild(option);
                }

                updateCount();

                let returningVisitorCount = 0;
                let returningVisitorTotal = 0;

                for (let tr of tbody.querySelectorAll("tr")) {
                    const returningVisitor = tr.children[4].textContent.trim();
                    if (returningVisitor == "Yes") {
                        returningVisitorCount++;
                    }
                    returningVisitorTotal++;
                }

                if (returningVisitorTotal == 0) returningVisitorTotal = 1; // Prevent division by zero
                const returningVisitorPercentage = (returningVisitorCount / returningVisitorTotal) * 100;
                panelReturningVisitors.textContent = `${returningVisitorPercentage.toFixed(2)}%`;

                new Chart(canvasChart, {
                    type: 'bar',
                    data: {
                        labels: schools,
                        datasets: [
                            {
                                label: '# of Visitors',
                                data: groupCountBySchool(tbody),
                                borderWidth: 1
                            }
                        ]
                    }
                })
            }

            btnExportData.onclick = () => confirm("Are you sure you want to export this data?");

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

            btnResetFilters.onclick = () => location.href = "visitors/visitors/";

            selectSchools.onchange = () => {
                if (selectSchools.value == "") {
                    for (const tr of tbody.querySelectorAll("tr")) {
                        tr.style.display = "";
                    }

                    updateCount();
                    return;
                }

                for (const tr of tbody.querySelectorAll("tr")) {
                    const school = tr.children[1].textContent.trim();
                    if (selectSchools.value == school) {
                        tr.style.display = "";
                    } else {
                        tr.style.display = "none";
                    }
                }

                updateCount();
            }

            function updateCount() {
                let visitorCount = 0;
                let schoolCount = schools.length - 1;

                for (const tr of tbody.querySelectorAll("tr")) {
                    if (tr.style.display != "none") {
                        visitorCount++;
                    }
                }

                panelCount.innerHTML = /*html*/`
                    Total Visitors: ${visitorCount}<br>
                    Total Schools: ${schoolCount < 0 ? 0 : schoolCount}
                `;
            }

            function sortTableRows(tbody, columnIndex, compareFn) {
                // Convert the rows NodeList to an array so we can sort it
                const rows = Array.from(tbody.querySelectorAll("tr"));

                // Sort using the provided comparator function
                rows.sort((a, b) => {
                    const aText = a.children[columnIndex].textContent.trim();
                    const bText = b.children[columnIndex].textContent.trim();
                    return compareFn(aText, bText);
                });

                // Append rows in new order
                rows.forEach(row => tbody.appendChild(row));
                updateCount();
            }

            function groupCountBySchool(tbody, schoolColumnIndex = 1) {
                if (!tbody) {
                    console.error("Tbody not found!");
                    return {};
                }

                const counts = {};

                for (const row of tbody.querySelectorAll("tr")) {
                    const cells = row.querySelectorAll("td");
                    const school = cells[schoolColumnIndex]?.textContent.trim();

                    if (school) {
                        counts[school] = (counts[school] || 0) + 1;
                    }
                }

                return counts;
            }

            selectSort.onchange = () => {
                switch (selectSort.value) {
                    case "": {
                        tbody.innerHTML = tbodyOriginalHtml;
                        selectSchools.onchange();
                    } break;
                    case "engagement": {
                        sortTableRows(tbody, 5, (a, b) => {
                            a.replace("%", "");
                            b.replace("%", "");
                            return parseFloat(b) - parseFloat(a);
                        });
                    } break;
                }
            }
        </script>
    </body>
</html>