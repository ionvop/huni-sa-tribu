<?php

chdir("../../");
require_once "common.php";
$db = new SQLite3("database.db");

?>

<html>
    <head>
        <title>
            Archived Content | Huni Sa Tribu
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
                }

                & > tbody {
                    & > tr {
                        border-bottom: 1px solid #fff;

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
            padding: 5rem;
            height: 100%;
            box-sizing: border-box;
            overflow: auto;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/home.jpg');
            background-size: cover;
            background-position: bottom;">
            <div style="
                display: grid;
                grid-template-columns: max-content 1fr;">
                <a style="
                    display: block;
                    padding: 1rem;"
                    href="content/">
                    BACK TO HOME
                </a>
                <div></div>
            </div>
            <div style="
                padding: 1rem;
                padding-top: 5rem;
                font-size: 2rem;
                font-weight: bold;">
                Archive
            </div>
            <div style="
                padding: 1rem;">
                <div style="
                    padding: 1rem;
                    background-color: #0005;">
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    TITLE
                                </th>
                                <th>
                                    TRIBE
                                </th>
                                <th>
                                    CATEGORY
                                </th>
                                <th>
                                    TYPE
                                </th>
                                <th>
                                    DATE
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = <<<SQL
                                    SELECT * FROM `content` WHERE `is_archived` = 1
                                SQL;

                                $result = $db->query($query);

                                $categoryMap = [
                                    "music" => "Music",
                                    "video" => "Video",
                                    "artifact" => "Artifact",
                                    "instrument" => "Instrument"
                                ];

                                $tribeMap = [
                                    "kagan" => "Kagan",
                                    "mandaya" => "Mandaya",
                                    "mansaka" => "Mansaka"
                                ];

                                $typeMap = [
                                    "image" => "Image",
                                    "video" => "Video",
                                    "audio" => "Audio"
                                ];

                                while ($content = $result->fetchArray()) {
                                    $content["title"] = htmlentities($content["title"]);
                                    $content["description"] = htmlentities($content["description"]);
                                    $type = getFileType($content["file"]);
                                    $date = date("m/d/y", $content["time"] + 28800);
                                    $contentElement = renderContent($content, 10);

                                    echo <<<HTML
                                        <tr>
                                            <td>
                                                $contentElement
                                            </td>
                                            <td>
                                                {$content["title"]}
                                            </td>
                                            <td>
                                                {$tribeMap[$content["tribe"]]}
                                            </td>
                                            <td>
                                                {$categoryMap[$content["category"]]}
                                            </td>
                                            <td>
                                                {$typeMap[$type]}
                                            </td>
                                            <td>
                                                {$date}
                                            </td>
                                            <td>
                                                <form action="server.php"
                                                    method="post"
                                                    enctype="multipart/form-data">
                                                    <button style="
                                                        background-color: #5c6;"
                                                        name="method"
                                                        value="restore"
                                                        id="btnRestore">
                                                        Restore
                                                    </button>
                                                    <input type="hidden"
                                                        name="id"
                                                        value="{$content['id']}">
                                                </form>
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
    </body>
    <script src="script.js"></script>
    <script>
        const btnRestore = document.getElementById("btnRestore");

        btnRestore.onclick = () => confirm("Are you sure you want to restore this content?");
    </script>
</html>