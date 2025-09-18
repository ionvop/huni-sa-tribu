<?php

chdir("../");
require_once "common.php";
$db = new SQLite3("database.db");

?>

<html>
    <head>
        <title>
            Visitor Management
        </title>
        <base href="../">
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

                    & > .cards {
                        display: grid;
                        grid-template-columns: repeat(3, 1fr);

                        & > .card {
                            & > .box {
                                background-color: #fff;
                                border-radius: 1rem;
                                border: 1px solid #555;
                            }
                        }
                    }

                    & > .table {
                        & > .box {
                            border-radius: 1rem;
                            overflow: auto;
                            border: 1px solid #555;
                            background-color: #fff;

                            & > .table {
                                padding-top: 1rem;
                                min-height: 20rem;

                                & > table {
                                    border-collapse: collapse;
                                    width: 100%;

                                    & > thead {
                                        position: sticky;
                                        top: 0rem;
                                        background-color: #f5fafa;
                                        border-bottom: 1px solid #555;

                                        & > tr {
                                            & > th {
                                                padding: 1rem;   
                                            }
                                        }
                                    }

                                    & > tbody {
                                        background-color: #fff;

                                        & > tr {
                                            border-bottom: 1px solid #aaa;

                                            & > td {
                                                padding: 1rem;
                                                text-align: center;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        </style>
    </head>
    <body>
        <div class="main">
            <?=renderNavigation("visitor", "visitor")?>
            <div class="content">
                <div class="title -pad -title">
                    Visitor Tracking
                </div>
                <div class="description -pad">
                    Monitor visitor engagement across web and mobile platforms
                </div>
                <div class="cards">
                    <div class="visitors card -pad">
                        <div class="box">
                            <div class="label -pad">
                                Total Visitors
                            </div>
                            <div class="value -pad -title">
                                <?php
                                    $query = <<<SQL
                                        SELECT COUNT(*) FROM (SELECT * FROM `qr_scans` GROUP BY `name`)
                                    SQL;

                                    $stmt = $db->prepare($query);
                                    $totalVisitors = $stmt->execute()->fetchArray(SQLITE3_NUM)[0];
                                    echo $totalVisitors;
                                ?>
                            </div>
                            <div class="details -pad -subtitle">
                                +0% from last week
                            </div>
                        </div>
                    </div>
                    <div class="interactions card -pad">
                        <div class="box">
                            <div class="label -pad">
                                Content Interactions
                            </div>
                            <div class="value -pad -title">
                                <?php
                                    $query = <<<SQL
                                        SELECT COUNT(*) FROM `qr_scans`
                                        LEFT JOIN `qr` ON `qr_scans`.`qr_id` = `qr`.`id`
                                        WHERE `qr`.`type` != "entrance"
                                    SQL;

                                    $stmt = $db->prepare($query);
                                    $result = $stmt->execute();
                                    echo $result->fetchArray(SQLITE3_NUM)[0];
                                ?>
                            </div>
                            <div class="details -pad -subtitle">
                                App interactions
                            </div>
                        </div>
                    </div>
                    <div class="return card -pad">
                        <div class="box">
                            <div class="label -pad">
                                Return Visitors
                            </div>
                            <div class="value -pad -title">
                                <?php
                                    $query = <<<SQL
                                        SELECT COUNT(*) AS `returning_visitors`
                                        FROM (
                                            SELECT *
                                            FROM (
                                                SELECT `qr_scans`.`name` AS `name`
                                                FROM `qr_scans`
                                                LEFT JOIN `qr` ON `qr_scans`.`qr_id` = `qr`.`id`
                                                WHERE `qr`.`type` = "entrance"
                                            )
                                            GROUP BY `name`
                                            HAVING COUNT(*) > 1
                                        )
                                    SQL;

                                    $stmt = $db->prepare($query);
                                    $result = $stmt->execute();
                                    $returningVisitors = $result->fetchArray(SQLITE3_ASSOC)["returning_visitors"];
                                    echo round(($returningVisitors / $totalVisitors) * 100, 2) . "%";
                                ?>
                            </div>
                            <div class="details -pad -subtitle">
                                Visitors returning
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table -pad">
                    <div class="box">
                        <div class="title -pad -title">
                            Detailed Visitor Engagement
                        </div>
                        <div class="description -pad">
                            Tracking of visitor interactions with content
                        </div>
                        <div class="table">
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
                                            Engagement
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = <<<SQL
                                            SELECT COUNT(*) AS `view_count`
                                            FROM `qr_scans`
                                            WHERE `time` > :time
                                            GROUP BY `name`
                                            ORDER BY `view_count` DESC
                                        SQL;

                                        $stmt = $db->prepare($query);
                                        $stmt->bindValue(":time", time() - 604800);
                                        $maxScansInAWeek = $stmt->execute()->fetchArray(SQLITE3_NUM)[0];

                                        $query = <<<SQL
                                            SELECT `name`, `school` FROM `qr_scans` GROUP BY `name`
                                        SQL;

                                        $stmt = $db->prepare($query);
                                        $result = $stmt->execute();

                                        while ($visitor = $result->fetchArray(SQLITE3_ASSOC)) {
                                            $query = <<<SQL
                                                SELECT * FROM `qr_scans` WHERE `name` = :name ORDER BY `time` DESC
                                            SQL;

                                            $stmt = $db->prepare($query);
                                            $stmt->bindValue(":name", $visitor["name"]);
                                            $result2 = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
                                            $date = date("m/d/y", $result2["time"]);

                                            $query = <<<SQL
                                                SELECT COUNT(*) AS `view_count`
                                                FROM `qr_scans`
                                                LEFT JOIN `qr` ON `qr_scans`.`qr_id` = `qr`.`id`
                                                WHERE `qr_scans`.`name` = :name
                                                AND `qr`.`type` != "entrance"
                                            SQL;

                                            $stmt = $db->prepare($query);
                                            $stmt->bindValue(":name", $visitor["name"]);
                                            $viewCount = $stmt->execute()->fetchArray(SQLITE3_NUM)[0];

                                            $query = <<<SQL
                                                SELECT COUNT(*) FROM `qr_scans` WHERE `name` = :name AND `time` > :time
                                            SQL;

                                            $stmt = $db->prepare($query);
                                            $stmt->bindValue(":name", $visitor["name"]);
                                            $stmt->bindValue(":time", time() - 604800);
                                            $scansInAWeek = $stmt->execute()->fetchArray(SQLITE3_NUM)[0];
                                            $engagement = ($maxScansInAWeek == 0) ? 0 : ($scansInAWeek / $maxScansInAWeek) * 100;

                                            echo <<<HTML
                                                <tr>
                                                    <td>
                                                        {$visitor["name"]}
                                                    </td>
                                                    <td>
                                                        {$visitor["school"]}
                                                    </td>
                                                    <td>
                                                        {$date}
                                                    </td>
                                                    <td>
                                                        {$viewCount}
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