<?php

chdir("../");
include "common.php";
$db = new SQLite3("database.db");
$selected = "all";

if (isset($_GET["type"])) {
    switch ($_GET["type"]) {
        case "music":
            $type = "Audio";
            $selected = "music";
            break;
        case "instrument":
            $type = "Instrument";
            $selected = "instruments";
            break;
        case "video":
            $type = "Video";
            $selected = "videos";
            break;
    }

    $query = <<<SQL
        SELECT * FROM `uploads` WHERE `type` = :type ORDER BY `time` DESC
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":type", $type);
} else {
    $query = <<<SQL
        SELECT * FROM `uploads` ORDER BY `time` DESC
    SQL;

    $stmt = $db->prepare($query);
}

$result = $stmt->execute();

?>

<html>
    <head>
        <title>
            Content Management
        </title>
        <base href="../">
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body > .main {
                & > .content {
                    display: grid;
                    grid-template-columns: max-content 1fr;
                    overflow: hidden;
                
                    & > .content {
                        overflow: auto;

                        & > .top {
                            display: grid;
                            grid-template-columns: 1fr max-content;

                            & > .title {
                                font-weight: bold;

                                & > .subtitle {
                                    color: #555;
                                }
                            }

                            & > .new {
                                & > button {
                                    background-color: var(--theme-green-dark);
                                    font-weight: bold;
                                    color: #fff;
                                }
                            }
                        }

                        & > .search {
                            & > .box {
                                display: grid;
                                grid-template-columns: max-content 1fr;
                                width: 30rem;
                                border: 1px solid #555;
                                border-radius: 1rem;

                                & > .icon {
                                    padding-left: 1rem;
                                    padding-right: 1rem;
                                }

                                & > .input {
                                    & > input {
                                        border: none;
                                    }
                                }
                            }
                        }

                        & > .table {
                            overflow: hidden;

                            & > .box {
                                display: grid;
                                grid-template-columns: repeat(9, max-content);
                                border: 1px solid #555;
                                border-radius: 1rem;
                                overflow: auto;
                                max-height: 30rem;

                                & > .header {
                                    position: sticky;
                                    top: 0;
                                    background-color: #fff;
                                    border-bottom: 3px solid #555;
                                    padding-left: 3rem;
                                    padding-right: 3rem;
                                }

                                & > .data {
                                    border-bottom: 1px solid #555;
                                    padding-left: 3rem;
                                    padding-right: 3rem;
                                }
                            }
                        }

                        & .stats {
                            & > .box {
                                display: grid;
                                grid-template-columns: repeat(4, 1fr);
                                border: 1px solid #555;
                                border-radius: 1rem;

                                & > .stat {
                                    & > .value {
                                        font-weight: bold;
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
        <div class="main -main">
            <?=renderHeader("content")?>
            <div class="content">
                <?=renderNavigation("content", $selected)?>
                <div class="content -pad">
                    <div class="top">
                        <div class="title">
                            <div class="title -pad -title">
                                All Content
                            </div>
                            <div class="subtitle -pad">
                                Manage cultural artifacts and track management
                            </div>
                        </div>
                        <a href="content/new/" class="-a new -pad">
                            <button class="-button">
                                <div class="-iconlabel">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M440-440H240q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h200v-200q0-17 11.5-28.5T480-760q17 0 28.5 11.5T520-720v200h200q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H520v200q0 17-11.5 28.5T480-200q-17 0-28.5-11.5T440-240v-200Z"/></svg>
                                    </div>
                                    <div class="label">
                                        Add Content
                                    </div>
                                </div>
                            </button>
                        </a>
                    </div>
                    <div class="search -pad">
                        <div class="box">
                            <div class="icon -center__flex">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111111"><path d="M380-320q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l224 224q11 11 11 28t-11 28q-11 11-28 11t-28-11L532-372q-30 24-69 38t-83 14Zm0-80q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                            </div>
                            <div class="input">
                                <input type="text" class="-input" placeholder="Search content...">
                            </div>
                        </div>
                    </div>
                    <div class="table -pad">
                        <div class="box">
                            <div class="date header -pad -center__flex">
                                Date
                            </div>
                            <div class="title header -pad -center__flex">
                                Title
                            </div>
                            <div class="tribe header -pad -center__flex">
                                Tribe
                            </div>
                            <div class="category header -pad -center__flex">
                                Category
                            </div>
                            <div class="type header -pad -center__flex">
                                Type
                            </div>
                            <div class="engagement header -pad -center__flex">
                                Engagement
                            </div>
                            <div class="webviews header -pad -center__flex">
                                Web Views
                            </div>
                            <div class="appscans header -pad -center__flex">
                                App Scans
                            </div>
                            <div class="actions header -pad -center__flex">
                                Actions
                            </div>
                            <?php
                                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                                    echo renderContentRow($row);
                                }
                            ?>
                        </div>
                    </div>
                    <div class="stats -pad">
                        <div class="box">
                            <div class="content stat">
                                <div class="value -pad -title -center">
                                    0
                                </div>
                                <div class="label -pad -center">
                                    Total Content
                                </div>
                            </div>
                            <div class="webviews stat">
                                <div class="value -pad -title -center">
                                    0
                                </div>
                                <div class="label -pad -center">
                                    Total Web Views
                                </div>
                            </div>
                            <div class="appscans stat">
                                <div class="value -pad -title -center">
                                    0
                                </div>
                                <div class="label -pad -center">
                                    Total App Scans
                                </div>
                            </div>
                            <div class="engagement stat">
                                <div class="value -pad -title -center">
                                    0%
                                </div>
                                <div class="label -pad -center">
                                    Avg. Engagement
                                </div>
                            </div>
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