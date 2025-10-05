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
                                        Returning Visitors
                                    </div>
                                    <div style="
                                        padding: 1rem;
                                        padding-top: 0rem;
                                        text-align: center;
                                        font-size: 2rem;
                                        font-weight: bold;">
                                        <?=round(getReturningVisitorsRatio() * 100, 2)?>%
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
                        grid-template-columns: 1fr repeat(3, max-content);">
                        <div style="
                            display: flex;
                            align-items: center;
                            padding: 1rem;
                            font-size: 1.5rem;
                            font-weight: bold;
                            text-align: center;">
                            Detailed Visitor Engagement
                        </div>
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
                                        $query = <<<SQL
                                            SELECT * FROM `visitors`
                                        SQL;

                                        $result = $db->query($query);

                                        while ($visitor = $result->fetchArray()) {
                                            $school = $visitor["school"];

                                            if ($school == "") {
                                                $school = "N/A";
                                            }

                                            $date = date("m/d/y", $visitor["time"] + 28800);
                                            $contentViews = getVisitorContentViews($visitor);
                                            $returningVisitor = getVisitorVisitCount($visitor) > 1 ? "Yes" : "No";
                                            $engagement = getVisitorEngagement($visitor);
                                            $engagement = round($engagement * 100, 2);

                                            echo <<<HTML
                                                <tr>
                                                    <td>
                                                        {$visitor['name']}
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
            </div>
        </div>
        <script src="script.js"></script>
        <script>
            const selectSchools = document.getElementById("selectSchools");
            const selectSort = document.getElementById("selectSort");
            const panelCount = document.getElementById("panelCount");
            const tbody = document.getElementById("tbody");
            let tbodyOriginalHtml = tbody.innerHTML;
            const schools = [];
            initialize();

            function initialize() {
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
            }

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
                    Total Schools: ${schoolCount}
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