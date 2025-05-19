<?php

chdir("../");
include "common.php";
$db = new SQLite3("database.db");
$user = GetUser($db);

if ($user == false) {
    Alert("You are not logged in.");
}

?>

<html>
    <head>
        <title>
            Dashboard
        </title>
        <base href="../">
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body > .main {
                display: grid;
                grid-template-columns: max-content 1fr;
                min-height: 100%;

                & > .content {
                    background-color: #242;
                    color: #fff;

                    & > .profile {
                        display: grid;
                        grid-template-columns: max-content 1fr;

                        & > .avatar {
                            padding-left: 5rem;

                            & > img {
                                width: 10rem;
                                height: 10rem;
                                border-radius: 50%;
                                object-fit: cover;
                            }
                        }
                    }

                    & > .tabs {
                        display: grid;
                        grid-template-columns: repeat(3, max-content) 1fr;
                        padding-left: 5rem;
                        border-bottom: 1px solid #5a5;

                        & > .tab {
                            font-weight: bold;
                            cursor: pointer;

                            &:hover {
                                box-shadow: inset 0 -5px 0 0 #5a5;
                            }
                        }
                    }

                    & > .media {
                        border-bottom: 1px solid #5a5;
                        
                        & > .list {
                            display: grid;
                            grid-template-columns: repeat(5, 1fr);

                            & > .item {
                                & > .image {
                                    & > img {
                                        width: 100%;
                                        height: 10rem;
                                        object-fit: cover;
                                        border-radius: 1rem;
                                    }
                                }

                                & > .title {
                                    font-weight: bold;
                                }

                                & > .date {
                                    font-size: 0.7rem;
                                    color: #aaa;
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
            <?=SetNagivation()?>
            <div class="content">
                <?=SetHeader()?>
                <div class="profile -pad">
                    <div class="avatar">
                        <img src="assets/image.png">
                    </div>
                    <div></div>
                </div>
                <div class="tabs">
                    <a class="-a images tab -pad" href="dashboard/images/">
                        Images
                    </a>
                    <a class="-a music tab -pad" href="dashboard/music/">
                        Music
                    </a>
                    <a class="-a videos tab -pad" href="dashboard/videos/">
                        Videos
                    </a>
                    <div></div>
                </div>
                <div class="images media">
                    <div class="label -pad -title">
                        Images
                    </div>
                    <div class="list">
                        <?php
                            $query = <<<SQL
                                SELECT * FROM `entries` WHERE `type` = 'image' ORDER BY `time` DESC LIMIT 5
                            SQL;

                            $result = $db->query($query);

                            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                                $row["title"] = htmlentities($row["title"]);
                                $row["time"] = date("F j, Y, g:i A", $row["time"]);

                                echo <<<HTML
                                    <div class="item">
                                        <div class="image -pad">
                                            <img src="uploads/media/{$row['file']}">
                                        </div>
                                        <div class="title -pad">
                                            {$row["title"]}
                                        </div>
                                        <div class="date -pad">
                                            {$row["time"]}
                                        </div>
                                    </div>
                                HTML;
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="script.js"></script>
        <script>

        </script>
    </body>
</html>