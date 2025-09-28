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
                        padding: 1rem;
                        font-size: 1.5rem;
                        font-weight: bold;
                        text-align: center;">
                        Detailed Visitor Engagement
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
                                <tbody>
                                    <?php
                                        $query = <<<SQL
                                            SELECT * FROM `visitors`
                                        SQL;

                                        $result = $db->query($query);

                                        while ($visitor = $result->fetchArray()) {
                                            $school = $visitor["school"];

                                            if ($school == null) {
                                                $school = "N/A";
                                            }

                                            $date = date("m/d/y", getVisitorLastVisit($visitor) + 28800);
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
            
        </script>
    </body>
</html>