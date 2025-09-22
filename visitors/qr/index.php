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
                    <?=renderVisitorTabs("qr")?>
                    <div style="
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
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
                        padding: 1rem;
                        font-size: 1.5rem;
                        font-weight: bold;
                        text-align: center;">
                        QR Code Scans Monitor
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
                                            "instrument" => "Instrument"
                                        ];

                                        while ($qr = $result->fetchArray()) {
                                            $content = getQrContent($qr);
                                            $count = getQrScans($qr);
                                            $time = getQrLastScan($qr);

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

        </script>
    </body>
</html>