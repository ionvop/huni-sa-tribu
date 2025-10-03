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
                        grid-template-columns: 1fr max-content">
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
                            padding: 1rem;">
                            <select style="
                                border-radius: 1rem;"
                                id="selectSort">
                                <option value="">
                                    Sort
                                </option>
                                <option value="school">
                                    School
                                </option>
                                <option value="engagement">
                                    Engagement
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
            const selectSort = document.getElementById("selectSort");
            const tbody = document.getElementById("tbody");
            let tbodyOriginalHtml = tbody.innerHTML;
            initialize();

            function initialize() {

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
            }

            selectSort.onchange = () => {
                switch (selectSort.value) {
                    case "": {
                        tbody.innerHTML = tbodyOriginalHtml;
                    } break;
                    case "school": {
                        sortTableRows(tbody, 1, (a, b) => a.localeCompare(b));
                        sortTableRows(tbody, 1, compareAlphabeticallyWithNA);
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

            function compareAlphabeticallyWithNA(a, b) {
                const A = a.trim().toLowerCase();
                const B = b.trim().toLowerCase();

                // Handle "N/A" cases first
                const isANA = A === "n/a";
                const isBNA = B === "n/a";

                if (isANA && isBNA) return 0;      // both are "N/A" → equal
                if (isANA) return 1;              // "N/A" goes last → push down
                if (isBNA) return -1;             // "N/A" goes last → push up the other

                // Otherwise, normal alphabetical comparison
                return A.localeCompare(B);
            }
        </script>
    </body>
</html>