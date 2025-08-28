<?php

chdir("../../");
require_once "common.php";
$db = new SQLite3("database.db");

$query = <<<SQL
    SELECT * FROM `qr`
SQL;

$stmt = $db->prepare($query);
$result = $stmt->execute();

?>

<html>
    <head>
        <title>
            QR Code
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
                    & > .top {
                        display: grid;
                        grid-template-columns: 1fr max-content;

                        & > .new {
                            & > button {
                                background-color: var(--theme-green-dark);
                                font-weight: bold;
                                color: #fff;
                            }
                        }
                    }

                    & > .table {
                        & > .box {
                            border-radius: 1rem;
                            overflow: auto;
                            border: 1px solid #555;
                            background-color: #fff;
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

                                            & > img {
                                                width: 5rem;
                                                height: 5rem;
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
            <?=renderNavigation("visitor", "qr")?>
            <div class="content">
                <div class="top">
                    <div class="title">
                        <div class="title -pad -title">
                            QR Code Management
                        </div>
                        <div class="description -pad">
                            Manage QR codes for museum and entrance
                        </div>
                    </div>
                    <form action="server.php" class="-form new -pad" method="post" enctype="multipart/form-data">
                        <button class="-button" name="method" value="new_qr">
                            <div class="-iconlabel">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M440-440H240q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h200v-200q0-17 11.5-28.5T480-760q17 0 28.5 11.5T520-720v200h200q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H520v200q0 17-11.5 28.5T480-200q-17 0-28.5-11.5T440-240v-200Z"/></svg>
                                </div>
                                <div class="label">
                                    Add QR Code
                                </div>
                            </div>
                        </button>
                    </form>
                </div>
                <div class="table -pad">
                    <div class="box">
                        <table id="tableQr">
                            <thead>
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Type
                                    </th>
                                    <th>
                                        QR Code
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
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                                        $row["name"] = htmlentities($row["name"]);

                                        echo <<<HTML
                                            <tr>
                                                <td>
                                                    {$row["name"]}
                                                </td>
                                                <td>
                                                    {$row["type"]}
                                                </td>
                                                <td>
                                                    <img src="" data-code="{$row['code']}">
                                                </td>
                                                <td>
                                                    0
                                                </td>
                                                <td>
                                                    2001-09-11
                                                </td>
                                                <td>
                                                    {$row["status"]}
                                                </td>
                                                <td>
                                                    <a href="visitor/qr/edit/?id={$row['id']}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111111"><path d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z"/></svg>
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
        <script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
        <script>
            let tableQr = document.getElementById("tableQr");

            for (let img of tableQr.getElementsByTagName("img")) {
                QRCode.toDataURL(img.dataset.code, (err, url) => {
                    if (err) {
                        throw err;
                    }

                    img.src = url;
                });
            }
        </script>
    </body>
</html>